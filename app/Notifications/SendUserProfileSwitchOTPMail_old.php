<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendUserProfileSwitchOTPMail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var User
     */
    protected $user;

    protected $otp;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param string|integer $otp
     */
    public function __construct( User $user, $otp )
    {
        $this->user = $user;
        $this->otp  = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via( $notifiable )
    {
        return [ 'mail' ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail( $notifiable )
    {
        return ( new MailMessage )
            ->subject( 'One-Time Password for Profile Switching' )
            ->greeting( 'Hi ' . $this->user->first_name . '!' )
            ->line( 'Your One-Time Password is below:' )
            ->with( $this->otp )
            ->line( 'OTP code is valid for ' . config( 'auth.otp_validity' ) . ' minutes.' );
    }
}
