<?php

namespace App\Models;

class ProfilFacturation extends Model
{

    public function detail_profil_facturations()
    {
        return $this->hasMany(DetailProfilFacturation::class);
    }
    
}
