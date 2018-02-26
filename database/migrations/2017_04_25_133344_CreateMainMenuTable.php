<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('name', 255);
            $table->integer('parent')->nullable();
            $table->string('description')->nullable();
            $table->smallInteger('order')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_menu');
    }
}
