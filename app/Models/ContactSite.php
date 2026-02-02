<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSite extends Contact
{
    protected $connection = 'homeostasia'; 
    protected $table = 'contacts';
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'message',
        'status',
        'created_at_r',
        'updated_at',
    ];
}