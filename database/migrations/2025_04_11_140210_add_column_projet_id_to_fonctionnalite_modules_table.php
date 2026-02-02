<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProjetIdToFonctionnaliteModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fonctionnalite_modules', function (Blueprint $table) {
            $table->integer('projet_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fonctionnalite_modules', function (Blueprint $table) {
            $table->dropColumn('projet_id');
        });
    }
}
