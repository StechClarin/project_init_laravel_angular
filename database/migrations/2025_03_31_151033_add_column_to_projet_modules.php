<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProjetModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projet_modules', function (Blueprint $table) {
            $table->foreignId('departement_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projet_modules', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropForeign(['departement_id']);
        });
    }
}
