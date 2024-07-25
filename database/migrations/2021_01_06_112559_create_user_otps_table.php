<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'user_otps', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'user_id' )
                  ->constrained( 'users' )
                  ->cascadeOnDelete();
            $table->string( 'otp' );
            $table->timestamp( 'last_sent_at' );
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
        Schema::dropIfExists( 'user_otps' );
    }
}
