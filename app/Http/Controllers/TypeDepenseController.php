<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

class TypeDepenseController extends TypeClientController
{
        protected function getValidationRules(): array
    {
        return [
            'nom' => [
                'required',
            ],
            'categorie_depense_id' => [
                'required',
            ],
         
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required' => "Veuillez renseigner le libellé du type de dépense",
            'categorie_depense_id.required' => "Veuillez selectionner une catégorie de dépense",
        ];
    }
}
