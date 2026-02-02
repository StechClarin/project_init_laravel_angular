<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{Fonctionnalite,ProjetModule,TacheFonctionnalite,Tache};

class FonctionnaliteModuleType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'projet_id'                          => ['type' => Type::int()],
            'duree'                              => ['type' => Type::string()],
            'duree_format'                       => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
            'fonctionnalite_id'                  => ['type' => Type::int()],
            'projet_module_id'                   => ['type' => Type::int()],
            'projet_modules'                     => ['type' => Type::listOf(GraphQL::type('ProjetModuleType'))],
            'fonctionnalite'                    => ['type' => GraphQL::type('FonctionnaliteType')],
            'tache_fonctionnalites'              => ['type' => Type::listOf(GraphQL::type('TacheFonctionnaliteType'))],
            'created_at'                         => ['type' => Type::string()],
            'date'                               => ['type' => Type::string(),  'alias' => 'created_at'],
            'date_fr'                            => ['type' => Type::string()],
        ];
    }

    public function resolveDureeField($root,$args)
    {
        $tache_duree = TacheFonctionnalite::where('fonctionnalite_module_id',$root->id)->sum('duree') ?? 0;
        
        $timeParts = explode(':', $tache_duree); 
        $seconds = isset($timeParts[0]) ? ($timeParts[0] * 3600) : 0;  
        $seconds += isset($timeParts[1]) ? ($timeParts[1] * 60) : 0;   
        $seconds += isset($timeParts[2]) ? $timeParts[2] : 0;   

        // if(isset($root->duree) && $seconds === 0)
        // {   
        //     return $root->duree;
        // }
        // return $seconds;
        return (int)$seconds/3600;
    }
    
    public function resolveDureeFormatField($root,$args)
    {
        // $fm = ::where('id',$root->fonctionnalite_id)->first();
        $tache_duree = TacheFonctionnalite::where('fonctionnalite_module_id',$root->id)->sum('duree') ?? 0;
    
        $timeParts = explode(':', $tache_duree); 
        $seconds = isset($timeParts[0]) ? ($timeParts[0] * 3600) : 0;  
        $seconds += isset($timeParts[1]) ? ($timeParts[1] * 60) : 0;   
        $seconds += isset($timeParts[2]) ? $timeParts[2] : 0;   

        $hours = floor($tache_duree / 3600);  
        $minutes = floor(($tache_duree % 3600) / 60);  
        $seconds = $tache_duree % 60; 
        $formatted_duree = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        return $formatted_duree;
    }
  

    // public function resolveStatusField($root,$args)
    // {
    //     $totalTasks = TacheFonctionnalite::where('fonctionnalite_id', $root->fonctionnalite_id)->count(); 
    //     $totalTasksNotFinish = TacheFonctionnalite::where('fonctionnalite_id', $root->fonctionnalite_id)
    //                                                 ->where('status', 1)  
    //                                                 ->count(); 
    //     if($totalTasksNotFinish == 0)
    //     {
    //         // return 0;
    //     }                                  
    //     if($totalTasksNotFinish == $totalTasks)
    //     {
    //         return 2;
    //     }
    //     return 1;
    // }
}
