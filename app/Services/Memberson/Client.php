<?php

namespace App\Services\Memberson;

use App\Models\MembersonProfile;
use App\Models\UserData;
use App\Role;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class Client
{
    /**
     * @var UserData|null
     */
    protected $userData;
    protected $studentRoleId;

    public function getMembershipSummary()
    {
        $userData = $this->getUserData();
        $response = $this->getProfileSummary();
        if ( $response->successful() && $data = $response->body() ) {
            $data = json_decode( $data );

            if ( $data->MembershipSummaries ) {
                $summaries        = collect( $data->MembershipSummaries );
                $activeMembership = $summaries
                    ->where( 'Tier', 'Gallery Explorer' )
                    ->firstWhere( 'Status', 'ACTIVE' );

                $userData->membership_type = $activeMembership->Type ?? null;
                $userData->membership_tier = $activeMembership->Tier ?? null;

                $userData->save();
            }
        }

        return $userData;
    }

    public function getProfileSummary()
    {
        $userData       = $this->getUserData();
        $customerNumber = $userData->memberson_customer_number;
        $endpoint       = "profile/$customerNumber/summary";
        $url            = $this->getUrl( $endpoint );

        return $this->sendRequestWithTokens()
                    ->get( $url );
    }

    public function checkIfMembershipExpired()
    {
//        $user = Auth::user();

//        if ( ! $user->children || ! $user->children->count() ) {
//            return;
//        }

        $userData = $this->getUserData();
        if (
            'GPE' === $userData->benefit_code &&
            optional( $userData->gpe_expires_at )->isPast()
        ) {
            // User's GPE access has expired
            // Logout user from the account
            Auth::logout();

            return Redirect::intended( '/' );
        }

        return;

        // Check if has any kid 12 or under years of age
//        $under12YearsKids = $user
//            ->children
//            ->filter( function ( User $child ) {
//                return optional( $child )->dob->age <= config( 'membership.kids_max_age' );
//            } );
//
//        if ( ! $under12YearsKids ) {
//            Auth::logout();
//        }
    }

    public function upgradeMembership( $memberNumber, $data )
    {
        $endpoint = 'member/' . $memberNumber . '/Upgrade';
        $url      = $this->getUrl( $endpoint );

        return $this->sendRequestWithTokens()
                    ->post( $url, $data );
    }

    public function addBenefit( $data )
    {
        $endpoint = 'benefit/issue';
        $url      = $this->getUrl( $endpoint );

        return $this->sendRequestWithTokens()
                    ->post( $url, $data );
    }

    public function updateBenefit( $benefitId, $data )
    {
        $endpoint = 'benefit/' . $benefitId;
        $url      = $this->getUrl( $endpoint );

        return $this->sendRequestWithTokens()
                    ->post( $url, $data );
    }

    public function addFamilyMember( $customerNumber, $data )
    {
        $endpoint = 'profile/' . $customerNumber . '/contact-persons/add';
        $url      = $this->getUrl( $endpoint );

        return $this->sendRequestWithTokens()
                    ->post( $url, $data );
    }

    /**
     * @param $customerNumber
     * @param $refNumber
     * @param $data
     *
     * Data format:
     * {
     *   "Type": "CHILD",
     *   "RefNumber": "409787d0-d1c0-4986-9464-8feae2638c44",
     *   "FirstName": "Adam",
     *   "LastName": "Smith",
     *   "IC": "K0000091335",
     *   "DOB": "2016-01-01T00:00:00",
     *   "Gender": "M"
     * }
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function updateFamilyMember( $customerNumber, $refNumber, $data )
    {
        $endpoint = 'profile/' . $customerNumber . '/contact-person/' . $refNumber;
        $url      = $this->getUrl( $endpoint );

        return $this->sendRequestWithTokens()
                    ->put( $url, $data );
    }

    public function updateUserProfile( $customerNumber, $data )
    {
        $endpoint = 'profile/' . $customerNumber;
        $url      = $this->getUrl( $endpoint );

        return $this->sendRequestWithTokens()
                    ->put( $url, $data );
    }

    public function getUserProfile()
    {
        $user     = Auth::user();
        $userData = $this->getUserData();
        if ( ! $user || ! $userData || ! $userData->memberson_customer_number ) {
            return null;
        }

        $endpoint = 'profile/' . $userData->memberson_customer_number;
        $url      = $this->getUrl( $endpoint );

        $response = $this->sendRequestWithTokens()
                         ->get( $url );

        if ( $response->successful() && $data = $response->body() ) {
            if ( $user && $data ) {

                // TODO update existing data to pre-populate
                $profileData = collect( json_decode( $data ) );
                if ( $gender = $profileData->get( 'GenderCode' ) ) {
                    $user->gender = $gender;
                }

                if ( $phones = $profileData->get( 'Phones' ) ) {
                    foreach ( $phones as $phone ) {
                        if (
                            'MOBILE' === $phone->Type &&
                            $phone->Number
                        ) {
                            $user->mobile = $phone->Number;
                        }
                    }
                }

                if ( $country = $profileData->get( 'NationalityCode' ) ) {
                    $user->country = $country;
                }

                if ( $dob = $profileData->get( 'DOB' ) ) {
                    $user->dob = Carbon::parse( $dob );
                }

                if ( $ic = $profileData->get( 'IC' ) ) {
                    $user->ic = $ic;
                }

                if ( $user->isDirty() ) {
                    $user->save();
                }

                return MembersonProfile::updateOrCreate( [
                    'user_id' => $user->id,
                ], [
                    'data' => $data
                ] );
            }
        }

        return null;
    }

    public function upsertKids()
    {
        $user     = Auth::user();
        $userData = $this->getUserData();
        $endpoint = 'profile/' . $userData->memberson_customer_number . '/contact-persons';
        $url      = $this->getUrl( $endpoint );

        $response = $this->sendRequestWithTokens()
                         ->get( $url );

        if ( $response->successful() && $data = $response->body() ) {
            $data = collect( json_decode( $data ) );

            $kids = $data->where( 'Type', 'CHILD' );

            if ( $kids->count() ) {
                // update or insert kids
                $kids->each( function ( $kid ) use ( $user ) {
                    $this->upsertChildToDatabase( $kid, $user );
                } );
            }

            // Remove all extra kids
            $this->removeAdditionalKidByMissingRefNumber( $user, $kids->pluck( 'RefNumber' )->toArray() );
        }

        return $user->children;
    }

    public function checkGPEBenefitCode()
    {
        $userData     = $this->getUserData();
        $token        = $this->getAuthToken();
        $profileToken = $this->getProfileToken();

        $endpoint = 'member/' . $userData->memberson_member_number . '/benefits?benefitCode=GPE';
        $url      = $this->getUrl( $endpoint );
        $response = $this->sendRequest( $token, $profileToken )
                         ->get( $url );

        if ( $response->successful() && $response->body() ) {
            $data      = collect( json_decode( $response->body() ) );
            $activeGPE = $data->where( 'BenefitCode', 'GPE' )
                              ->firstWhere( 'StatusValue', 'Active' );

            if ( $activeGPE ) {
                $userData->benefit_code = 'GPE';

                if ( $activeGPE->Identifier ) {
                    $userData->gpe_benefit_id = $activeGPE->Identifier;
                }

                if ( $activeGPE->ExpiryDate ) {
                    $userData->gpe_expires_at = Carbon::parse( $activeGPE->ExpiryDate );
                }

                $userData->save();

                return true;
            }
        }

        // No benefit code
        $userData->benefit_code   = null;
        $userData->gpe_expires_at = null;
        $userData->save();

        return false;
    }

    public function getProfileToken( $force = false )
    {
        $userData = $this->getUserData();
        if (
            ! $force &&
            $userData->profile_token &&
            ! $userData->profile_token_expires_at->isPast()
        ) {
            return $userData->profile_token;
        }

        // User's profile token expired. Logout user to re-login
        Auth::logout();

        return false;
    }

    public function getAuthToken()
    {
        $cacheKey = config( 'membership.memberson.cache.keys.auth_token' );
        if ( Cache::has( $cacheKey ) ) {
            return Cache::get( $cacheKey );
        }

        $token = $this->retrieveAuthToken();

        if ( $token ) {
            $cacheLifetime = config( 'membership.memberson.cache.auth_token' );
            Cache::set( $cacheKey, $token, $cacheLifetime );
        }

        return $token;
    }

    public function retrieveAuthToken()
    {
        $username = config( 'membership.memberson.username' );
        $password = config( 'membership.memberson.password' );
        $url      = $this->getUrl( Endpoints::AUTHENTICATION );

        $response = $this->sendRequest()->post( $url, [
            'username' => $username,
            'password' => $password,
        ] );

        if ( $response->successful() && $response->body() ) {
            return (string) trim( $response->body(), '"' );
        }

        return null;
    }

    public function sendRequestWithTokens()
    {
        $token        = $this->getAuthToken();
        $profileToken = $this->getProfileToken();

        return $this->sendRequest( $token, $profileToken );
    }

    public function sendRequest( $token = null, $profileToken = null )
    {
        $svcAuth = config( 'membership.memberson.svc_auth' );

        $headers = [
            'SvcAuth'      => $svcAuth,
            'Content-Type' => 'application/json'
        ];

        if ( $token ) {
            $headers['Token'] = $token;
        }

        if ( $profileToken ) {
            $headers['ProfileToken'] = $profileToken;
        }

        return Http::withHeaders( $headers );
    }

    public function getUrl( $endpoint )
    {
        return sprintf(
            '%s/%s/%s',
            trim( config( 'membership.memberson.domain' ), '/' ),
            trim( config( 'membership.memberson.suffix' ), '/' ),
            trim( $endpoint, '/' )
        );
    }

    protected function upsertChildToDatabase( $child, User $parent = null )
    {
        if ( ! $parent ) {
            $parent = Auth::user();
        }

        $childUser = User::whereRefNumber( $child->RefNumber )
                         ->firstOrNew();

        $childUser->ic         = $child->IC;
        $childUser->ref_number = $child->RefNumber;
        $childUser->dob        = Carbon::parse( $child->DOB );
        $childUser->gender     = $child->Gender;
        $childUser->first_name = $child->FirstName;
        $childUser->last_name  = $child->LastName;
        $childUser->role_id    = $this->getStudentRoleId();
        $childUser->status     = 'Enable';

        if ( $childUser->isDirty() ) {
            $childUser->save();
        }

        // Make relation between parent and child
        if ( $childUser->wasRecentlyCreated ) {
            DB::table( 'relation_user' )->insert( [
                'parent_id' => $parent->id,
                'child_id'  => $childUser->id,
            ] );
        }

        return $childUser;
    }

    public function removeAdditionalKidByMissingRefNumber( User $parent, array $kidsRefNumber )
    {
        if ( ! count( $kidsRefNumber ) ) {
            return false;
        }

        $kids = $parent->children;

        if ( ! $kids || ! $kids->count() ) {
            return false;
        }

        $query = $parent->children()
                        ->whereNotIn( 'ref_number', $kidsRefNumber );

        $missingRefKids = $query->get();

        if ( ! $missingRefKids->count() ) {
            return false;
        }

        $missingRefKidsId = $missingRefKids->pluck( 'id' )->toArray();

        // Remove kids from relative table first
        DB::table( 'relation_user' )
          ->where( 'parent_id', $parent->id )
          ->whereIn( 'child_id', $missingRefKidsId )
          ->delete();

        User::whereIn( 'id', $missingRefKidsId )->delete();

        return true;
    }

    protected function getStudentRoleId()
    {
        if ( $this->studentRoleId ) {
            return $this->studentRoleId;
        }

        $role = Role::whereName( 'student' )->first();

        return $this->studentRoleId = $role->id;
    }

    protected function getUserData()
    {
        return Auth::user()->data;
    }
}
