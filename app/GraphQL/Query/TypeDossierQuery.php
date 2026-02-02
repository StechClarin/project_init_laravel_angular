<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class TypeDossierQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'show_for_client'                  => ['type' => Type::boolean()],
            'client_id'                        => ['type' => Type::int()],
        ]);
    }
}
