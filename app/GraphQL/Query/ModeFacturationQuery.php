<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Builder;

class ModeFacturationQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
        ]);
    }

    public function addQuery(Builder &$query, array &$args)
    {
        $query->orderBy('value');
    }
}
