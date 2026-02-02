<?php

namespace App\Models;

class Tag extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "priorite_id",
            "column_excel" => "Priorite",
            "column_unique" => true
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => true
        ],
    ];
    public function priorite(){
        return $this -> belongsTo(Priorite::class);
    }
}
