<?php

namespace App\GraphQL\Query;

use App\RefactoringItems\RefactGraphQLQuery;
use GraphQL\Type\Definition\Type;

class FonctionnaliteQuery extends RefactGraphQLQuery
{
    public function args(): array
    {
        return $this->addArgs([
            'search'                             => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],
            'date_start'                         => ['type' => Type::string()],
            'date_end'                           => ['type' => Type::string()],
            'date'                               => ['type' => Type::string()],
            'date_fr'                            => ['type' => Type::string()],
        ]);
    }
    // public function resolver($root,$args)
    // {
    //     dd('ici)');
    //     $f = FonctionnaliteModule::query();
    //     $total= $f->count();
    //     $totalActif = $f->where('status',2)->count();
    //     if($total == $totalActif)
    //     {
    //         $projet = ProjetModule::where('id', $f->projet_module_id)->first();
    //         $projet->status = 2;
    //         $projet->save();
    //     }
    // }
}
