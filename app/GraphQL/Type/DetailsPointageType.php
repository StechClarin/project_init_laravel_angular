<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class DetailsPointageType extends RefactGraphQLType
{

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'pointage_id'                        => ['type' => Type::int()],
            'date_start'                       => ['type' => Type::string()],
            'date_debut'                       => ['type' => Type::string()],
            'date_end'                       => ['type' => Type::string()],
            'date_fin'                       => ['type' => Type::string()],
            'heure_arrive'                       => ['type' => Type::string()],
            'heure_depart'                       => ['type' => Type::string()],
            'absence'                            => ['type' => Type::boolean()],
            'retard'                             => ['type' => Type::boolean()],
            'justificatif'                       => ['type' => Type::boolean()],
            'justificatif_file'                  => ['type' => Type::boolean()],
            'description'                        => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'day'                               => ['type' => Type::string()],
            'pointage'                          =>['type'=> GraphQL::type('PointageType')],
            'personnel'                          =>['type'=> GraphQL::type('PersonnelType')],

        ];
    }
}
