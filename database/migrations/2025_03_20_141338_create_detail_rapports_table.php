<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailRapportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_rapports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapport_assistance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assistance_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('detail_rapports');
    }
}
