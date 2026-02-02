<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{DB};

use App\RefactoringItems\{CRUDController};
use App\Models\{Fonctionnalite, Module, ModuleDepartement,ProjetModule, ProjetDepartement, FonctionnaliteModule};

class FonctionnaliteModuleController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'projet_module_id'                  => [
                'required',
                Rule::unique($this->table)->where('projet_module_id', $this->request->projet_module_id)->ignore($this->modelId)
            ],
            'fonctionnalites'         => [
                'required'
            ],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'projet_module_id.required'            => "Renseigner le nom du module",
        ];
    }
    public function beforeValidateData(): void
    {
        $errors = null;
        // dd($this->request->all());
        foreach ($this->request->fonctionnalites as $key => $value) {
            // $fonctionnalites[] = [
            //     'id' => Fonctionnalite::where('nom', $value)->first()->id,
            //     'duree' => $this->request->duree[$key] ?? 0,
            // ];
            $fm = FonctionnaliteModule::where(['fonctionnalite_id'=> (int)$value, 'projet_module_id' => (int) $this->request->projet_module_id]);
            if($fm->exists())
            {   
                $fonctionnalite = Fonctionnalite::find( (int) $value);
                if ($fonctionnalite) {  
                    $nomFonctionnalite = $fonctionnalite->nom;  
                    $errors = $nomFonctionnalite . ': existe deja dans ce module';
                }  
            }
        }
        if($errors)
        {  
            throw new \Exception($errors);  
        }

        // $this->request['fonctionnalites'] = $fonctionnalites;
        // dd($this->request['fonctionnalites']);
    }

    public function saveFonctionnaliteModule()
    {

        return DB::transaction(function ()
        {
            // dd($this->request->all());
            $this->beforeValidateData();
            $this->getValidationRules();

            $fonctionnalites = null;
            foreach ($this->request->fonctionnalites as $key => $value) {
                // $fonctionnalites[] = [
                //     'id' => Fonctionnalite::where('nom', $value)->first()->id,
                //     'duree' => $this->request->duree[$key] ?? 0,
                // ];
                $fonctionnalites[] = [  
                    'id' => (int) $value,  
                    'duree' => $this->request->duree[$key] ?? 0,  
                ];  
            }
            $this->request['fonctionnalites'] = $fonctionnalites;

            // dd($this->request->fonctionnalites);
            foreach ($this->request->fonctionnalites as $value)
            {
                $fonctionnalite = new FonctionnaliteModule;
                $fonctionnalite->projet_module_id = (int) $this->request->projet_module_id;
                $fonctionnalite['projet_id'] = ProjetModule::where('id',(int) $this->request->projet_module_id)->first()->projet_id;
          
                foreach($value as $key => $fonction)
                {
                    if($key === "id")
                    {
                        // var_dump($fonction);
                        $exist = FonctionnaliteModule::where(['fonctionnalite_id'=> $fonction, 'projet_module_id'=> (int) $this->request->projet_module_id]);
                        if(!$exist->exists())
                        {
                            $fonctionnalite->fonctionnalite_id = $fonction;
                            $fonctionnalite->save();
                            
                        }
                        else
                        {
                            $fonctionnalite = Fonctionnalite::find($fonction)->first();
                            $errors = $fonctionnalite->nom . " : existe deja dans le module";
                        }
                    }
                    else
                    {
                        
                        $fonctionnalite->duree = $fonction;
                    }
                    if(!empty($errors))
                    { 
                        throw new \Exception($errors);  
                    }
                    
                }
            }
            //    dd($fonctionnalite);
           
            // dd(getGraphQLResponse($fonctionnalite->id));
            return $this->getGraphQLResponse(false);
        });
       
    }

    public function afterCRUDProcessing(&$model): void
    {
   
    }
}
