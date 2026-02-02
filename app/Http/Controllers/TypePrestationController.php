<?php

namespace App\Http\Controllers;

use App\Jobs\ImportTypePrestationFileJob;
use App\Models\TypePrestation;
use App\RefactoringItems\SaveModelController;

class TypePrestationController extends ModelController
{
    protected $job = ImportTypePrestationFileJob::class;

    protected $model = TypePrestation::class;
   // public $relationToDelete = array('paiements',"cloture_caisse_mode_paiements","credit_clients");

}
