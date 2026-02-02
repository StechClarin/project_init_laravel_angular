<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanalSlacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canal_slacks', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slack_id');
            $table->timestamps();
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
        Schema::dropIfExists('canal_slacks');
    }
}
