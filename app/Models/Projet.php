<?php

namespace App\Models;

class Projet extends Model
{
    public $codePrefix = 'PRJ';

    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "telephone",
            "column_excel" => "Telephone",
            "column_unique" => false
        ],
        [
            "column_db" => "type_projet_id",
            "column_excel" => "Type De Projet",
            "column_unique" => false
        ],
        [
            "column_db" => "client_id",
            "column_excel" => "Client",
            "column_unique" => false
        ],
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function projet(){
        return $this->belongsTo(NoyauxInterne::class);
    }

    public function rapport_assistance()
    {
        return $this->hasMany(RapportAssistance::class, 'projet_id');
    }
}
