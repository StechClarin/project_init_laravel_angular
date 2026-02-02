<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;

class NiveauHabiliteController extends EntityTypeController
{
    protected $relationsdelete = array('users', 'commandes');

    protected function getValidationRules(): array
    {
        return [
           'nom' => [
               'required',
               Rule::unique($this->table)->ignore($this->modelId)
           ],
           'niveau' => [
                'required',
                Rule::unique($this->table)->ignore($this->modelId)
            ],
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            "nom.unique"              => "Ce nom existe déja",
            "niveau.unique"           => "Ce niveau existe déja",
        ];
    }
}
