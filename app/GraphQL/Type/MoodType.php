<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class MoodType extends RefactGraphQLType
{
    protected $column = 'tag_id';

    protected function resolveFields(): array
    {
        return [
            'id'                        => ['type' => Type::int()],
            'user_id'                   => ['type' => Type::int()],
            'designation'               => ['type' => Type::string()],
            'updated_at'                => ['type' => Type::string()],
            'emoji'                     =>['type' => Type::string()],

            

        ];
    }

    protected function resolveEmojiField($root, $args)
    {
        $map = [
            'En forme'          => '😄',
            'Mauvaise hummeur'  => '😤',
            'Malade'            => '🤒',
            'Fatigue'           => '🥱',
        ];

        return $map[$root->designation] ?? '❓';
    }

}
