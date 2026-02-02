<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{Planification,PlanificationAssigne};

class PlanificationType extends RefactGraphQLType
{

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'date_debut'                         => ['type' => Type::string()],
            'date_debut_fr'                      => ['type' => Type::string()],
            'date_fin'                           => ['type' => Type::string()],
            'date_fin_fr'                        => ['type' => Type::string()],
            'personnel_id'                       => ['type' => Type::int()],
            'personnel'                          => ['type' => GraphQL::type('PersonnelType')],
            'details'                            => ['type' => Type::listOf(GraphQL::type('PlanificationAssigneType'))],
            'nombre_tache'                       => ['type' => Type::int()],
            'nombre_projet'                      => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
        ];
    }

    protected function resolveNombreProjetField($root,$args)
    {
        $query =  Planification::where('date_debut', '=',$root->date_debut)
                                ->where('date_fin', '=', $root->date_fin)->first();
    
        $query2 = PlanificationAssigne::where('planification_id',$query->id)->count();
        return $query2;
    }
    
    protected function resolvestatusField($root,$args)
    {
        $total = PlanificationAssigne::where('planification_id',$root->id)->count();
        $totalstatus = PlanificationAssigne::where('planification_id',$root->id)
                                        ->where('status','=',1)->count();
        if($total == $totalstatus)
        {
            return 1;
        }
        return 0;
    }
}
