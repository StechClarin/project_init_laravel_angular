<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class EtatExport implements FromView
{
    use Exportable;

    private $datestartFr                    = null;
    private $dateendFr                      = null;
    private $data                           = null;
    private $tagname                        = null;
    private $pointventesalls                = null;
    private $societefacturationsalls        = null;
    public function __construct($datestartFr,$dateendFr,$data, $tagname,$pointventesalls=null,$societefacturationsalls=null)
    {
        $this->data                      = $data;
        $this->datestartFr               = $datestartFr;
        $this->dateendFr                 = $dateendFr;
        $this->tagname                   = $tagname;
        $this->pointventesalls           = $pointventesalls;
        $this->societefacturationsalls   = $societefacturationsalls;

    }

    public function view(): View
    {

        return view("pdfs.etats.{$this->tagname}", [
            'data'                           => $this->data,
            'date_debut'                     => $this->datestartFr,
            'date_fin'                       => $this->dateendFr,
            'pointventesalls'                => $this->pointventesalls,
            'societefacturationsalls'        => $this->societefacturationsalls,
            'point_vente'                    => $this->pointventesalls,
            'caisse'                         => $this->pointventesalls,
            "point_ventealls"                => $this->pointventesalls,
            'is_excel'                       => true,

        ]);
    }
}
