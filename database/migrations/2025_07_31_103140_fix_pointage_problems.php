<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPointageProblems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pointages',  function (Blueprint $table) {
            $dropcolumn = [
                'heure_arrive',
                'heure_depart',
                'retard',
                'absence',
                'justificatif',
                'justificatif_absence',
                'description',
                'semaine'
            ];

            foreach ($dropcolumn as $column) {
                if (Schema::hasColumn('pointages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        if (!Schema::hasTable('details_pointages')) {
            Schema::create('details_pointages', function (Blueprint $table) {
                $table->id();

                $table->foreignId('pointage_id')->nullable()->constrained('pointages')->onDelete('cascade');
                $table->foreignId('personnel_id')->nullable()->constrained('personnels')->onDelete('cascade');

                $table->time('heure_arrive');
                $table->time('heure_depart')->nullable();
                $table->boolean('retard')->default(false);
                $table->boolean('absence')->default(false);
                $table->boolean('justificatif')->default(false);
                $table->string('description')->nullable();
                $table->string('justificatif_file')->nullable();
                $table->string('day'); 

                $table->timestamps(); 

                
                \App\Models\Outil::listenerUsers($table);
            });
        }
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
