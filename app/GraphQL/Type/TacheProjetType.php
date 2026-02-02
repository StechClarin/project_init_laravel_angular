<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{FonctionnaliteModule, ProjetModule};

class TacheProjetType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                         => ['type' => Type::int()],
            'personnel_id'               => ['type' => Type::int()],
            'projet_id'                  => ['type' => Type::int()],
            'tag_id'                     => ['type' => Type::int()],
            'priorite_id'                => ['type' => Type::int()],
            'date'                       => ['type' => Type::string()],
            'date_debut'                 => ['type' => Type::string()],
            'date_debut2'                => ['type' => Type::string()],
            'nom_tache'                  => ['type' => Type::string()],
            
            // Le champ 'duree' retourne un entier (minutes)
            'duree'                      => ['type' => Type::int()],
            
            // CORRECTION: 'duree_convertie' doit être de type string, pas une liste
            'duree_convertie'            => ['type' => Type::string()],
            
            'date_fin'                   => ['type' => Type::string()],
            'date_fin2'                  => ['type' => Type::string()],
            'description'                => ['type' => Type::string()],
            'display_text'               => ['type' => Type::string(), 'alias' => 'nom'],
            'created_at'                 => ['type' => Type::string()],
            'status'                     => ['type' => Type::int()],
            'date_debut2_fr'             => ['type' => Type::string()],
            'date_debut_fr'              => ['type' => Type::string()],
            'date_fin_fr'                => ['type' => Type::string()],
            'date_fin2_fr'               => ['type' => Type::string()],
            'tag'                        => ['type' => GraphQL::type('TagType')],
            'priorite'                   => ['type' => GraphQL::type('PrioriteType')],
            'personnel'                  => ['type' => GraphQL::type('PersonnelType')],
            'projet'                     => ['type' => GraphQL::type('ProjetType')],
            'date_start'                 => ['type' => Type::string()],
            'date_end'                   => ['type' => Type::string()],
            'time_spent'                 => ['type' => Type::string()],
        ];
    }

    /**
     * Résout le champ 'duree' pour retourner la durée en minutes.
     * C'est la méthode de résolution pour le champ 'duree'.
     */
    public function resolveDureeField($root, $args)
    {
        if (empty($root->duree)) {
            return 0;
        }

        // Suppose que la durée est au format 'HH:MM:SS'
        [$heures, $minutes, $secondes] = explode(':', $root->duree);
        return intval($heures) * 60 + intval($minutes);
    }

    /**
     * Résout le champ 'duree_convertie' pour retourner la durée sous sa forme de chaîne.
     * C'est la méthode de résolution pour le champ 'duree_convertie'.
     */
    public function resolveDureeConvertieField($root, $args)
    {
        // Renvoie directement la valeur du champ 'duree' du modèle,
        // qui est déjà au format 'HH:MM:SS'
        return $root->duree;
    }
}