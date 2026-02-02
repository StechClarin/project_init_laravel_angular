<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class TacheType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'type_tache_id'                      => ['type' => Type::int()],
            'type_tache'                        => ['type' => GraphQL::type('TypeTacheType')],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],
            'created_at'                         => ['type' => Type::string()],
            'date'                               => ['type' => Type::string(),  'alias' => 'created_at'],
            'date_fr'                            => ['type' => Type::string()], 
        ];
    }
}
