<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as ModelsRole;
use App\Traits\HasModelRelationships;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'name', 'email', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_connexions' => 'array'
    ];

    public function setPasswordAttribute($value)
    {
        if (isset($value) && Hash::needsRehash($value))
        {
            $hashed = Hash::make($value);
            $this->attributes['password'] = $hashed;
        }
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function moods() {
        return $this->hasOne(Mood::class)->latest('created_at'); 
    }

    public function notif() {
        return $this->hasMany(Notif::class);
    }
    public function notifPermUser() {
        return $this->hasMany(NotifPermUser::class);
    }




}
