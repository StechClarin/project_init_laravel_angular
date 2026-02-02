<?php

namespace App\Models;

use App\RefactoringItems\SaveModel;

class Mood extends Model
{
    public function getEmojiAttribute()
{
    $map = [
        'En forme'          => '😄',
        'Mauvaise hummeur'  => '😤',
        'Malade'            => '🤒',
        'Fatigue'           => '🥱',
    ];

    return $map[$this->designation] ?? '❓';
}

}
