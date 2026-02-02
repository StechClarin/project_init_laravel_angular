<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ValidateStock;
use App\Models\Commande;
use App\Models\CommandeProduit;
use App\Models\EntreeSortieStock;
use App\Models\EntreeSortieStockProduit;
use App\Models\FicheTechnique;
use App\Models\MotifInOut;
use App\Models\Outil;
use App\Models\Preference;
use App\Models\Produit;
use Illuminate\Support\Facades\Mail;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class ReguleStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
       
        try
        {
            $report = array();
            $totalToUpload = 0;
            $totalUpload = 0;
            $allcommandes = [];

            $exception = DB::transaction(function () use  (&$totalUpload,&$totalToUpload,&$allcommandes,&$report) {

                $allcommandes = Commande::where('is_treated',false)->where('etat_commande',8)->get() ;
            
                foreach ($allcommandes as $onecommande)
                {
                    //$errors = null;
                    $ProduitCommandes = CommandeProduit::where('commande_id',$onecommande->id)->where('is_treated',false)->whereNotIn('produit_id',Produit::where('is_menu',true)->get(['id']))->get();
                    if(count($ProduitCommandes) > 0)
                    {
                        $motif  = MotifInOut::where('nom','commande')->first();
                        if(!isset($motif))
                        {
                            $motif                          = new MotifInOut ();
                            $motif->nom                     = 'commande';
                            $motif->save();
                        }
                        $sortiestock =   EntreeSortieStock::where('commande_id',$onecommande->id)->first();
                        if(!isset($sortiestock))
                        {
                            $sortiestock                         = new EntreeSortieStock();
                            $sortiestock->date                   = Outil::donneValeurDate( null);
                            $sortiestock->commande_id            = $onecommande->id;
                            $sortiestock->code                   = 'code';
                            $sortiestock->multiplicateur         = -1;
                            $sortiestock->depot_id               = $onecommande->depot_id;
                            $sortiestock->motif_in_out_id        = $motif->id ?? null;
                            $sortiestock->etat                   = 1;
                            $sortiestock->created_at_user_id     = 1;
                            $sortiestock->save();
                            $sortiestock->user_validate_at       = 1;
                            $sortiestock->save();
                            Outil::saveCode($sortiestock,'SST');
                        }
                        foreach ($ProduitCommandes as $onIntem)
                        {
                            $err = array();
                            $totalToUpload ++;
                            $produit = Produit::find($onIntem->produit_id);
                            $currentqte = Produit::getCurrentQte($produit->id,$onecommande->depot_id);
                            if($currentqte < $onIntem->quantite && FicheTechnique::where('produit_id',$produit->id)->count() >0 )
                            {
                                Commande::AjusterQte($sortiestock,$produit->id,$onecommande->depot_id,$onIntem->quantite ,$onIntem->id);
                                $onIntem->is_treated = 1;
                                $onIntem->save();
                                $totalUpload ++; 
                            }
                            else
                            {
                                $sortiestockProduit                         = new EntreeSortieStockProduit();
                                $sortiestockProduit->produit_id             = $onIntem->produit_id;
                                $sortiestockProduit->entree_sortie_stock_id = $sortiestock->id;
                                $sortiestockProduit->multiplicateur         = -1;
                                $sortiestockProduit->depot_id               = $sortiestock->depot_id;
                                $sortiestockProduit->etat                   = 1;
                                $sortiestockProduit->quantite               = $onIntem->quantite;
                                $sortiestockProduit->commande_produit_id    = $onIntem->id;
                                $sortiestockProduit->save();
                                $totalUpload ++;
                                $onIntem->is_treated = 1;
                                $onIntem->save();
                            }
                        }
                        array_push($report, [
                            'libelle'           => $onecommande->code,
                            'causse'            => $err,
                        ]);
                        $is_traited_cm = CommandeProduit::where('commande_id',$onecommande->id)->where('is_treated',false)->whereNotIn('produit_id',Produit::where('is_menu',true)->get(['id']))->first();
                        if(!isset($is_traited_cm))
                        {
                            $onecommande->is_treated = 1;
                            $onecommande->save();
                        }
                    }

                    if(EntreeSortieStockProduit::where('entree_sortie_stock_id',$sortiestock->id)->count() == 0)
                    {
                        $sortiestock->delete();
                        $sortiestock->forceDelete();
                    }
                }
                
                return null;
            });

           

            if(count($allcommandes) > 0 && is_null($exception))
            {
                //echo 'ici mail'.count($allcommandes);

                $pdf = PDF::loadView('pdfs.new-info-commande-rapport', array(
                    'reports'       => $report,
                    'title'         => 'Rapport de Regularisation des stocks de la commande ',
                    'totals'        => [
                        'toUpload'     => $totalToUpload,
                        'upload'       => $totalUpload,
                    ],
                    'addToData' => array('entete' => null, 'hidefooter' => true)
                ));

                Outil::sendEmail(ValidateStock::class,$pdf);
            } 
        }
        catch (\Exception $e)
        {
            return Outil::getResponseError($e);
        }
    }
}
