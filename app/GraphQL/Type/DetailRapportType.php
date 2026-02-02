<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;


class DetailRapportType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'rapport_assistance_id'              => ['type' => Type::int()],
            'assistance_id'                      => ['type' => Type::int()],
            'assistance'                         => ['type' => GraphQL::type('AssistanceType')],
        ];
    }
}
