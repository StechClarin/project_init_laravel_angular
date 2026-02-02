<?php

namespace App\Models;


class DemandeAbsence extends Model
{

    public static $columnsExport =  [
        [
            "column_db" => "date",
            "column_excel" => "Date",
            "column_unique" => false
        ],
        [
            "column_db" => "date_debut",
            "column_excel" => "Date debut",
            "column_unique" => false
        ],
        [
            "column_db" => "date_fin",
            "column_excel" => "Date fin",
            "column_unique" => false
        ],
        [
            "column_db" => "motif",
            "column_excel" => "Motif",
            "column_unique" => false
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false
        ],
        [
            "column_db" => "employe_id",
            "column_excel" => "Employe",
            "column_unique" => false
        ],
    ];
}
