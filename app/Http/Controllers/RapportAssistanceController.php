<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\{DB};
use App\Models\{Assistance,RapportAssistance,DetailRapport};
use App\RefactoringItems\CRUDController;
use Illuminate\Validation\Rule;

class RapportAssistanceController extends CRUDController
{
    
    protected function getValidationRules(): array
    {
        
        return [
            'rapport_assistance_id' => [
                Rule::unique($this->table)->where('assistance_id', $this->request->assistance_id)->ignore($this->modelId)
            ],
            'date'      => ['required'],
            'projet_id' => ['required'],
            'libelle'   => ['required'],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'date.required'           => "Veuillez definir une date",
            'projet_id.required'      => "Veuillez selectionner le projet",
            'libelle.required'        => "Veuillez definir le libellé",
        ]; 
    }

    public function beforeValidateData(): void
    { 
        $errors = null;
        $date = new DateTime();
       
        $this->request['details'] = json_decode($this->request->details);
        if (isset($this->request->date)) {
            $date = DateTime::createFromFormat('d/m/Y', $this->request->date);
            if ($date) {
                $this->request->merge(['date' => $date->format('Y-m-d')]);
            }
        }
        if (isset($this->request->status)) {
            $this->request->merge(['status' => $this->request->status === 'on' ? 1 : 0]);        
        }
    }
    public function beforeCRUDProcessing(): void 
    {

    }
    public function afterCRUDProcessing(&$model): void
    {

        $data = parseArray($this->request->details, DetailRapport::class);
        if(isset($this->request->details))
        {
            foreach($this->request->details as $detail_rapport)
            {   $detail_rapports = new DetailRapport();
                $detail_rapports->rapport_assistance_id = $model->id;
                $detail_rapports->assistance_id = $detail_rapport->assistance->id;
                $detail_rapports->save();
            }

        }
        // $model->saveHasManyRelation($data, DetailRapport::class);

        
    }

}
