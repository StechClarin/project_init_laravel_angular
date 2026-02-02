<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Outil;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DesactierMenu::class,
        Commands\RegulerStockCommande::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        //$schedule->command('desactvier:menu')->dailyAt('23:59');
        $schedule->command('desactvier:menu')->dailyAt('23:59');  
        $schedule->command('sendmail:regulerstock')->dailyAt('23:59');  

         //vérifier paiement avec CinetPay
        $schedule->call(function(){
            $retour = Outil::enregistrerGeolocalisation();
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
