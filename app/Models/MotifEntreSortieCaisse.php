<?php

namespace App\Models;

class MotifEntreSortieCaisse extends Model
{
    protected $table = 'motif_entresortie_caisses';
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "decription",
            "column_excel" => "Description",
            "column_unique" => false
        ],
    ];



    
}
