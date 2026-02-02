<?php

namespace App\Models;

class NotifPermUser extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notif()
    {
        return $this->belongsTo(Notif::class);
    }
}
