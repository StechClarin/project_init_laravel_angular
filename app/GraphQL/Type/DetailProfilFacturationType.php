<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;


class DetailProfilFacturationType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'option_facturation_id'              => ['type' => Type::int()],
            'article_facturation_id'             => ['type' => Type::int()],

            'article_facturation'                => ['type' => GraphQL::type('ArticleFacturationType')],
        ];
    }
}
