<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;


class AssistanceType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'code'                               => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'detail'                             => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'duree'                              => ['type' => Type::int()],

            'canal_slack_id'                      => ['type' => Type::int()],
            'canal_slack'                         => ['type' => GraphQL::type('CanalSlackType')],

            'date_fr'                            => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],
            'status_fr'                          => ['type' => Type::string()],
            'color_status'                       => ['type' => Type::string()],
            'date_debut'                        => ['type' => Type::string()],
            'date_fin'                          => ['type' => Type::string()],

            'projet_id'                          => ['type' => Type::int()],
            'projet'                             => ['type' => GraphQL::type('ProjetType')],

            'canal_id'                           => ['type' => Type::int()],
            'canal'                              => ['type' => GraphQL::type('CanalType')],

            'tag_id'                             => ['type' => Type::int()],
            'tag'                                => ['type' => GraphQL::type('TagType')],

            'rapporteur'                         => ['type' => Type::string()],

            'collecteur_id'                      => ['type' => Type::int()],
            'collecteur'                         => ['type' => GraphQL::type('UserType')],

            'assigne_id'                         => ['type' => Type::int()],
            'assigne'                            => ['type' => GraphQL::type('UserType')],

            'type_tache_id'                      => ['type' => Type::int()],
            'type_tache'                         => ['type' => GraphQL::type('TypeTacheType')],
            'rapport_assistance'                 => ['type' => GraphQL::type('RapportAssistanceType')],

        ];
    }
}
