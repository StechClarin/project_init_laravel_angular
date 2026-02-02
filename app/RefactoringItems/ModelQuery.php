<?php


namespace App\RefactoringItems;

use App\Models\{
    ChapitreNomenclatureDouaniere,
    OrdreTransitAsre,
    OrdreTransitFf,
    Outil,
    Client,
};
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{Auth, DB};
use ReflectionClass;

class ModelQuery
{
    public static function getQueryOrQueryPaginated($root, $args, &$query, $order = true, $arrayOrder = null)
    {
        $collumn        = 'id';
        $property       =  'DESC';
        if (isset($order)) {
            if (isset($arrayOrder)) {
                $collumn    = isset($arrayOrder['collumn']) ? $arrayOrder['collumn'] : $collumn;
                $property   = isset($arrayOrder['property']) ? $arrayOrder['property'] : $property;
            }
        }

        if (!isset($args['page']) && isset($args['count'])) {
            $query = $query->limit($args['count']);
        }
        if (isset($args['count']) && isset($args['page'])) {
            $count = Arr::get($args, 'count', 20);
            $page  = Arr::get($args, 'page', 1);
            if ($order && isset($collumn) && isset($property)) {
                $query->orderBy($collumn, $property);
            }
            $query = $query->paginate($count, ['*'], 'page', $page);
        } else {
            if ($order && isset($collumn) && isset($property)) {
                $query->orderBy($collumn, $property);
            }
            $query = $query->get();
        }
        return $query;
    }

    // public static $modelNamespace = '\\App\\Models';

    // public static function initForQuery($root, $args, $nameQuery, &$query)
    // {
    //     $nameQuery = str_ireplace("For", '', $nameQuery);
    //     $refl = new ReflectionClass(self::$modelNamespace . "\\" .  ucfirst($nameQuery));
    //     $query = $refl->getName()::query();

    //     Outil::addWhereToModel($query, $args,
    //         [
    //             ['id',                     '='],
    //             ['nom',                 'like'],
    //             ['description',         'like'],
    //         ]);

    //     if (isset($args['search']))
    //     {
    //         $search = $args['search'];
    //         $query->where('nom', Outil::getOperateurLikeDB(),'%'. $search . '%');
    //     }

    //     self::getQueryOrQueryPaginated($root, $args, $query);
    // }

    // public static function forBanque($root, $args, $query)
    // ..

    // public static function forBureau($root, $args, $query)
    // ..

