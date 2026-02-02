<?php

namespace App\Models;

class Contact extends Model
{
    public static $columnsExport =  [

        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => false
        ],
        [
            "column_db" => "prenom",
            "column_excel" => "Prenom",
            "column_unique" => false
        ],
     
        [
            "column_db" => "telephone",
            "column_excel" => "Telephone",
            "column_unique" => true
        ],
      
        [
            "column_db" => "email",
            "column_excel" => "Email",
            "column_unique" => true
        ],

    ];
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
   
}
