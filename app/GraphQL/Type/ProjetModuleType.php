<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{ProjetModule,FonctionnaliteModule,TacheFonctionnalite};

class ProjetModuleType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(),'alias' => 'nom'],
            'description'                        => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'departement_id'                     => ['type' => Type::int()],
            'projet_id'                          => ['type' => Type::int()],
            'projet'                             => ['type' =>  GraphQL::type('ProjetType')],
            'created_at'                         => ['type' => Type::string()],
            'date'                               => ['type' => Type::string(),  'alias' => 'created_at'],
            'date_fr'                            => ['type' => Type::string()],
            'fonctionnalite_modules'             => ['type' => Type::listOf(GraphQL::type('FonctionnaliteModuleType'))],
            'nombre_tache'                       => ['type' => Type::int()],
            'nombre_tache_close'                 => ['type' => Type::int()],
            'progression'                        => ['type' => Type::int()],


        ];
    }

    public function resolveProgressionField($root, $args)
    {
        $total = $this->resolveNombreTacheField($root, $args);
        if($total == 0) return 0;
        $close = $this->resolveNombreTacheCloseField($root, $args);
        $value = $close*100/$total;
        return (int)$value ?? 0;
    }
    public function resolveNombreTacheCloseField($root, $args)
    {
        // $fonctionnaliteId = FonctionnaliteModule::where([  
        //     'projet_module_id' => $root->id,   
        // ])->pluck('id'); 
        // dd(FonctionnaliteModule::where([  
        //     'projet_module_id' => $root->id,   
        // ])->pluck('id')->toSql());
        // // $count = TacheFonctionnalite::where('status', 1)->whereIn('fonctionnalite_id', $fonctionnaliteId)->first();
        // dd($fonctionnaliteId);
        // $count = TacheFonctionnalite::where('status', 1)  
        //     ->whereIn('fonctionnalite_id', $fonctionnaliteId)    
        //     ->count() ?? 0;  
        // // var_dump($root->id);

        $count = TacheFonctionnalite::where('status', 1)  
            ->whereIn('fonctionnalite_module_id', function($query) use ($root) {  
                $query->select('id')  
                        ->from('fonctionnalite_modules')  
                        ->where('projet_module_id', $root->id);  
            })->count();
            
        return $count; 
    }

    public function resolveNombreTacheField($root, $args)
    {
      
        // $fonctionnaliteId = FonctionnaliteModule::where([  
        //     'projet_module_id' => $root->id,   
        // ])->pluck('id'); 

        // $count = TacheFonctionnalite::where('status','<>', null)  
        //     ->whereIn('fonctionnalite_id', $fonctionnaliteId)    
        //     ->count() ?? 0; 
        $count = TacheFonctionnalite::where('status','<>', null)  
            ->whereIn('fonctionnalite_module_id', function($query) use ($root) {  
                $query->select('id')  
                        ->from('fonctionnalite_modules')  
                        ->where('projet_module_id', $root->id);  
            })->count() ?? 0;
        
        return $count;  
    }
}
