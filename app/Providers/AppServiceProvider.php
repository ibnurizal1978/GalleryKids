<?php

namespace App\Providers;

use App\Console\Commands\DownCommand;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Auth0\Login\Contract\Auth0UserRepository::class,
            \App\Repositories\GKAuth0UserRepository::class
        );

        $this->app->extend( 'command.down', function () {
            return new DownCommand();
        } );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load everything over https on production
        if ( config( 'app.env' ) === 'production' && config( 'app.force_ssl' ) ) {
            URL::forceScheme( 'https' );
        }

        // Observers
        User::observe( UserObserver::class );

        // Increase Schema Length for older version of MySQL (Older than MySQL v5.7.7).
        // This error happens: https://prnt.sc/11a85xo
        Schema::defaultStringLength( 191 );
    }
}
