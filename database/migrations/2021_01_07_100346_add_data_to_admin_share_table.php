<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToAdminShareTable extends Migration
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
            if ( ! Schema::hasColumn( $this->table, 'data' ) ) {
                $table->text( 'data' )
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
            if ( Schema::hasColumn( $this->table, 'data' ) ) {
                $table->dropColumn( 'data' );
            }
        } );
    }
}
