<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;
use App\Models\Assistance;

class DetailRapportQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::int()],
            'id'                                 => ['type' => Type::int()],
            'rapport_assistance_id'              => ['type' => Type::int()],
            'assistance_id'                      => ['type' => Type::int()],
        ]);
    }
    

}
