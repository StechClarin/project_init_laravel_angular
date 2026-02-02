<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;


class DemandeAbsenceType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'date_debut'                         => ['type' => Type::string()],
            'date_fin'                           => ['type' => Type::string()],
            'heure_debut'                         => ['type' => Type::string()],
            'heure_fin'                           => ['type' => Type::string()],
            'motif'                              => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],

            'date_fr'                            => ['type' => Type::string()],
            'date_debut_fr'                      => ['type' => Type::string()],
            'date_fin_fr'                        => ['type' => Type::string()],
            'employe_id'                         => ['type' => Type::int()],
            'employe'                            => ['type' => GraphQL::type('PersonnelType')],
            'status'                             => ['type' => Type::int()],

        ];
    }


}
