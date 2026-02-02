<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistanceTypeTaches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistance_type_taches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assistance_id')->nullable();
            $table->foreign('assistance_id')->references('id')->on('assistances')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('type_tache_id')->nullable();
            $table->foreign('type_tache_id')->references('id')->on('type_taches')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('assistance_type_taches');
    }
}
