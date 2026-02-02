<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{VisaQualite,Visa,ProjetModule,VisaFinal,VisaCtoCdp,TacheFonctionnalite,FonctionnaliteModule,Outil};
use App\RefactoringItems\SaveModelController;
use Illuminate\Support\Facades\DB;


class VisaController extends Controller
{
    public function checkStatusModule(FonctionnaliteModule $f)
    {
       
        if($f->status == 2)
        {
            $projet = ProjetModule::where('id', $f->projet_module_id)->first();
            $projet->status = 2;
            $projet->save();
        }
    }
    public function visaview(Request $request)
    {    try
        {
            return DB::transaction(function () use ($request)
            {
                $errors = null;
                $data = 0;
                $user_id = Auth::user()->id;
                if(!isset($request->id))
                {
                    throw new \Exception('Erreur d\'enregistré');
                }
                $tache_fonctionnalite = TacheFonctionnalite::where('id', $request->id)->first();
                $visa = new Visa;
                $visa->tache_fonctionnalite_id = $tache_fonctionnalite->id;
                $visa->user_id = $user_id;
                $visa->visa = $request->status;

                if($request->substatut == 'visa_dev')
                {
                    if($visa->save())
                    {
                        $data = 1;
                    }
                    else
                    {
                        throw new \Exception('Visa dev non enregistré');
                    }       
                }
                else if($request->substatut == 'visa_qualite')
                {
                    if($visa->save())
                    {
                        if($visa->visa == 1)
                        {
                            $visa_final                          = new VisaFinal;
                            $visa_final->tache_fonctionnalite_id = $tache_fonctionnalite->id;
                            $visa_final->user_id                 = $user_id;
                            $visa_final->visa                    = $request->status;
                            if($visa_final->save())
                            {
                                $data = 1;
                            }
                        }
                        else
                        {
                            $visa_qualite                          = new VisaQualite;
                            $visa_qualite->tache_fonctionnalite_id = $tache_fonctionnalite->id;
                            $visa_qualite->user_id                 = $user_id;
                            $visa_qualite->commentaire             = $request->commentaire;
                            $visa_qualite->visa                    = $request->status;
                            if($visa_qualite->save())
                            {
                                $data = 1;
                            }
                        }
                      
                    }
                    else
                    {
                        throw new \Exception('Visa non enregistré');
                    }       
                }
                else if($request->substatut == 'visa_chef')
                {
                    if($request->status == 1)
                    {
                        $visa_final                          = new VisaFinal;
                        $visa_final->tache_fonctionnalite_id = $tache_fonctionnalite->id;
                        $visa_final->user_id                 = $user_id;
                        $visa_final->visa                    = $request->status;
                        if($visa_final->save())
                        {
                            $tache_fonctionnalite->status = 1;
                            if($tache_fonctionnalite->save())
                            {
                                $data = 1;
                            }
                        }
                    }
                    else if($request->status == 0)
                    {
                        $visa_cto                          = new VisaCtoCdp;
                        $visa_cto->tache_fonctionnalite_id = $tache_fonctionnalite->id;
                        $visa_cto->user_id                 = $user_id;
                        $visa_cto->commentaire             = $request->commentaire;
                        $visa_cto->visa                    = $request->status;
                        if($visa_cto->save())
                        {
                            $visa->save();
                            $visa_final                          = new VisaFinal;
                            $visa_final->tache_fonctionnalite_id = $tache_fonctionnalite->id;
                            $visa_final->user_id                 = $user_id;
                            $visa_final->visa                    = $request->status;
                            if($visa_final->save())
                            {
                                $data = 1;
                            }
                            
                        }
                    }
                    else
                    {
                        throw new \Exception('Visa non enregistré');
                    } 
                }
                $tacheFonctionnalite = TacheFonctionnalite::where('id', $tache_fonctionnalite->id);
                $totalTasks = $tacheFonctionnalite->count();   
                $totalTasksFinish = $tacheFonctionnalite->where('status', 1)->count();   
                $fm = FonctionnaliteModule::where('fonctionnalite_id', $tache_fonctionnalite->fonctionnalite_id)->first();
                if ($totalTasksFinish == $totalTasks) { 
                    if ($fm) { 
                        $fm->status = 2;  
                        $fm->save();
                        $data = 1; 
                        $this->checkStatusModule($fm);
                    }  
                } else {  
                    if ($fm) {  
                        $fm->status = 1;  
                        $fm->save(); 
                        $data = 1; 
                    }  
                }  
                return response('{"data":' . $data . ' }')->header('Content-Type', 'application/json');
                
            });
        }
        catch (\Exception $e)
        {
            return Outil::getResponseError($e);
        }
    }
}
