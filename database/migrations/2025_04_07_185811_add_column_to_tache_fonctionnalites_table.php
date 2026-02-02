<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTacheFonctionnalitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tache_fonctionnalites', function (Blueprint $table) {
            $table->integer('status')->default(0)->after('fonctionnalite_id');
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
            $table->dropColumn('status');
        });
    }
}
