<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPointageContion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("details_pointages", function (Blueprint $table) {
            if (Schema::hasColumn("details_pointages", "heure_arrive")) {
                $table->time("heure_arrive")->nullable()->change();
            }
            if (Schema::hasColumn("details_pointages", "heure_depart")) {
                $table->time("heure_depart")->nullable()->change();
            }
        });

        Schema::table("pointages", function (Blueprint $table) {
            if (Schema::hasColumn("pointages", "temps_au_bureau")) {
                $table->dropColumn("temps_au_bureau");
            }
        });
        Schema::table("pointages", function (Blueprint $table) {
            if (!Schema::hasColumn("pointages", "temps_au_bureau")) {
                $table->integer("temps_au_bureau")->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
