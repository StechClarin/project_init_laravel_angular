<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class CanalSlackType extends RefactGraphQLType
{
    protected $column = 'canal_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'slack_id'                           => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],

        ];
    }
}
