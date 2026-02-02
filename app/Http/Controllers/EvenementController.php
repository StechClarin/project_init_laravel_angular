<?php

namespace App\Http\Controllers;

use App\RefactoringItems\CRUDController;
use Illuminate\Validation\Rule;
use DateTime;
use App\Models\Personnel;
use App\Models\Projet;


class EvenementController extends CRUDController
{
    public function beforeValidateData(): void
    {



        if (request()->has('positif_negatif')) {
            request()->merge([
                'positif_negatif' => request('positif_negatif') === 'oui' ? true : false,
            ]);
        }

        // if (request()->has('justificatif')) {
        //     request()->merge([
        //         'justificatif' => request('justificatif') === 'oui' ? true : false,
        //     ]);
        // }

        if ($this->request->from_excel) {
            $personnel = Personnel::query()->whereRaw('TRIM(unaccent(lower(personnel))) = TRIM(unaccent(lower(?)))', [$this->request["personnel_id"]])->first();
            $this->request["personnel_id"] = $personnel->id ?? null;
            $projet = Projet::query()->whereRaw('TRIM(unaccent(lower(projet))) = TRIM(unaccent(lower(?)))', [$this->request["projet_id"]])->first();
            $this->request["projet_id"] = $projet->id ?? null;
            // dd($this->request);
            $this->request->merge([
                'positif_negatif' => $this->request->retard === 'oui' ? true : false,
            ]);
            // $this->request->merge([
            //     'retard' => $this->request->justificatif === 'oui' ? true : false,
            // ]);
            // dd($this->request["type_client_id"]);
            $res = [];
        }
    }

    protected function getValidationRules(): array
    {
        return [
            'date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'personnel_id' => [
                'required',
            ],
            'observation' => [
                'required',
            ],
            'temps' => [
                'required',
            ],
            'projet_id' => [
                'required',
            ],
            'gravite_id' => [
                'required',
            ],
            'mesure_id' => [
                'required',
            ],
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            'date.before_or_equal' => "vous ne pouvez selectionner une date a venir",
            'date.required' => "veillez renseigner la date ",
            'observation.required' => "veillez noter une observation",
            'temps.required' => "veillez renseigner le nombre d'heures perdues",
            'projet_id.required' => "veillez selectionner un projet",
            'gravite_id.required' => "veillez selectionner une gravité",
            'mesure_id.required' => "veillez selectionner une mesure",

        ];
    }
}
