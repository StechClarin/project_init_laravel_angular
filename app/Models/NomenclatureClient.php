<?php

namespace App\Models;

class NomenclatureClient extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "couleur",
            "column_excel" => "Couleur",
            "column_unique" => false
        ]
    ];
}
