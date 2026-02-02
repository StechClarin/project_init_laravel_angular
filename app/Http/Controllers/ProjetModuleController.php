<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\RefactoringItems\{CRUDController};
use App\Models\{Projet,Departement};

class ProjetModuleController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'nom'                  => [
                'required',
                Rule::unique($this->table, 'nom')  
                    ->where('projet_id', $this->request->projet_id)  
                    ->ignore($this->modelId)
            ],
            'nom_departement'       => 'required',
            'nom_projet'       => 'required',
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required'            => "Renseigner le nom du module",
            'nom_departement.required' => "Renseigner le departement",
            'nom_projet.required' => "Renseigner le  nom du projet"
        ];
    }

    public function beforeValidateData(): void
    {
        // dd($this->request->all());
        if(isset($this->request->nom_projet))
        {
            $this->request['projet_id'] = Projet::where('nom',$this->request->nom_projet)->first()->id;
        }
        if(isset($this->request->nom_departement))
        {
            $departement = Departement::whereRaw('LOWER(nom) LIKE LOWER(?)', ["%{$this->request->nom_departement}%"])->first() ?? null;
            if($departement)
            {
                $this->request['departement_id'] = $departement->id ;   
            }
        }
    }

    public function visaview(Request $request)
    {
        dd($this->request->all());
    }

}
