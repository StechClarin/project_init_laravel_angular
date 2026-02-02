<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;


class ContactPersonnelType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'personnel_id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'telephone'                          => ['type' => Type::int()],
            'email'                            => ['type' => Type::string()],
            'affiliation'                   => ['type' => Type::string()],
        ];
    }


}
