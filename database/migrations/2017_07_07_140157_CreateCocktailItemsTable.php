<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCocktailItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cocktail_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned();
            $table->string('title');
            $table->float('price', 8, 2);
            $table->string('description', 510)->nullable();
            $table->smallInteger('order');
            $table->boolean('disabled')->default(false);
        });
        Schema::table('cocktail_items', function (Blueprint $table) {
            $table->foreign('parent')->references('id')->on('cocktail_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cocktail_items');
    }
}
