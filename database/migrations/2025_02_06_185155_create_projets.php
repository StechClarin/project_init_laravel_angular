<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

class CreateProjets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code');
            $table->string('status')->default(1);
            $table->text('description')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_cloture')->nullable();

            $table->string('hebergeur')->nullable();
            $table->string('serveur')->nullable();
            $table->date('date_prochaine_renouvellement')->nullable();
            $table->integer('tarif')->nullable();

            $table->string('lien_test')->nullable();
            $table->string('identifiant_test')->nullable();
            $table->string('mot_de_passe_test')->nullable();

            $table->string('lien_prod')->nullable();
            $table->string('identifiant_prod')->nullable();
            $table->string('mot_de_passe_prod')->nullable();

            $table->foreignId('type_projet_id')->nullable()->constrained();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('noyauxinterne_id')->references('id')->on('noyaux_internes')->nullable()->constrained();

            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('projets');
    }
}
