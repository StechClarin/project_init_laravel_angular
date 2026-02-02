<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixColumnsForStat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('details_pointages',  function (Blueprint $table) {
            if (!Schema::hasColumn('details_pointages', 'personnel_id')) {
                $table->foreignId('personnel_id')->nullable()->constrained('personnels')->onDelete('cascade');
            }
            if (!Schema::hasColumn('details_pointages', 'date')) {
                $table->string('date')->nullable()->comment('');
            }
        });

        Schema::table('tache_projets', function (Blueprint $table) {
              if (!Schema::hasColumn('tache_projets', 'date')) {
                $table->string('date')->nullable()->comment('');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
