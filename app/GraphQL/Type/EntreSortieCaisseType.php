<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class EntreSortieCaisseType extends RefactGraphQLType
{
    protected $column = 'tag_id';

    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'caisse_id'                          => ['type' => Type::int()],
            'caisse'                             => ['type' => GraphQL::type('CaisseType')],
            'montant'                            => ['type' => Type::float()],
            'motifentresortiecaisse_id'             => ['type' => Type::int()],
            'motifentresortiecaisse'                => ['type' => GraphQL::type('MotifEntreSortieCaisseType')],
            'description'                        => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],
        ];
    }
}
