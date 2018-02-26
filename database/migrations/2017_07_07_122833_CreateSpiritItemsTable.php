<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpiritItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spirit_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned();
            $table->string('title');
            $table->float('price', 8, 2);
            $table->string('description', 510)->nullable();
            $table->smallInteger('order');
            $table->boolean('disabled')->default(false);
        });
        Schema::table('spirit_items', function (Blueprint $table) {
            $table->foreign('parent')->references('id')->on('spirit_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spirit_items');
    }
}
