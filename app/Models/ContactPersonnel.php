<?php

namespace App\Models;

class ContactPersonnel extends Model
{
    public function contact_personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
