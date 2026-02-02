<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class RapportEmailQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'id'                         => ['type' => Type::int()],
            'destinataire'               => ['type' => Type::int()],
            'objet'                      => ['type' => Type::string()],
            'date_end'                   => ['type' => Type::string()],
            'date_fr'                   => ['type' => Type::string()],
            'date_start'                 => ['type' => Type::string()],
        ]);
    }
}
