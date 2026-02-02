<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacheFonctionnalitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tache_fonctionnalites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fonctionnalite_module_id')->constrained()->onDelete('cascade');
            $table->foreignId('tache_id')->constrained()->onDelete('cascade');
            $table->time('duree')->nullable();
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
        Schema::dropIfExists('tache_fonctionnalites');
    }
}
