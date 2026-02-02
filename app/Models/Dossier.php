<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\FalseType;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany};

class Dossier extends Model
{
    public $codePrefix = 'DS';

    public function dossier_manifestes()
    {
        return $this->hasMany(DossierManifeste::class)->orderBy('id');
    }

    public function dossier_note_details()
    {
        return $this->hasMany(DossierNoteDetail::class)->orderBy('id');
    }

    public function regime_nd()
    {
        return $this->belongsTo(Regime::class, 'regime_nd_id');
    }

    public function ordre_transit():BelongsTo
    {
       return $this->belongsTo(OrdreTransit::class)->with(['ordre_transit_marchandises' => function ($query)
        {
            $query->where('type_dossier_id', $this->type_dossier_id);
        }]);
    }

    public function devise_ass_nd()
    {
        return $this->belongsTo(Devise::class, 'devise_ass_nd_id');
    }

    public function devise_fret_nd()
    {
        return $this->belongsTo(Devise::class, 'devise_fret_nd_id');
    }

    public function liquidations()
    {
        return $this->hasMany(DossierLiquidation::class);
    }

    public function getCanUpdateLiquidationAttribute()
    {
        $rtr = false ;
        foreach($this->dossier_note_details as $kk => $item)
        {
            $currentDossierNomenclature = NomenclatureDouaniere::query()->find($item->nomenclature_douaniere_id);

            $u = $currentDossierNomenclature->taxe_douanieres()->pluck('taxe_douanieres.id')->toArray();
            $v = $item->dossier_nomenclature_douaniere_taxe_douanieres()->pluck('taxe_douaniere_id')->toArray();
            if (count($v) > 0)
            {
                if (count($u) !== count($v) || !empty(array_diff($u, $v)) || !empty(array_diff($v, $u)))
                {
                    $rtr = true ;
                    break ;
                }
            }
        }

        return $rtr;
    }

    public function getcanSetDeviseAttribute()
    {
        $deviseFret = Devise::query()->find($this->devise_fret_nd_id);
        $deviseAss = Devise::query()->find($this->devise_ass_nd_id);
        $deviseFretChange = false; $deviseAssChange = false;
        if (isset($deviseFret))
        {
            $deviseFretChange = (float)$this->cours_devise_fret !== (float)$deviseFret->taux_change;
        }

        if (isset($deviseAss))
        {
            $deviseAssChange = (float)$this->cours_devise_ass !== (float)$deviseAss->taux_change;
        }

        $deviseNDChange = false;
      
        //Check devise dans dossier note details
        if ($this->dossier_note_details()->count() > 0)
        {
            foreach ($this->dossier_note_details as $dossierNoteDetail)
            {
                $currentDevise = Devise::query()->find($dossierNoteDetail->devise_id);

               // dd($currentDevise->taux_change, $dossierNoteDetail->cours_devise);
                
                if ((float)$dossierNoteDetail->cours_devise !== (float) $currentDevise->taux_change)
                {
                    $deviseNDChange = true;
                    break;
                }
            }
        }

        return ($deviseFretChange || $deviseAssChange || $deviseNDChange) && $this->dossier_note_details()->count() > 0;
    }

    public function getApurementAttribute()
    {
        return (float) $this->dossier_note_details()->sum('poids_brut') === (float) $this->ordre_transit->ordre_transit_marchandises->sum('poids') && (float) $this->dossier_note_details()->sum('nb_colis') === (float) $this->ordre_transit->ordre_transit_marchandises->sum('quantite');
    }

    public function getStepTraitementAttribute()
    {
        //return $this->dossier_manifestes()->count() <= 0 || ($this->liquidations()->count() <= 0 && $this->dossier_note_details()->count() <= 0) ;
        return $this->dossier_manifestes()->count() <= 0 || !$this->getApurementAttribute();
    }

    public function getStepDeclarationAttribute()
    {
        return !$this->getStepTraitementAttribute() && !$this->declaration_dossier_iscorrect && !$this->bae_dossier_iscorrect;
    }

    public function getStepAttenteBaeAttribute()
    {
        return $this->declaration_dossier_iscorrect && !$this->bae_dossier_iscorrect;
    }

    public function getStepLivraisonAttribute()
    {
        return !$this->getStepTraitementAttribute() && !$this->getStepDeclarationAttribute() && !$this->getStepAttenteBaeAttribute() && $this->bae_dossier_iscorrect;
    }
}
