<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Préfixes des routes REST à tester
    |--------------------------------------------------------------------------
    | Tu peux ajouter autant de préfixes que nécessaire.
    | La clé est juste un alias, la valeur est le préfixe dans l’URL.
    */

    'rest_prefixes' => [
        'web' => 'guindy_manager/public',  // Préfixe actuel utilisé en local
    ],

    /*
    |--------------------------------------------------------------------------
    | Endpoint GraphQL
    |--------------------------------------------------------------------------
    */

    'graphql_endpoint' => '/graphql',

    /*
    |--------------------------------------------------------------------------
    | Intégration ChatGPT pour explication d'erreurs
    |--------------------------------------------------------------------------
    */

    'chatgpt' => [
        'enabled' => true,
        'api_key' => env('OPENAI_API_KEY', ''),
        'model' => 'gpt-4',
    ],

    /*
    |--------------------------------------------------------------------------
    | Intégration Slack pour rapport d'erreurs
    |--------------------------------------------------------------------------
    | Définis l’URL du webhook Slack dans ton .env (obligatoire pour activer)
    */

    'slack_webhook' => env('SLACK_WEBHOOK_URL', ''),

];
