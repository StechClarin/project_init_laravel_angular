<?php

namespace App\Models;

class Mesure extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "designation",
            "column_excel" => "Nom",
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
