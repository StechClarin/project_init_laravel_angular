<?php

namespace App\Models;

class Vehicule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'marchandises';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type_marchandise_id' => 2,
    ];
}
