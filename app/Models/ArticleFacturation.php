<?php

namespace App\Models;

class ArticleFacturation extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "code",
            "column_excel" => "Code",
            "column_unique" => true
        ],

        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => false
        ],
        [
            "column_db" => "famille_debour_id",
            "column_excel" => "Famille Debour",
            "column_unique" => false
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false
        ],
    ];
}
