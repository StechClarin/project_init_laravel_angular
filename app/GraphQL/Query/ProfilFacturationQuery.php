<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class ProfilFacturationQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'mode_facturation_id'   => ['type' => Type::int()],
            'option_facturation_id' => ['type' => Type::int()],
        ]);
    }
}
