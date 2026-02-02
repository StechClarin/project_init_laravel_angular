<?php


namespace App\Models;

class Assistance extends Model
{
    public $codePrefix = 'AST';

    public static $columnsExport =  [
        [
            "column_db" => "date",
            "column_excel" => "Date",
            "column_unique" => false
        ],
        [
            "column_db" => "projet_id",
            "column_excel" => "Projet",
            "column_unique" => false
        ],
        [
            "column_db" => "canal_id",
            "column_excel" => "canal",
            "column_unique" => false
        ],
        [
            "column_db" => "detail",
            "column_excel" => "Detail",
            "column_unique" => false
        ],
        [
            "column_db" => "tag_id",
            "column_excel" => "Nature",
            "column_unique" => false
        ],
        [
            "column_db" => "type_tache_id",
            "column_excel" => "Type Tache",
            "column_unique" => false
        ],
        [
            "column_db" => "assigne_id",
            "column_excel" => "Assigne a",
            "column_unique" => false
        ],
        [
            "column_db" => "status",
            "column_excel" => "Status",
            "column_unique" => false
        ],
        [
            "column_db" => "collecteur_id",
            "column_excel" => "Collecter par",
            "column_unique" => false
        ],
        [
            "column_db" => "rapporteur",
            "column_excel" => "Rapporte par",
            "column_unique" => false
        ],
    ];

    public function canal_slack()
    {
        return $this->belongsTo(CanalSlack::class);
    }

    public function rapport_assistance(){
        return $this->hasMany(RapportAssistance::class);
    }

}
