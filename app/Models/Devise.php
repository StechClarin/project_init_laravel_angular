<?php

namespace App\Models;

class Devise extends Model
{
    public function getTauxChangeAttribute()
    {
        return round($this->cours / $this->unite, $this->precision ?? 0);
    }
}
