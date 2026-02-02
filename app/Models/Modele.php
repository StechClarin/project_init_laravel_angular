<?php

namespace App\Models;

class Modele extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "DESIGNATION",
            "column_unique" => true
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false
        ]
    ];
}
