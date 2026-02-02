<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use DateTime;


class EvenementType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'date_debut'                               => ['type' => Type::string()],
            'date_fin'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'mesure_id'                            => ['type' => Type::string()],
            'gravite_id'                            => ['type' => Type::string()],
            'observation'                       => ['type' => Type::string()],
            'personnel_id'                      => ['type' => Type::int()],
            'personnel'                         => ['type' => GraphQL::type('PersonnelType')],
            'temps'                             => ['type' => Type::int()],
            'projet_id'                         => ['type' => Type::int()],
            'projet'                            => ['type' => GraphQL::type('ProjetType')],
            'mesure'                            => ['type' => GraphQL::type('MesureType')],
            'gravite'                            => ['type' => GraphQL::type('GraviteType')],
            'positif_negatif'                   => ['type' => Type::string()],
            'description'                       => ['type' => Type::string()],
            'display_text'                      => ['type'=> Type::string()],
        ];
    }


}
