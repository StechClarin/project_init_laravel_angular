<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class DepenseType extends RefactGraphQLType
{

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'created_at_user_id'                 => ['type' => Type::string()],
            'created_at_fr'                         => ['type' => Type::string()],
            'created_at'                         => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'montant'                            => ['type' => Type::float()],
            'typedepense_id'                     => ['type' => Type::int()],
            'typedepense'                        => ['type' => GraphQL::type('TypeDepenseType')],
            'description'                        => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],
            'created_by'                         => ['type' => GraphQL::type('UserType')],
        ];
    }

}
