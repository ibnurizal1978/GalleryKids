<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( Schema::hasTable( 'categories' ) && ! Schema::hasColumn( 'categories', 'status' ) ) {
            Schema::table( 'categories', function ( Blueprint $table ) {
                $table->integer( 'status' )->default( 1 );
            } );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'categories', function ( Blueprint $table ) {
            $table->dropColumn( 'status' );
        } );
    }
}
