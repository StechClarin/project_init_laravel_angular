<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPlanificationAssignesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planification_assignes', function (Blueprint $table) {
            $table->string("id_planification")->nullable();
            $table->string("date")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planification_assignes', function (Blueprint $table) {
            $table->dropColumn('id_planification');
            $table->dropColumn('date');
        });
    }
}
