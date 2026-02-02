<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class TypeProjetType extends RefactGraphQLType
{
    protected $column = 'type_projet_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'nbre_projet'                        => ['type' => Type::int()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],

        ];
    }
}
