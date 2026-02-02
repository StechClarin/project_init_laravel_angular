<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoyauxInternesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('noyaux_internes')) {
            Schema::create('noyaux_internes', function (Blueprint $table) {
                $table->id();
                $table->string('nom');
                $table->string('description')->nullable();
                $table->timestamps();
                \App\Models\Outil::listenerUsers($table);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supprime la table uniquement si elle existe
        Schema::dropIfExists('noyaux_internes');
    }
}