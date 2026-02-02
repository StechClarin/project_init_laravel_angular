<?php

namespace App\Models;

class DetailRapport extends Model
{
    protected $fillable = [
        'date',
        'rapport_assistance_id',
        'assistance_id',
    ];
    public static $columnsExport =  [
        [
            "column_db" => "date",
            "column_excel" => "Date",
            "column_unique" => false
        ],
        [
            "column_db" => "rapport_assistance_id",
            "column_excel" => "Rapport Assistance",
            "column_unique" => false
        ],
        [
            "column_db" => "assistance_id",
            "column_excel" => "Assistance",
            "column_unique" => false
        ],
    ];


    public function assistance()
    {
        return $this->belongsTo(Assistance::class);

    }

    public function rapport_assistance()
    {
        return $this->belongsTo(RapportAssistance::class);
    }


}
