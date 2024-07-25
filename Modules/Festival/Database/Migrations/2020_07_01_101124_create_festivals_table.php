<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFestivalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('festivals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('synopsis');
            $table->string('url');
            $table->date('content_start_date')->nullable();
            $table->date('content_expiry_date')->nullable();
            $table->enum('status', ['Enable', 'Disable']);
            $table->enum('members_only', ['Yes', 'No']);
            $table->enum('targeted_age_group', ['Younger than 10', '10 to 15','Older than 15']);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('festivals');
    }
}
