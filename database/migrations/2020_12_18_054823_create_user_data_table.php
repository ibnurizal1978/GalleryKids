<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'user_data', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'user_id' )
                  ->unique()
                  ->constrained( 'users' )
                  ->cascadeOnDelete();
            $table->string( 'memberson_customer_number' )
                  ->nullable()
                  ->default( null );
            $table->string( 'memberson_member_number' )
                  ->nullable()
                  ->default( null );
            $table->string( 'accenture_user_id' )
                  ->nullable()
                  ->default( null );
            $table->string( 'profile_token' )
                  ->nullable()
                  ->default( null );
            $table->timestamp( 'profile_token_expires_at' )
                  ->nullable()
                  ->default( null );
            $table->boolean( 'email_verified' )
                  ->default( false );

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
        Schema::dropIfExists( 'user_data' );
    }
}
