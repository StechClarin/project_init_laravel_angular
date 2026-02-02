<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class TypeTacheType extends RefactGraphQLType
{
    protected $column = 'type_tache_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'type_tache_id'                      => ['type' => Type::int()],
            'nbre_tache'                         => ['type' => Type::int()],
            'display_text'                       => ['type' => Type::string(), 'alias'=>'nom'],
        ];
    }
}
