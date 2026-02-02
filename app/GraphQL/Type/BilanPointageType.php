<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use DateTime;
use DateInterval;
use App\Models\Pointage;


class BilanPointageType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'            => ['type' => Type::int()],
            'pointage_id'   => ['type'=> Type::int()],
            'pointage'     =>['type'=>GraphQL::type('PointageType')],
        ];
    } 
}
