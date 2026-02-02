<?php

namespace Guindy\GuindyTester\Helpers;

use Guindy\GuindyTester\Results\TestError;
use Illuminate\Support\Facades\Http;

class SendToSlack
{
    public static function send(TestError $error): void
    {
        $webhookUrl = config('guindytester.slack_webhook');

        if (empty($webhookUrl)) {
            return;
        }

        $committer = $error->committer ?? 'Inconnu';

        $message = [
            'text' => " *Erreur détectée pendant les tests GuindyTester*",
            'attachments' => [
                [
                    'color' => '#ff0000',
                    'fields' => [
                        [
                            'title' => 'Route',
                            'value' => $error->route,
                            'short' => true,
                        ],
                        [
                            'title' => 'Méthode',
                            'value' => $error->method,
                            'short' => true,
                        ],
                        [
                            'title' => 'Code HTTP',
                            'value' => $error->statusCode,
                            'short' => true,
                        ],
                        [
                            'title' => 'Committeur',
                            'value' => $committer,
                            'short' => true,
                        ],
                        [
                            'title' => 'Message d\'erreur',
                            'value' => substr($error->errorMessage, 0, 1000), // éviter trop long
                            'short' => false,
                        ],
                        [
                            'title' => 'Explication ChatGPT',
                            'value' => $error->chatgptExplanation ?? '_non disponible_',
                            'short' => false,
                        ],
                    ],
                ],
            ],
        ];

        Http::post($webhookUrl, $message);
    }
}
