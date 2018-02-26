<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('menu_items', function (Blueprint $table) {
            $table->integer('parent')->unsigned()->change();
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreign('parent')->references('id')->on('menu_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign('menu_items_parent_foreign');
        });
    }
}
