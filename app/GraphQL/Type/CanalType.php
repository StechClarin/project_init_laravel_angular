<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class CanalType extends RefactGraphQLType
{
    protected $column = 'canal_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'nbre_assistance'                    => ['type' => Type::int()],
            'display_text'                       => ['type' => Type::string()],

        ];
    }
}
