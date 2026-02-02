<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;
use App\Models\Assistance;

class RapportAssistanceQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::string()],
            // 'id'                                 => ['type' => Type::int()],
            // 'date_start'                         => ['type' => Type::string()],
            // 'date_end'                         => ['type' => Type::string()],
            // 'date'                            => ['type' => Type::string()],
            // 'date_fr'                            => ['type' => Type::string()],
            // 'libelle'                            => ['type' => Type::string()],
            // 'description'                        => ['type' => Type::string()],
            // 'projet_id'                          => ['type' => Type::int()],
            // 'file'                               => ['type' => Type::string()],
            // 'status'                             => ['type' => Type::int()],
        ]);
    }
    

}
