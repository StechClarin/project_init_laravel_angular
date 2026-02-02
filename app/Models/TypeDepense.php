<?php

namespace App\Models;

class TypeDepense extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "categorie_depense_id",
            "column_excel" => "Categorie Depense",
            "column_unique" => false
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false
           
        ],
    ];

    public function categorie_depense(){
        return $this->belongsTo(CategorieDepense::class);
    }

    
}
