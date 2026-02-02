<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\RefactoringItems\{CRUDController};

class EntityTypeController extends CRUDController
{
    protected function getValidationRules(): array
    {
        if(array_key_exists('famille_produit_id', $this->request->all()))
        {
            $nomUnique = Rule::unique($this->table)->where('famille_produit_id', $this->request->famille_produit_id)->ignore($this->modelId);
        }
        else
        {
            $nomUnique = Rule::unique($this->table)->ignore($this->modelId);
        }

        if (\str_contains($this->table, 'nomenclature_douanieres'))
        {
            $nomUnique = false;
        }

        return [
            'code'                        => [
                'nullable',
                Rule::unique($this->table)->ignore($this->modelId)
            ],
            'nom'                         => [
                'required',
                $nomUnique
            ],
            'nbre_jour'                        => [
               str_contains(strtolower($this->model), "modalitepaiement") ? 'required' : 'nullable'
            ],
            'tarifbsc'                        => [
                str_contains(strtolower($this->model), "typeconteneur") ? 'required' : 'nullable'
            ],
            // 'abreviation'                 => [
            //     \str_contains($this->table, 'unite_mesures') ? 'required' : 'nullable',
            //     Rule::unique($this->table)->ignore($this->modelId)
            // ],
            // 'ordre'                       => [
            //     'nullable',
            //     array_key_exists('famille_produit_id', $this->request->all()) ? Rule::unique($this->table)->where('famille_produit_id', $this->request->famille_produit_id)->ignore($this->modelId) : Rule::unique($this->table)->ignore($this->modelId)
            // ],
            // 'description'                 => 'nullable',
            // 'taux_change'                 => 'nullable',
            // 'devise_base'                 =>  [
            //     'nullable',
            //     array_key_exists('devise_base', $this->request->all()) ? Rule::unique($this->table)->where('devise_base', 1)->ignore($this->modelId) : Rule::unique($this->table)->ignore($this->modelId)
            // ],
            // 'signe'                       => [
            //     'nullable',
            //     Rule::unique($this->table)->ignore($this->modelId)
            // ],
            // 'nb_jour'                     => 'nullable',
            // 'client_id'                   => 'nullable',

            // 'nb_utilisation'             => 'nullable',
            // 'code_couleur'               => 'nullable',
            // 'famille_produit_id'         => 'nullable',
            // 'valeur'                     => 'nullable',
            // 'categorie_depense_id'       => 'nullable',
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            "nom.required"             => "Le nom est obligatoire",
            "nbre_jour.required"       => "Le nombre de jour est obligatoire",
            "signe.unique"             => "Le signe de la devise est déjà utilisé",
            "devise_base.unique"       => "Une devise de base est déja définie",
            "nom.unique"               => "Ce nom existe déjà",
            "tarifbsc.required"        => "Le tarif BSC est obligatoire",
        ];
    }
}
