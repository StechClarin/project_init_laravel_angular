<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class AvanceSalaireQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::int()],
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'employe_id'                         => ['type' => Type::int()],
            'remboursement_id'                   => ['type' => Type::int()],
            'montant'                            => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
            'etat'                               => ['type' => Type::int()],
            'personnel_id'                       => ['type' => Type::int()],
        ]);
    }
}
