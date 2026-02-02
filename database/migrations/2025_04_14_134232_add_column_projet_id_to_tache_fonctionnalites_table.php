<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProjetIdToTacheFonctionnalitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tache_fonctionnalites', function (Blueprint $table) {
            $table->foreignId('projet_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tache_fonctionnalites', function (Blueprint $table) {
            $table->dropColumn('projet_id');
        });
    }
}
