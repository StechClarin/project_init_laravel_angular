<?php

namespace App\Http\Controllers;

use App\Jobs\ImportPrestationFileJob;
use App\Models\Prestation;
use App\RefactoringItems\SaveModelController;

class PrestationController extends ModelController
{
    protected $job = ImportPrestationFileJob::class;

    protected $model = Prestation::class;
   // public $relationToDelete = array('paiements',"cloture_caisse_mode_paiements","credit_clients");

}
