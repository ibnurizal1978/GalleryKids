<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEmailUniqueIndexFromUsersTable extends Migration
{
    protected $table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( $this->table, function ( Blueprint $table ) {
            $manager = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $manager->listTableIndexes( $this->table );

            if ( array_key_exists( 'users_email_unique', $indexes ) ) {
                $table->dropUnique( 'users_email_unique' );
            }
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( $this->table, function ( Blueprint $table ) {
            //
        } );
    }
}
