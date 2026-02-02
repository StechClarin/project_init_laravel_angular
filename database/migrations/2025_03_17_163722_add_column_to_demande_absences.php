<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDemandeAbsences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_absences', function (Blueprint $table) {
            $table->time('heure_debut')->nullable()->after('date_fin');
            $table->time('heure_fin')->nullable()->after('date_fin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_absences', function (Blueprint $table) {
            $table->dropColumn('heure_debut');
            $table->dropColumn('heure_fin');
        });
    }
}
