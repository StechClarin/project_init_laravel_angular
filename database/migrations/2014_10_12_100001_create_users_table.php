<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text( 'image')->nullable();
            $table->string('telephone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('current_team_id')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->foreignId('niveau_habilite_id')->nullable()->constrained()->nullOnDelete();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            \App\Models\Outil::listenerUsers($table);
        });

        Schema::table('niveau_habilites', function (Blueprint $table)
        {
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
        Schema::table('niveau_habilites', function (Blueprint $table)
        {
            \App\Models\Outil::listenerUsers($table, false);
        });

        Schema::dropIfExists('users');
    }
}
