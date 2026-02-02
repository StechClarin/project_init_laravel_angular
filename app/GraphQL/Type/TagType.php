<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class TagType extends RefactGraphQLType
{
    protected $column = 'tag_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'priorite_id'                        => ['type' => Type::int()],
            'priorite'                        => ['type' => GraphQL::type('PrioriteType')],
            'description'                        => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],
        ];
    }
}
