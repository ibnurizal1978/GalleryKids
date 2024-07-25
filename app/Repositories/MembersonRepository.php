<?php


namespace App\Repositories;


use App\Http\Requests\GEMembershipUpgradeRequest;
use App\Models\MembersonProfile;
use App\Models\UserData;
use App\Services\Memberson\Client;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MembersonRepository
{
    protected $kidCounter;
    /**
     * @var Client
     */
    protected $client;

    public function __construct( Client $client )
    {
        $this->client = $client;
    }

    public function upgradeGEMembership( GEMembershipUpgradeRequest $request )
    {
        $this->updateUserProfile( $request );
        $this->upgradeMembershipToGPE();
        $this->addKids( $request );
        $this->addGPEBenefit();
    }

    public function upgradeMembershipToGPE()
    {
        $userData = Auth::user()->data;

        // Check if user is GE and Not has GPE.

        if (
            ! Str::of( $userData->membership_type )->contains( 'Gallery Explorer' ) ||
            'GPE' === $userData->benefit_code
        ) {
            return false;
        }

        $user = Auth::user();

        $data = [
            "StartDate"            => $user->created_at->toJSON(),
            "TargerMembershipType" => "Gallery Parent Explorer",
            "LocationCode"         => "LWEB",
            "Registrator"          => "TRINAXWEB",
            "SalesPerson"          => "TRINAXWEB",
            "Amount"               => 0,
            "Currency"             => "SGD",
            "ReceiptNumber"        => "Receipt" . $user->id,
            "Description"          => "Upgrade membership to GPE from " . $userData->membership_type
        ];


        $response = $this->client
            ->upgradeMembership(
                $userData->memberson_member_number,
                $data
            );

        if ( $response->successful() && $body = $response->body() ) {
            $body = json_decode( $body );

            if ( $body->NewMemberNumber ) {
                $userData->benefit_code            = 'GPE';
                $userData->memberson_member_number = $body->NewMemberNumber;
                $userData->save();

                return true;
            }
        }

        return false;
    }

    public function addGPEBenefit()
    {
        $user     = Auth::user();
        $userData = $user->data;

        if ( $userData->gpe_benefit_id ) {
            return $this->updateGPEBenefit();
        }

        $expiry = $this->getMembershipExpiryDate( $user );

        $data = [
            "MemberNumber" => $userData->memberson_member_number,
            "BenefitCode"  => "GPE",
            "Description"  => "Added GPE from GalleryKids website",
            "LocationCode" => "LKIDSCLUBWEB",
            "Registrator"  => "KIDSCLUDWEB",
            "Amount"       => 0,
            "ValidFrom"    => now()->toJSON(),
            "ExpiryDate"   => $expiry->toJSON()
        ];


        $response = $this
            ->client
            ->addBenefit( $data );

        if ( $response->successful() && $data = $response->body() ) {
            $data = json_decode( $data );

            if ( $data->ExpiryDate ) {
                $userData->gpe_expires_at = Carbon::parse( $data->ExpiryDate );
            }

            if ( $data->Identifier ) {
                $userData->gpe_benefit_id = $data->Identifier;
            }

            $userData->benefit_code = 'GPE';
            $userData->save();
        }

        return $userData;
    }

    public function updateGPEBenefit()
    {
        $user     = Auth::user();
        $userData = $user->data;
        if ( ! $userData->gpe_benefit_id ) {
            return $userData;
        }

        $expiry = $this->getMembershipExpiryDate( $user );

        $data = [
            "Amount"      => 0,
            "ValidFrom"   => now()->toJSON(),
            "ExpiryDate"  => $expiry->toJSON(),
            "Description" => "Upgraded GPE from GalleryKids website",
            "Status"      => "ACTIVE"
        ];


        $response = $this->client
            ->updateBenefit( $userData->gpe_benefit_id, $data );

        if ( $response->successful() ) {
            $userData->gpe_expires_at = $expiry;
            $userData->save();
        }

        return $userData;
    }

    public function addKids( Request $request )
    {
        if ( ! $request->has( 'kids' ) ) {
            return false;
        }

        $userData = Auth::user()->data;

        $kids = $request->get( 'kids' );
        foreach ( $kids as $kid ) {
            $kidData = [
                "Type"      => "CHILD",
                "FirstName" => $kid['firstname'],
                "LastName"  => $kid['lastname'],
                "IC"        => $this->getKidIC(),
                "DOB"       => $this->getFormattedDOB( $kid['dob'] ),
                "Gender"    => $kid['gender']
            ];

            $this
                ->client
                ->addFamilyMember(
                    $userData->memberson_customer_number,
                    $kidData
                );
        }

        // Now, update all the kids in the database
        $this->client->upsertKids();

        // Now update memberson user profile again
        $this->client->getUserProfile();

        return true;
    }

    public function hasMissingInfo()
    {
        $user = Auth::user();
        if ( ! $user ) {
            return false;
        }

        $membersonProfile = $user->membersonProfile;
        if ( ! $membersonProfile ) {
            $membersonProfile = $this->client->getUserProfile();
        }

        if ( ! $membersonProfile || ! $membersonProfile->data ) {
            return false;
        }

        $userProfile = json_decode( $membersonProfile->data, true );

        if ( $userProfile ) {
            if (
                ! $userProfile['NationalityCode'] ||
                ! $userProfile['GenderCode'] ||
                ! $userProfile['DOB']
            ) {
                return true;
            }

            // Check if Phone Number Missing
            foreach ( $userProfile['Phones'] as $index => $phone ) {
                if ( 'MOBILE' !== $phone['Type'] || ! isset( $phone['Number'] ) ) {
                    continue;
                }

                if ( ! $phone['Number'] ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function updateMissingProfile( Request $request )
    {
        $user     = Auth::user();
        $userData = optional( $user )->data;

        if ( ! $user || ! $userData ) {
            return false;
        }

        $membersonProfile = $user->membersonProfile;
        if ( ! $membersonProfile ) {
            $membersonProfile = $this->client->getUserProfile();
        }

        if ( ! $membersonProfile || ! $membersonProfile->data ) {
            return false;
        }

        return $this->updateProfileOnMemberson( $membersonProfile, $request, $userData, $user );
    }

    public function  updateUserProfile( Request $request )
    {
        $userData = Auth::user()->data;

        // Check if user is GE and Not has GPE.
        if (
            ! Str::of( $userData->membership_type )->contains( 'Gallery Explorer' ) ||
            'GPE' === $userData->benefit_code
        ) {
            return false;
        }

        $user             = Auth::user();
        $membersonProfile = $user->membersonProfile;
        if ( ! $membersonProfile ) {
            $membersonProfile = $this->client->getUserProfile();
        }

        if ( ! $membersonProfile || ! $membersonProfile->data ) {
            return false;
        }

        return $this->updateProfileOnMemberson( $membersonProfile, $request, $userData, $user );
    }

    protected function getFormattedDOB( $date )
    {
        return Carbon::createFromFormat( 'd/m/Y H:i:s', $date . ' 00:00:00' );
    }

    protected function generateParentIC()
    {
        $user = $this->getUser();

        return 'P' . $user->data->memberson_customer_number;
    }

    protected function getKidIC( User $user = null )
    {
        if ( ! $user ) {
            if ( ! Auth::check() ) {
                return false;
            }
            $user = Auth::user();
        }

        $newKidNumber = Str::padLeft( $this->getNewKidNumber( $user ), 3, 0 );

        return 'K' . $user->data->memberson_customer_number . $newKidNumber;
    }

    protected function getNewKidNumber( User $user )
    {
        if ( $this->kidCounter ) {
            $this->kidCounter ++;

            return $this->kidCounter;
        }


        $this->kidCounter = $user->children()->count() + 1;

        return $this->kidCounter;
    }

    public function updateExistingChildrenMissingIC()
    {
        if ( ! Auth::check() ) {
            return false;
        }

        $user     = Auth::user();
        $userData = optional( $user )->data;

        if ( ! $user || ! $userData ) {
            return false;
        }

        $children = $user->children;

        if ( ! $children || ! $children->count() ) {
            return false;
        }

        $childrenWithMissingIC = $children->filter( function ( User $child ) {
            $fakeICs = config( 'membership.fake_kid_ics' );
            if ( is_string( $fakeICs ) ) {
                $fakeICs = explode( ',', $fakeICs );
            }

            return empty( $child->ic ) ||
                   strlen( $child->ic ) <= 11 ||
                   in_array( $child->ic, $fakeICs );
        } );

        if ( ! $childrenWithMissingIC || ! $childrenWithMissingIC->count() ) {
            return false;
        }

        foreach ( $childrenWithMissingIC as $child ) {
            $refNumber = optional( $child )->ref_number;
            if ( ! $refNumber ) {
                continue;
            }

            $data = [
                "Type"      => "CHILD",
                "RefNumber" => $refNumber,
                "FirstName" => $child->first_name,
                "LastName"  => $child->last_name,
                "IC"        => $this->getKidIC(),
                "DOB"       => optional( $child )->dob->toJSON(),
                "Gender"    => optional( $child )->gender
            ];

            $this
                ->client
                ->updateFamilyMember(
                    $userData->memberson_customer_number,
                    $refNumber,
                    $data
                );
        }

        return $this->client->upsertKids();
    }

    /**
     * @param User|null $user
     *
     * @return Carbon|null
     */
    protected function getMembershipExpiryDate( User $user = null )
    {
        $user   = $this->getUser( $user );
        $expiry = now();
        if ( $children = optional( $user )->children ) {
            foreach ( $children as $child ) {
                if ( ! $child || ! $child->dob ) {
                    continue;
                }

                $dob = $child
                    ->dob
                    ->addYears( config( 'membership.kids_max_age' ) );
                if ( $dob > $expiry ) {
                    $expiry = $dob;
                }
            }
        }

        if ( $expiry->isPast() ) {
            $expiry = now()->addYears( 2 );
        }

        return $expiry;
    }

    protected function getUser( User $user = null )
    {
        if ( $user ) {
            return $user;
        }

        if ( ! Auth::check() ) {
            return null;
        }

        return Auth::user();
    }

    /**
     * @param MembersonProfile|Model $membersonProfile
     * @param Request $request
     * @param UserData|null $userData
     * @param User|null $user
     *
     * @return bool
     */
    protected function updateProfileOnMemberson( Model $membersonProfile, Request $request, ?UserData $userData, ?User $user )
    {
        $userProfile = json_decode( $membersonProfile->data, true );

        // All request data
        $mobile   = $request->get( 'mobile' );
        $country  = $request->get( 'country' );
        $gender   = $request->get( 'gender', 'M' );
        $dob      = $request->get( 'dob' );
        $parentIC = $this->generateParentIC();

        // Update profile
        if ( $userProfile ) {
            if ( $mobile ) {
                // Find index of Mobile
                $mobileIndex = 0;
                foreach ( $userProfile['Phones'] as $index => $phone ) {
                    if ( 'MOBILE' === $phone['Type'] ) {
                        $mobileIndex = $index;
                    }
                }
                $userProfile['Phones'][ $mobileIndex ]['Number'] = $mobile;
            }

            $userProfile['NationalityCode'] = $country;
            $userProfile['GenderCode']      = $gender;

            if ( $dob ) {
                $userProfile['DOB'] = $this->getFormattedDOB( $dob )
                                           ->toJSON();
            }
            $userProfile['IC'] = $parentIC;

            $response = $this
                ->client
                ->updateUserProfile(
                    $userData->memberson_customer_number,
                    $userProfile
                );

            if ( $response->successful() ) {
                $user->mobile  = $mobile;
                $user->country = $country;
                $user->gender  = $gender;
                $user->dob     = $this->getFormattedDOB( $dob );
                $user->ic      = $parentIC;
                $user->save();

                $membersonProfile->data = json_encode( $userProfile );
                $membersonProfile->save();

                return true;
            }

        }

        return false;
    }
}
