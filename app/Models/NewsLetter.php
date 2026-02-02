<?php

namespace App\Models;

use App\RefactoringItems\SaveModel;

class NewsLetter extends Model
{
    protected $connection = 'homeostasia'; 
    protected $table = 'newsletters';
}
