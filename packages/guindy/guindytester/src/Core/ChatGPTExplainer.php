<?php

namespace Guindy\GuindyTester\Core;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatGPTExplainer
{
    protected string $model;
    protected string $apiKey;
    protected bool $enabled;

    const API_URL = 'https://api.openai.com/v1/chat/completions';
    const CACHE_TTL_DAYS = 7;
    const MAX_ERROR_LENGTH = 1500;

    public function __construct()
    {
        $config = config('guindytester.chatgpt');
        $this->model = $config['model'] ?? 'gpt-4';
        $this->apiKey = $config['api_key'] ?? '';
        $this->enabled = $config['enabled'] ?? false;
    }

    /**
     * Explique une erreur via l’API ChatGPT
     */
    public function explain(string $errorMessage, string $route = '', string $method = 'POST'): string
    {
        if (!$this->enabled || empty($this->apiKey)) {
            return 'ChatGPT désactivé ou clé manquante.';
        }

        $errorMessage = Str::limit($errorMessage, self::MAX_ERROR_LENGTH);
        $cacheKey = 'chatgpt_explain_' . md5($route . '_' . $errorMessage);

        return Cache::remember($cacheKey, now()->addDays(self::CACHE_TTL_DAYS), function () use ($errorMessage, $route, $method) {
            $response = $this->buildRequest()->post(self::API_URL, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un assistant expert en debug PHP et Laravel. Explique les erreurs techniques de manière claire et utile.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Voici une erreur rencontrée lors d'un test API sur la route [$route] ($method) :\n\n{$errorMessage}\n\nExplique-moi ce que signifie cette erreur et comment y remédier."
                    ]
                ],
            ]);

            if ($response->failed()) {
                return 'Erreur lors de l’appel à ChatGPT : ' . $response->body();
            }

            $explanation = $response->json()['choices'][0]['message']['content'] ?? 'Explication non trouvée.';
            $this->logExplanationToFile($route, $method, $errorMessage, $explanation);

            return $explanation;
        });
    }

    /**
     * Construit une requête HTTP prête à envoyer à ChatGPT
     */
    protected function buildRequest()
    {
        return Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Sauvegarde localement l’explication retournée par ChatGPT
     */
    protected function logExplanationToFile(string $route, string $method, string $errorMessage, string $explanation): void
    {
        $logContent = now()->toDateTimeString() . " | ROUTE: {$route} | METHOD: {$method}\n";
        $logContent .= "ERREUR: {$errorMessage}\n";
        $logContent .= "EXPLICATION: {$explanation}\n";
        $logContent .= str_repeat('-', 100) . "\n";

        $logPath = storage_path('logs/chatgpt_explanations.log');

        try {
            file_put_contents($logPath, $logContent, FILE_APPEND);
        } catch (\Throwable $e) {
            Log::error('Erreur lors de l’écriture du log ChatGPT : ' . $e->getMessage());
        }
    }
}
