<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\Outil;


class AvanceSalaireType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'employe_id'                         => ['type' => Type::int()],
            'employe'                            => ['type' => GraphQL::type('PersonnelType')],
            'remboursement_id'                   => ['type' => Type::int()],
            'remboursements'                     => ['type' => Type::listOf(GraphQL::type('RemboursementType'))],
            'montant'                            => ['type' => Type::int()],
            'montant_fr'                         => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'etat'                               => ['type' => Type::int()],
            'restant'                            => ['type' => Type::int()],
            'restant_fr'                         => ['type' => Type::string()],
        ];
    }

    protected function resolveRestantField($root,$args){
        if(count($root->remboursements) > 0)
        {
            $restant = $root->montant;
            foreach($root->remboursements as $remboursement){
                if($remboursement->status == 1){
                    $restant = $restant - $remboursement->montant;
                }
            }
            return $restant;
        }
        return $root->montant;
    }
    protected function resolveRestantFrField($root,$args){
        return Outil::formatWithThousandSeparator($this->resolveRestantField($root, $args));
    }
    

}
