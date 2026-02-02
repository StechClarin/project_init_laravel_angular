<?php

namespace App\Models;

use App\Traits\HasModelRelationships;
use App\RefactoringItems\Models\Model as SharedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\RefactoringItems\Models\{ModelUtils, Trackable};

class Model extends SharedModel
{
    use HasFactory;
    use HasModelRelationships;
    use ModelUtils;
    use Trackable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];
}
