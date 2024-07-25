<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminShareDerivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'admin_share_derivs', function ( Blueprint $table ) {
            $table->id();
            $table->integer( 'share_id' )->index();
            $table->unsignedBigInteger( 'uid' )
                  ->nullable()
                  ->default( null )
                  ->index();
            $table->unsignedInteger( 'order' )
                  ->nullable()
                  ->default( null );
            $table->string( 'image' );
            $table->unsignedInteger( 'width' )
                  ->nullable()
                  ->default( null );
            $table->unsignedInteger( 'height' )
                  ->nullable()
                  ->default( null );
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
        Schema::dropIfExists( 'admin_share_derivs' );
    }
}
