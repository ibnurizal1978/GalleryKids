<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDimensionMediumToAdminShareTable extends Migration
{
    protected $table = 'admin_share';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( $this->table, function ( Blueprint $table ) {
            if ( ! Schema::hasColumn( $this->table, 'dimension' ) ) {
                $table->string( 'dimension' )
                      ->nullable()
                      ->default( null );
            }

            if ( ! Schema::hasColumn( $this->table, 'medium' ) ) {
                $table->string( 'medium' )
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
            if ( Schema::hasColumn( $this->table, 'dimension' ) ) {
                $table->dropColumn( 'dimension' );
            }

            if ( Schema::hasColumn( $this->table, 'medium' ) ) {
                $table->dropColumn( 'medium' );
            }
        } );
    }
}
