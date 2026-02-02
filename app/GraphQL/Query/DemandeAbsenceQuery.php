<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;
use App\Models\DemandeAbsence; // Ensure this is the correct namespace for the DemandeAbsence model

class DemandeAbsenceQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::int()],
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'date_debut'                         => ['type' => Type::string(), 'ignoreInDB' => true],
            'date_fin'                           => ['type' => Type::string(), 'ignoreInDB' => true],
            'heure_debut'                         => ['type' => Type::string(), 'ignoreInDB' => true],
            'heure_fin'                           => ['type' => Type::string(), 'ignoreInDB' => true],
            'motif'                              => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'employe_id'                         => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
            'date_mode'                         => ['type' => Type::string(), 'ignoreInDB' => true],

        ]);
    }



}
