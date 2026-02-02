<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class DepenseQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'typedepense_id'                   => ['type' => Type::int()],
        ]);
    }
}
