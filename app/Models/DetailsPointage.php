<?php

namespace App\Models;


class DetailsPointage extends Model
{


    protected $table = "details_pointages";

    public function pointage(){
        return $this->belongsTo(Pointage::class);
    }
}
