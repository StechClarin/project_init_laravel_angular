<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapportAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapport_assistances', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('projet_id')->constrained()->cascadeOnDelete();
            $table->String('file')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('rapport_assistances');
    }
}
