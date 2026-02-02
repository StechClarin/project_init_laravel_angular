<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class TacheProjetQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'        => ['type' => Type::string()],
            'nom_tache'        => ['type' => Type::string()],
            'projet_id'        => ['type'=>Type::int()],
            'personnel_id'        => ['type'=>Type::int()],
            'date_start'   => ['type' => Type::string(), 'ignoreInDB' => true],
            'date_end'      => ['type' => Type::string(), 'ignoreInDB' => true],

        ]);
    }
}
