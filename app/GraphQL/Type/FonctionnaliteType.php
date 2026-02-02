<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{FonctionnaliteModule,ProjetModule};

class FonctionnaliteType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'version'                            => ['type' => Type::string()],
            'str_nom'                            => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],
            'created_at'                         => ['type' => Type::string()],
            'date'                               => ['type' => Type::string(),  'alias' => 'created_at'],
            'date_fr'                            => ['type' => Type::string()],
            // 'tache_fonctionnalites'              => ['type' => Type::listOf(GraphQL::type('TacheFonctionnaliteType'))],
            'fonctionnalite_module'              => ['type' => GraphQL::type('FonctionnaliteModuleType')],
        ];
    }
   
    public function resolveStrNomField($root, $args)
    {
        return strtolower(str_replace(' ', '', $root->nom));  
    }
   
}
