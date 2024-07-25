<?php


namespace App\Services\Auth0;

use Illuminate\Support\Carbon;

class UserProfile
{
    public $email;
    public $emailVerified = false;
    public $sub;
    public $customerNumber;
    public $memberNumber;
    public $profileToken;
    /**
     * @var Carbon|null
     */
    public $profileTokenExpiry;
    public $accentureUserId;
    public $firstName;
    public $lastName;
    public $guid;

    public function __construct( array $profile )
    {
        $this->setProfileData( $profile );
    }

    public function setProfileData( array $profile )
    {
        $this->email              = $profile['email'] ?? null;
        $this->emailVerified      = (bool) $profile['email_verified'];
        $this->sub                = $profile['sub'] ?? null;
        $this->customerNumber     = $profile[ $this->getCustomerNumberKey() ];
        $this->memberNumber       = $profile[ $this->getMemberNumberKey() ];
        $this->profileToken       = $profile[ $this->getProfileTokenKey() ];
        $this->profileTokenExpiry = Carbon::parse( $profile[ $this->getProfileTokenExpiryKey() ] );
        $this->accentureUserId    = $profile[ $this->getUserIDKey() ];
        $this->firstName          = $profile[ $this->getFirstNameKey() ];
        $this->lastName           = $profile[ $this->getLastNameKey() ];
        $this->guid               = $profile[ $this->getGuidKey() ];
    }

    public function getGuidKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.guid' );

        return $this->getApiDataKey( $endpoint );
    }

    public function getLastNameKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.last_name' );

        return $this->getApiDataKey( $endpoint );
    }

    public function getFirstNameKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.first_name' );

        return $this->getApiDataKey( $endpoint );
    }

    public function getUserIDKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.user_id' );

        return $this->getApiDataKey( $endpoint );
    }

    public function getProfileTokenExpiryKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.profile_token_expiry' );

        return $this->getApiDataKey( $endpoint );
    }

    public function getProfileTokenKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.profile_token' );

        return $this->getApiDataKey( $endpoint );
    }

    public function getMemberNumberKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.member_number' );

        return $this->getApiDataKey( $endpoint );
    }

    public function getCustomerNumberKey()
    {
        $endpoint = config( 'membership.auth0.membership_data.endpoints.customer_number' );

        return $this->getApiDataKey( $endpoint );
    }

    protected function getApiDataKey( $endpoint )
    {
        return sprintf(
            '%s/%s/%s',
            config( 'membership.auth0.membership_data.host' ),
            config( 'membership.auth0.membership_data.suffix' ),
            $endpoint
        );
    }
}
