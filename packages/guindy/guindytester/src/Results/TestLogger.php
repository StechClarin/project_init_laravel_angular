<?php

namespace Guindy\GuindyTester\Results;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TestLogger
{
    protected static string $baseLogDir = 'storage/guindytester_results';

    /**
     * Sauvegarde une erreur dans un fichier JSON sous le dossier du committeur.
     */
    public static function logError(TestError $error): void
    {
        $committer = self::getGitCommitterName();
        $logDir = self::$baseLogDir . '/' . Str::slug($committer);

        self::ensureDirectoryExists($logDir);

        $filename = $logDir . '/' . date('Ymd_His') . '_' . Str::slug($error->route) . '.json';
        File::put($filename, json_encode($error->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Crée le répertoire si nécessaire.
     */
    protected static function ensureDirectoryExists(string $path): void
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    /**
     * Récupère le nom du committeur actuel (via Git).
     */
    protected static function getGitCommitterName(): string
    {
        $name = trim(shell_exec('git config user.name'));
        return $name !== '' ? $name : 'unknown_committer';
    }
}
