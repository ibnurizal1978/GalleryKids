<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeroSliderTitleToKcaeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn( 'kcae_contents', 'hero_slider_title' ) ) {
            Schema::table( 'kcae_contents', function ( Blueprint $table ) {
                $table->text( 'hero_slider_title' )
                      ->nullable()
                      ->after( 'description' );
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
        if ( Schema::hasColumn( 'kcae_contents', 'hero_slider_title' ) ) {
            Schema::table( 'kcae_contents', function ( Blueprint $table ) {
                $table->dropColumn( 'hero_slider_title' );
            } );
        }
    }
}
