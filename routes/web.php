<?php

use App\Http\Controllers\Admin\KCAEController;
use App\Http\Controllers\Auth\Auth0Controller;
use App\Http\Controllers\ChangeProfileController;
use App\Http\Controllers\MembersonController;
use App\Http\Controllers\MembersonProfileListAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get( '/clear-cache', function () {
    $exitCode = Artisan::call( 'cache:clear' );

    return '<h1>Cache facade value cleared</h1>';
} );
Route::get( '/config-cache', function () {
    $exitCode = Artisan::call( 'config:cache' );

    return '<h1>Clear Config cleared</h1>';
} );
Route::get( '/clear-route', function () {
    $exitCode = Artisan::call( 'route:clear' );

    return '<h1>Clear Route cleared</h1>';
} );
Route::get( '/clear-view', function () {
    $exitCode = Artisan::call( 'view:clear' );

    return '<h1>Clear View cleared</h1>';
} );
Route::get( '/migrate-database', function () {
    $exitCode = Artisan::call( 'migrate --force' );

    return '<h1>Database Migrated!</h1>';
} );
Route::get( 'storage-link', function () {
    $exitCode = Artisan::call( 'storage:link' );

    return '<h1>Storage Linked!</h1>';
} );
Route::get( 'maintenance', function () {

    return view( 'maintenance' );
} );
//Route::get( 'sync-customer-number', function () {
//    $exitCode = Artisan::call( 'user:sync:customernumber' );
//
//    return '<h1>Customer Number Synced</h1>';
//} );

Route::get( 'remove-orphan-children', function () {
    $exitCode = Artisan::call( 'user:remove_orphan_children' );

    return '<h1>All orphan children removed</h1>';
} );
Route::get( 'invalid-state-exception', function () {
    throw new \Auth0\SDK\Exception\CoreException( 'Invalid state' );
} );
Route::get( '/keppelcentre', 'FrontController@keppelCentre' )->name( 'keppelCentre' );
Route::post( '/newLogin', 'LoginController@LoginStepOne' )->name( 'newLogin' );
Route::get( '/newTestingRegister', 'RegisterController@newTestingRegister' )->name( 'newTestingRegister' );
Route::get( '/{id}/showShare', 'FrontController@singleShare' )->name( 'showShare' );
Route::post( '/LoginTypeTwo', 'LoginController@LoginStepTwo' );
Route::post( '/forgetPassword', 'RegisterController@ForgetPassword' );
Route::post( '/LoginTypeThree', 'LoginController@LoginStepThree' );
Route::Post( '/newRegister', 'RegisterController@newRegister' )->name( 'newRegister' );
Route::get( '/', 'HomeController@home' );
Route::get( '/{tab}', 'FrontController@tab' );
//Route::get('/register/class','RegisterController@registerPageClass')->name('register.form.class');
//Route::get('/register/family','RegisterController@registerPageFamily')->name('register.form.family');
//Route::post('/register/class','RegisterController@registerClass')->name('register.class');
//Route::post('/register/family','RegisterController@registerFamily')->name('register.family');
Route::get( '/verify/otp', 'RegisterController@verifyOtpPage' )->name( 'otp.verify' );
Route::get( '/resend/otp', 'RegisterController@resendOtp' )->name( 'resend.otp' );
Route::post( '/verify/otp', 'RegisterController@verifyOtp' )->name( 'verify.otp' );

Route::get( '/login', 'LoginController@loginPage' )->name( 'login.page' );
Route::post( '/login', 'LoginController@login' )->name( 'login' );
Route::get( '/home', 'RegisterController@home' )->name( 'home' )->middleware( 'auth' );
Route::post( '/logout', 'LoginController@logout' )->name( 'logout' );

Route::get( '/forget/username', 'ForgetPasswordController@forgetUsername' )->name( 'forget.username' );
Route::post( '/forget/username', 'ForgetPasswordController@forgetUsernameSendmail' )->name( 'forget.username.sendmail' );

Route::get( '/forget/password', 'ForgetPasswordController@forgetPassword' )->name( 'forget.password' );
Route::post( '/forget/password', 'ForgetPasswordController@forgetPasswordSendOTP' )->name( 'password.reset.otp' );
Route::get( '/reset/password/verify_otp', 'ForgetPasswordController@verifyOTPPage' )->name( 'password.reset.verify' );
Route::get( '/reset/password/resend_otp', 'ForgetPasswordController@resendOTP' )->name( 'resend.otp.password.reset' );
Route::get( '/password/reset/verify_otp', 'ForgetPasswordController@verifyOTP' )->name( 'password.reset.verify.otp' );
Route::post( '/reset/newpassword', 'ForgetPasswordController@resetPassword' )->name( 'reset.password' );

