<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableForAuth0Integration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->string( 'password' )->nullable()->change();
            $table->string( 'first_name' )->nullable()->change();
            $table->string( 'last_name' )->nullable()->change();
            $table->string( 'sub' )
                  ->nullable()
                  ->default( null )
                  ->unique();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropColumn( 'sub' );
        } );
    }
}
