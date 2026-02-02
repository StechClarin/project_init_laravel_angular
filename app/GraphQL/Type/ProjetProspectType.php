<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class ProjetProspectType extends RefactGraphQLType
{

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'client_id'                         => ['type' => Type::int()],
            'client'                            => ['type' => GraphQL::type('ClientType')],
            'nom'                               => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'date_start'                         => ['type' => Type::string()],
            'date_end'                           => ['type' => Type::string()],
            'commentaires'                       => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'noyaux_interne_id'                  => ['type' => Type::int()],
            'noyaux_interne'                     => ['type' => GraphQL::type('NoyauxInterneType')],

        ];
    }
}
