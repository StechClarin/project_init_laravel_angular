<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistances', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('detail');
            $table->integer('status')->default(0);
            $table->date('date');

            $table->foreignId('canal_id')->nullable()->constrained();
            $table->foreignId('canal_slack_id')->nullable()->constrained();

            $table->foreignId('tag_id')->nullable()->constrained();
            $table->foreignId('projet_id')->nullable()->constrained();

            $table->string('rapporteur')->nullable();

            $table->unsignedBigInteger('collecteur_id')->nullable();
            $table->foreign('collecteur_id')->references('id')->on('users')->onUpdate('cascade');

            $table->unsignedBigInteger('assigne_id')->nullable();
            $table->foreign('assigne_id')->references('id')->on('users')->onUpdate('cascade');

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
        Schema::dropIfExists('assistances');
    }
}
