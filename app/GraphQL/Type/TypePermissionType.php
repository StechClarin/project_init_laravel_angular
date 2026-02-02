<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TypePermissionType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'name'                               => ['type' => Type::string()],
            'couleur'                            => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],

            'permissions'                        => ['type' => Type::listOf(GraphQL::type('PermissionType'))],
        ];
    }
}
