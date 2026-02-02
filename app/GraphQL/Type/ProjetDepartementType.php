<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{ProjetModule,FonctionnaliteModule,TacheFonctionnalite};
class ProjetDepartementType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'progression'                        => ['type' => Type::int()],
            'projet_id'                          => ['type' => Type::int()],
            'projet'                             => ['type' => GraphQL::type('ProjetType')],
            'departement_id'                     => ['type' => Type::int()],
            'departement'                        => ['type' => GraphQL::type('DepartementType')],
            'created_at'                         => ['type' => Type::string()],
            'date'                               => ['type' => Type::string(),  'alias' => 'created_at'],
            'date_fr'                            => ['type' => Type::string()],
            'nombre_tache'                       => ['type' => Type::int()],
            'nombre_tache_close'                 => ['type' => Type::int()],
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
        $moduleId = ProjetModule::where('projet_id', $root->projet_id)  
            ->pluck('id');
       
        $fonctionnaliteId = FonctionnaliteModule::whereIn('projet_module_id',$moduleId)->pluck('id');    
        
        $count = TacheFonctionnalite::where('status', 1)  
            ->whereIn('fonctionnalite_module_id', $fonctionnaliteId)    
            ->count() ?? 0;

        return $count; 
    }

    public function resolveNombreTacheField($root, $args)
    {
        $fonctionnaliteId = FonctionnaliteModule::where('projet_id',$root->projet_id)->pluck('id') ?? null; 
    
      
       if($fonctionnaliteId !== null)
       {
            $count = TacheFonctionnalite::where('status','<>',null)  
                ->whereIn('fonctionnalite_module_id', $fonctionnaliteId)    
                ->count() ?? 0;

       }
        return $count;  
    }
}
