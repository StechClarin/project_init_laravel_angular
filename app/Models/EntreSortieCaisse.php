<?php

namespace App\Models;

class EntreSortieCaisse extends Model
{
    protected $table = 'entresortie_caisses';
    public static $columnsExport =  [
        [
            "column_db" => "caisse_id",
            "column_excel" => "caisse",
            "column_unique" => true
        ],
        [
            "column_db" => "motifentresortiecaisse_id",
            "column_excel" => "motif",
            "column_unique" => false
        ],
        [
            "column_db" => "montant",
            "column_excel" => "montant",
            "column_unique" => false
        ],
        [
            "column_db" => "decription",
            "column_excel" => "description",
            "column_unique" => false
        ],
    ];

    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    public function motifentresortiecaisse()
    {
        return $this->belongsTo(MotifEntreSortieCaisse::class);
    }
}
