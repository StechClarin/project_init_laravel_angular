<?php

namespace App\Models;

class TypeDossier extends Model
{

    public function getNbreTypeDossierAttribute()
    {
        return $this->type_dossiers_formule()->count();
    }

    public function getBgStyleAttribute()
    {
        //dd($this['couleurbg']);
        $rtr = "background : {$this->couleurbg} !important;";
        if ($this->getNbreTypeDossierAttribute() > 0)
        {
            $rtr = "background: linear-gradient(to left," ;
            $percent = 100 / $this->getNbreTypeDossierAttribute() ;
            $percent = (int) round($percent);

            foreach ($this->type_dossiers_formule as $key => $value)
            {
                $rtr .= " {$value->couleurbg} {$percent}%";

                if ($key !== ($this->getNbreTypeDossierAttribute() -1))
                {
                    $rtr.= " ," ;
                }
            }

            $rtr .= ");";

            //dd($rtr);
        }
        return $rtr;
    }

    public function getFgStyleAttribute()
    {
        return "color : {$this->couleurfg} !important;";
    }

    public function type_dossiers_formule()
    {
        return $this->belongsToMany(__CLASS__, DetailTypeDossier::class, 'parent_id', 'type_dossier_id')
            ->as('details');
    }
}
