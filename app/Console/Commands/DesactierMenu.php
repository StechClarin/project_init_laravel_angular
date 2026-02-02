<?php

namespace App\Console\Commands;

use App\Jobs\DesactiverMenuJob;
use App\Mail\DesactiverMenu;
use App\Models\Preference;
use App\Models\Produit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class DesactierMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'desactvier:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Pour desactiver automatiquement les menus dont la date de fin est aujourd'hui";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app('Illuminate\Bus\Dispatcher')->dispatch(new DesactiverMenuJob());
        //sleep(20);
        $this->info("votre comnmande a ete executé avec succès ".date("H:i:s"));
        return 1;
    }
}
