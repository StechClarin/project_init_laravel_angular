<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class ProjetQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([

            'search'                     => ['type' => Type::string()],
            'type_projet_id'             => ['type' => Type::int()],
            'client_id'                 => ['type' => Type::int()],
        ]);
    }
}
