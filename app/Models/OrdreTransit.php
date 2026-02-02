<?php

namespace App\Models;

class OrdreTransit extends Model
{
    public $codePrefix = 'OT';

    public function type_dossiers()
    {
        return $this->belongsToMany(TypeDossier::class, OrdreTransitTypeDossier::class)
            ->as('details');
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    public function devise_ff()
    {
        return $this->belongsTo(Devise::class, 'devise_ff_id');
    }

    public function devise_fft()
    {
        return $this->belongsTo(Devise::class, 'devise_fft_id');
    }

    public function ordre_transit_documents()
    {
        return $this->hasMany(OrdreTransitDocument::class);
    }

    public function ordre_transit_type_conteneurs()
    {
        return $this->hasMany(OrdreTransitTypeConteneur::class);
    }

    public function ordre_transit_marchandises()
    {
        return $this->hasMany(OrdreTransitMarchandise::class);
    }

    public function articles()
    {
        return $this->hasMany(OrdreTransitMarchandise::class)->groupBy('marchandise_id');
    }

    public function ordre_transit_bls()
    {
        return $this->hasMany(OrdreTransitBl::class);
    }

    public function ordre_transit_ffs()
    {
        return $this->hasMany(OrdreTransitFf::class);
    }

    public function ordre_transit_ffts()
    {
        return $this->hasMany(OrdreTransitFft::class);
    }
    public function ordre_transit_asres()
    {
        return $this->hasMany(OrdreTransitAsre::class);
    }
    public function ordre_transit_dpis()
    {
        return $this->hasMany(OrdreTransitDpi::class);
    }

    public function ordre_transit_bscs()
    {
        return $this->hasMany(OrdreTransitBsc::class);
    }

    public function getDeviseAsreAttribute()
    {
        $res = null ;
        $u = $this->ordre_transit_asres()->first();
        if (isset($u, $u->devise_id) )
        {
            $res = $this->ordre_transit_asres()->where('devise_id', $u->devise_id)->count() === $this->ordre_transit_asres()->count() ? $u->devise_id : null ;
        }
        return $res ;
    }

    public function getParSttAsreAttribute()
    {
        return $this->ordre_transit_asres()->where('type', 2)->count() === $this->ordre_transit_asres()->count() ;
    }

    public function getWithoutDpiAttribute()
    {
        return $this->ordre_transit_dpis()->where('type', 1)->count() === $this->ordre_transit_dpis()->count() ;
    }

    public function getDeviseFretAttribute()
    {
        $res = null ;
        $u = $this->ordre_transit_ffts()->first();

        if (isset($u, $u->devise_id) )
        {
            $res = $this->ordre_transit_ffts()->where('devise_id', $u->devise_id)->count() === $this->ordre_transit_ffts()->count() ? $u->devise_id : null ;
        }
        return $res ;
    }
    public function getDeviseFactureFournisseurAttribute()
    {
        $res = null ;
        $u = $this->ordre_transit_ffs()->first();

        if (isset($u, $u->devise_id) )
        {
            $res = $this->ordre_transit_ffs()->where('devise_id', $u->devise_id)->count() === $this->ordre_transit_ffs()->count() ? $u->devise_id : null ;
        }
        return $res ;
    }

    public function getCoutFretAttribute()
    {
        return $this->ordre_transit_ffs()->where('inclut_fret', true)->count() === $this->ordre_transit_ffs()->count() ;
    }
}
