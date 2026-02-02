<?php

namespace App\Models;

class Navire extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "DESIGNATION",
            "column_unique" => true
        ]
    ];
}
