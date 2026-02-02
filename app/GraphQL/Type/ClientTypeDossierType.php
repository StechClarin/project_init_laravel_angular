<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ClientTypeDossierType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'parent_id'                          => ['type' => Type::int()],
            'client_id'                          => ['type' => Type::int()],
            'type_dossier_id'                    => ['type' => Type::int()],
            'etat'                               => ['type' => Type::boolean()],

            'client'                             => ['type' => GraphQL::type('ClientType')],
            'type_dossier'                       => ['type' => GraphQL::type('TypeDossierType')]
        ];
    }
}
