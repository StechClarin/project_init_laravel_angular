<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\{DB};
use App\Models\{Remboursement,AvanceSalaire};


class RemboursementType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
            'avance_salaire_id'                  => ['type' => Type::int()],
            'montant'                            => ['type' => Type::int()],
            'montant_total'                      => ['type'=> Type::int()],
            'restant'                            => ['type' => Type::int()],
            'etat'                               => ['type' => Type::int()],
        ];
    }

    public function resolveDateField($root, $args)
    {
        return $this->resolveDateFrField($root, $args);
    }

    public function resolveRestantField($root, $args)  
    {  
        if (!isset($root->avance_salaire_id)) {
            return 0;
        }
        $dernierRemboursement = Remboursement::where('avance_salaire_id', $root->avance_salaire_id)
            ->orderBy('id', 'desc')
            ->first();
        return $dernierRemboursement->restant ?? 0;
    }  




    // public function resolveTotalRestantfields()
    // {
    //     dd('ici');
    // }
}
