<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileToUsersTable extends Migration
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
            if ( ! Schema::hasColumn( $this->table, 'mobile' ) ) {
                $table->string( 'mobile' )
                      ->index()
                      ->nullable()
                      ->default( null );
            }
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
            if ( Schema::hasColumn( $this->table, 'mobile' ) ) {
                $table->dropColumn( 'mobile' );
            }
        } );
    }
}
