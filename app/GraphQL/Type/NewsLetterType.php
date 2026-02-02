<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class NewsLetterType extends RefactGraphQLType
{

    public function fields(): array
    {
        return  [
            'id'                                 => ['type' => Type::int()],
            'email'                              => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],


            'created_at'                         => ['type' => Type::string()],
            'updated_at'                         => ['type' => Type::string()],
            'deleted_at'                         => ['type' => Type::string()],
        ];
    }
}
