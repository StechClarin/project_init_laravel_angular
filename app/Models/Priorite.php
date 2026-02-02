<?php

namespace App\Models;

use Illuminate\Cache\TagSet;

class Priorite extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "nom",
            "column_unique" => true
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false
        ],
    ];

    public function tags(){
        return $this -> hasMany(Tag::class);
    }
}
