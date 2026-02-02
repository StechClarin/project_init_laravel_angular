<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\RefactoringItems\{CRUDController};
use App\Models\Outil;


class DepartementController extends CRUDController
{


    public function afterCRUDProcessing(&$model): void
    {
        // dd($model);

        Outil::uploadFileToModel($this->request, $model, 'image');
    }

}
