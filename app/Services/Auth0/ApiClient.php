<?php

namespace App\Services\Auth0;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiClient
{
    public function getOauthToken( $email, $password )
    {
        $endpoint     = 'oauth/token';
        $url          = $this->getUrl( $endpoint );
        $clientId     = config( 'laravel-auth0.client_id' );
        $clientSecret = config( 'laravel-auth0.client_secret' );

        return Http::asForm()
                   ->post( $url, [
                       'grant_type'    => 'password',
                       'username'      => $email,
                       'password'      => $password,
                       'client_id'     => $clientId,
                       'client_secret' => $clientSecret
                   ] );
    }

    public function getUrl( $endpoint )
    {
        $domain = config( 'laravel-auth0.domain' );
        if ( ! Str::startsWith( $domain, [ 'https://', 'http://' ] ) ) {
            $domain = 'https://' . $domain;
        }

        return sprintf(
            '%s/%s',
            trim( $domain, '/' ),
            trim( $endpoint, '/' )
        );
    }
}
