<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFeedbackPeopleAmountField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn('people_amount');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->string('people_amount', 50)->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn('people_amount');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->smallInteger('people_amount')->after('description')->nullable();
        });
    }
}
