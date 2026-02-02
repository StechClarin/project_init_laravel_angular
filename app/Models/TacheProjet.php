<?php

namespace App\Models;

class TacheProjet extends Model
{
//    public function module()
//    {
//        return $this->hasMany(Module::class);
//    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);


    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function priorite()
    {
        return $this->belongsTo(Priorite::class);
    }

}
