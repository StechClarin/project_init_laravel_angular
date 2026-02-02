<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreSortieCaissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entresortie_caisses', function (Blueprint $table) {
            $table->id();
            $table->integer('caisse_id');
            $table->foreign('caisse_id')->references('id')->on('caisses');
            $table->integer('motifentresortiecaisse_id');
            $table->foreign('motifentresortiecaisse_id')->references('id')->on('motif_entresortie_caisses');
            $table->integer('montant');
            $table->string('description');
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
        Schema::dropIfExists('entresortie_caisses');
    }
}
