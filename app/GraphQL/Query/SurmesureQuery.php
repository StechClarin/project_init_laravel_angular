<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class SurmesureQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'prospect_id'                        => ['type' => Type::int()],
            'date_start'                         => ['type' => Type::string()],
            'date_end'                           => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
        ]);
    }
}
