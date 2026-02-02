<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanificationAssignesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planification_assignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planification_id')->constrained()->onDelete('cascade');
            $table->foreignId('projet_id')->constrained()->onDelete('cascade');
            $table->foreignId('fonctionnalite_module_id')->constrained()->onDelete('cascade');
            $table->foreignId('tache_fonctionnalite_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('planification_assignes');
    }
}
