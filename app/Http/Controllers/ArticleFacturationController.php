<?php

namespace App\Http\Controllers;

use App\Models\FamilleDebour;
use Illuminate\Validation\Rule;

class ArticleFacturationController extends EntityTypeController
{
    protected function getValidationRules(): array
    {
        return [
            'nom'                         => [
                'required',
                //Rule::unique($this->table)->where('nom', $this->request->nom)->ignore($this->modelId)
            ],

            'code'                    => 'required',

            //'option_facturation_id'   => $this->request->from_excel ? 'nullable' : 'required',

            //'famille_debour_id'       => 'required',
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            //'option_facturation_id.required'            => "Renseigner l'option de facturation",

            'famille_debour_id.required'               => "Renseigner la famille de debour",
        ];
    }
    public function beforeValidateData(): void
    {
        if($this->request->from_excel)
        {
            //$getFamilleDebour = FamilleDebour::query()->whereRaw('TRIM(lower(nom)) = TRIM(lower(?))',$this->request->famille_debour_id)->first();
            $getFamilleDebour = FamilleDebour::query()->whereRaw('TRIM(lower(code)) = TRIM(lower(?))',$this->request->famille_debour_id)->first();
            $this->request['famille_debour_id'] = $getFamilleDebour->id ?? null ;
        }
    }

}
