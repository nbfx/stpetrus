<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrinkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drink_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned();
            $table->string('title');
            $table->string('description', 510)->nullable();
            $table->float('price', 8, 2);
            $table->smallInteger('order');
            $table->boolean('disabled')->default(false);
        });
        Schema::table('drink_items', function (Blueprint $table) {
            $table->foreign('parent')->references('id')->on('drink_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drink_items');
    }
}
