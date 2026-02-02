<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class PlanificationAssigneType extends RefactGraphQLType
{

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'planification_id'                   => ['type' => Type::int()],
            'projet_id'                          => ['type' => Type::int()],
            'projet'                             => ['type' => GraphQL::type('ProjetType')],
            'fonctionnalite_module_id'           => ['type' => Type::int()],
            'fonctionnalite_module'              => ['type' => GraphQL::type('FonctionnaliteModuleType')],
            'tache_fonctionnalite_id'            => ['type' => Type::string()],
            'personnel_id'                       => ['type' => Type::string()],
            'tache_fonctionnalite'               => ['type' => GraphQL::type('TacheFonctionnaliteType')],
            'tag'                                => ['type' => GraphQL::type('TagType')],
            'priorite'                                => ['type' => GraphQL::type('PrioriteType')],
            'personnel'                          => ['type' => GraphQL::type('PersonnelType')],
            'tag_id'                             => ['type' => Type::int()],
            'priorite_id'                        => ['type' => Type::int()],
            'description'                        => ['type' => Type::string()],
            'date_debut'                         => ['type' => Type::string()],
            'date_debut_fr'                        => ['type' => Type::string()],
            'duree_effectue'                        => ['type' => Type::string()],
            'date_fin'                        => ['type' => Type::string()],
            'date_fin_fr'                        => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'day'                               => ['type' => Type::string()],
            'status'                            => ['type' => Type::int()],
        ];
    }
}
