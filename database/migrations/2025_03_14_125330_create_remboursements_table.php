<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemboursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remboursements', function (Blueprint $table) {
            $table->id();
            $table->date('date'); 
            $table->unsignedBigInteger('avance_salaire_id')->nullable();
            $table->foreign('avance_salaire_id')->references('id')->on('avance_salaires')->onUpdate('cascade');
            $table->integer('montant')->default(0);
            $table->integer('restant')->default(0);
            $table->integer('etat')->default(0); 
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
        Schema::dropIfExists('remboursements');
    }
}
