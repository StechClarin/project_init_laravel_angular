<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class MotifEntreSortieCaisseType extends RefactGraphQLType
{
    protected $column = 'tag_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],
        ];
    }
}
