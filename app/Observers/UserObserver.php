<?php

namespace App\Observers;

use App\Mail\RegistrationWelcomeEmail;
use App\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\User $user
     *
     * @return void
     */
    public function created( User $user )
    {
//        if ( $user->email ) {
//            Mail::to( $user )->send( new RegistrationWelcomeEmail( $user ) );
//        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\User $user
     *
     * @return void
     */
    public function updated( User $user )
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\User $user
     *
     * @return void
     */
    public function deleted( User $user )
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\User $user
     *
     * @return void
     */
    public function restored( User $user )
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param \App\User $user
     *
     * @return void
     */
    public function forceDeleted( User $user )
    {
        //
    }
}
