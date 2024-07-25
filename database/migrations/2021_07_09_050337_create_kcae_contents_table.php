<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKcaeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'kcae_contents', function ( Blueprint $table ) {
            $table->id();
            $table->text( 'title' );
            $table->text( 'description' )->nullable();
            $table->text( 'mid-section' )->nullable();
            $table->text( 'last-section-top' )->nullable();
            $table->text( 'last-section-box1' )->nullable();
            $table->text( 'last-section-box2' )->nullable();
            $table->text( 'last-section-box3' )->nullable();
            $table->text( 'last-section-bottom' )->nullable();
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
        Schema::dropIfExists( 'kcae_contents' );
    }
}
