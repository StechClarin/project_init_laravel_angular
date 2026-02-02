<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FICHIER DE CONFIGURATION DES VARIABLES D'ENVIRONNMENT
    |--------------------------------------------------------------------------
    |
    | Chaque fois qu'une variable est modifiée dans ce fichier, il faudra
    | faire à nouveau php artisan config:cache pour rendre la modification disponible.
    |
    */
    'APP_URL'                          => env('APP_URL', 'https://www.stt.com'),
    'FOLDER'                           => env('FOLDER', ''),
    'FRONT_URL'                        => env('FRONT_URL', ''),
    'MSG_ERROR'                        => env('MSG_ERROR', 'Contactez le support technique'),
    'PERMISSION_TRANSACTION'           => env('PERMISSION_TRANSACTION'),
    'APP_ERROR_API'                    => env('APP_ERROR_API', false),
    'SLACK_BOT_TOKEN'                  => env('SLACK_BOT_TOKEN', ''),

];
