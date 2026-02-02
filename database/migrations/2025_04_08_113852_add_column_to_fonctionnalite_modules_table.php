<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToFonctionnaliteModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fonctionnalite_modules', function (Blueprint $table) {
            $table->string('duree')->nullable()->after('fonctionnalite_id');
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
        Schema::table('fonctionnalite_modules', function (Blueprint $table) {
            $table->dropColumn('duree');
            $table->dropColumn('status');
        });
    }
}
