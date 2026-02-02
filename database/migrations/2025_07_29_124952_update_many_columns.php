<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateManyColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapport_assistances', function (Blueprint $table) {
            if (!Schema::hasColumn('rapport_assistances', 'assistance_id')) {
                $table->foreignId('assistance_id')->nullable()->constrained('assistances')->onDelete('cascade');
            }
        });

        Schema::table('caisses', function (Blueprint $table) {
            if (Schema::hasColumn('caisses', 'description')) {
                $table->string('description')->nullable()->change();
            }
        });
        Schema::table('depenses', function (Blueprint $table) {
            if (!Schema::hasColumn('depenses', 'code')) {
                $table->string('code')->nullable();
            }
        });
        Schema::table('depenses', function (Blueprint $table) {
            if (Schema::hasColumn('depenses', 'description')) {
                $table->string('description')->nullable()->change();
            }
        });
        Schema::table('depenses', function (Blueprint $table) {
            if (!Schema::hasColumn('depenses', 'date')) {
                $table->string('date')->nullable();
            }
        });
        Schema::table('tache_fonctionnalites', function (Blueprint $table) {
            if (Schema::hasColumn('tache_fonctionnalites', 'fonctionnalite_id')) {
                $table->integer('fonctionnalite_id')->nullable()->change();
            }
        });
        Schema::table('pointages', function (Blueprint $table) {
            if (Schema::hasColumn('pointages', 'semaine')) {
                $table->string('semaine')->nullable()->change();
            }
        });
        Schema::table('pointages', function (Blueprint $table) {
            if (!Schema::hasColumn('pointages', 'temps_au_bureau')) {
                $table->time('temps_au_bureau')->default('00:00:00');
            }
        });
        Schema::table('pointages', function (Blueprint $table) {
            if (Schema::hasColumn('pointages', 'date')) {
                $table->dropColumn('date');
            }
        });
        Schema::table('planification_assignes', function (Blueprint $table) {
            if (!Schema::hasColumn('planification_assignes', 'date_debut')) {
                $table->string('date_debut')->nullable();
            }
        });
        Schema::table('planification_assignes', function (Blueprint $table) {
            if (!Schema::hasColumn('planification_assignes', 'date_fin')) {
                $table->string('date_fin')->nullable();
            }
        });
        Schema::table('planification_assignes', function (Blueprint $table) {
            if (!Schema::hasColumn('planification_assignes', 'duree_effectue')) {
                $table->time('duree_effectue')->nullable();
            }
        });
        Schema::table('planification_assignes', function (Blueprint $table) {
            if (!Schema::hasColumn('planification_assignes', 'priorite_id')) {
                $table->foreignId('priorite_id')->nullable()->constrained('priorites');
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
