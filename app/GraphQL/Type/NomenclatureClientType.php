<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;

class NomenclatureClientType extends RefactGraphQLType
{
    protected $column = 'nomenclature_client_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'couleur'                            => ['type' => Type::string()],
            'nbre_client'                        => ['type' => Type::int()],
        ];
    }
}