    public static function forClient($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                     '='],
                ['nom',                 'like'],
                ['type_client_id',         '='],
                ['status',                 '='],
                ['modalite_paiement_id',   '='],
            ]
        );

        if (isset($args['search'])) {
            $motRecherche  = $args['search'];
            $query = $query->where(function ($query) use ($motRecherche) {
                return $query->where('nom', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%')
                    ->orWhere('email', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%')
                    ->orWhere('code', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%')
                    ->orWhere('telephone', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%');
            });
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }



    public static function forProjet($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                     '='],
                ['nom',                 'like'],
                ['type_projet_id',         '='],
                ['status',                 '='],
            ]
        );

        if (isset($args['search'])) {
            $motRecherche  = $args['search'];
            $query = $query->where(function ($query) use ($motRecherche) {
                return $query->where('nom', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%')
                    ->orWhere('code', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%');
            });
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }
    public static function forTacheProjet($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                     '='],
                ['nom_tache',                 'like'],
                ['status',                 '='],
            ]
        );

        if (isset($args['search'])) {
            $motRecherche  = $args['search'];
            $query = $query->where(function ($query) use ($motRecherche) {
                return $query->where('nom_tache', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%');
            });
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }
    public static function forProjetDepartement($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                     '='],
                ['departement_id',         '='],
            ]
        );


        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forAssistance($root, $args, $query)
    {
        // dd($args);
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                  '='],
                ['nom',                 'like'],
                ['collecteur_id',       '='],
                ['rapporteur',          '='],
                ['assigne_id',          '='],
                ['tag_id',              '='],
                ['type_tache_id',       '='],
                ['canal_id',            '='],
                ['etat',                '='],
                ['status',              '='],
            ]
        );

        if (isset($args['search'])) {
            $motRecherche  = $args['search'];
            $query = $query->where(function ($query) use ($motRecherche) {
                return $query->where('nom', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%')
                    ->orWhere('code', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%');
            });
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forRapportAssistance($root, $args, $query)
    {

        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                  '='],
                ['libelle',          'like'],

            ]
        );
        if (isset($args['search'])) {
            $motRecherche  = $args['search'];
            $query = $query->where(function ($query) use ($motRecherche) {
                return $query->where('libelle', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%');
            });
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forProjetProspect($root, $args, $query)
    {

        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                  '='],
                ['status',              '='],
            ]
        );
        // dd($args);
        if (isset($args['search'])) {
            $query->whereRaw(
                'client_id in (select id from clients where nom like ? OR prenom like ?)',
                [$args['search'], $args['search']]
            );
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    // public static function forAvanceSalaire($root, $args, $query)
    // {
    //     dd($query->get());
    // }
    // public static function forBilanPointage($root, $args, $query)
    // {
    //     $date_debut = $date_fin = null;

    //     if (isset($args['date_debut']) && isset($args['date_fin'])) {
    //         $date_debut = DateTime::createFromFormat('d/m/Y', $args['date_debut']);
    //         $date_fin = DateTime::createFromFormat('d/m/Y', $args['date_fin']);

    //         if ($date_debut) $date_debut = $date_debut->format('Y-m-d');
    //         if ($date_fin) $date_fin = $date_fin->format('Y-m-d');

    //         $query = $query->whereBetween('date', [$date_debut, $date_fin]);
    //     }

    //     if (isset($args['personnel_id'])) {
    //         $query = $query->where('personnel_id', $args['personnel_id']);
    //     }

    //     $pointages = $query->orderBy('personnel_id')->get();

    //     $heureReference = new DateTime('08:30');
    //     $totalParPersonnel = [];
    //     $tempsBureauParPersonnel = [];

    //     foreach ($pointages as $pointage) {
    //         $personnelId = $pointage->personnel_id;

    //         if (!isset($totalParPersonnel[$personnelId])) {
    //             $totalParPersonnel[$personnelId] = 0;
    //         }

    //         if (!isset($tempsBureauParPersonnel[$personnelId])) {
    //             $tempsBureauParPersonnel[$personnelId] = 0;
    //         }

    //         // ➤ Calcul du retard
    //         if ($pointage->heure_arrive) {
    //             $heureArrivee = new DateTime($pointage->heure_arrive);
    //             $minutesRetard = ($heureArrivee > $heureReference) ?
    //                 ($heureReference->diff($heureArrivee)->h * 60 + $heureReference->diff($heureArrivee)->i)
    //                 : 0;
    //         } else {
    //             $minutesRetard = 0;
    //         }

    //         $pointage->temps_retard = sprintf('%02d:%02d', floor($minutesRetard / 60), $minutesRetard % 60);
    //         $totalParPersonnel[$personnelId] += $minutesRetard;
    //         $pointage->total_temps_retard = sprintf('%02d:%02d', floor($totalParPersonnel[$personnelId] / 60), $totalParPersonnel[$personnelId] % 60);

    //         // ➤ Calcul du temps passé au bureau
    //         if ($pointage->heure_arrive && $pointage->heure_depart) {
    //             $heureArrivee = new DateTime($pointage->heure_arrive);
    //             $heureDepart = new DateTime($pointage->heure_depart);

    //             if ($heureDepart > $heureArrivee) {
    //                 $interval = $heureArrivee->diff($heureDepart);
    //                 $minutesBureau = $interval->h * 60 + $interval->i;
    //             } else {
    //                 $minutesBureau = 0;
    //             }
    //         } else {
    //             $minutesBureau = 0;
    //         }

    //         $tempsBureauParPersonnel[$personnelId] += $minutesBureau;
    //         $pointage->temps_au_bureau = sprintf('%02d:%02d', floor($minutesBureau / 60), $minutesBureau % 60);
    //         // $pointage->total_temps_au_bureau = sprintf('%02d:%02d', floor($tempsBureauParPersonnel[$personnelId] / 60), $tempsBureauParPersonnel[$personnelId] % 60);
    //     }

    //     return $pointages;
    // }




    public static function forDemandeAbsence($root, $args, $query)
    {
        // dd($args);
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                  '='],
                ['motif',            'like'],
                ['employe_id',          '='],

            ]
        );

        if (isset($args['date_debut']) && isset($args['date_fin'])) {
            $date_debut = DateTime::createFromFormat('d/m/Y', $args['date_debut']);
            if ($date_debut) {
                $date_debut = $date_debut->format('Y-m-d');
            }
            $date_fin = DateTime::createFromFormat('d/m/Y', $args['date_fin']);
            if ($date_fin) {
                $date_fin   = $date_fin->format('Y-m-d');
            }

            $query = $query
                ->where('date_debut', '>=', $date_debut)
                ->where('date_fin', '<=', $date_fin);
        }


        if (!empty($args['date_debut']) && !empty($args['date_fin']) && !empty($args['date_mode'])) {
            $dateDebut = $args['date_debut'];
            $dateFin = $args['date_fin'];
            $dateMode = $args['date_mode'];

            if (in_array($dateMode, ['debut', 'creation'])) {
                $champ = $dateMode === 'debut' ? 'date_debut' : 'created_at';
                $query->whereBetween($champ, [$dateDebut, $dateFin]);
                // dd($query->toSql(), $query->getBindings());

            }

            // Pour tester :
        }



        if (isset($args['heure_debut']) && isset($args['heure_fin'])) {
            $heure_debut = $args['heure_debut'];
            $heure_fin = $args['heure_fin'];


            $query = $query->where('heure_debut', '>=', $heure_debut)
                ->where('heure_fin', '<=', $heure_fin);
        }





        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forContact($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                     '='],
                ['nom',                 'like'],

            ]
        );

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forCanal($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                     '='],
                ['nom',                 'like'],
                ['type_projet_id',         '='],
                ['status',                 '='],
            ]
        );

        if (isset($args['search'])) {
            $motRecherche  = $args['search'];
            $query = $query->where(function ($query) use ($motRecherche) {
                return $query->where('nom', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%');
            });
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forDevise($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['taux_change',              '='],
                ['devise_base',              '='],
                ['signe',                    '='],
            ]
        );

        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%')
                ->orWhere(function ($subquery) use ($search) {
                    $subquery->where('signe', Outil::getOperateurLikeDB(), '%' . $search . '%')
                        ->orWhere('cours', Outil::getOperateurLikeDB(), $search)
                        ->orWhere('unite', Outil::getOperateurLikeDB(), $search)
                        ->orWhere('precision', Outil::getOperateurLikeDB(), $search)
                        ->orWhere('taux_change', Outil::getOperateurLikeDB(), $search)
                    ;
                });
        }

        if (isset($args['ordre_transit_id'])) {
            $res = OrdreTransitFf::query()->where('ordre_transit_id', $args['ordre_transit_id'])->whereNotNull('devise_id')->pluck('devise_id');
            if (count($res) > 0) {
                $query->whereIn('id', $res);
            }
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forDossier($root, $args, $query)
    {
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }


    public static function forFournisseur($root, $args, $query)
    {
        if (isset($args['article_facturation_id'])) {
            $query->whereRaw("id in (select fournisseur_id from fournisseur_article_facturations where article_facturation_id={$args['article_facturation_id']})");
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forGroupePermission($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                   '='],
                ['name',              'like'],
                ['display_name',      'like']
            ]
        );

        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('name', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }

        $query->has('permissions', '>', 0);

        $query->orderBy('name');

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }


    public static function forModalitePaiement($root, $args, $query)
    {
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    // public static function forModele($root, $args, $query)
    // ..

    // public static function forModePaiement($root, $args, $query)
    // ..

    // public static function forNavire($root, $args, $query)
    // ..

    public static function forModule($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                      '='],
                ['title',                'like'],
                ['icon',                 'like'],
                ['description',          'like'],
                ['order',                   '='],
                ['module_id',               '='],
                ['mode_link_id',            '='],
            ]
        );
        $optionals = ['order' => true, 'column_order' => 'order'];

        return self::getQueryOrQueryPaginated($root, $args, $query, $optionals);
    }


    //public static function forNomenclatureDouaniere($root, $args, $query)
    // ..


    // public static function forNomenclatureClient($root, $args, $query)
    // ..


    public static function forNotif($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                             '='],
                ['message',                     'like'],
                ['link',                        'like'],
            ]
        );

        if (isset($args['search'])) {
            $query = $query->where('message', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%')
                ->orWhere('link', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%');
        }
        if (isset($args['date_start']) && isset($args['date_end'])) {
            $from = $args['date_start'];
            $to = $args['date_end'];

            // Eventuellement la date fr
            $from = (strpos($from, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d') : $from;
            $to = (strpos($to, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d') : $to;

            $from = date($from . ' 00:00:00');
            $to = date($to . ' 23:59:59');

            $query->whereBetween('created_at', array($from, $to));
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forNotifPermUser($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                                   '='],
                ['notif_id',                             '='],
                ['permission_id',                        '='],
                ['user_id',                              '='],
                ['role_id',                              '='],
                ['view',                                 '='],

            ]
        );

        if (isset($args['date_start']) && isset($args['date_end'])) {
            $from = $args['date_start'];
            $to = $args['date_end'];

            // Eventuellement la date fr
            $from = (strpos($from, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d') : $from;
            $to = (strpos($to, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d') : $to;

            $from = date($from . ' 00:00:00');
            $to = date($to . ' 23:59:59');

            $query->whereBetween('created_at', array($from, $to));
        }

        if (Auth::user()) {
            $query->where('user_id', Auth::user()->id)->where('view', false);
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }
    public static function forDetailsPointage($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['date_debut',                        '='],
                ['date_fin',                           '='],

            ]
        );

        if (isset($args['date_start']) && isset($args['date_end']) || isset($args['date_debut']) && isset($args['date_fin'])) {
            $from = $args['date_start'];
            $to = $args['date_end'];

            // Eventuellement la date fr
            $from = (strpos($from, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d') : $from;
            $to = (strpos($to, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d') : $to;

            

          
            $query->whereBetween('date', array($from, $to));

        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }



    public static function forNiveauHabilite($root, $args, $query)
    {
        if (Auth::user()) {
            // $query->where('user_id', Auth::user()->id)->where('view', false);
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forOrdreTransit($root, $args, $query)
    {
        // Pour n'avoir accès qu'aux données de l'entreprise
        if (Auth::user() && isset(Auth::user()->client_id)) {
            $query->where("client_id", Auth::user()->client_id);
        }
        $can_do =  true;
        if (isset($args['skip_dossier']) && $args['skip_dossier'] === true) {
            $can_do =  false;
        }
        if ($can_do) {
            $query->whereRaw("(select count(dossiers.id) from dossiers where ordre_transit_id = ordre_transits.id) = 0");
        }
        $query->orderBy("id", 'desc');
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forPage($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                      '='],
                ['title',                'like'],
                ['icon',                 'like'],
                ['description',          'like'],
                ['order',                   '='],
                ['module_id',               '='],
                ['link',                 'like'],
                ['permissions',          'like'],
                ['can_be_managed',          '='],
            ]
        );

        if (isset($args['autre'])) {
            if ($args['autre'] == 1) {
                $query = $query->whereNull('module_id');
            } else {
                $query = $query->whereNotNull('module_id');
            }
        }

        $optionals = ['order' => true, 'column_order' => 'order'];

        return self::getQueryOrQueryPaginated($root, $args, $query, $optionals);
    }

    // public static function forPort($root, $args, $query)
    // ..

    public static function forPermission($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                   '='],
                ['name',              'like'],
                ['display_name',      'like']
            ]
        );

        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('name', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }

        // Pour n'avoir accès qu'aux permissions de ses profils
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            $query->whereRaw("id in (select role_has_permissions.permission_id from model_has_roles, role_has_permissions where model_has_roles.model_id={$user_id} and model_has_roles.role_id=role_has_permissions.role_id)");
        }

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forPreference($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                       '='],
                ['nom',                   'like'],
                ['display_name',          'like'],
                ['valeur',                'like'],
                ['description',           'like'],
            ]
        );

        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        $query->orderBy("id", 'asc');
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }
    public static function forPay($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                       '='],
                ['nom',                   'like'],
                ['display_name',          'like'],

            ]
        );

        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        $query->orderBy("id", 'asc');
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }




    // public static function forRegime($root, $args, $query)
    // ..


    public static function forRole($root, $args, $query)
    {
        // Pour n'avoir accès qu'aux profils dont toutes les permissions existent bel et bien dans la liste
        // des permissions du client
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            $query->whereRaw("
                (select count(*) from role_has_permissions where role_has_permissions.role_id=roles.id and role_has_permissions.permission_id NOT IN (select role_has_permissions.permission_id from model_has_roles, role_has_permissions where model_has_roles.model_id={$user_id} and model_has_roles.role_id=role_has_permissions.role_id)) = 0
            ");
        }

        $query->orderBy("id", 'asc');
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forTypeClient($root, $args, $query)
    {
        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forTag($root, $args, $query)
    {
        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forTypeTache($root, $args, $query)
    {
        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forCategorieDepense($root, $args, $query)
    {
        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forTypeDepense($root, $args, $query)
    {
        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forPriorite($root, $args, $query)
    {
        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where('nom', Outil::getOperateurLikeDB(), '%' . $search . '%');
        }
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forTypeProjet($root, $args, $query)
    {
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forSecteurActivite($root, $args, $query)
    {
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forTypeDossier($root, $args, $query)
    {
        Outil::addWhereToModel(
            $query,
            $args,
            [
                ['id',                       '='],
                ['show_for_client',          '='],
            ]
        );
        // Pour n'avoir accès qu'aux données de l'entreprise
        if (Auth::user() && isset(Auth::user()->client_id) && Auth::user()->client->type_dossiers()->count() > 0) {
            $query->whereIn("id", Auth::user()->client->type_dossiers()->get(['type_dossiers.id'])->pluck('id')->toArray());
        }

        if (isset($args['client_id'])) {
            $client = Client::query()->find($args['client_id']);
            if (isset($client)) {
                if ($client->type_dossiers()->count() > 0) {
                    $query->whereIn("id", $client->type_dossiers()->get(['type_dossiers.id'])->pluck('id')->toArray());
                }
            }
        }

        $query->orderBy("id", 'asc');
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }



    public static function forTypePermission($root, $args, $query)
    {
        $query->orderBy('id');

        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forTypeTransport($root, $args, $query)
    {
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }

    // public static function forUniteMesure($root, $args, $query)
    // ..

    public static function forVehicule($root, $args, $query)
    {
        //$query->where('type_marchandise_id', 2);

        $query = $query->whereRaw("(select type from type_marchandises  where marchandises.type_marchandise_id=type_marchandises.id ) = 2");

        if (isset($args['search'])) {
            $motRecherche  = $args['search'];
            $query = $query->where(function ($query) use ($motRecherche) {
                return $query->where('nom', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%')
                    ->orWhere('immatriculation', Outil::getOperateurLikeDB(), '%' . $motRecherche . '%');
            });
        }
        if (isset($args['type_marchandise_id'])) {
            $query = $query->where('type_marchandise_id', $args['type_marchandise_id']);
        }
        if (isset($args['nomenclature_douaniere_id'])) {
            $query = $query->where('nomenclature_douaniere_id', $args['nomenclature_douaniere_id']);
        }
        if (isset($args['marque_id'])) {
            $query = $query->where('marque_id', $args['marque_id']);
        }
        if (isset($args['modele_id'])) {
            $query = $query->where('modele_id', $args['modele_id']);
        }
        if (isset($args['energie_id'])) {
            $query = $query->where('energie_id', $args['energie_id']);
        }
        return  self::getQueryOrQueryPaginated($root, $args, $query);
    }

    public static function forUser($root, $args, $query)
    {

        // Pour n'avoir accès qu'aux données de l'entreprise
        if (Auth::user() && isset(Auth::user()->client_id)) {
            $query->where("client_id", Auth::user()->client_id);
        }

        $query->orderBy("id", 'asc');
        //dd($query->toSql());
        return self::getQueryOrQueryPaginated($root, $args, $query);
    }
}
