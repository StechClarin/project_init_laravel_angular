<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\VisaFinal;

class VisaFinalType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'user_id'                            => ['type' => Type::int()],
            'visa'                               => ['type' => Type::int()],
            'last_visa'                          => ['type' => Type::int()],
            'tache_fonctionnalite_id'            => ['type' => Type::int()],
        ];
    }

    public function resolveLastVisaField($root, $args)
    {
        $last = VisaFinal::orderBy('id', 'desc')->first();
        return $last->visa;
    }

}