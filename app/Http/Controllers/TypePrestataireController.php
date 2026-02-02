<?php

namespace App\Http\Controllers;

use App\Jobs\ImportTypePrestataireFileJob;
use App\Models\TypePrestataire;
use App\RefactoringItems\SaveModelController;

class TypePrestataireController extends ModelController
{
    protected $job = ImportTypePrestataireFileJob::class;

    protected $model = TypePrestataire::class;
   // public $relationToDelete = array('paiements',"cloture_caisse_mode_paiements","credit_clients");

}
