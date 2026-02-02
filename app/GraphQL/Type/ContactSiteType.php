<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class ContactSiteType extends RefactGraphQLType
{
    public function fields(): array
    {
        return  [
            'id'                                => ['type' => Type::int()],
            'nom'                               => ['type' => Type::string()],
            'email'                             => ['type' => Type::string()],
            'telephone'                         => ['type' => Type::string()],
            'message'                           => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],


            'created_at_fr'                     => ['type' => Type::string()],
            'created_at'                         => ['type' => Type::string()],
            'updated_at'                         => ['type' => Type::string()],
            'deleted_at'                         => ['type' => Type::string()],
        ];
    }
}


