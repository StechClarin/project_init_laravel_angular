<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class DashboardType extends RefactGraphQLType
{

    protected function resolveFields(): array
    {
        return [
            'assistances_en_cours'                                => ['type' => Type::int()],
        ];
    }
}
