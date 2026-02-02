<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Models\{Prospect};


class ProjetProspectController extends EntityTypeController
{
    protected function getValidationRules(): array
    {
        
        return [
            'date'        => ['required'],
            'nom'        => ['required'],
            'commentaires'=> ['required'],
            'client_id'   => ['required'],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
      
        return [
            'date.required'           => "Veuillez definir une date de debut",
            'nom.required'           => "Veuillez definir le nom du projet",
            'client_id.required'      => "Veuillez selectionner le prospect",
            'commentaires.required'   => "Veuillez inserer le detail necessaire ",
        ]; 
    }

    public function beforeValidateData(): void
    { 
        
        $errors = null;
        $date = new DateTime();
       
        if (isset($this->request->date)) {
            $date = DateTime::createFromFormat('d/m/Y', $this->request->date);
            if ($date) {
                $this->request->merge(['date' => $date->format('Y-m-d')]);
            }
        }  
        // dd($this->request->all());
    }

    public function beforeCRUDProcessing(): void
    {
        if(!$this->request->has('noyaux_interne_id'))
        {
            
            
        }
    }

}