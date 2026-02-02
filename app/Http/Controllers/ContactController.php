<?php

namespace App\Http\Controllers;

use App\RefactoringItems\CRUDController;
use Illuminate\Validation\Rule;

class ContactController extends CRUDController
{

    protected function getValidationRules(): array
    {
        return [
            'nom'    => ['required'],
            'prenom'  => ['required'],
            'telephone' => ['required', Rule::unique('contacts', 'telephone')->ignore($this->request->id)],
            'email'  => [ Rule::unique('contacts', 'email')->ignore($this->request->id)]
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required' => "Le nom est requis",
            'prenom.required' => "Le prénom est requis",
            'telephone.required' => "Le numéro de téléphone est requis",
            'telephone.unique' => "Ce numéro de téléphone est déjà utilisé",
            'email.unique' => "Cette adresse e-mail est déjà utilisée",
            'email.email' => "L'adresse e-mail doit être valide",
        ];
    }

}
