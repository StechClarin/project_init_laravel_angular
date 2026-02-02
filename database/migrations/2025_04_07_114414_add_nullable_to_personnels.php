<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToPersonnels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personnels', function (Blueprint $table) {
            if (!Schema::hasColumn('personnels', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('personnels', 'role_id')) {
                $table->integer('role_id')->nullable();
                $table->foreign('role_id')->references('id')->on('roles');
            }
            if (!Schema::hasColumn('personnels', 'connectivite')) {
                $table->boolean('connectivite')->default(false);
            }
            if (!Schema::hasColumn('personnels', 'nomcp')) {
                $table->string('nomcp')->default('N/A');
            }
            if (!Schema::hasColumn('personnels', 'telephonecp')) {
                $table->string('telephonecp')->default('N/A');
            }
            if (!Schema::hasColumn('personnels', 'emailcp')) {
                $table->string('emailcp')->default('N/A');
            }
            if (!Schema::hasColumn('personnels', 'fonction')) {
                $table->string('fonction')->default('N/A');
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
        Schema::table('personnels', function (Blueprint $table) {
            //
        });
    }
}
