<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class DeviseType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'code'                               => ['type' => Type::string()],
            'signe'                              => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],
            'taux_change'                        => ['type' => Type::float()],
            'cours'                              => ['type' => Type::float()],
            'unite'                              => ['type' => Type::int()],
            'precision'                          => ['type' => Type::int()],
            'devise_base'                        => ['type' => Type::boolean()],
        ];
    }
}
