<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;


class RapportAssistanceType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'libelle'                            => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'libelle'],

            'description'                        => ['type' => Type::string()],
            'projet_id'                          => ['type' => Type::int()],
            'projet'                             => ['type' => GraphQL::type('ProjetType')],
            'details'                            => ['type' => Type::listOf( GraphQL::type('DetailRapportType'))],
            'details_assistance'                => ['type' => Type::listOf( GraphQL::type('DetailRapportType'))],
            'rapport_email'                      => ['type' => Type::listOf( GraphQL::type('RapportEmailType'))],
            'file'                               => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
        ];
    }
}
