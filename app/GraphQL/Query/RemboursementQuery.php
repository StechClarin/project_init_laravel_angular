<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class RemboursementQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::int()],
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'avance_salaire_id'                  => ['type' => Type::int()],
            'montant'                            => ['type' => Type::int()],
            'restant'                            => ['type' => Type::int()],
            'etat'                               => ['type' => Type::int()],
        ]);
    }
  
}
