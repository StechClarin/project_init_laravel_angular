<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacheAssignesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tache_assignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels');
            $table->foreignId('projet_id')->constrained('projets');
            $table->foreignId('tache_id')->constrained('taches');
            $table->string('duree')->nullable();
            $table->text('description')->nullable();
            $table->string('date_debut');
            $table->string('date_fin');
            $table->integer('status')->comment('0: en attente, 1: en cours, 2: terminé, 3: annulé')->default(0);
            \App\Models\Outil::listenerUsers($table);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tache_assignes');
    }
}



