<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{
    Outil,
    Contact,
    TypeProjet,
    ProjetProspect,
    SurMesure,
    ProjetDepartement,
    Departement,
    User,};
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use DateTime;

class ProjetController extends EntityTypeController
{
    protected function getValidationRules(): array
    {
        return [
            'nom'                  => [
                'required',
                Rule::unique($this->table)->where('nom', $this->request->nom)->ignore($this->modelId)
            ],
            'type_projet_id'       => 'required',
            'client_id'               => 'required',
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required'             => "Renseigner le nom du projet",
            'type_projet_id.required'    => "Renseigner le type de projet",
            'client_id.required'            => "Renseigner le client"
        ];
    }
    public function beforeValidateData(): void
    {
        // dd($this->request->all());
        if ($this->request->has('date_prochain_renouvellement')) {
            $date = DateTime::createFromFormat('d/m/Y', $this->request->input('date_prochain_renouvellement'));
            if ($date) {
                $this->request->merge(['date_prochain_renouvellement' => $date->format('Y-m-d')]);
            }
        }
        if ($this->request->has('date_debut')) {
            $date = DateTime::createFromFormat('d/m/Y', $this->request->input('date_debut'));
            if ($date) {
                $this->request->merge(['date_debut' => $date->format('Y-m-d')]);
            }
        }
        if ($this->request->has('date_cloture')) {
            $date = DateTime::createFromFormat('d/m/Y', $this->request->input('date_cloture'));
            if ($date) {
                $this->request->merge(['date_cloture' => $date->format('Y-m-d')]);
            }
        }
        {

        }
        if (!isset($this->request->id))
        {
            $this->request['code']  =  Outil::getCode($this->model, $this->modelValue->codePrefix);
        }

         

        if ($this->request->from_excel)
        {
            $getTypeProjet = TypeProjet::query()->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))',[$this->request["type_projet_id"]])->first();
            $this->request["type_projet_id"] = $getTypeProjet->id ?? null;
        }
    }

    public function afterCRUDProcessing(&$model): void
    {
        if($model->id){
            if(isset($this->request->noyaux_interne_id))
            {
                $prospect = ProjetProspect::where([  
                    'noyaux_interne_id' => $this->request->noyaux_interne_id,  
                    'nom' => $this->request->nom,  
                    'client_id' => $this->request->client_id,  
                ])->update(['status' => 2]);
            }
            else
            {
                $surmesure = SurMesure::where([   
                    'nom' => $this->request->nom,  
                    'client_id' => $this->request->client_id,  
                ])->update(['status' => 2]);
            }
            $exists = ProjetDepartement::where('projet_id', $model->id)->exists();
            if(!$exists)
            {
                $departement = Departement::get();
                foreach($departement as $dep)
                {
                    $projetDepartment = ProjetDepartement::create([
                        'projet_id' => $model->id,
                        'departement_id' => $dep->id,
                    ]);
                }
            }
           
        }      
    } 


}
