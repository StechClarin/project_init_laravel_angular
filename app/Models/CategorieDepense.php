<?php

namespace App\Models;

class CategorieDepense extends Model
{

    public function type_depense(){
        return $this->hasMany(TypeDepense::class);
    }
}
