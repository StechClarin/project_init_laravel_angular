<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\RefactoringItems\{CRUDController};

class FonctionnaliteController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'nom'                  => [
                'required',
                Rule::unique($this->table)->where('nom', $this->request->nom)->ignore($this->modelId)
            ],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required'            => "Renseigner le nom de la fonctionnalité",
        ];
    }
    public function beforeValidateData(): void
    {
        
    }
}
