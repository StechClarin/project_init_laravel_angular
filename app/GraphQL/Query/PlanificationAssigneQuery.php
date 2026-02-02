<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class PlanificationAssigneQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::string()],
            'tag_id'                             => ['type' => Type::int()],
            'projet_id'                          => ['type' => Type::int()],
            'fonctionnalite_module_id'           => ['type' => Type::int()],
            'tache_fonctionnalite_id'            => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
        ]);
    }


}