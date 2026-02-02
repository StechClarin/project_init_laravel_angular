<?php

namespace App\Models;

class Evenement extends Model
{
    public static $columnsExport =  [
        [
            "column_db" => "date",
            "column_excel" => "date(jj/mm/aaaa)",
            "column_unique" => true
        ],
        [
            "column_db" => "garvite",
            "column_excel" => "Niveau de gravite",
            "column_unique" => false
        ],
        [
            "column_db" => "mesure",
            "column_excel" => "Mesure",
            "column_unique" => false
        ],
        [
            "column_db" => "personnel_id",
            "column_excel" => " personnel",
            "column_unique" => false
        ],
        [
            "column_db" => "projet_id",
            "column_excel" => " projet",
            "column_unique" => false
        ],
        [
            "column_db" => "observation",
            "column_excel" => "observation",
            "column_unique" => false
        ],
        [
            "column_db" => "temps",
            "column_excel" => "heures perdue",
            "column_unique" => false
        ],
    ];
    public function personnel(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Personnel::class);
    }
    public function projets(){
        return $this -> belongsTo(Projet::class);
    }
    public function mesure(){
        return $this -> belongsTo(Mesure::class);
    }
    public function gravite(){
        return $this -> belongsTo(Gravite::class);
    }
}
