<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUidToAdminShareTable extends Migration
{
    protected $tableName = 'admin_share';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( $this->tableName, function ( Blueprint $table ) {
            $table->id()->change();
            if ( ! Schema::hasColumn( $this->tableName, 'uid' ) ) {
                $table->unsignedInteger( 'uid' )
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
        Schema::table( 'admin_share', function ( Blueprint $table ) {
            if ( Schema::hasColumn( $this->tableName, 'uid' ) ) {
                $table->dropColumn( 'uid' );
            }
        } );
    }
}
