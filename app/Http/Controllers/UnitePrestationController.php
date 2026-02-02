<?php

namespace App\Http\Controllers;

use App\Jobs\ImportUnitePrestationFileJob;
use App\Models\UnitePrestation;
use App\RefactoringItems\SaveModelController;

class UnitePrestationController extends ModelController
{
    protected $job = ImportUnitePrestationFileJob::class;

    protected $model = UnitePrestation::class;

}
