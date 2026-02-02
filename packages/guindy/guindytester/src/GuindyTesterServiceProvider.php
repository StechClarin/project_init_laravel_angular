<?php

namespace Guindy\GuindyTester;

use Illuminate\Support\ServiceProvider;
use Guindy\GuindyTester\Commands\RunGuindyTests;

class GuindyTesterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap du package.
     */
    public function boot()
    {
        // ─── Publication des fichiers de configuration ────────────────────
        $this->publishes([
            __DIR__ . '/config/guindytester.php' => config_path('guindytester.php'),
            __DIR__ . '/config/guindytester_db_info.php' => config_path('guindytester_db_info.php'),
        ], 'guindytester-config');

        // ─── Enregistrement de la commande artisan si en console ─────────
        if ($this->app->runningInConsole()) {
            $this->commands([
                RunGuindyTests::class,
            ]);
        }
    }

    /**
     * Enregistrement des bindings et configuration du package.
     */
    public function register()
    {
        // ─── Merge automatique des configs (accessible via config('guindytester.*')) ─
        $this->mergeConfigFrom(
            __DIR__ . '/config/guindytester.php',
            'guindytester'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/config/guindytester_db_info.php',
            'guindytester_db_info'
        );
    }
}
