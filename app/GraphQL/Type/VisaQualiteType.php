<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class VisaQualiteType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'tache_fonctionnalite_id'            => ['type' => Type::int()],
            'commentaire'                        => ['type' => Type::string()],
            'user_id'                            => ['type' => Type::int()],
            'visa'                               => ['type' => Type::int()],
        ];
    }
}