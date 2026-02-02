<?php

namespace App\Models;

use App\GraphQL\Type\ClientTypeDossierType;

class Client extends Model
{
    public $codePrefix = 'CL';

    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        // [
        //     "column_db" => "numero_comptable",
        //     "column_excel" => "Nº Comptable",
        //     "column_unique" => false
        // ],
        // [
        //     "column_db" => "adresse_postale",
        //     "column_excel" => "Adresse",
        //     "column_unique" => false
        // ],
        [
            "column_db" => "telephone",
            "column_excel" => "Telephone",
            "column_unique" => false
        ],
        [
            "column_db" => "email",
            "column_excel" => "Email",
            "column_unique" => true
        ],


        [
            "column_db" => "type_client_id",
            "column_excel" => "Type De Client",
            "column_unique" => false
        ],
        [
            "column_db" => "modalite_paiement_id",                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
            "column_excel" => "Modalité Paiement",
            "column_unique" => false
        ],
        [
            "column_db"  => "description",
            "column_excel" => "Description",
            "column_unique" => false
        ]
    ];

    public function type_dossiers()
    {
        return $this->belongsToMany(TypeDossier::class, ClientTypeDossier::class)
            ->as('details');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function details()
    {
        return $this->hasMany(Contact::class);
    }
}
