<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;


class EntreSortieCaisseQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'motifentresortiecaisse'       => ['type' => Type::int()],
            'caisse_id'                   => ['type' => Type::int()],
        ]);
    }
}
