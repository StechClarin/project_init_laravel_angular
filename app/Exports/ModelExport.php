<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ModelExport implements FromView
{
    /**
     * les donnees a export
     *
     * @var array
     */
    protected $data = [];

    /**
     * Le nom du template
     *
     * @var array
     */
    protected $filename = [];


    public function __construct($data, string $filename)
    {
        $this->data = $data;
        $this->filename = $filename;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view("exports.{$this->filename}", [
            'data'    => $this->data,
        ]);
    }
}
