<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class ProjetDepartementQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::string()],
            'projet_id'                          => ['type' => Type::int()],
            'departement_id'                     => ['type' => Type::int()],
        ]);
    }
}
