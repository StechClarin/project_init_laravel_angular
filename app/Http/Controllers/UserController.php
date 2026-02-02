<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use App\Models\{Outil, User};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\Validation\Rule;
use App\RefactoringItems\{CRUDController};
use Spatie\Permission\Models\Role;

class UserController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'name'                  => 'required',
            'email'                 => [
                'required',
                Rule::unique($this->table)->ignore($this->modelId)
            ],
            'password'              => Rule::requiredIf(function () {
                return is_null($this->modelId);
            }),
            'telephone'             => 'nullable',
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            "email.unique"  => "Un utilisateur avec le même email existe déja",
        ];
    }

    public $niveau_habilite_id = null;
    public function beforeCRUDProcessing(): void
    {
        if (!isset($this->modelId) && $this->request->password != $this->request->confirmpassword) {
            throw new \Exception("Veuillez saisir le même mot de passe");
        }
        if (strlen($this->request->password) < 8) {
            throw new \Exception("Le mot de passe doit contenir au moins 8 caractères");
        }

        $this->niveau_habilite_id = $this->request->niveau_habilite_id;
        $this->roles = $this->request->roles;
        // $this->typeproduits = $this->request->input('typeproduits');

        if (isset($this->modelId)) {
            // if (!isset($this->niveau_habilite_id))
            // {
            //     $this->request['niveau_habilite_id'] = $this->modelValue->niveau_habilite_id;
            // }
            // if (count($this->roles)==0)
            // {
            //     $this->request['roles'] = $this->modelValue->roles()->pluck('id')->toArray();
            // }
            // if ( count($this->typeproduits)==0)
            // {
            //     $this->request['typeproduits'] = $this->modelValue->typeproduits()->pluck('id')->toArray();
            // }
        }
    }

    public function afterCRUDProcessing(&$model): void
    {
        // dd($this->typeproduits);
        $model->syncRoles($this->request->roles);
        // $typeproduits = parseArray($this->typeproduits);
        // $model->type_produits()->sync($typeproduits);

        Outil::uploadFileToModel($this->request, $model, 'image');
    }
}
