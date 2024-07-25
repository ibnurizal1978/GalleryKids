<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailIndexesOnUsersTable extends Migration
{
    protected $table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( $this->table, function ( Blueprint $table ) {
            $table->string( 'email' )
                  ->nullable()
                  ->index()
                  ->change();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( $this->table, function ( Blueprint $table ) {
            //
        } );
    }
}
