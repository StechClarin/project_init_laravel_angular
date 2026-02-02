<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Contracts\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as ModelsRole;
use App\Traits\HasModelRelationships;



class BilanTache extends Model
{

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function tacheprojet()
    {
        return $this->belongsTo(TacheProjet::class);
    }
}
