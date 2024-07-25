<?php


namespace App\Repositories;


use App\Models\UserOtp;
use App\Notifications\SendUserProfileSwitchOTPMail;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function sendOtp( User $user = null )
    {
        $otpData = $this->createOtp( $user );
        if ( ! $otpData || ! $otpData->otp ) {
            return false;
        }

        $user->notify( new SendUserProfileSwitchOTPMail( $user, $otpData->otp ) );

        return true;
    }

    public function createOtp( User $user = null )
    {
        if ( ! $user ) {
            $user = Auth::user();
        }

        $otpData = UserOtp::whereUserId( $user->id )
                          ->first();
        if ( $this->isValidOTP( $otpData ) ) {
            return $otpData;
        }

        $otp = rand( 100000, 999999 );

        return UserOtp::updateOrCreate( [
            'user_id' => $user->id,
        ], [
            'otp'          => $otp,
            'last_sent_at' => now()
        ] );
    }

    public function verifyOtp( $otp, User $user = null )
    {
        if ( ! $user ) {
            $user = Auth::user();
        }

        if ( ! optional( $user )->id ) {
            return false;
        }

        $otpData = UserOtp::whereUserId( $user->id )->first();
        if ( $this->isValidOTP( $otpData ) && $otpData->otp == trim( $otp ) ) {
            $otpData->delete();

            return true;
        }

        return false;
    }

    /**
     * @param UserOtp|null $otpData
     *
     * @return bool
     */
    protected function isValidOTP( UserOtp $otpData = null )
    {
        return $otpData &&
               $otpData->last_sent_at &&
               ! $otpData
                   ->last_sent_at
                   ->addMinutes( config( 'auth.otp_validity' ) )
                   ->isPast();
    }

}
