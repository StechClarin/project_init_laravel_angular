<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class ArticleFacturationType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'code'                               => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
        ];
    }
}
