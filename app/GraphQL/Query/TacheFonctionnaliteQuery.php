<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class TacheFonctionnaliteQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'fonctionnalite_module_id'            => ['type' => Type::int()],
            'description'                        => ['type' => Type::string()],
            'tache_id'                           => ['type' => Type::int()],
            'fonctionnalite_id'                  => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
            'date_start'                         => ['type' => Type::string()],
            'date_end'                           => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
        ]);
    }
}
