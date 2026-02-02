<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class ProjetProspectQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::string()],
            'client_id'                          => ['type' => Type::int()],
            'date_start'                         => ['type' => Type::string()],
            'date_end'                           => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'noyaux_interne_id'                  => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
        ]);
    }
}
