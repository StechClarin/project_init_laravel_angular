<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use DateTime;
use DateInterval;
use App\Models\Pointage;
use PhpParser\Node\Arg;

class PointageType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                            => ['type' => Type::int()],
            'temps_au_bureau'         => ['type' => Type::string(),],
            'date_debut'                    => ['type' => Type::string(),],
            'date_debut_fr'                 => ['type' => Type::string(),],
            'date_fin'                      => ['type' => Type::string(),],
            'date_fin_fr'                   => ['type' => Type::string(),],
            'created_at'                   => ['type' => Type::string(),],
            'created_at_fr'                   => ['type' => Type::string(),],
            'personnel_id'                  => ['type' => Type::int()],
            'personnel'                     => ['type' => GraphQL::type('PersonnelType')],
            'details'                       => ['type' => Type::listOf(GraphQL::type('DetailsPointageType'))],
        ];
    }

}
