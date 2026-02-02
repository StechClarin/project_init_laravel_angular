<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class AssistanceQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                     => ['type' => Type::int()],
            'date_start'                 => ['type'=> Type::string()],
            'date_end'                   => ['type'=> Type::string()],
            'etat'                       => ['type' => Type::int()],
            'projet_id'                  => ['type' => Type::int()],
            'collecteur_id'              => ['type' => Type::int()],
            'rapporteur'                 => ['type' => Type::string()],
            'status'                     => ['type' => Type::int()],
            'assigne_id'                 => ['type' => Type::int()],
            'tag_id'                     => ['type' => Type::int()],
            'type_tache_id'              => ['type' => Type::int()],
            'canal_id'                   => ['type' => Type::int()],
        ]);
    }
}
