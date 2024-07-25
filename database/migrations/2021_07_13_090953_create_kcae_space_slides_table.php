<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKcaeSpaceSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'kcae_space_slides', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' )->index();
            $table->text( 'description' )->nullable();
            $table->string( 'image' )->nullable();
            $table->unsignedBigInteger( 'space_id' )->nullable();
            $table->timestamps();

            $table->foreign( 'space_id' )
                  ->references( 'id' )
                  ->on( 'kcae_spaces' )
                  ->nullOnDelete();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'kcae_space_slides' );
    }
}
