<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgeGroupablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_groupables', function (Blueprint $table) {
            $table->unsignedBigInteger('age_group_id');
            $table->foreign('age_group_id')->references('id')->on('age_groups');
            $table->integer('age_groupable_id')->unsigned();
            $table->string('age_groupable_type');
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
        Schema::dropIfExists('age_groupables');
    }
}
