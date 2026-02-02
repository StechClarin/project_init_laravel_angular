<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class ProspectQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'prenom'                             => ['type' => Type::string()],
            'telephone'                          => ['type' => Type::string()],
            'email'                              => ['type' => Type::string()],
        ]);
    }
}
