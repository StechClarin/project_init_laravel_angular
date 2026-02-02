<?php

namespace App\Models;

class UniteMesure extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "abreviation",
            "column_excel" => "Abreviation",
            "column_unique" => false
        ]
    ];

}
