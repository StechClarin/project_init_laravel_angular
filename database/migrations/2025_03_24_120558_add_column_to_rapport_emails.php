<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToRapportEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapport_emails', function (Blueprint $table) {
            $table->string('objet')->nullable();
            $table->string('texte')->nullable();
            $table->json('file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rapport_emails', function (Blueprint $table) {
            $table->dropColumn('objet');
            $table->dropColumn('texte');
            $table->dropColumn('file');
            $table->dropColumn('rapport_assistance_id');
            $table->dropForeign(['rapport_assistance_id']);
        });
    }
}
