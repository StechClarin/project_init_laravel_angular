<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class PointageQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'        => ['type' => Type::string()],
            'personnel_id'  => ['type' => Type::int()],
            'retard'        => ['type' => Type::boolean()],
            'date_debut'    => ['type' => Type::string()], 
            'date_fin'      => ['type' => Type::string()],
            'created-at'    => ['type' => Type::string()],
        ]);
    }
}

