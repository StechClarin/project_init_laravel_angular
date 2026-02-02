<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{FonctionnaliteModule,ProjetModule};

class TacheAssigneType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'personnel_id'                       => ['type' => Type::int()],
            'projet_id'                          => ['type' => Type::int()],
            'tache_id'                           => ['type' => Type::int()],
            'date_debut'                         => ['type' => Type::string()],
            'duree'                              => ['type' => Type::string()],
            'date_fin'                           => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],
            'created_at'                         => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'date_debut_fr'                      => ['type' => Type::string()],
            'date_fin_fr'                        => ['type' => Type::string()],
            'tache'                              => ['type' => GraphQL::type('TacheType')],
            'personnel'                          => ['type' => GraphQL::type('PersonnelType')],
            'projet'                             => ['type' => GraphQL::type('ProjetType')],
            'date_start_task'                    => ['type' => Type::string()],
            'date_end_task'                      => ['type' => Type::string()],
            'time_spent'                         => ['type' => Type::string()],

        ];
    }


   

   
}
