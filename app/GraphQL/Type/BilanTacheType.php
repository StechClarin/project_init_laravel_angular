<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use DateTime;
use DateInterval;
use App\Models\Pointage;


class BilanTacheType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'personnel_id'               => ['type'=> Type::int()],
            'personnel'                  =>['type'=>GraphQL::type('PersonnelType')],
            'tacheprojet'                =>['type'=>GraphQL::type('TacheProjetType')],
            'planificationassigne'       =>['type'=>GraphQL::type('PlanificationAssigneType')],
        ];
    } 
}
