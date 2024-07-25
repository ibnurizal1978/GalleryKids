<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKcaeSpacesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'kcae_spaces_categories', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->unsignedInteger( 'serial' )->default( 1000 );
            $table->string( 'status' )->default( 'enabled' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'kcae_spaces_categories' );
    }
}
