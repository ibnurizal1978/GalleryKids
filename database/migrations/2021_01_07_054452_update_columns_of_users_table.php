<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsOfUsersTable extends Migration
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
            // Remove Unnecessary Columns
            if ( Schema::hasColumn( $this->table, 'year_of_birth' ) ) {
                $table->dropColumn( 'year_of_birth' );
            }

            if ( Schema::hasColumn( $this->table, 'hash' ) ) {
                $table->dropColumn( 'hash' );
            }

            if ( Schema::hasColumn( $this->table, 'membersonCustNumber' ) ) {
                $table->dropColumn( 'membersonCustNumber' );
            }

            if ( Schema::hasColumn( $this->table, 'profileToken' ) ) {
                $table->dropColumn( 'profileToken' );
            }

            if ( Schema::hasColumn( $this->table, 'memberNo' ) ) {
                $table->dropColumn( 'memberNo' );
            }


            // Add Columns
            if ( ! Schema::hasColumn( $this->table, 'ref_number' ) ) {
                $table->string( 'ref_number' )
                      ->index()
                      ->nullable()
                      ->default( null );
            }

            if ( ! Schema::hasColumn( $this->table, 'ref_number' ) ) {
                $table->string( 'ic' )
                      ->index()
                      ->nullable()
                      ->default( null );
            }

            if ( ! Schema::hasColumn( $this->table, 'ref_number' ) ) {
                $table->date( 'dob' )
                      ->nullable()
                      ->default( null );
            }

            if ( ! Schema::hasColumn( $this->table, 'gender' ) ) {
                $table->string( 'gender' )
                      ->nullable()
                      ->default( null );
            }

            if ( ! Schema::hasColumn( $this->table, 'country' ) ) {
                $table->string( 'country' )
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
            $table->dropColumn( [
                'ref_number',
                'ic',
                'dob',
                'gender',
                'country',
            ] );
        } );
    }
}
