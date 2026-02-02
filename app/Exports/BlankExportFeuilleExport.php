<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromView;

class BlankExportFeuilleExport implements FromView
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function view(): View
    {
        $element = null;
        $columns =  $this->model::$columnsExport;
        return view('pdfs.tramemodele', [
            'columns' => $columns
        ]);
    }
}

