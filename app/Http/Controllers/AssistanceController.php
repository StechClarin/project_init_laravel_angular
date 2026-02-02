<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{
    Outil,
    Contact,
    TypeProjet,
    TypeTache,
    Projet,
    Canal,
    Tag,
    User,};
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use DateTime;
use Exception;

class AssistanceController extends EntityTypeController
{
    protected function getValidationRules(): array
    {
        return [
            'date'            => 'required',
            'collecteur_id'   => 'required',
            'rapporteur'      => 'required',
            'type_tache_id'   => 'required',
            'assigne_id'      => 'required',
            'projet_id'       => 'required',
            'canal_id'        => 'required',
            'tag_id'          => 'required',
            'detail'          => 'required',
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'collecteur_id.required'        => "Veuillez renseigner le collecteur",
            'rapporteur.required'           => "Veuillez renseigner le rapporteur",
            'assigne_id.required'           => "Veuillez renseigner l'assigné",
            'canal_id.required'             => "Veuillez renseigner le canal",
            'tag_id.required'               => "Veuillez renseigner la nature de l'assistance", 
            'projet_id.required'            => "Veuillez renseigner le Projet",
            'type_tache_id.required'        => "Veuillez renseigner le type de tache",
            'canal_id.required'             => "Veuillez renseigner le canal ",

            'detail.required'             => "Veuillez decrire l'assistance",

        ]; 
    }
    public function beforeValidateData(): void
    {   
       
        if (!isset($this->request->id))
        {
            $this->request['code']                       =  Outil::getCode($this->model, $this->modelValue->codePrefix);
        }

        if (isset($this->request->date) && $this->request->from_excel == false) {
            $date = DateTime::createFromFormat('d/m/Y', $this->request->date);
            if ($date) {
                $this->request->merge(['date' => $date->format('Y-m-d')]);
            }
        }
        $this->request['status'] = 0;
        if ($this->request->from_excel)
        {   
            $errors = "";
            if(isset($this->request['date']))
            {
                $this->request['date'] = $this->excelToDate($this->request->date);
            }
          
            if(isset($this->request["type_tache_id"]))
            {
                $getTypeTache = TypeTache::query()->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))',[$this->request["type_tache_id"]])->first(); 
                if(isset($getTypeTache->id))
                {
                    $this->request["type_tache_id"] = $getTypeTache->id;
                }
                else
                {
                    $errors = $this->request["type_tache_id"]." N'existe pas dans le systeme";
                }
            }
            
            if(isset($this->request["projet_id"]))
            {
                $getProjet = Projet::query()->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))',[$this->request["projet_id"]])->first();
                if(isset($getProjet->id))
                {
                    $this->request["projet_id"] = $getProjet->id;
                }
                else
                {
                    $errors = $this->request["projet_id"]." N'existe pas dans le systeme";
                }
            }

            if(isset($this->request["canal_id"]))
            {
                $getCanal = Canal::query()->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))',[$this->request["canal_id"]])->first();
                if(isset($getCanal->id))
                {
                    $this->request["canal_id"] = $getCanal->id ;
                }
                else
                {
                    $errors = $this->request["canal_id"]." N'existe pas dans le systeme";
                    $this->request["canal_id"] = null ;

                }
            }

            if(isset($this->request["tag_id"]))
            {
                $getTag = Tag::query()->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))',[$this->request["tag_id"]])->first();
                if(isset($getTag->id))
                {
                    $this->request["tag_id"] = $getTag->id;
                }
                else
                {
                    $errors = $this->request["tag_id"]." N'existe pas dans le systeme";
                }
            }

            if(isset($this->request["collecteur_id"]))
            {
                $getCollecteur = User::query()->whereRaw('TRIM(unaccent(lower(name))) = TRIM(unaccent(lower(?)))',[$this->request["collecteur_id"]])->first();
                if(isset($getCollecteur->id))
                {
                    $this->request["collecteur_id"] = $getCollecteur->id;
                }
                else
                {
                    $errors = $this->request["collecteur_id"]." N'existe pas dans le systeme";
                }
            }
            
            if(isset($this->request["assigne_id"]))
            {
                $getAssigne = User::query()->whereRaw('TRIM(unaccent(lower(name))) = TRIM(unaccent(lower(?)))',[$this->request["assigne_id"]])->first();
                if(isset($getAssigne->id))
                {
                    $this->request["assigne_id"] = $getAssigne->id ;
                }
                else
                {  
                    $errors = $this->request["assigne_id"]." N'existe pas dans le systeme";
                }
            }
            
            switch (strtolower($this->request["status"])) {
                case "en cours":
                    $this->request["status"] = 0;
                    break;
                case "en attente":
                    $this->request["status"] = 1;
                    break;
                case "cloturé":
                    $this->request["status"] = 2;
                    break;
                default:
                    $this->request["status"] = 0;
                    break;
            }
            // dd($this->request->all());
            //throw new Exception($errors, 1);
        }
    }
    function excelToDate($excelDate) {
        $baseDate = new DateTime('1900-01-01');
        $baseDate->modify('+' . ($excelDate - 2) . ' days');
        return $baseDate->format('Y-m-d');
    }
    // public function checkRequestImportExcel($model ,$request,$errors,$name) 
    // {   
    //     if(isset($request))
    //     {   
    //         $getObjet = $model->whereRaw('TRIM(unaccent(lower('.$name.'))) = TRIM(unaccent(lower(?)))',[$request])->first();
    //         dd($getObjet);
    //         if(isset($getObjet->id))
    //         {
    //             $request= $getObjet->id;
    //             dd(''.$request);
    //         }
    //         else
    //         {
    //             $errors = $request." N'existe pas dans le systeme";
    //         }
    //     }
    // }

    


}
