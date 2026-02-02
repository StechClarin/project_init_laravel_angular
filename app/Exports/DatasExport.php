<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class DatasExport implements FromView
{
    use Exportable;

    private $data = null;
    private $queryName = null;
    private $id = null;

    public function __construct($data, $queryName, $id = null)
    {
        $this->data = $data;
        $this->queryName = $queryName;
        $this->id = $id;
    }

    public function view(): View
    {
        $FileName = (isset($this->id) ? "detail-" : "") . "{$this->queryName}";


        // dd($this->data);
        return view("pdfs.{$FileName}", [
            'data'            => $this->data["data"],
            'details'         => $this->data["details"],
            'titre'           => $this->data["titre"],
            'permission'      => $this->data["permission"],
            'is_excel'        => true,
            'filtres'         => $this->data["filtres"],
        ]);
    }
}
