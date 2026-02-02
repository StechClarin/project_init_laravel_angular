<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanificationProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('planification_projets', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreign('planification_id')->constrained()->onDelete('cascade');
    //         $table->foreign('projet_id')->constrained()->onDelete('cascade');
    //         \App\Models\Outil::listenerUsers($table);
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::dropIfExists('planification_projets');
    // }
}
