<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public static function functionCall()
    {
        $functionCall = "updateOrCreate";
        if (config('app.env') === 'production')
        {
            $functionCall = "firstOrCreate";
        }
        return $functionCall;
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            DonneesBaseSeeder::class,
            MenuBaseSeeder::class,
            PaysSeeder::class,
            // AddColumnSeeder::class,
            // GestionStockSeeder::class,
            // RecompileDataSeeder::class,
        ]);

        $this->seedProcedures();
    }

    protected function seedProcedures()
    {
        $this->command->info("CREATION DES PROCEDURES STOQUÉES");
        DB::beginTransaction();
        DB::unprepared(file_get_contents(base_path('database/ProcedureStocke.sql')));
        DB::unprepared(file_get_contents(base_path('database/procedure.sql')));
        DB::commit();
    }
}
