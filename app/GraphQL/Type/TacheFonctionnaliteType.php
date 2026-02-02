<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class TacheFonctionnaliteType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'duree'                              => ['type' => Type::string()],
            'tache_id'                           => ['type' => Type::int()],
            'status'                             => ['type' => Type::int()],
            'tache'                              => ['type' =>  GraphQL::type('TacheType')],
            'fonctionnalite_module_id'           => ['type' => Type::int()],
            'fonctionnalite_modules'             => ['type' => Type::listOf(GraphQL::type('FonctionnaliteModuleType'))],
            'visas'                              => ['type' => Type::listOf(GraphQL::type('VisaType'))],
            'visa_finals'                        => ['type' => Type::listOf(GraphQL::type('VisaFinalType'))],
            'visa_qualite'                       => ['type' => Type::listOf(GraphQL::type('VisaQualiteType'))],
            'visa_cto_cdp'                       => ['type' => Type::listOf(GraphQL::type('VisaCtoCdpType'))],
            'created_at'                         => ['type' => Type::string()],
            'date'                               => ['type' => Type::string(),  'alias' => 'created_at'],
            'date_fr'                            => ['type' => Type::string()],
        ];
    }
    public function resolveDureeField($root, $args)
    {
        $timeParts = explode(':', $root->duree);
        $seconds = isset($timeParts[0]) ? ($timeParts[0] * 3600) : 0;
        $seconds += isset($timeParts[1]) ? ($timeParts[1] * 60) : 0;
        $seconds += isset($timeParts[2]) ? $timeParts[2] : 0;

        return (int)$seconds/3600;
        // Convertir le total des secondes en heures:minutes:secondes
        // $hours = floor($seconds / 3600);
        // $minutes = floor(($seconds % 3600) / 60);
        // $seconds = $seconds % 60;

        // return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}

