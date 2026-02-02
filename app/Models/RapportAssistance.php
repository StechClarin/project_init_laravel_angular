<?php

namespace App\Models;

class RapportAssistance extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "date",
            "column_excel" => "Date",
            "column_unique" => true
        ],
        [
            "column_db" => "projet_id",
            "column_excel" => "Projet",
            "column_unique" => false
        ],
        [
            "column_db" => "libelle",
            "column_excel" => "Libelle",
            "column_unique" => false
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false
        ],
        [
            "column_db" => "file",
            "column_excel" => "File",
            "column_unique" => false
        ],
        [
            "column_db" => "status",
            "column_excel" => "Status",
            "column_unique" => false
        ],
    ];

    public function detail_rapports()
    {
        return $this->hasMany(DetailRapport::class);
    }
    public function details()
    {
        return $this->hasMany(DetailRapport::class);
    }

    public function assistance(){
        return $this->hasMany(Assistance::class, 'id', 'assistance_id');
    }

}
