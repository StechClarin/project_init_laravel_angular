<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class ModeleQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'marque_id'                  => ['type' => Type::int()],
        ]);
    }
}
