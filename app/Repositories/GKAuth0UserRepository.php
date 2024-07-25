<?php

namespace App\Repositories;

use App\Models\UserData;
use App\Role;
use App\Services\Auth0\UserProfile;
use App\Services\Memberson\Client;
use App\User;
use Auth0\Login\Auth0JWTUser;
use Auth0\Login\Repository\Auth0UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GKAuth0UserRepository extends Auth0UserRepository
{
    protected function upsertUser( UserProfile $profile )
    {
        $user = $this->getUser( $profile );
        $this->upsertUserData( $profile, $user );

        return $user;
    }

    public function getUserByDecodedJWT( array $decodedJwt ): Authenticatable
    {
        $user = $this->upsertUser( $decodedJwt );

        return new Auth0JWTUser( $user->getAttributes() );
    }

    public function getUserByUserInfo( array $userinfo ): Authenticatable
    {
        $user = $this->upsertUser( new UserProfile( $userinfo['profile'] ) );

        // Log UserInfo sent by Auth0 for debug purpose
        Log::driver( 'auth0' )
           ->info( "User ID: {$user->id}", $userinfo );

        return $user;
    }

    public function upsertUserData( UserProfile $profile, User $user )
    {
        $userData = UserData::updateOrCreate( [
            'user_id' => $user->id
        ], [
            'memberson_customer_number' => $profile->customerNumber,
            'memberson_member_number'   => $profile->memberNumber,
            'accenture_user_id'         => $profile->accentureUserId,
            'profile_token'             => $profile->profileToken,
            'profile_token_expires_at'  => $profile->profileTokenExpiry,
            'email_verified'            => $profile->emailVerified,
        ] );

        return $userData;
    }

    /**
     * @param UserProfile $profile
     *
     * @throws \Exception
     */
    protected function deleteMatchingUser( UserProfile $profile ): void
    {
        $query = User::whereEmail( $profile->email )->orWhere( 'sub', $profile->sub );
        $users = $query->get();

        if ( $users->count() ) {
            DB::table( 'relation_user' )->whereIn( 'parent_id', $users->pluck( 'id' )->toArray() )->delete();

            $query->delete();
        }
    }

    protected function getUser( UserProfile $profile )
    {
        if ( $user = $this->getUserByGuid( $profile ) ) {
            return $user;
        }

        if ( $user = $this->getUserByEmail( $profile ) ) {
            return $user;
        }

        return $this->createUser( $profile );
    }

    protected function getUserByGuid( UserProfile $profile )
    {
        $user = User::firstWhere( 'guid', $profile->guid );
        if ( ! $user ) {
            return null;
        }

        $user->sub        = $profile->sub;
        $user->email      = $profile->email;
        $user->first_name = $profile->firstName;
        $user->last_name  = $profile->lastName;
        $user->save();

        return $user;
    }

    protected function getUserByEmail( UserProfile $profile )
    {
        $user = User::firstWhere( 'email', $profile->email );
        if ( ! $user ) {
            return null;
        }

        $user->sub        = $profile->sub;
        $user->guid       = $profile->guid;
        $user->first_name = $profile->firstName;
        $user->last_name  = $profile->lastName;
        $user->save();

        return $user;
    }

    protected function createUser( UserProfile $profile )
    {
        $role = Role::whereName( 'guardian' )->first();

        return User::updateOrCreate( [
            'guid' => $profile->guid
        ], [
            'sub'        => $profile->sub,
            'email'      => $profile->email,
            'first_name' => $profile->firstName,
            'last_name'  => $profile->lastName,
            'role_id'    => $role->id,
            'status'     => 'Enable',
        ] );
    }
}
