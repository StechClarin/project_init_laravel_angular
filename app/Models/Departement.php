<?php

namespace App\Models;

class Departement extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false
        ],
    ];


    public function getWebhookLink(){
        $link =  route('webhook', ['canal' => $this->id]);
        return $link;
    }
}
