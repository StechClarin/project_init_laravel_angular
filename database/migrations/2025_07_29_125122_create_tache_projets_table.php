<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacheProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tache_projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels');
            $table->foreignId('projet_id')->constrained('projets')->nullable();
            $table->foreignId('priorite_id')->constrained('priorites')->nullable();
            $table->foreignId('tag_id')->constrained('tags')->nullabel();
            $table->string('nom_tache');
            $table->string('description')->nullable();
            $table->integer('status')->comment('0: en attente, 1: en cours, 2: terminé, 3: annulé')->default(0);
            $table->string('date_debut')->nullable();
            $table->string('date_debut2')->nullable();
            $table->string('date_fin')->nullable();
            $table->string('date_fin2')->nullable();
            $table->time('duree');
            $table->time('duree_effectue')->nullable();
            $table->timestamps();
            \App\Models\Outil::listenerUsers($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tache_projets');
    }
}
