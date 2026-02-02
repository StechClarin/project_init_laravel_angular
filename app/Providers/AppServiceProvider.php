<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Gestions\PhotoGestionInterface',                          'App\Gestions\PhotoGestion');
        $this->app->bind('App\Gestions\EsGestionInterface',                             'App\Gestions\EsGestion');
        $this->app->bind('App\Gestions\CodeGestionInterface',                           'App\Gestions\CodeGestion');
        $this->app->bind('App\Gestions\CaisseSocieteFacturationSoldeGestionInterface',  'App\Gestions\CaisseSocieteFacturationSoldeGestionV1');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
