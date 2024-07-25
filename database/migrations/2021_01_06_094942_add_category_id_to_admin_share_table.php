<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToAdminShareTable extends Migration
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
            if ( ! Schema::hasColumn( $this->table, 'category_id' ) ) {
                $table->bigInteger( 'category_id' )
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
            if ( Schema::hasColumn( $this->table, 'category_id' ) ) {
                $table->dropColumn( 'category_id' );
            }
        } );
    }
}
