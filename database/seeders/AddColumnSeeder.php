<?php

namespace Database\Seeders;

use App\Models\{
    DetailTypeDossier,
    ModeFacturation,
    ModeReglement,
    Preference,
    TypeDossier
};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Mpdf\Utils\UtfString;

class AddColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Preference
        if (Schema::hasColumn('moods', 'emoji_file')) {
            Schema::table('moods', function (Blueprint $table) {
                $table->dropColumn('emoji_file');
            });
        }


        if (Schema::hasColumn('assistances', 'rapporteur_id')) {
            Schema::table('assistances', function (Blueprint $table) {
                $table->dropColumn('rapporteur_id');
            });
        }

        if (!Schema::hasColumn('assistances', 'rapporteur')) {
            Schema::table('assistances', function (Blueprint $table) {
                $table->string('rapporteur')->nullable();
            });
        }

        if (!Schema::hasColumn('assistances', 'canal_slack_id')) {
            Schema::table('assistances', function (Blueprint $table) {
                $table->foreignId('canal_slack_id')->nullable()->constrained();
            });
        }
        if (Schema::hasColumn('evenements', 'mesure_id')) {
            Schema::table('evenements', function (Blueprint $table) {
                $table->dropColumn('mesure_id')->nullable();
            });
        }
        if (!Schema::hasColumn('evenements', 'mesure_id')) {
            Schema::table('evenements', function (Blueprint $table) {
                $table->integer('mesure_id')->nullable();
            });
        }
        if (Schema::hasColumn('evenements', 'mesure')) {
            Schema::table('evenements', function (Blueprint $table) {
                $table->dropColumn('mesure');
            });
        }
        if (!Schema::hasColumn('evenements', 'gravite_id')) {
            Schema::table('evenements', function (Blueprint $table) {
                $table->integer('gravite_id')->nullable();
            });
        }
        if (Schema::hasColumn('evenements', 'gravite')) {
            Schema::table('evenements', function (Blueprint $table) {
                $table->dropColumn('gravite');
            });
        }
        if (Schema::hasColumn('fonctionnalite_modules', 'module_id')) {
            Schema::table('fonctionnalite_modules', function (Blueprint $table) {
                $table->dropColumn('module_id');
            });
        }
        if (!Schema::hasColumn('fonctionnalite_modules', 'projet_module_id')) {
            Schema::table('fonctionnalite_modules', function (Blueprint $table) {
                $table->foreignId('projet_module_id')->constrained()->onDelete('cascade');
            });
        }

        if (!Schema::hasColumn('tache_fonctionnalites', 'fonctionnalite_module_id')) {
            Schema::table('tache_fonctionnalites', function (Blueprint $table) {
                $table->foreignId('fonctionnalite_module_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
        if (Schema::hasColumn('tache_fonctionnalites', 'projet_id')) {
            Schema::table('tache_fonctionnalites', function (Blueprint $table) {
                $table->dropColumn('projet_id');
            });
        }
        if (!Schema::hasColumn('planification_assignes', 'day')) {
            Schema::table('planification_assignes', function (Blueprint $table) {
                $table->string('day')->nullable();
            });
        }
        if (!Schema::hasColumn('planification_assignes', 'personnel_id')) {
            Schema::table('planification_assignes', function (Blueprint $table) {
                $table->foreignId('personnel_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('planifications', 'personnel_id')) {
            Schema::table('planifications', function (Blueprint $table) {
                $table->foreignId('personnel_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('projets', 'noyauxinterne_id')) {
            Schema::table('projets', function (Blueprint $table) {
                $table->foreignId('noyauxinterne_id')->nullable()->references('id')->on('noyaux_internes')->onDelete('set null');
            });
        }
        if (Schema::hasColumn('pointages', 'heure_arrive') && Schema::hasColumn('pointages', 'heure_depart')) {
            Schema::table('pointages', function (Blueprint $table) {
                $table->string('heure_arrive')->nullable()->change();
                $table->string('heure_depart')->nullable()->change();
            });
        }
        if (Schema::hasColumn('tache_assignes', 'date_debut') && Schema::hasColumn('tache_assignes', 'date_fin')) {
            Schema::table('tache_assignes', function (Blueprint $table) {
                $table->string('date_debut')->nullable()->change();
                $table->string('date_fin')->nullable()->change();
            });
        }
        if (!Schema::hasColumn('bilan_pointages', 'date')) {
            Schema::table('bilan_pointages', function (Blueprint $table) {
                $table->string('date')->nullable();
            });
        }

        if (!Schema::hasColumn('pointages', 'absence')) {
            Schema::table('pointages', function (Blueprint $table) {
                $table->boolean('absence')->default(false);
            });
        }

        if (!Schema::hasColumn('pointages', 'justificatif_absence')) {
            Schema::table('pointages', function (Blueprint $table) {
                $table->boolean('justificatif_absence')->default(false);
            });
        }

        if (Schema::hasColumn('noyaux_internes', 'description')) {
            Schema::table('noyaux_internes', function (Blueprint $table) {
                $table->string('description')->nullable()->change();
            });
        }


        if (Schema::hasColumn('personnels', 'role_id')) {
            Schema::table('personnels', function (Blueprint $table) {
                $table->integer('role_id')->nullable()->change();
            });
        }
        if (Schema::hasColumn('personnels', 'password')) {
            Schema::table('personnels', function (Blueprint $table) {
                $table->string('password')->nullable()->change();
            });
        }
        if (Schema::hasColumn('personnels', 'emailcp')) {
            Schema::table('personnels', function (Blueprint $table) {
                $table->string('emailcp')->nullable()->change();
            });
        }
        if (Schema::hasColumn('personnels', 'fonction')) {
            Schema::table('personnels', function (Blueprint $table) {
                $table->string('fonction')->nullable()->change();
            });
        }

        if (!Schema::hasColumn('bilan_taches', 'personnel_id')) {
            Schema::table('bilan_taches', function (Blueprint $table) {
                $table->foreignId('personnel_id')->constrained()->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('bilan_taches', 'tacheassigne_id')) {
            Schema::table('bilan_taches', function (Blueprint $table) {
                $table->foreignId('tacheassigne_id')->references('id')->on('tache_assignes')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('bilan_taches', 'date')) {
            Schema::table('bilan_taches', function (Blueprint $table) {
                $table->string('date')->nullable();
                \App\Models\Outil::listenerUsers($table);
            });
        }

        if (Schema::hasColumn('motif_entresortie_caisses', 'description')) {
            Schema::table('motif_entresortie_caisses', function (Blueprint $table) {
                $table->string('description')->nullable()->change();
            });
        }
        if (Schema::hasColumn('fonctionnalites', 'description')) {
            Schema::table('fonctionnalites', function (Blueprint $table) {
                $table->string('description')->nullable()->change();
            });
        }
        if (!Schema::hasColumn('rapport_assistances', 'assistance_id')) {
            Schema::table('rapport_assistances', function (Blueprint $table) {
                $table->foreignId('assistance_id')->references('id')->on('assistances')->nullable()->onDelete('cascade');
            });
        }
    }
}
