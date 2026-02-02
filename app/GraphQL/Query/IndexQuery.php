<?php

namespace App\GraphQL\Query;

use App\Models\Outil;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class IndexQuery extends Query
{
    protected $attributes = ['name' => 'indexs' ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Index'));
    }

    public function args():array
    {
        return
        [

        ];
    }

    public function resolve($root, $args)
    {
       
        $nbre_entrepots         = DB::select(DB::raw("select count(id) as nbre from entrepots "))[0]->nbre;
        $nbre_clients           = DB::select(DB::raw("select count(id) as nbre from clients "))[0]->nbre;
        $nbre_marchandises      = DB::select(DB::raw("select count(id) as nbre from marchandises "))[0]->nbre;
        $nbre_livreurs          = DB::select(DB::raw("select count(id) as nbre from livreurs "))[0]->nbre;
        return
        [
            [

                'nbre_entrepots'            => $nbre_entrepots,
                'nbre_clients'              => $nbre_clients,
                'nbre_marchandises'         => $nbre_marchandises,
                'nbre_livreurs'             => $nbre_livreurs,
            ]
        ];
    }

}
