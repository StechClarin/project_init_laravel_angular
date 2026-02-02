<?php

namespace App\Console\Commands;

use App\Jobs\DesactiverMenuJob;
use App\Jobs\ReguleStockJob;
use App\Mail\ValidateStock;
use App\Models\{Produit,Outil,MotifInOut,FicheTechnique,EntreeSortieStock,CommandeProduit,Commande, EntreeSortieStockProduit, Preference};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class RegulerStockCommande extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:regulerstock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer un mail à l\'admin pour lui  alerter que le stock  des produits de la commande sont valide' ;

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
     * @return mixed
     */
    public function handle()
    {
        app('Illuminate\Bus\Dispatcher')->dispatch(new ReguleStockJob());
        return 1 ;
    }
}
