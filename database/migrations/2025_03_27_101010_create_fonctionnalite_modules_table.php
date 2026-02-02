<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFonctionnaliteModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fonctionnalite_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_module_id')->constrained()->onDelete('cascade');
            $table->foreignId('fonctionnalite_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('fonctionnalite_modules');
    }
}
