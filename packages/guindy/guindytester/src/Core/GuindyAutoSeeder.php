<?php

namespace Guindy\GuindyTester\Core;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

/**
 * Classe GuindyGuindyAutoSeeder
 * Permet d'insérer automatiquement des données minimales
 * dans les tables contenant des clés étrangères avant les tests.
 */
class GuindyAutoSeeder
{
    protected array $dbInfo;

    public function __construct()
    {
        $this->dbInfo = $this->loadDbInfo();
    }

    protected function loadDbInfo(): array
    {
        // Utilise la config Laravel
        $dbInfo = config('guindytester_db_info');
        if (empty($dbInfo) || !is_array($dbInfo)) {
            throw new \RuntimeException("La configuration 'guindytester_db_info' est introuvable ou invalide.");
        }
        return $dbInfo;
    }

    public function seed()
    {
        foreach ($this->dbInfo as $table => $rows) {
            if (!$this->tableExists($table)) {
                continue;
            }

            foreach ($rows as $row) {
                if (!$this->rowExists($table, $row)) {
                    DB::table($table)->insert($row);
                }
            }
        }
    }

    protected function tableExists(string $table): bool
    {
        return Schema::hasTable($table);
    }

    protected function rowExists(string $table, array $row): bool
    {
        $query = DB::table($table);

        foreach ($row as $key => $value) {
            $query->where($key, $value);
        }

        return $query->exists();
    }
}
