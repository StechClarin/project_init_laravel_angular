<?php

namespace App\Http\Controllers;

use App\Models\CoursDevise;
use App\Models\Devise;
use Illuminate\Validation\Rule;

class DeviseController extends EntityTypeController
{
    protected $columStatut = 'devise_base';
    protected $oldCours = null;

    protected function getValidationRules(): array
    {
        return [
            'code'                        => [
                'required',
                Rule::unique($this->table)->ignore($this->modelId)
            ],
            'nom'                         => [
                'required',
                array_key_exists('famille_produit_id', $this->request->all()) ? Rule::unique($this->table)->where('famille_produit_id', $this->request->famille_produit_id)->ignore($this->modelId) : Rule::unique($this->table)->ignore($this->modelId)
            ],
            'description'                 => 'nullable',
            'taux_change'                 => 'nullable',
            'devise_base'                 =>  [
                'nullable',
                array_key_exists('devise_base', $this->request->all()) ? Rule::unique($this->table)->where('devise_base', 1)->ignore($this->modelId) : Rule::unique($this->table)->ignore($this->modelId)
            ],
            'signe'                       => [
                'required',
                Rule::unique($this->table)->ignore($this->modelId)
            ],
            'cours'                     => 'required',
            'unite'                     => 'required',
            'precision'                 => 'nullable',
        ];
    }

    public function checkDeviseBase()
    {
        $deviseBase = $this->model::where('devise_base', true)
            ->where('id', '!=', $this->modelId)->first();

        if (!is_null($deviseBase) && ($this->request->devise_base == true || $this->request->status == 1))
        {
            throw new \Exception("Une devise de base est déja définie");
        }
    }

    public function beforeValidateData(): void
    {
        $this->request['devise_base'] = !(array_key_exists('devise_base', $this->request->all())) ? 0 : 1;
        if (!empty($this->request['id']))
        {
            $devise = Devise::query()->find($this->request['id']);
            if (isset($devise))
            {
                $this->oldCours =  $devise->cours;
            }
        }

    }

    public function beforeCRUDProcessing(): void
    {
        $this->checkDeviseBase();
    }

    public function beforeStatut(): void
    {
        $this->checkDeviseBase();
    }

    public function afterCRUDProcessing(&$model): void
    {
       $cd = CoursDevise::query()->where('devise_id',$model->id)->where('cours',$model->cours)->first();

       if (!isset($cd))
       {
           $cd =  new CoursDevise();
           $cd->devise_id = $model->id;
           $cd->cours = $this->oldCours;
           $cd->save();
       }
    }
}
