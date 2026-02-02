<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class DetailsPointageQuery extends RefactGraphQLQuery
{

    public function args(): array
    {
        return $this->addArgs([
            'search'        => ['type' => Type::string()],
            'date_start'   => ['type' => Type::string(), 'ignoreInDB' => true],
            'date_end'      => ['type' => Type::string(), 'ignoreInDB' => true],
        ]);
    }
}