Route::get( '/dbsetup', 'HomeController@dbsetup' );
Route::get( '/admin/login', 'LoginController@adminLogin' )->name( 'admin.login' );
Route::Post( 'loginAdmin', 'LoginController@login' )->name( 'loginAdmin' );
//Route::Post('sharePoints','FrontController@sharePoints')->name('sharePoints');

Route::get( '/auth0/callback', [ Auth0Controller::class, 'callback' ] )->name( 'auth0-callback' );
Route::get( '/sso/login', [ Auth0Controller::class, 'login' ] )->name( 'sso-login' );
Route::get( '/sso/logout', [ Auth0Controller::class, 'logout' ] )->name( 'sso-logout' );
Route::get( '/sso/login2', [ Auth0Controller::class, 'login2' ] )->name( 'sso-login2' );
//Route::get( '/my/profile', [ Auth0Controller::class, 'profile' ] )->name( 'myprofile' );

/* ============== NEW 3 MODULES ================ */
Route::get( '/explore/new', 'Admin\ExploreController@frontExplore')->name('/explore/new');
Route::get( '/play/new', 'Admin\PlayController@frontExplore')->name('/play/new');
Route::get( '/festivals/new', 'Admin\FestivalsController@frontExplore')->name('/festivals/new');
/* ============== NEW 3 MODULES ================ */


Route::middleware( 'auth' )->group( function () {

    // Memberson Details
    Route::post( 'memberson-ge-upgrade', [
        MembersonController::class,
        'upgradeGalleryExplorerMembership'
    ] )->name( 'membersonGEUpgrade' );

    Route::post( 'add-kids', [
        MembersonController::class,
        'addKids'
    ] )->name( 'memberson-add-kids' );

    Route::post( 'update-profile-info', [
        MembersonController::class,
        'updateProfile'
    ] )->name( 'update-profile-info' );

    // Change Profile
    Route::prefix( 'change-profile' )->group( function () {
        Route::post( '/send-opt', [
            ChangeProfileController::class,
            'sendOtp'
        ] )->name( 'profile-otp' );

        Route::post( '/child', [
            ChangeProfileController::class,
            'childLogin'
        ] )->name( 'child-login' );

        Route::post( '/parent', [
            ChangeProfileController::class,
            'parentLogin'
        ] )->name( 'parent-login' );
    } );
} );


