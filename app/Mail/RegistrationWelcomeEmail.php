<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct( User $user )
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return RegistrationWelcomeEmail|false
     */
    public function build()
    {
        if ( ! $this->user->email ) {
            return false;
        }

        return $this
            ->subject( 'Welcome to GalleryKids!' )
            ->view( 'emails.register' );
    }
}
