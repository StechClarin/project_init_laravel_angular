<?php

namespace App\Http\Controllers;

use App\Models\TypeDepense;
use App\Models\Outil;
use App\RefactoringItems\CRUDController;
use Illuminate\Validation\Rule;

class DepenseController extends CRUDController
{

    protected function getValidationRules(): array
    {
        return [
            'nom' => [
                'required',
            ],
            'typedepense_id' => [
                'required',
            ],
            'montant' => [
                'required',
            ],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'nom.required' => "Veuillez renseigner le libellé de la dépense",
            'typedepense_id.required' => "Veuillez selectionner un type de dépense",
            'montant.required' => "Veuillez renseigner le montant",
        ];
    }
    public function beforeValidateData(): void
    {
        if (!isset($this->request->id)) {
            $this->request['code'] = Outil::getCode($this->model, $this->modelValue->codePrefix);
        }

        // dd($this->request);

        if (isset($this->request->from_excel) && $this->request['from_excel']) {
            $getTypeClient = TypeDepense::query()->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))', [$this->request["typedepense_id"]])->first();
            $this->request["typedepense_id"] = $getTypeClient->id ?? null;
            // dd($this->request);

            // dd($this->request["type_client_id"]);
            $res = [];
        }
    }
    public function afterCRUDProcessing(&$model): void
    {
            $model->date = $model->created_at;
            // dd($model->date);
            $model->save();
        
    }
}
