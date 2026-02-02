<?php

namespace App\Models;



class AvanceSalaire extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "date",
            "column_excel" => "Date",
            "column_unique" => false
        ],
        [
            "column_db" => "employe_id",
            "column_excel" => "Employe",
            "column_unique" => false
        ],
        [
            "column_db" => "montant",
            "column_excel" => "Montant",
            "column_unique" => false
        ],
        [
            "column_db" => "statut",
            "column_excel" => "Statut",
            "column_unique" => false
        ],
        [
            "column_db" => "etat",
            "column_excel" => "Etat rembourse",
            "column_unique" => false
        ],
        [
            "column_db" => "restant",
            "column_excel" => "Restant",
            "column_unique" => false
        ],
    ];
}
