<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMembershipDataToUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'user_data', function ( Blueprint $table ) {
            $table->string( 'membership_type' )
                  ->nullable()
                  ->default( null );
            $table->string( 'membership_tier' )
                  ->nullable()
                  ->default( null );
            $table->string( 'benefit_code' )
                  ->nullable()
                  ->default( null );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'user_data', function ( Blueprint $table ) {
            $table->dropColumn(['membership_type', 'membership_tier', 'benefit_code']);
        } );
    }
}
