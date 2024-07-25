<?php

namespace App\Exceptions;

use Exception;

class Auth0UserMissingException extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param string $message
     *
     * @return void
     */
    public function __construct( $message = 'Auth0 User is Missing.' )
    {
        parent::__construct( $message );
    }
}
