<?php

namespace App\Http\Controllers;

use App\Models\DetailProfilFacturation;
use App\Models\ModeFacturation;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\throwException;

class ProfilFacturationController extends EntityTypeController
{

    protected function getValidationRules(): array
    {
        return [
            'nom'                         => [
                'required',
                Rule::unique($this->table)->where('nom', $this->request->nom)->ignore($this->modelId)
            ],

            'mode_facturation_id'   => 'required',
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            'mode_facturation_id.required'            => "Renseigner le mode de facturation",

            'famille_debour_id.required'               => "Renseigner la famille de debour",
        ];
    }

    public function beforeValidateData(): void
    {
        $details = parseArray($this->request->details);

        $getModeFacturation = ModeFacturation::query()->find($this->request->mode_facturation_id);

        if (!isset($getModeFacturation))
        {
            throw new \Exception('Mode de facturation introuvable');
        }
        if ($getModeFacturation->value === 0 || $getModeFacturation->value === 2)
        {
            $this->request['option_facturation_id'] = null;
        }

        if ($getModeFacturation->value === 1 && empty($this->request->option_facturation_id))
        {
            throw new \Exception("Renseigner l'option de facturation");
        }
        else if ($getModeFacturation->value === 2 && count($details) === 0)
        {
            throw new \Exception("Pour le mode de facturation spécifique, renseigner au moins une ligne dans le tableau");
        }
    }

    public function afterCRUDProcessing(&$model): void
    {
        $data = parseArray($this->request->details, DetailProfilFacturation::class);
        $model->saveHasManyRelation($data, DetailProfilFacturation::class);
    }
}
