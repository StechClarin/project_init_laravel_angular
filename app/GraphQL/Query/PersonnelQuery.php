<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class PersonnelQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                      => ['type' => Type::string()],
            'nom'                         => ['type' => Type::string()],
            'prenom'                      => ['type' => Type::string()],
            'date_naissance'              => ['type' => Type::string()],
            'lieu_naissance'               => ['type' => Type::string()],
            'telephone'                    => ['type' => Type::int()],
            'email'                       => ['type' => Type::string()],
            'adresse'                     => ['type' => Type::string()],
            'date_embauche'               => ['type' => Type::string()],
            'anciennete'                => ['type' => Type::int()], 
            'fonction'                    => ['type' => Type::string()],  

        ]);
    }


}
