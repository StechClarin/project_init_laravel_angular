<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvanceSalairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avance_salaires', function (Blueprint $table) {
            $table->id();
            $table->date('date'); 
            $table->unsignedBigInteger('employe_id')->nullable();
            $table->foreign('employe_id')->references('id')->on('personnels')->onUpdate('cascade');
            $table->integer('montant')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('avance_salaires');
    }
}
