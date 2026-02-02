<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\RefactoringItems\{CRUDController};
use App\Models\{FonctionnaliteModule,TacheFonctionnalite,ProjetModule};

class TacheFonctionnaliteController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'tache_id' => [  
                'required',  
                Rule::unique($this->table)  
                    ->where(function ($query) {  
                        return $query->where('tache_id', $this->request->tache_id)  
                                     ->where('fonctionnalite_module_id', $this->request->fonctionnalite_module_id);  
                    })  
                    ->ignore($this->modelId),  
                ],  
            'fonctionnalite_module_id' => ['required'], 
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'tache_id.required' => "Renseigner la tache",
            'fonctionnalite_module_id.required' => "Rassurez vous que la fonctionnalité es bien renseignée",
        ];
    }
    public function beforeValidateData(): void
    {
        // dd($this->request->all());
    }
    // public function afterCRUDProcessing(&$model):void
    // {
    //     if($model->id)
    //     {
    //         $fm = FonctionnaliteModule::where('fonctionnalite_id',$model->fonctionnalite_id)->first();
    //         $fm->status = 1;
    //         if($fm->save())
    //         {
    //            $this->checkStatusModule($fm, 'add');
    //         }
    //     }
    // }

   

    public function beforeDelete(): void
    {
        $fm = FonctionnaliteModule::where('fonctionnalite_id', TacheFonctionnalite::where('id', (int) $this->request->id)->first()->fonctionnalite_id)->first();
        $total_tache = TacheFonctionnalite::where('fonctionnalite_module_id', $fm->fonctionnalite->id)->count();
        $total = TacheFonctionnalite::where(['fonctionnalite_module_id'=> $fm->fonctionnalite->id, 'status'=> 1])->count();
        if($total_tache == 1)
        {
            $fm->status = 0;
            if($fm->save())
            {
                $this->checkStatusModule($fm,'delete');
            }
        }
        else
        {
            $fm->status = 1;
            if($fm->save())
            {   
                $this->checkStatusModule($fm,'delete');
            }
        }
    }
    public function checkStatusModule(FonctionnaliteModule $f, $action)
    {
        $total_tache = TacheFonctionnalite::where('fonctionnalite_module_id', $f->fonctionnalite_id)->count();
        $total = TacheFonctionnalite::where(['fonctionnalite_module_id'=> $f->fonctionnalite->id, 'status'=> 2])->count();
        $projet = ProjetModule::where('id', $f->projet_module_id)->first();
        // dd($total_tache, $total);
        if($action == "delete")
        {
            if($total_tache-1 != $total &&  $total > 1)
            {   
                
                $projet->status = 1;
            }
            else if($total_tache-1 == $total &&  $total >= 1)
            {
                $projet->status = 2;
            }
            else if($total_tache-1 == $total &&  $total <1)
            {
                $f->status = 0;
                $f->save();
                $projet->status = 0;
            }
            else
            {
                $projet->status = 1;
            }
        }
        else
        {
            $projet->status = 1;
        }
        $projet->save();
    }

}
