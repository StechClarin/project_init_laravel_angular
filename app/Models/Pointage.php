<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Contracts\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as ModelsRole;
use App\Traits\HasModelRelationships;
use Mpdf\Tag\Details;

class Pointage extends Model
{

    protected $table = 'pointages';
    public static $columnsExport =  [
        [
            "column_db" => "date",
            "column_excel" => "date(jj/mm/aaaa)",
            "column_unique" => true
        ],
        [
            "column_db" => "heure_arrive",
            "column_excel" => "heure d'arrivee",
            "column_unique" => false
        ],
        [
            "column_db" => "heure_depart",
            "column_excel" => "heure de depart",
            "column_unique" => false
        ],
        [
            "column_db" => "personnel_id",
            "column_excel" => "personnel",
            "column_unique" => false
        ],
        [
            "column_db" => "retard",
            "column_excel" => "retard(oui/non)",
            "column_unique" => false
        ],
        [
            "column_db" => "justificatif",
            "column_excel" => "justificatif(oui/non)",
            "column_unique" => false
        ],
    ];

    public function personnel(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Personnel::class);
    }
    public function details_pointages(){
        return $this->hasMany(DetailsPointage::class);
    }
    public function details(){
        return $this->hasMany(DetailsPointage::class);
    }

}
