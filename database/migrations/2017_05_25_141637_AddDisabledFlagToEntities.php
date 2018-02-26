<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisabledFlagToEntities extends Migration
{
    private $models = [
        App\Dish::class,
        App\History::class,
        App\Language::class,
        App\MainMenu::class,
        App\MenuGroup::class,
        App\MenuItem::class,
        App\Place::class,
        App\Teammate::class,
        App\WineGroup::class,
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->models as $model) {
            $model = new $model();
            if (!Schema::hasColumn($model->getTable(), 'disabled')) {
                Schema::table($model->getTable(), function (Blueprint $table) {
                    $table->boolean('disabled')->default(false);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->models as $model) {
            $model = new $model();
            if (Schema::hasColumn($model->getTable(), 'disabled')) {
                Schema::table($model->getTable(), function (Blueprint $table) {
                    $table->dropColumn('disabled');
                });
            }
        }
    }
}
