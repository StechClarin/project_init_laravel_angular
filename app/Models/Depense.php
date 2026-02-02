<?php

namespace App\Models;

use Illuminate\Http\Request;

use App\Models\{
    Outil,
    TypeDepense,
    User,
    ValidationDossier
};


class Depense extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "typedepense_id",
            "column_excel" => "Type Depense",
            "column_unique" => false
        ],
        [
            "column_db" => "montant",
            "column_excel" => "Montant",
            "column_unique" => false
        ],

        [
            "column_db" => "description",
            "column_excel" => "Description",
            "column_unique" => false

        ],
    ];

    public function typedepense()
    {
        return $this->belongsTo(TypeDepense::class);
    }
    public function created_by()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_at_user_id');
    }
}
