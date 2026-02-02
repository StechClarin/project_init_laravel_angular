<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class DossierQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'client_id'                  => ['type' => Type::int()],
            'type_dossier_id'            => ['type' => Type::int()],
        ]);
    }
}
