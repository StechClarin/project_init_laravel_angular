<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class ContactType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'prenom'                                => ['type' => Type::string()],
            'telephone'                          => ['type' => Type::string()],
            'adresse'                            => ['type' => Type::string()],
            'email'                              => ['type' => Type::string()],
            'fonction'                           => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'display_text'                      => ['type' => Type::string(), 'alias' => 'nom'],
            'image'                              => ['type' => Type::string()],
            'client_id'                          => ['type' => Type::int()],
            'personnel_id'                          => ['type' => Type::int()],

            'client'                             => ['type' => GraphQL::type('ClientType')],
            'fournisseur'                        => ['type' => GraphQL::type('ClientType')],
        ];
    }
}
