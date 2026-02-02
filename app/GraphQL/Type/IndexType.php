<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;

class IndexType extends RefactGraphQLType
{
    protected $attributes = ['name' => 'Index'];
    protected function resolveFields(): array
    {
        return  [
            'nbre_entrepots'                        => ['type' => Type::int()],
            'nbre_clients'                          => ['type' => Type::int()],
            'nbre_marchandises'                     => ['type' => Type::int()],
            'nbre_livreurs'                         => ['type' => Type::int()],
        ];
    }
}
