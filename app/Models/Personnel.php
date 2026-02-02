<?php

namespace App\Models;

use Spatie\Permission\Models\Role;

class Personnel extends Model
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
            "column_db" => "date_naissance",
            "column_excel" => "date de naissance",
            "column_unique" => false
        ],
        [
            "column_db" => "lieu_naissance",
            "column_excel" => "lieu de naissance",
            "column_unique" => false

        ],
        [
            "column_db" => "email",
            "column_excel" => "Email",
            "column_unique" => true
        ],
        [
            "column_db" => "connectivite",
            "column_excel" => "connectivite (oui/non)",
            "column_unique" => true
        ],
        [
            "column_db" => "role_id",
            "column_excel" => "profil",
            "column_unique" => false
        ],
        [
            "column_db" => "password",
            "column_excel" => "default password",
            "column_unique" => false
        ],


        [
            "column_db" => "telephone",
            "column_excel" => "Telephone",
            "column_unique" => true
        ],
        [
            "column_db" => "adresse",
            "column_excel" => "adresse",
            "column_unique" => false
        ],
        [
            "column_db" => "date_embauche",
            "column_excel" => "date de prise en fonction",
            "column_unique" => false
        ],

        [
            "column_db" => "nomcp",
            "column_excel" => "Nom du contact",
            "column_unique" => false
        ],

        [
            "column_db" => "fonction",
            "column_excel" => "affiliation du contact",
            "column_unique" => false
        ],
        [
            "column_db" => "telephonec",
            "column_excel" => "Telephone du contact",
            "column_unique" => true
        ],




    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class);
    }
    public function planificationassignes()
    {
        return $this->hasMany(PlanificationAssigne::class);
    }
    public function tacheprojets()
    {
        return $this->hasMany(TacheProjet::class);
    }


}
