<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tache;
use App\RefactoringItems\CRUDController;
use Exception;
use Mpdf\Tag\B;

class TacheController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'type_tache_id' => [
                'required',
            ],
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required'            => "Renseigner le nom de la tache",
            'type_tache_id.required'  => "Renseigner le type de tache de la tache",
        ];
    }
    public function beforeValidateData():void
    {
        $errors = '';

       
        $tache_exist = Tache::where(['nom'=> $this->request->nom, 'type_tache_id' => $this->request->type_tache_id])->exists();
        if($tache_exist)
        {
            $errors = 'Tache existe déjà';
        }

        if(!empty($errors))
        {
            throw new Exception($errors,1);
        }


    }


}
