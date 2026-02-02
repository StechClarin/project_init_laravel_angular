<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use DateTime;
use GraphQL\Type\Definition\Type;

class EvenementQuery extends RefactGraphQLQuery
{

    public function args(): array
    {
        return $this->addArgs([

            'search'                     => ['type' => Type::string()],
            'positif_negatif'                     => ['type' => Type::boolean()],
            'personnel_id'             => ['type' => Type::int()],
            'projet_id'             => ['type' => Type::int()],
            'mesure_id'             => ['type' => Type::int()],
            'gravite_id'             => ['type' => Type::int()],


            // 'client_id'                 => ['type' => Type::int()],
        ]);


    }
}
