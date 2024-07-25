<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsNullableOnAdminShareTable extends Migration
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
            if ( Schema::hasColumn( $this->table, 'image' ) ) {
                $table->string( 'image', '6000' )
                      ->nullable()
                      ->default( null )
                      ->change();
            }

            if ( Schema::hasColumn( $this->table, 'TITLE' ) ) {
                $table->string( 'TITLE' )
                      ->nullable()
                      ->default( null )
                      ->change();
            }

            if ( Schema::hasColumn( $this->table, 'ARTIST' ) ) {
                $table->string( 'ARTIST' )
                      ->nullable()
                      ->default( null )
                      ->change();
            }

            if ( Schema::hasColumn( $this->table, 'DATE_OF_ART_CREATED' ) ) {
                $table->string( 'DATE_OF_ART_CREATED' )
                      ->nullable()
                      ->default( null )
                      ->change();
            }

            if ( Schema::hasColumn( $this->table, 'CLASSIFICATION' ) ) {
                $table->string( 'CLASSIFICATION' )
                      ->nullable()
                      ->default( null )
                      ->change();
            }

            if ( Schema::hasColumn( $this->table, 'CREDITLINE' ) ) {
                $table->string( 'CREDITLINE' )
                      ->nullable()
                      ->default( null )
                      ->change();
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
        Schema::table( 'admin_share', function ( Blueprint $table ) {
            //
        } );
    }
}
