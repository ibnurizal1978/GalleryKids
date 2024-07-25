<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKcaeSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'kcae_spaces', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' )->index();
            $table->text( 'description' )->nullable();
            $table->string( 'image' )->nullable();
            $table->unsignedBigInteger( 'category_id' )->nullable();
            $table->timestamps();

            $table->foreign( 'category_id' )
                  ->references( 'id' )
                  ->on( 'kcae_spaces_categories' )
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
        Schema::dropIfExists( 'kcae_spaces' );
    }
}
