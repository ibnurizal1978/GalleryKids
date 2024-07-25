<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGpeExpiresInUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'user_data', function ( Blueprint $table ) {
            $table->timestamp( 'gpe_expires_at' )
                  ->nullable()
                  ->default( null );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'user_data', function ( Blueprint $table ) {
            $table->dropColumn('gpe_expires_at');
        } );
    }
}
