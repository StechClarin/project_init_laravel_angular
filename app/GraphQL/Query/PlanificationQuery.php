<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class PlanificationQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                      => ['type' => Type::string()],
            'tag_id'                      => ['type' => Type::int()],
            'date_debut_fr'               => ['type' => Type::string()],
            'date_fin_fr'                 => ['type' => Type::string()],
            'date_debut'                  => ['type' => Type::string()],
            'date_fin'                    => ['type' => Type::string()],
        ]);
    }


}