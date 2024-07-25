<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendChildrenUsernames;
use App\Mail\PasswordResetOTP;
use App\PasswordReset;
use Carbon\Carbon;
use App\User;



class ForgetPasswordController extends Controller
{
    /**
     * forget username classes.
     */
    
    
    public function forgetUsername()
    {
        $route = 'forget.username.sendmail';
        return view('password.reset_request',compact('route'));
    }

     /**
     * send mail user for forget username.
     */
    
    
    public function forgetUsernameSendmail(Request $request)
    {   
        $request->validate([
            'email' => 'required|string|exists:users,email',
        ]);

        $user = User::where('email',$request['email'])->first();
        if($user->status == 'Disable')
        {
            session()->flash('error','Your account is disabled');  
            return redirect()->back();
        }
        $parents = $user->children()->first()->parents;    
        Mail::to($user->email)->send(new SendChildrenUsernames($user->children,$parents));
        session()->flash('success','A mail containing usernames has been sent to you');
        return redirect()->back();
    }

    /**
      * forget password classes.
     */
    
    public function forgetPassword()
    {
    	return view('password.reset_request');
    }
    
    /**
     * send mail user for forget password.
     */

    public function forgetPasswordSendOTP(Request $request)
    {
    	$request->validate([
            'email' => 'required|string|exists:users,email',
        ]);

        $user = User::where('email',$request['email'])->first();
        if($user->status == 'Disable')
        {
            session()->flash('error','Your account is disabled');  
            return redirect()->back();
        } 
        
        $otp = rand(10000,99999);

        $token = hash_hmac('md5', $user->email, 'kidsclub_ngs');

        $date_time = date('Y-m-d H:i:s');

        Mail::to($user->email)->send(new PasswordResetOTP($otp));        

        PasswordReset::updateOrCreate(['email' => $user->email] , ['otp' => $otp, 'token' => $token, 'created_at' => $date_time,'updated_at' => $date_time]);

        session()->flash('success','An otp has been sent to your mail');
        return redirect()->route('password.reset.verify',['token' => $token]);
            
    }
    
    /**
     * verify otp view load.
     */

    public function verifyOTPPage(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:password_resets,token',
        ]);
        
        $token = $request->token;

        return view('password.verify_otp',compact('token'));
    }

    /**
     * resend otp.
     */
    
    public function resendOTP(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:password_resets,token',
        ]);
        
        $data = $request->all();

        $reset_request = PasswordReset::where('token',$data['token'])->first();

        $otp = rand(10000,99999);

        $date_time = date('Y-m-d H:i:s');

        Mail::to($reset_request->email)->send(new PasswordResetOTP($otp));        

        PasswordReset::updateOrCreate(['email' => $reset_request->email] , ['otp' => $otp, 'created_at' => $date_time,'updated_at' => $date_time]);

        session()->flash('success','An otp has been sent to your mail');
        return redirect()->back();

    }

    
    /**
     * verify otp.
     */
    
    public function verifyOTP(Request $request)
    {
       $request->validate([
            'token' => 'required|string',
            'otp' => 'required|string',
        ]);

        $data = $request->all();

        $reset_request = PasswordReset::where('token',$data['token'])->first();

        if($reset_request->otp == $data['otp'])
        return view('password.reset',compact('data'));
        session()->flash('error','Invalid OTP');
        return redirect()->route('password.reset.verify',['token' => $reset_request->token]);

    }

    
    /**
     * display reset password view.
     */
    
    public function resetPasswordPage(Request $request)
    {
    	$request->validate([
            'token' => 'required|string',
        ]);

        $data = $request->all();

        return view('password.reset',compact('data'));
    }

    /**
     * reset password.
     */
    
    public function resetPassword(Request $request)
    {
        $request->validate([

        'token' => 'required|string|exists:password_resets,token',    
        'username' => 'required|string|exists:users,username',
        'password' => 'required|min:8|confirmed',
        
        ]);

        $data = $request->all(); 
        
        $user = User::where('username',$request['username'])->first();

        $password_reset = PasswordReset::where('token',$data['token'])->first();

        if($user->isStudent())
        {
            $parent = $user->parents()->whereNotNull('email')->first();
            
        }
        else
        {
            $parent = $user;
            if(is_null($user->email))
            {
               $parent = $user->children()->first()->parents()->whereNotNull('email')->first(); 
            }
        }   

        if($parent->email != $password_reset->email)
        {
            session()->flash('success',"You dont't have permission to reset password of this user");
            return redirect()->back();
        }    

        $user->update(['password' => bcrypt($data['password'])]);
        
        session()->flash('success',"Password reset successful for {$user->username}");

        return redirect('/');

    }

}
