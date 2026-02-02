<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use Illuminate\Database\Eloquent\Builder;
use GraphQL\Type\Definition\Type;

class PayQuery extends RefactGraphQLQuery
{

    public function args(): array
    {
        return $this->addArgs([
            'cedeao'       => ['type' => Type::boolean()],
        ]);
    }
    public function addQuery(Builder &$query, array &$args)
    {
       return $query->orderBy('nom');
    }
}
