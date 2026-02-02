<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class ProspectType extends RefactGraphQLType
{

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'prenom'                             => ['type' => Type::string()],
            'telephone'                          => ['type' => Type::string()],
            'email'                              => ['type' => Type::string()],
            'commentaire'                        => ['type' => Type::string()],
        ];
    }
}
