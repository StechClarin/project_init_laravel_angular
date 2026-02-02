<?php

namespace App\Models;


class Planification extends Model
{
    public function details()
    {
        return $this->hasMany(PlanificationAssigne::class)->orderBy('id', 'desc');
    }
}
