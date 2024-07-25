<?php

namespace App\Listeners\Database\State;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class LoadDatabaseStates
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param MigrationsEnded $event
     *
     * @return void
     */
    public function handle( MigrationsEnded $event )
    {
        Artisan::call( 'ensure-database-state-is-loaded' );
    }
}
