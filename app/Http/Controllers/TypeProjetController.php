<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

class TypeProjetController extends EntityTypeController
{

    protected function getValidationRules(): array
    {
        return [
            'nom'                         => [
                'required',
                Rule::unique($this->table)->where('nom', $this->request->nom)->ignore($this->modelId)
            ],
        ];
    }

}
