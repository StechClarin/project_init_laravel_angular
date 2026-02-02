<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class ProjetModuleQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'id'                                 => ['type' => Type::int()],
            'search'                             => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'projet_id'                          => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
            'date_start'                         => ['type' => Type::string()],
            'date_end'                           => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
        ]);
    }
}
