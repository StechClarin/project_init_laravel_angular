<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TypeDossierType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'abreviation'                        => ['type' => Type::string()],
            'image'                              => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'couleurbg'                          => ['type' => Type::string()],
            'couleurfg'                          => ['type' => Type::string()],
            'bgStyle'                            => ['type' => Type::string()],
            'fgStyle'                            => ['type' => Type::string()],
            //'show_container'                     => ['type' => Type::boolean()],
            'show_exo'                           => ['type' => Type::boolean()],
            'show_step_importation'              => ['type' => Type::boolean()],
            'show_for_client'                    => ['type' => Type::boolean()],
            'is_default'                         => ['type' => Type::boolean()],

            'nbre_type_dossier'                  => ['type' => Type::int()],

            'details'                            => ['type' => Type::listOf(GraphQL::type('TypeDossierType')), 'alias' => 'type_dossiers_formule'],
        ];
    }

    protected function resolveDisplayTextField($root, $args)
    {
        return $root['nom'];
    }

}
