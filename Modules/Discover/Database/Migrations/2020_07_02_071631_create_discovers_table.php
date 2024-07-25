<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discovers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('synopsis');
            $table->string('url');
            $table->date('content_start_date')->nullable();
            $table->date('content_expiry_date')->nullable();
            $table->enum('status', ['Enable', 'Disable']);
            $table->enum('members_only', ['Yes', 'No']);
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
        Schema::dropIfExists('discovers');
    }
}
