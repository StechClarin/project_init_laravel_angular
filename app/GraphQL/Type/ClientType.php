<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class ClientType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'code'                               => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],
            'email'                              => ['type' => Type::string()],
            'telephone'                          => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'tag'                                => ['type' => Type::int()],
            'status_fr'                          => ['type' => Type::string()],
            'color_status'                       => ['type' => Type::string()],
            'image'                              => ['type' => Type::string()],

            'fixe'                              => ['type' => Type::string()],
            'faxe'                              => ['type' => Type::string()],
            'ninea'                              => ['type' => Type::string()],
            'rcc'                              => ['type' => Type::string()],
            'adresse_postale'                              => ['type' => Type::string()],
            'adresse_geographique'                              => ['type' => Type::string()],
            'nomenclature_client'                           => ['type' => GraphQL::type('NomenclatureClientType')],
            'details'                           => ['type' => Type::listOf(GraphQL::type('ContactType'))],


            'pay_id'                             => ['type' => Type::int()],
            'type_client_id'                     => ['type' => Type::int()],
            'secteur_activite_id'                => ['type' => Type::int()],
            'modalite_paiement_id'               => ['type' => Type::int()],

            'pay'                                => ['type' => GraphQL::type('PaysType')],
            'type_client'                        => ['type' => GraphQL::type('TypeClientType')],
            'secteur_activite'                   => ['type' => GraphQL::type('SecteurActiviteType')],
            'modalite_paiement'                  => ['type' => GraphQL::type('ModalitePaiementType')],
            'contacts'                           => ['type' => GraphQL::type('ContactType')],
            'projets'                            => ['type' => GraphQL::type('ProjetType')],

            // Pour les clients uniquement
            'users'                               => ['type' => GraphQL::type('UserType')],
        ];
    }
}
