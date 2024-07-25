<?php

namespace App\Services\Auth0;

class Manager
{
    /**
     * @var ApiClient
     */
    protected $client;

    public function __construct( ApiClient $client )
    {
        $this->client = $client;
    }

    public function verifyPassword( $email, $password )
    {
        $response = $this->client
            ->getOauthToken( $email, $password );

        return $response->successful();
    }

}
