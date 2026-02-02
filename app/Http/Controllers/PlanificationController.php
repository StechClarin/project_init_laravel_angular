<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RefactoringItems\CRUDController;
use App\Models\{PlanificationAssigne};
use DateTime;

class PlanificationController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [

            'date_debut'       => [
                'required'
            ],
            'date_fin'       => [
                'required'
            ],
            'details'       => [
                'required',
                'array'
            ],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'date_debut.required'            => "Renseigner la date debut",
            'date_fin.required'            => "Renseigner la date fin",
            'details.required'            => "Veuillez inserer des taches ou fonctionnalités dans le tableau",
        ];
    }
    public function beforeValidateData(): void
    {
        $errors = null;
      
        $this->request['details'] = json_decode($this->request->details);
        if (isset($this->request->date_debut)) {
            $date_debut = DateTime::createFromFormat('d/m/Y', $this->request->date_debut);
            if ($date_debut) {
                $this->request->merge(['date_debut' => $date_debut->format('Y-m-d')]);
            }
        }
        if (isset($this->request->date_fin)) {
            $date_fin = DateTime::createFromFormat('d/m/Y', $this->request->date_fin);
            if ($date_fin) {
                $this->request->merge(['date_fin' => $date_fin->format('Y-m-d')]);
            }
        }
        if (is_null($this->request->created_at) && isset($this->request->date_cebut) && $this->request->date_cebut < today()) {
            $errors = "La date de début ne doit pas être inférieure à la date d'aujourd'hui";
        }
        
        if($errors)
        {  
            throw new \Exception($errors);  
        }

    }
    public function afterCRUDProcessing(&$model): void
    {
        $data = $this->request->details;

        $personnelId = $this->request->get('personnel_id');
        foreach ($data as &$detail) {
            // dd($detail['personnel_id'] = $personnelId);
            $detail->personnel_id  = $personnelId;
        }
        // dd($data);
        // dd(parseArray($this->request->details, PlanificationAssigne::class));
        $model->saveHasManyRelation($data, PlanificationAssigne::class);
    }

}


                                                              


