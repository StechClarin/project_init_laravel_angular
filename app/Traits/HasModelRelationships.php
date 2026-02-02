<?php

namespace App\Traits;

use App\Models\{
    Bureau,
    Client,
    Contact,
    Devise,
    Dossier,
    FileItem,
    Fournisseur,
    ModeFacturation,
    Module,
    ModeLink,
    ModePaiement,
    ModalitePaiement,
    Modele,
    NiveauHabilite,
    Notif,
    NotifPermUser,
    OrdreTransit,
    Page,
    Pays,
    TypeClient,
    TypeConteneur,
    TypeDossier,
    UniteMesure,
    User,
    TypeProjet,
    SecteurActivite,
    Projet,
    Tag,
    TypeTache,
    Personnel,
    Remboursement,
    RapportAssistance,
    RapportEmail,
    DetailRapport,
    Assistance,
    BilanPointage,
    Prospect,
    ProjetProspect,
    NoyauxInterne,
    Fonctionnalite,
    FonctionnaliteModule,
    ProjetModule,
    TacheFonctionnalite,
    Tache,
    Departement,
    ProjetDepartement,
    Visa,
    VisaFinal,
    VisaCtoCdp,
    VisaQualite,
    PlanificationAssigne,
    Planification,
    Priorite,
};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany};
use Spatie\Permission\Models\{Role, Permission};

trait HasModelRelationships
{
    public function permissions()
    {
        return $this->hasMany(Permission::class)->orderBy('type_permission_id');
    }
    public function notif()
    {
        return $this->belongsTo(Notif::class);
    }

    public function pay()
    {
        return $this->belongsTo(Pays::class);
    }

    public function mode_facturation()
    {
        return $this->belongsTo(ModeFacturation::class);
    }

    public function modele()
    {
        return $this->belongsTo(Modele::class);
    }
    public function modeles()
    {
        return $this->hasMany(Modele::class);
    }


    public function notifpermusers()
    {
        return $this->hasMany(NotifPermUser::class);
    }

    public function notif_perm_users()
    {
        return $this->hasMany(NotifPermUser::class);
    }

