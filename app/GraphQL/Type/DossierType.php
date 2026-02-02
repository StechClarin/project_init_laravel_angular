<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class DossierType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],

            'code'                               => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'code'],
            'status'                             => ['type' => Type::boolean()],
            'status_fr'                          => ['type' => Type::string()],
            'color_status'                       => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'type_dossier_id'                    => ['type' => Type::int()],
            'niveau_habilite_id'                 => ['type' => Type::int()],
            'client_id'                          => ['type' => Type::int()],

            'type_dossier'                       => ['type' => GraphQL::type('TypeDossierType')],
            'client'                             => ['type' => GraphQL::type('ClientType')],
            'niveau_habilite'                    => ['type' => GraphQL::type('NiveauHabiliteType')],

        ];
    }

}
