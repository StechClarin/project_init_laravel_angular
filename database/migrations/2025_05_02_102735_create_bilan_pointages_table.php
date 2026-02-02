<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBilanPointagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bilan_pointages', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'personnel_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId( 'pointage_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('total_temps_au_bureau')->nullable();
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
        Schema::dropIfExists('bilan_pointages');
    }
}
