<?php

namespace Guindy\GuindyTester\Results;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Guindy\GuindyTester\Core\ChatGPTExplainer;
use Guindy\GuindyTester\Helpers\SendToSlack;

class TestResultFormatter
{
    protected static string $baseDir = 'storage/guindytester_results';

    public static function logErrors(array $errors): void
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $committer = self::getGitCommitterName();
        $logDir = base_path(self::$baseDir . '/' . Str::slug($committer));

        if (!File::exists($logDir)) {
            File::makeDirectory($logDir, 0755, true);
        }

        $results = [];
        $gpt = new ChatGPTExplainer();

        foreach ($errors as $error) {
            if (!($error instanceof TestError)) continue;

            //  Ajout de l’explication ChatGPT (optionnel)
            if (config('guindytester.chatgpt.enabled')) {
                $error->chatgptExplanation = $gpt->explain(
                    $error->errorMessage,
                    $error->route,
                    $error->method
                );
            }

            // Log local (un par erreur)
            TestLogger::logError($error);

            // Slack
            SendToSlack::send($error);

            // Pour le fichier global
            $results[] = $error->toArray();
        }

        //  Fichier global JSON avec toutes les erreurs du committeur
        $globalFilename = $logDir . "/errors_{$committer}_{$timestamp}.json";
        File::put($globalFilename, json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function quickLog(string $text): void
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "quicklog_" . Str::random(6) . "_{$timestamp}.txt";
        $committer = self::getGitCommitterName();
        $logDir = base_path(self::$baseDir . '/' . Str::slug($committer));

        if (!File::exists($logDir)) {
            File::makeDirectory($logDir, 0755, true);
        }

        File::put($logDir . '/' . $filename, $text);
    }

    protected static function getGitCommitterName(): string
    {
        $name = trim(shell_exec('git config user.name'));
        return $name !== '' ? $name : 'unknown_committer';
    }
}
