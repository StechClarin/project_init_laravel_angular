<?php

namespace App\Http\Controllers;

use App\Models\MotifEntreSortieCaisse;
use App\RefactoringItems\CRUDController;
use Illuminate\Validation\Rule;
use App\Models\Caisse;

class EntreSortieCaisseController extends CRUDController
{

    protected function getValidationRules(): array
    {
        return [
            'caisse_id' => [
                'required',
            ],
            'motifentresortiecaisse_id' => [
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
            'caisse_id.required' => "Veuillez selectionner une caisse",
            'motifentresortiecaisse_id.required' => "Veuillez selectionner un motif",
            'montant.required' => "Veuillez renseigner le montant",
        ];
    }

    public function beforeValidateData(): void
    {
        if ($this->request->from_excel) {
            $this->request["caisse_id"] = $this->getEntityIdByName(Caisse::class, $this->request["caisse_id"]);
            $this->request["motifentresortiecaisse_id"] = $this->getEntityIdByName(MotifEntreSortieCaisse::class, $this->request["motifentrecaisse_id"]);
        }
    }


    private function getEntityIdByName(string $modelClass, ?string $name): ?int
    {
        if (!$name) {
            return null;
        }

        $entity = $modelClass::query()
            ->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))', [$name])
            ->first();

        return $entity->id ?? null;
    }
}