// Admin Panels
Route::prefix( 'admin' )
     ->middleware( 'admin' )
     ->name( 'admin.' )
     ->group( function () {

         // Memberson Profile API Data in Admin Panel
         Route::prefix( 'memberson-profile' )
              ->group( function () {
                  Route::get( '/list', [
                      MembersonProfileListAdminController::class,
                      'index'
                  ] )->name( 'memberson-profile.list' );
              } );

         // KCAE
         Route::prefix( 'kcae' )
              ->name( 'kcae.' )
              ->group( function () {
                  Route::get(
                      'page-content',
                      [ KCAEController::class, 'pageContent' ]
                  )->name( 'page-content' );
                  Route::post(
                      'page-content',
                      [ KCAEController::class, 'updatePageContent' ]
                  );

                  // Hero Slider
                  Route::resource( 'hero-slides', 'Admin\KCAEHeroSliderController' );

                  // Spaces
                  Route::prefix( 'spaces' )
                       ->name( 'spaces.' )
                       ->group( function () {

                           // Categories
                           Route::prefix( 'categories' )
                                ->name( 'categories.' )
                                ->group( function () {
                                    Route::get(
                                        '/',
                                        [ KCAEController::class, 'categories' ]
                                    )->name( 'index' );

                                    Route::get(
                                        'add',
                                        [ KCAEController::class, 'addCategory' ]
                                    )->name( 'add' );
                                    Route::post(
                                        'add',
                                        [ KCAEController::class, 'insertCategory' ]
                                    );

                                    Route::get(
                                        'edit/{category}',
                                        [ KCAEController::class, 'editCategory' ]
                                    )->name( 'edit' );
                                    Route::put(
                                        'edit/{category}',
                                        [ KCAEController::class, 'updateCategory' ]
                                    );

                                    Route::delete(
                                        '{category}',
                                        [ KCAEController::class, 'deleteCategory' ]
                                    )->name( 'delete' );
                                } );

                           Route::get( '/', [ KCAEController::class, 'spaces' ] )
                                ->name( 'index' );

                           Route::get( 'add', [ KCAEController::class, 'addSpace' ] )
                                ->name( 'add' );
                           Route::post( 'add', [ KCAEController::class, 'insertSpace' ] );

                           Route::get( 'edit/{space}', [ KCAEController::class, 'editSpace' ] )
                                ->name( 'edit' );
                           Route::put( 'edit/{space}', [ KCAEController::class, 'updateSpace' ] );

                           Route::delete( '{space}', [ KCAEController::class, 'deleteSpace' ] )
                                ->name( 'delete' );

                           Route::prefix( 'slides' )
                                ->name( 'slides.' )
                                ->group( function () {
                                    Route::get( '/', [ KCAEController::class, 'slides' ] )
                                         ->name( 'index' );

                                    Route::get( 'add', [ KCAEController::class, 'addSlide' ] )
                                         ->name( 'add' );
                                    Route::post( 'add', [ KCAEController::class, 'insertSlide' ] );

                                    Route::get( 'edit/{slide}', [ KCAEController::class, 'editSlide' ] )
                                         ->name( 'edit' );
                                    Route::put( 'edit/{slide}', [ KCAEController::class, 'updateSlide' ] );

                                    Route::delete( '{slide}', [ KCAEController::class, 'deleteSlide' ] )
                                         ->name( 'delete' );
                                } );
                       } );

              } );


            /* ----------------- NEW Nov 2021 -------------- */
              
            /* --------- EXPLORE MODULE -----------*/
            Route::prefix( 'explore' )->name( 'explore.' )->group( function () {
            Route::get('page-content', 'Admin\ExploreController@pageContent')->name( 'page-content' );
            Route::post('page-content','Admin\ExploreController@updatePageContent');

            // Hero Slider
            Route::resource( 'hero-slides', 'Admin\KCAEHeroSliderController' );

            // Spaces
            Route::prefix( 'spaces' )->name( 'spaces.' )->group( function () {

                // Categories
                Route::prefix( 'categories' )->name( 'categories.' )->group( function () {
                    Route::get('/','Admin\ExploreController@categories')->name( 'index' );
                    Route::get('add','Admin\ExploreController@addCategory')->name( 'add' );
                    Route::post('add', 'Admin\ExploreController@insertCategory');
                    Route::get('edit/{category}', 'Admin\ExploreController@editCategory')->name( 'edit' );
                    Route::post('edit/{category}', 'Admin\ExploreController@updateCategory');
                    Route::delete('{category}', 'Admin\ExploreController@deleteCategory')->name( 'delete' );
                });

                    Route::get( '/', 'Admin\ExploreController@spaces')->name( 'index' );
                    Route::get( 'add', 'Admin\ExploreController@addSpace')->name( 'add' );
                    Route::post( 'add', 'Admin\ExploreController@insertSpace')->name( 'add' );
                    Route::get( 'edit/{space}', 'Admin\ExploreController@editSpace' )->name( 'edit' );
                    Route::post( 'edit', 'Admin\ExploreController@updateSpace' )->name( 'edit2' );
                    Route::get( 'delete/{id}', 'Admin\ExploreController@deleteSpace' )->name( 'delete' );

                    Route::prefix( 'slides' )->name( 'slides.' )->group( function () {
                        Route::get( '/', [ KCAEController::class, 'slides' ] )->name( 'index' );
                        Route::get( 'add', [ KCAEController::class, 'addSlide' ] )->name( 'add' );
                        Route::post( 'add', [ KCAEController::class, 'insertSlide' ] );
                        Route::get( 'edit/{slide}', [ KCAEController::class, 'editSlide' ] )->name( 'edit' );
                        Route::put( 'edit/{slide}', [ KCAEController::class, 'updateSlide' ] );
                        Route::delete( '{slide}', [ KCAEController::class, 'deleteSlide' ] )->name( 'delete' );
                    });
                });
            });
            /* --------- END EXPLORE MODULE -----------*/

            /* --------- PLAY MODULE -----------*/
            Route::prefix( 'play' )->name( 'play.' )->group( function () {
                Route::get('page-content', 'Admin\PlayController@pageContent')->name( 'page-content' );
                Route::post('page-content','Admin\PlayController@updatePageContent');
    
                // Hero Slider
                Route::resource( 'hero-slides', 'Admin\KCAEHeroSliderController' );
    
                // Spaces
                Route::prefix( 'spaces' )->name( 'spaces.' )->group( function () {
    
                    // Categories
                    Route::prefix( 'categories' )->name( 'categories.' )->group( function () {
                        Route::get('/','Admin\PlayController@categories')->name( 'index' );
                        Route::get('add','Admin\PlayController@addCategory')->name( 'add' );
                        Route::post('add', 'Admin\PlayController@insertCategory');
                        Route::get('edit/{category}', 'Admin\PlayController@editCategory')->name( 'edit' );
                        Route::post('edit/{category}', 'Admin\PlayController@updateCategory');
                        Route::delete('{category}', 'Admin\PlayController@deleteCategory')->name( 'delete' );
                    });
    
                        Route::get( '/', 'Admin\PlayController@spaces')->name( 'index' );
                        Route::get( 'add', 'Admin\PlayController@addSpace')->name( 'add' );
                        Route::post( 'add', 'Admin\PlayController@insertSpace')->name( 'add' );
                        Route::get( 'edit/{space}', 'Admin\PlayController@editSpace' )->name( 'edit' );
                        Route::post( 'edit', 'Admin\PlayController@updateSpace' )->name( 'edit2' );
                        Route::get( 'delete/{id}', 'Admin\PlayController@deleteSpace' )->name( 'delete' );
    
                        Route::prefix( 'slides' )->name( 'slides.' )->group( function () {
                            Route::get( '/', [ KCAEController::class, 'slides' ] )->name( 'index' );
                            Route::get( 'add', [ KCAEController::class, 'addSlide' ] )->name( 'add' );
                            Route::post( 'add', [ KCAEController::class, 'insertSlide' ] );
                            Route::get( 'edit/{slide}', [ KCAEController::class, 'editSlide' ] )->name( 'edit' );
                            Route::put( 'edit/{slide}', [ KCAEController::class, 'updateSlide' ] );
                            Route::delete( '{slide}', [ KCAEController::class, 'deleteSlide' ] )->name( 'delete' );
                        });
                    });
                });
                /* --------- END PLAY MODULE -----------*/

                 /* --------- FESTIVALS MODULE -----------*/
                Route::prefix( 'festivals' )->name( 'festivals.' )->group( function () {
                Route::get('page-content', 'Admin\FestivalsController@pageContent')->name( 'page-content' );
                Route::post('page-content','Admin\FestivalsController@updatePageContent');
    
                // Hero Slider
                Route::resource( 'hero-slides', 'Admin\KCAEHeroSliderController' );
    
                // Spaces
                Route::prefix( 'spaces' )->name( 'spaces.' )->group( function () {
    
                    // Categories
                    Route::prefix( 'categories' )->name( 'categories.' )->group( function () {
                        Route::get('/','Admin\FestivalsController@categories')->name( 'index' );
                        Route::get('add','Admin\FestivalsController@addCategory')->name( 'add' );
                        Route::post('add', 'Admin\FestivalsController@insertCategory');
                        Route::get('edit/{category}', 'Admin\FestivalsController@editCategory')->name( 'edit' );
                        Route::post('edit/{category}', 'Admin\FestivalsController@updateCategory');
                        Route::delete('{category}', 'Admin\FestivalsController@deleteCategory')->name( 'delete' );
                    });
    
                        Route::get( '/', 'Admin\FestivalsController@spaces')->name( 'index' );
                        Route::get( 'add', 'Admin\FestivalsController@addSpace')->name( 'add' );
                        Route::post( 'add', 'Admin\FestivalsController@insertSpace')->name( 'add' );
                        Route::get( 'edit/{space}', 'Admin\FestivalsController@editSpace' )->name( 'edit' );
                        Route::post( 'edit', 'Admin\FestivalsController@updateSpace' )->name( 'edit2' );
                        Route::get( 'delete/{id}', 'Admin\FestivalsController@deleteSpace' )->name( 'delete' );
    
                        Route::prefix( 'slides' )->name( 'slides.' )->group( function () {
                            Route::get( '/', [ KCAEController::class, 'slides' ] )->name( 'index' );
                            Route::get( 'add', [ KCAEController::class, 'addSlide' ] )->name( 'add' );
                            Route::post( 'add', [ KCAEController::class, 'insertSlide' ] );
                            Route::get( 'edit/{slide}', [ KCAEController::class, 'editSlide' ] )->name( 'edit' );
                            Route::put( 'edit/{slide}', [ KCAEController::class, 'updateSlide' ] );
                            Route::delete( '{slide}', [ KCAEController::class, 'deleteSlide' ] )->name( 'delete' );
                        });
                    });
                });
                /* --------- END FESTIVALS MODULE -----------*/


         /* ----------------- NEW Nov 2021 -------------- */


         // Users
         Route::prefix( 'users' )
              ->name( 'users.' )
              ->group( function () {
                  Route::get( '/search', [
                      \App\Http\Controllers\Admin\UserController::class,
                      'search'
                  ] )->name( 'search' );

                  Route::delete( '/{user}', [
                      \App\Http\Controllers\Admin\UserController::class,
                      'destroy'
                  ] )->name( 'delete' );
              } );

     } );
