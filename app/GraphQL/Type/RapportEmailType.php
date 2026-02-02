<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;


class RapportEmailType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'destinataire'                       => ['type' => Type::int()], 
            'objet'                              => ['type' => Type::string()],
            'text'                               => ['type' => Type::string()],
            'file'                               => ['type' => Type::string()],
            'create_at'                          => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'date'                               => ['type' => Type::string(), 'alias' => 'created_at'],
            'client'                             => ['type' => GraphQL::type('ClientType')],
        ];
    }


}
