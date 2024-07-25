<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth0UserMissingException;
use App\Repositories\GKAuth0UserRepository;
use App\Repositories\MembersonRepository;
use App\Services\Memberson\Client;
use Auth0\Login\Contract\Auth0UserRepository;
use Auth0\Login\Facade\Auth0;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Validation\UnauthorizedException;

class Auth0Controller extends Controller
{
    /**
     * @var GKAuth0UserRepository
     */
    protected $userRepository;

    /**
     * Auth0Controller constructor.
     *
     * @param GKAuth0UserRepository $userRepository
     */
    public function __construct( GKAuth0UserRepository $userRepository )
    {
        $this->userRepository = $userRepository;
    }

    public function login()
    {
       /* if ( Auth::check() ) {
            return redirect()->intended( '/' );
        }*/

/* 

for live, use https://login.nationalgallery.sg/v2/logout?client_id=EX9qfbj36Nhi7NE7AYGHPXalkbXLLts0&returnTo=https://login.nationalgallery.sg/gallerykids/sso/login2'
https://www.nationalgallery.sg/gallerykids/sso/logout
for staging, use https://ngs-development.au.auth0.com/v2/logout?client_id=gj5QAYRgQ5bwOhfnS5tKEP2wHmGGDyQE&returnTo=https://staging.nationalgallery.sg/gallerykids/sso/login2
*/

   return redirect('https://login.nationalgallery.sg/v2/logout?client_id=EX9qfbj36Nhi7NE7AYGHPXalkbXLLts0&returnTo=https://www.nationalgallery.sg/gallerykids/sso/login2');
        Auth::logout();
        return $this->login2();
}

    public function login2()
    {

        $params          = request()->query->all();
        $params['scope'] = 'openid name first_name last_name email email_verified';

        return App::make( 'auth0' )->login(
            null,
            null,
//            [ 'scope' => 'openid name email email_verified' ],
            $params,
            'code'
        );
    }

    public function logout()
    {
        Auth::logout();
        $logoutUrl = sprintf(
            'https://%s/v2/logout?client_id=%s&returnTo=%s',
            config( 'laravel-auth0.domain' ),
            config( 'laravel-auth0.client_id' ),
            config( 'app.url' )
        );

        return Redirect::intended( $logoutUrl );
    }

    public function profile()
    {
        if ( ! Auth::check() ) {
            return redirect()->route( 'login' );
        }

        return view( 'profile' )->with(
            'user',
            print_r( Auth::user()->getUserInfo(), true )
        );
    }

    /**
     * Callback action that should be called by auth0, logs the user in.
     */
    public function callback()
    {
        // Try to get the user information
        $profile = Auth0::getUser();

        // URL: https://staging.nationalgallery.sg/gallerykids/auth0/callback?error=unauthorized&error_description=Authentication%20failed%20-%20Rule&state=df5bd3f58a85574074bcff88b13a0637
        // Throw Login Failed if User Profile not Returned by The Auth0
        if ( ! $profile ) {
            throw new Auth0UserMissingException();
        }

        // Get the user related to the profile
        $auth0User = $this->userRepository->getUserByUserInfo( $profile );

        if ( $auth0User ) {
            // If we have a user, we are going to log them in, but if
            // there is an onLogin defined we need to allow the Laravel developer
            // to implement the user as they want an also let them store it.
            if ( Auth0::hasOnLogin() ) {
                $user = Auth0::callOnLogin( $auth0User );
            } else {
                // If not, the user will be fine
                $user = $auth0User;
            }

            Auth::login( $user, Auth0::rememberUser() );
        }

        $client = new Client();
        $client->getMembershipSummary();
        $client->checkGPEBenefitCode(); // Check if GPE benefit exists and update in the database
        $client->upsertKids(); // update all kids in the database
        $client->checkIfMembershipExpired(); // Logout if GPE access expired
        $client->getUserProfile(); // load user profile and add it to the cache to use it later

        $membersonRepo = resolve( MembersonRepository::class );
        $membersonRepo->updateExistingChildrenMissingIC(); // Update Missing IC of Existing Kids

        return Redirect::intended( '/' );
    }
}
