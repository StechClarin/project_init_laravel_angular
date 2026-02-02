<?php

namespace App\Models;

class Notif extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notifPermUser()
    {
        return $this->hasMany(NotifPermUser::class);
    }
}
