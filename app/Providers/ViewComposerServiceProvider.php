<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'admin::layouts.master', 'App\Http\View\Composers\TemplateComposer'
            
        );

        View::composer(
            'layouts.master', 'App\Http\View\Composers\BannerComposer'
        );

        View::composer(
            'layouts.navbar', 'App\Http\View\Composers\NavbarComposer'
        );
    }
}
