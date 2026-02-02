<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMultipleColumnsAndRelations extends Migration
{
    public function up(): void
    {
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

        Schema::table('assistances', function (Blueprint $table) {
            if (!Schema::hasColumn('assistances', 'rapporteur')) {
                $table->string('rapporteur')->nullable();
            }
            if (!Schema::hasColumn('assistances', 'canal_slack_id')) {
                $table->foreignId('canal_slack_id')->nullable()->constrained();
            }
        });

        if (Schema::hasColumn('evenements', 'mesure_id')) {
            Schema::table('evenements', function (Blueprint $table) {
                $table->dropColumn('mesure_id');
            });
        }
        Schema::table('evenements', function (Blueprint $table) {
            if (!Schema::hasColumn('evenements', 'mesure_id')) {
                $table->integer('mesure_id')->nullable();
            }
            if (Schema::hasColumn('evenements', 'mesure')) {
                $table->dropColumn('mesure');
            }
            if (!Schema::hasColumn('evenements', 'gravite_id')) {
                $table->integer('gravite_id')->nullable();
            }
            if (Schema::hasColumn('evenements', 'gravite')) {
                $table->dropColumn('gravite');
            }
        });

        Schema::table('fonctionnalite_modules', function (Blueprint $table) {
            if (Schema::hasColumn('fonctionnalite_modules', 'module_id')) {
                $table->dropColumn('module_id');
            }
            if (!Schema::hasColumn('fonctionnalite_modules', 'projet_module_id')) {
                $table->foreignId('projet_module_id')->constrained()->onDelete('cascade');
            }
        });

        Schema::table('taches', function (Blueprint $table) {
            if (!Schema::hasColumn('taches', 'created_at_user_id')) {
                \App\Models\Outil::listenerUsers($table);
            }
        });

        Schema::table('tache_fonctionnalites', function (Blueprint $table) {
            if (!Schema::hasColumn('tache_fonctionnalites', 'fonctionnalite_module_id')) {
                $table->foreignId('fonctionnalite_module_id')->nullable()->constrained()->onDelete('cascade');
            }
            if (Schema::hasColumn('tache_fonctionnalites', 'projet_id')) {
                $table->dropColumn('projet_id');
            }
        });

        Schema::table('planification_assignes', function (Blueprint $table) {
            if (!Schema::hasColumn('planification_assignes', 'day')) {
                $table->string('day')->nullable();
            }
            if (!Schema::hasColumn('planification_assignes', 'personnel_id')) {
                $table->foreignId('personnel_id')->nullable()->constrained()->onDelete('cascade');
            }
        });

        Schema::table('planifications', function (Blueprint $table) {
            if (!Schema::hasColumn('planifications', 'personnel_id')) {
                $table->foreignId('personnel_id')->nullable()->constrained()->onDelete('cascade');
            }
        });

        Schema::table('projets', function (Blueprint $table) {
            if (!Schema::hasColumn('projets', 'noyauxinterne_id')) {
                $table->foreignId('noyauxinterne_id')->nullable()->references('id')->on('noyaux_internes')->onDelete('set null');
            }
        });

        Schema::table('pointages', function (Blueprint $table) {
            if (Schema::hasColumn('pointages', 'heure_arrive')) {
                $table->string('heure_arrive')->nullable()->change();
            }
            if (Schema::hasColumn('pointages', 'heure_depart')) {
                $table->string('heure_depart')->nullable()->change();
            }
            if (!Schema::hasColumn('pointages', 'absence')) {
                $table->boolean('absence')->default(false);
            }
            if (!Schema::hasColumn('pointages', 'justificatif_absence')) {
                $table->boolean('justificatif_absence')->default(false);
            }
        });

        Schema::table('tache_assignes', function (Blueprint $table) {
            if (Schema::hasColumn('tache_assignes', 'date_debut')) {
                $table->string('date_debut')->nullable()->change();
            }
            if (Schema::hasColumn('tache_assignes', 'date_fin')) {
                $table->string('date_fin')->nullable()->change();
            }
        });

        Schema::table('bilan_pointages', function (Blueprint $table) {
            if (!Schema::hasColumn('bilan_pointages', 'date')) {
                $table->string('date')->nullable();
            }
        });

        Schema::table('noyaux_internes', function (Blueprint $table) {
            if (Schema::hasColumn('noyaux_internes', 'description')) {
                $table->string('description')->nullable()->change();
            }
        });

        Schema::table('personnels', function (Blueprint $table) {
            if (Schema::hasColumn('personnels', 'role_id')) {
                $table->integer('role_id')->nullable()->change();
            }
            if (Schema::hasColumn('personnels', 'password')) {
                $table->string('password')->nullable()->change();
            }
            if (Schema::hasColumn('personnels', 'emailcp')) {
                $table->string('emailcp')->nullable()->change();
            }
            if (Schema::hasColumn('personnels', 'fonction')) {
                $table->string('fonction')->nullable()->change();
            }
        });

        Schema::table('bilan_taches', function (Blueprint $table) {
            if (!Schema::hasColumn('bilan_taches', 'personnel_id')) {
                $table->foreignId('personnel_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('bilan_taches', 'tacheassigne_id')) {
                $table->foreignId('tacheassigne_id')->references('id')->on('tache_assignes')->onDelete('cascade');
            }
            if (!Schema::hasColumn('bilan_taches', 'date')) {
                $table->string('date')->nullable();
                \App\Models\Outil::listenerUsers($table);
            }
        });



        Schema::table('motif_entresortie_caisses', function (Blueprint $table) {
            if (Schema::hasColumn('motif_entresortie_caisses', 'description')) {
                $table->string('description')->nullable()->change();
            }
        });

        Schema::table('fonctionnalites', function (Blueprint $table) {
            if (Schema::hasColumn('fonctionnalites', 'description')) {
                $table->string('description')->nullable()->change();
            }
        });


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
    }

    public function down(): void
    {
        // Tu peux compléter ici si tu veux annuler les modifications (non obligatoire mais recommandé)
    }
}
