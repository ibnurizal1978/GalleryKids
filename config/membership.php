<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Membership Details comes with Auth0 Authentication
    |--------------------------------------------------------------------------
    |
    | In this section there are several details of membership claim API. Which
    | comes with Auth0 SSO response. An example will look like this:
    |    array:12 [▼
    |      "http://ngs.flex-solver.app/claim/customernumber" => "00027362"
    |      "http://ngs.flex-solver.app/claim/profiletoken" => "8f9f4ce9-3fb4-459f-adad-1db2e369ccd8"
    |      "http://ngs.flex-solver.app/claim/profiletokenexpiry" => "2020-12-18 05:33:11"
    |      "http://ngs.flex-solver.app/claim/accentureuserid" => 20007
    |      "email" => "voxov14400@cctyoo.com"
    |      "email_verified" => false
    |      "iss" => "https://ngs-development.au.auth0.com/"
    |      "sub" => "auth0|5fdaed95b59fba00698a0a92"
    |      "aud" => "gj5QAYRgQ5bwOhfnS5tKEP2wHmGGDyQE"
    |      "iat" => 1608183192
    |      "exp" => 1608219192
    |      "nonce" => "4bb9daf3c5bfa366f8cff9f7dc1cafae"
    |    ]
    |
    */

    'auth0' => [
        'membership_data' => [
            'host'      => env( 'AUTHO_MEMBERSHIP_DATA_DOMAIN', 'http://ngs.flex-solver.app' ),
            'suffix'    => env( 'AUTHO_MEMBERSHIP_DATA_SUFFIX', 'claim' ),
            'endpoints' => [
                'customer_number'      => env( 'AUTHO_MEMBERSHIP_CUSTOMER_NUMBER_ENDPOINT', 'customernumber' ),
                'member_number'        => env( 'AUTHO_MEMBERSHIP_MEMBER_NUMBER_ENDPOINT', 'membernumber' ),
                'profile_token'        => env( 'AUTHO_MEMBERSHIP_PROFILE_TOKEN_ENDPOINT', 'profiletoken' ),
                'profile_token_expiry' => env( 'AUTHO_MEMBERSHIP_PROFILE_TOKEN_EXPIRY_ENDPOINT', 'profiletokenexpiry' ),
                'user_id'              => env( 'AUTHO_MEMBERSHIP_USER_ID_ENDPOINT', 'accentureuserid' ),
                'first_name'           => env( 'AUTHO_MEMBERSHIP_FIRST_NAME_ENDPOINT', 'firstname' ),
                'last_name'            => env( 'AUTHO_MEMBERSHIP_LAST_NAME_ENDPOINT', 'lastname' ),
                'guid'            => env( 'AUTHO_MEMBERSHIP_GUID_ENDPOINT', 'idguid' ),
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Memberson Access Settings
    |--------------------------------------------------------------------------
    |
    | This part will hold all of the access details of memberson API
    |
    */

    'memberson' => [
        'username' => env( 'MEMBERSON_API_USERNAME' ),
        'password' => env( 'MEMBERSON_API_PASSWORD' ),
        'svc_auth' => env( 'MEMBERSON_API_SVC_AUTH' ),
        'domain'   => env( 'MEMBERSON_API_DOMAIN' ),
        'suffix'   => env( 'MEMBERSON_API_SUFFIX', 'api' ),

        'cache' => [
            'lifetime' => [
                'auth_token' => 60, // In minutes
            ],
            'keys'     => [
                'auth_token' => 'memberson_auth_token'
            ]
        ],

        'parent_benefit_types' => [
            'Gallery Insider (SG/PR) Adult',
            'Gallery Insider (SG/PR) Senior',
            'Gallery Insider (SG/PR) Student',
            'Gallery Insider (Non-SG) Adult',
            'Gallery Insider (Non-SG) Senior',
            'Gallery Insider (Non-SG) Student',
            'Gallery Insider Corporate',
            'Patron',
            'Corporate Patron',
            'Art Donor',
            'BFG',
            'PG Recipient',
            'Complimentary',
            'Adopt Now – Complimentary',
        ]
    ],

    'kids_max_age' => env( 'KIDS_MAX_AGE', 12 ),
    'fake_kid_ics' => 'K0000091335', // Comma-seperated values
];
