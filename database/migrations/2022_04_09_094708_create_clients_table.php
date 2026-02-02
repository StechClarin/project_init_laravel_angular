<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table)
        {
            $table->id();
            $table->string('code')->nullable();
            $table->string('nom')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->text('image')->nullable();
            $table->string('description')->nullable();
            $table->integer('status')->default(1);
            $table->foreignId('type_client_id')->nullable()->constrained();
            $table->foreignId('secteur_activite_id')->nullable()->constrained();
            $table->foreignId('modalite_paiement_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
            \App\Models\Outil::listenerUsers($table);
        });


        schema::table('users', function (Blueprint $table)
        {
            $table->foreignId('client_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('users', function (Blueprint $table)
        {
            $table->dropConstrainedForeignId('client_id');
        });

        Schema::dropIfExists('clients');
    }
}