    public function niveau_habilite()
    {
        return $this->belongsTo(NiveauHabilite::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function mode_link()
    {
        return $this->belongsTo(ModeLink::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('order');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function created_at_user()
    {
        return $this->belongsTo(User::class);
    }


    public function updated_at_user()
    {
        return $this->belongsTo(User::class);
    }


    public function secteur_activite()
    {
        return $this->belongsTo(SecteurActivite::class);
    }

    public function type_projet()
    {
        return $this->belongsTo(TypeProjet::class);
    }

    public function type_client()
    {
        return $this->belongsTo(TypeClient::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function projets()
    {
        return $this->belongsToMany(Projet::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function modalite_paiement()
    {
        return $this->belongsTo(ModalitePaiement::class);
    }
    public function mode_paiement(): BelongsTo
    {
        return $this->belongsTo(ModePaiement::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }


    public function rapporteur()
    {
        return $this->belongsTo(User::class, 'rapporteur_id');
    }

    public function assigne()
    {
        return $this->belongsTo(User::class, 'assigne_id');
    }

    public function collecteur()
    {
        return $this->belongsTo(User::class, 'collecteur_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function type_tache()
    {
        return $this->belongsTo(TypeTache::class);
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class)->orderBy('id', 'desc');
    }



    public function files() // ordretransits
    {
        return $this->hasMany(FileItem::class)->orderBy('id', 'desc');
    }
    public function employe()
    {
        return $this->belongsTo(Personnel::class, 'employe_id');
    }
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
    public function planification()
    {
        return $this->belongsTo(Planification::class);
    }

    public function remboursements()
    {
        return $this->hasMany(Remboursement::class)->orderBy('id', 'desc');
    }
    public function planification_assignes()
    {
        return $this->hasMany(PlanificationAssigne::class)->orderBy('id', 'desc');
    }
    public function bilanpointage()
    {
        return $this->hasMany(BilanPointage::class)->orderBy('id', 'desc');
    }

    public function rapport_email()
    {
        return $this->belongsTo(RapportEmail::class)->orderBy('id', 'desc');
    }


    
    public function details_assistance()
    {
        return $this->hasMany(DetailRapport::class)->orderBy('id', 'desc');
    }

    public function prospect():BelongsTo
    {
        return $this->belongsTo(Prospect::class)->orderBy('id', 'desc');
    }
    public function noyaux_interne():BelongsTo
    {
        return $this->belongsTo(NoyauxInterne::class)->orderBy('id', 'desc');
    }
    public function fonctionnalites()
    {
        return $this->belongsToMany(Fonctionnalite::class)->orderBy('id', 'desc');
    }
    public function fonctionnalite()
    {
        return $this->belongsTo(Fonctionnalite::class)->orderBy('id', 'desc');
    }
    public function taches()
    {
        return $this->hasMany(Tache::class)->orderBy('id', 'desc');
    }
    public function tache()
    {
        return $this->BelongsTo(Tache::class)->orderBy('id', 'desc');
    }
    public function priorite()
    {
        return $this->BelongsTo(Priorite::class)->orderBy('id', 'desc');
    }
    public function projet_modules()
    {
        return $this->hasMany(ProjetModule::class)->orderBy('id', 'desc');
    }
    public function tache_fonctionnalites()
    {
        return $this->hasMany(TacheFonctionnalite::class)->orderBy('id', 'desc');
    }
    public function tache_fonctionnalite()
    {
        return $this->BelongsTo(TacheFonctionnalite::class)->orderBy('id', 'desc');
    }
    public function fonctionnalite_module()
    {
        return $this->BelongsTo(FonctionnaliteModule::class)->orderBy('id', 'desc');
    }public function fonctionnalite_modules()
    {
        return $this->hasMany(FonctionnaliteModule::class)->orderBy('id', 'desc');
    }

    public function departements()
    {
        return $this->hasMany(Departement::class)->orderBy('id', 'desc');
    }
    
    public function departement():BelongsTo
    {
        return $this->BelongsTo(Departement::class)->orderBy('id', 'desc');
    }
    public function projet_departements()
    {
        return $this->hasMany(ProjetDepartement::class)->orderBy('id', 'desc');
    }
    public function visas()
    {
        return $this->hasMany(Visa::class)->orderBy('id', 'asc');
    }
    public function visa_finals()
    {
        return $this->hasMany(VisaFinal::class)->orderBy('id', 'asc');
    }
    public function visa_qualite()
    {
        return $this->hasMany(VisaQualite::class)->orderBy('id', 'desc');
    }
    public function visa_cto_cdp()
    {
        return $this->hasMany(VisaCtoCdp::class)->orderBy('id', 'desc');
    }
    public function tachess()
    {
        return $this->hasManyThrough(
            TacheFonctionnalite::class,
            FonctionnaliteModule::class,
            'projet_id', 
            'fonctionnalite_id', 
            'id',
            'id'
        );
    }

    // public function user():BelongsTo
    // {
    //     return $this->BelongsTo(User::class,'email')->orderBy('id', 'desc');
    // }
    
   

    /**
     * --------------------
     * GETTER
     * -----------------
     */

    public function getNbCommandesAttribute()
    {
        return $this->commandes()->get()->count();
    }

    public function getNbMarchandisesAttribute()
    {
        return $this->marchandises()->get()->count();
    }

    public function getNbClientsAttribute()
    {
        return $this->clients()->get()->count();
    }

    public function getNbPaiementsAttribute()
    {
        return $this->paiements()->get()->count();
    }

    public function getNomCompletAttribute()
    {
        return trim("{$this->prenom} {$this->nom}");
    }
}
