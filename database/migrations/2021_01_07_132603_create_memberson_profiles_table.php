<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersonProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'memberson_profiles', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'user_id' )
                  ->unique()
                  ->constrained( 'users' )
                  ->cascadeOnDelete();
            $table->text( 'data' );
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
        Schema::dropIfExists( 'memberson_profiles' );
    }
}
