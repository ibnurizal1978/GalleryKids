<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_share', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('image');
            $table->string('TITLE');
            $table->string('ARTIST');
            $table->string('DATE_OF_ART_CREATED');
            $table->string('CLASSIFICATION');
            $table->string('CREDITLINE');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_share');
    }
}
