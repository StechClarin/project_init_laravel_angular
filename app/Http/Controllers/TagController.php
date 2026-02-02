<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

class TagController extends TypeClientController
{
    protected function getValidationRules(): array
    {
        return [
            'nom' => [
                'required',
                Rule::unique($this->table)->where('nom', $this->request->nom)->ignore($this->modelId)
            ],
            'priorite_id' => 'required',
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required'                       => "Renseigner le nom du tag",
            'nom.unique'                         => "Le nom du tag doit être unique",
            'priorite_id.required'               => "Renseigner la priorité du tag",

        ];
    }

 

}
