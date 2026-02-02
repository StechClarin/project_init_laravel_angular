<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //la migration
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('date_naissance');
            $table->string('lieu_naissance');
            $table->date('date_embauche');
            $table->integer('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('password')->nullable();
            $table->boolean('connectivite')->default(false);
            $table->string('nomcp');
            $table->string('telephonecp');
            $table->string('emailcp')->nullable();
            $table->string('fonction')->nullable();
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
        Schema::dropIfExists('personnels');
    }
}
