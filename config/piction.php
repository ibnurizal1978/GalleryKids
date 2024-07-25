<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Piction API Details
    |--------------------------------------------------------------------------
    |
    | All the details of Piction API.
    |
    */

    'api' => [
        'host'     => env( 'PICTION_API_HOST' ),
        'username' => env( 'PICTION_API_USERNAME' ),
        'password' => env( 'PICTION_API_PASSWORD' ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Piction Caching
    |--------------------------------------------------------------------------
    |
    | Caching various response data from Piction to save some requests
    |
    */

    'cache_lifetime' => [
        'surl_token' => env( 'PICTION_SURL_TOKEN_CACHE_LIFETIME', 5 ), // In minutes
    ],

];
