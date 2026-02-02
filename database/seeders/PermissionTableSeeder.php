<?php

namespace Database\Seeders;

use App\Models\{User, TypePermission, GroupePermission, GroupeTypePermission};
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    private $functionCall;

    public function __construct()
    {
        $this->functionCall = DatabaseSeeder::functionCall();
    }

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $groupePermissions =
        [
            // BACKOFFICE
            [
                "name" => "Modalités de paiement",
                "tag" => "modalitepaiement",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des modalités de paiement"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer une modalité de paiement"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une modalité de paiement"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une modalité de paiement"),
                ],
            ],
            [
                "name" => "Modes de paiement",
                "tag" => "modepaiement",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des modes de paiement"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un mode de paiement"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un mode de paiement"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un mode de paiement"),
                ],
            ],
            [
                "name" => "Personnels",
                "tag" => "personnel",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des personnels"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un personnel"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un personnel"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un personnel"),
                ],
            ],
            [
                "name" => "Noyaux de guindy",
                "tag" => "noyauxinterne",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des noyaux de guindy"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un noyau de guindy"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un noyau de guindy"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un noyau de guindy"),
                ],
            ],

            [
                "name"  => "Contact",
                "tag"   => "contact",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des contacts"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un contact"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un contact"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un contact"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un contact"),
                ],
            ],

            [
                "name"=> "notification",
                "tag"=> "notification",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des notifications"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une notification"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une notification"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une notification"),
                ],
            ],
            [
                "name"=> "pointage",
                "tag"=> "pointage",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des pointages"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un pointage"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un pointage"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un pointage"),
                ],
            ],

            [
                "name"=> "evenement",
                "tag"=> "evenement",
                "permissions"=>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des événements"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un événement"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un événement"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un événement"),
                ],
            ],
            [
                "name"=> "mesure",
                "tag"=> "mesure",
                "permissions"=>
                [
                    array("name"=> "liste", "couleur"=> "primary", "display_name"=> "Voir la liste des mesures"),
                    array("name"=> "creation", "couleur"=> "success", "display_name"=> "Créer une mesure"),
                    array("name"=> "modification", "couleur"=> "warning", "display_name"=> "Modifier une mesure"),
                    array("name"=> "suppression", "couleur"=> "danger", "display_name"=> "Supprimer une mesure"),
                    array("name"=> "detail", "couleur"=> "info", "display_name"=> "Voir les détails d'une mesure"),
                ]
            ],
            [
                "name"=> "gravite",
                "tag"=> "gravite",
                "permissions"=>
                [
                    array("name"=> "liste", "couleur"=> "primary", "display_name"=> "Voir la liste des gravites"),
                    array("name"=> "creation", "couleur"=> "success", "display_name"=> "Créer une gravite"),
                    array("name"=> "modification", "couleur"=> "warning", "display_name"=> "Modifier une gravite"),
                    array("name"=> "suppression", "couleur"=> "danger", "display_name"=> "Supprimer une gravite"),
                    array("name"=> "detail", "couleur"=> "info", "display_name"=> "Voir les détails d'une gravite"),
                ]
            ],
            [
                "name" => "Pays",
                "tag" => "pays",
                "permissions" =>
                [
                    //array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des types de conteneurs"),
                    //array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un type de conteneur"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un type de conteneur"),
                    //array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un type de conteneur"),
                ],
            ],
            [
                "name" => "Modèles",
                "tag" => "modele",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des modèles"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un modèle"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un modèle"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un modèle"),
                ],
            ],

            [
                "name" => "Types de client",
                "tag" => "typeclient",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des types de client"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un type de client"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un type de client"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un type de client"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un type de client"),
                ],
            ],
            [
                "name" => "Types de projet",
                "tag" => "typeprojet",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des types de projet"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un type de projet"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un type de projet"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un type de projet"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un type de projet"),
                ],
            ],

            [
                "name" => "Types de tâche",
                "tag" => "typetache",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des types de tâche"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un type de tâche"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un type de tâche"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un type de tâche"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un type de tâche"),
                ],
            ],

            [
                "name" => "Tag",
                "tag" => "tag",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des types de tâche"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un tag"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un tag"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un tag"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un tag"),
                ],
            ],

            [
                "name"  => "entre de caisse",
                "tag"   => "entrecaisse",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des entr de caisse"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une  entre de caisse"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une  entre de caisse"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une entre  de caisse"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une entre  de caisse"),
                ],
            ],

            [
                "name"  => "caisse",
                "tag"   => "caisse",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des caisses"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une caisse"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une caisse"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une caisse"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une caisse"),
                ],
            ],
            [
                "name"  => "sortie de caisse",
                "tag"   => "sortiecaisse",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des sorties de caisse"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une sortie de caisse"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une sortie de caisse"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une sortie de caisse"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une sortie de caisse"),
                ],

            ],


            [
                "name" => "Motif entre/sortie de caisse",
                "tag" => "motifentresortiecaisse",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des motifs d'entrée/sortie de caisse"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un motif d'entrée/sortie de caisse"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un motif d'entrée/sortie de caisse"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un motif d'entrée/sortie de caisse"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un motif d'entrée/sortie de caisse"),
                ],
               
            ],
           
            [
                "name"  => "Dépenses",
                "tag"   => "depense",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des dépenses"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une dépense"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une dépense"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une dépense"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une dépense"),
                ],
            ],

            [
                "name" => "Types de dépense",
                "tag" => "typedepense",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des types de dépense"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un type de dépense"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un type de dépense"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un type de dépense"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un type de dépense"),
                ],
            ],

            [
                "name" => "Catégorie de dépense",
                "tag" => "categoriedepense",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des catégories de dépense"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une catégorie de dépense"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une catégorie de dépense"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une catégorie de dépense"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une catégorie de dépense"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une catégorie de dépense"),
                ],
            ],

            [
                "name" => "Priorité",
                "tag" => "priorite",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des priorités"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une priorité"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une priorité"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une priorité"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une priorité"),
                ],
            ],

            [
                "name" => "Assistance",
                "tag" => "assistance",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des assistances"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une assistance"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une assistance"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une assistance"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une assistance"),
                ],
            ],

            [
                "name" => "Secteur d'activité",
                "tag" => "secteuractivite",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des types de projet"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un secteur d'activité"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un secteur d'activité"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un secteur d'activité"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un secteur d'activité"),
                ],
            ],


            [
                "name" => "Projets",
                "tag" => "projet",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des projets"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un projet"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un projet"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un projet"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un projet"),
                    array("name" => "statut", "couleur" => "primary", "display_name" => "Activer/Désactiver un projet"),
                ],
            ],

            [
                "name" => "Canaux",
                "tag" => "canal",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des canaux"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un canal"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un canal"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un canal"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un canal"),
                    array("name" => "statut", "couleur" => "primary", "display_name" => "Activer/Désactiver un canal"),
                ],
            ],

            [
                "name"  => "Canaux slack",
                "tag"   => "canalslack",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des canaux slack"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un canal slack"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un canal slack"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un canal slack"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un canal slack"),
                    array("name" => "statut", "couleur" => "primary", "display_name" => "Activer/Désactiver un canal slack"),
                ],
            ],

            [
                "name"  =>"Departements",
                "tag"   => "departement",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des départements"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un département"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un département"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un département"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un département"),
                    array("name" => "statut", "couleur" => "primary", "display_name" => "Activer/Désactiver un département"),
                ],
            ],

            [
                "name" => "Clients de la société",
                "tag" => "client",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des clients"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer un client"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier un client"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer un client"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'un client"),
                    array("name" => "statut", "couleur" => "primary", "display_name" => "Activer/Désactiver un client"),
                ],
            ],


            //DASHBOARD

            [
                "name" => "Dashboard",
                "tag" => "dashboard",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir le dashboard"),
                ],
            ],

            // OUTILS ADMIN
            [
                "name" => "Préferences",
                "tag" => "preference",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des préférences"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier les préférences un profil"),
                ],
            ],
            [
                "name" => "Profils",
                "tag" => "role",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des profils", "for_client" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un profil", "for_client" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un profil", "for_client" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un profil", "for_client" => true),
                ],
            ],
            [
                "name" => "Niveaux d'habilitation",
                "tag" => "niveauhabilite",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des niveaux d'habilitation"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un niveau d'habilitation"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un niveau d'habilitation"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un niveau d'habilitation"),
                ],
            ],
            [
                "name" => "Demande  d'absence",
                "tag" => "demandeabsence",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste demande d'absence"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer une demande d'absence"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une demande d'absence"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une demande d'absence"),
                ],
            ],
            [
                "name"  => "Newsletters",
                "tag"   => "newsletter",
                "permissions" =>
                [
                    array("name" => "liste", "couleur" => "primary", "display_name" => "Voir la liste des newsletters"),
                    array("name" => "creation", "couleur" => "success", "display_name" => "Créer une newsletter"),
                    array("name" => "modification", "couleur" => "warning", "display_name" => "Modifier une newsletter"),
                    array("name" => "suppression", "couleur" => "danger", "display_name" => "Supprimer une newsletter"),
                    array("name" => "detail", "couleur" => "info", "display_name" => "Voir les détails d'une newsletter"),
                ],
            ],
            [
                "name" => "Avance sur salaire",
                "tag" => "avancesalaire",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste avance sur salaire"),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer une avance sur salaire"),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une avance sur salaire"),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une avance sur salaire"),
                ],
            ],
            [
                "name" => "Utilisateurs",
                "tag" => "user",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des utilisateurs", "for_client" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un utilisateur", "for_client" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un utilisateur", "for_client" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un utilisateur", "for_client" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un utilisateur", "for_client" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'un utilisateur", "for_client" => true),
                ],
            ],
            [
                "name" => "Rapport assistance",
                "tag" => "rapportassistance",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des rapports", "for_rapport" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un rapports", "for_rapport" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un rapports", "for_rapport" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un rapports", "for_rapport" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un rapports", "for_rapport" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'un rapports", "for_rapport" => true),
                ],
            ],
            [
                "name" => "Propection",
                "tag" => "prospection",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des prospections", "for_prospection" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "Créer un prospections", "for_prospection" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier un prospections", "for_prospection" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer un prospections", "for_prospection" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un prospections", "for_prospection" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'un prospections", "for_prospection" => true),
                ],
            ],
            [
                "name" => "Gestion Projet",
                "tag" => "gestionprojet",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des gestions de projets", "for_gestionprojet" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "faire une gestion projets", "for_gestionprojet" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une gestion projets", "for_gestionprojet" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une gestion deprojets", "for_gestionprojet" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un gestionprojets", "for_gestionprojet" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'une gestion de projets", "for_gestionprojet" => true),
                ],
            ],
            [
                "name" => "Fonctionnalité",
                "tag" => "fonctionnalite",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des gfonctionnalites", "for_fonctionnalite" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "faire une fonctionnalite", "for_fonctionnalite" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une fonctionnalite", "for_fonctionnalite" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une fonctionnalite", "for_fonctionnalite" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un fonctionnalites", "for_fonctionnalite" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'une fonctionnalite", "for_fonctionnalite" => true),
                ],
            ],
            [
                "name" => "Tache",
                "tag" => "tache",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des taches", "for_tache" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "faire une tache", "for_tache" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une tache", "for_tache" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une tache", "for_tache" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un taches", "for_tache" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'une tache", "for_tache" => true),
                ],
            ],

            [
                "name" => "Tache Personnel",
                "tag" => "tacheassigne",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des taches personnelles", "for_tacheassigne" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "faire une tache personnelle", "for_tacheassigne" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une tache personnelle", "for_tacheassigne" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une tache personnelle", "for_tacheassigne" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'une tache personnelle", "for_tacheassigne" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'une tache personnelle", "for_tacheassigne" => true),
                ],
            ],
            [
                "name" => "Planification",
                "tag" => "planification",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des planifications", "for_planification" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "faire une planification", "for_planification" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une planification", "for_planification" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une planification", "for_planification" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un planifications", "for_planification" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'une planification", "for_planification" => true),
                ],
            ],
            [
                "name" => "Tache Projet",
                "tag" => "tacheprojet",
                "permissions" =>
                [
                    array("name" => "liste" , "couleur" => "primary" , "display_name" => "Voir la liste des taches du projet", "for_tacheprojet" => true),
                    array("name" => "creation" , "couleur" => "success" , "display_name" => "faire une tache projet", "for_tache projet" => true),
                    array("name" => "modification" , "couleur" => "warning" , "display_name" => "Modifier une tache projet", "for_tacheprojet" => true),
                    array("name" => "suppression" , "couleur" => "danger" , "display_name" => "Supprimer une tache projet", "for_tacheprojet" => true),
                    array("name" => "statut" , "couleur" => "primary" , "display_name" => "Activer/Désactiver le compte d'un tache projets", "for_tacheprojet" => true),
                    array("name" => "detail" , "couleur" => "info" , "display_name" => "Voir les détails d'une tache projet", "for_tacheprojet" => true),
                ],
            ],
        ];


        foreach ($groupePermissions as $groupePermission)
        {
            $getGroupePermission = GroupePermission::{$this->functionCall}([
                'tag' => $groupePermission['tag']
            ],
            [
                'name' => $groupePermission['name']
            ]);

            foreach ($groupePermission['permissions'] as $permission)
            {
                $typePermission = TypePermission::firstOrCreate([
                    'name' => $permission['name']
                ],
                [
                    'couleur' => $permission['couleur'] ?? "primary"
                ]);

                $namePermission = $permission['name'] . "-" . $getGroupePermission->tag;
                $newitem = Permission::where('name', $namePermission)->first();
                if (!isset($newitem))
                {
                    $newitem = new Permission();
                }
                $newitem->name = $namePermission;
                $newitem->display_name = $permission['display_name'];
                $newitem->for_client = $permission['for_client'] ?? false;
                $newitem->type_permission_id = $typePermission->id;
                $newitem->groupe_permission_id = $getGroupePermission->id;
                $newitem->save();

            }
        }

        $permissions = [
            // array('type_permission' => 'activer',             "name" => "activer-prestataire",                    "guard_name" => "web", "display_name" => "Activer un prestataire"),
            // array('type_permission' => 'desactiver',          "name" => "desactiver-prestataire",                 "guard_name" => "web", "display_name" => "Desactiver un prestataire "),
            // array('type_permission' => 'activer',             "name" => "activer-client",                         "guard_name" => "web", "display_name" => "Activer un client"),
            // array('type_permission' => 'desactiver',          "name" => "desactiver-client",                      "guard_name" => "web", "display_name" => "Desactiver un client "),
        ];

        foreach ($permissions as $permission)
        {
            Permission::firstOrCreate([
                'name' => $permission['name']
            ],
            [
                'display_name' => $permission['name']
            ]);
        }


        /**
         * Roles / Profils
         */
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super admin'
        ]);

        $superAdminRole->syncPermissions(Permission::all());

        $clientRole = Role::firstOrCreate([
            'name' => 'client'
        ]);

        $clientRole->syncPermissions(Permission::query()->where('for_client',true)->get());




        /**
         * Utilisateurs
         */
        $users = array();
        array_push($users, array("name" => "GUINDY MN", "email" => "root@guindytechnology.com", "image" => ('assets/media/logos/logo.svg'), "password" => "rootGT@2025"));
        array_push($users, array("name" => "GUINDY", "email" => "guindytechnology@gmail.com", "image" => ('assets/media/logos/logo.svg'), "password" => "guindyGT@2025"));

        foreach ($users as $user)
        {
            $newitem = User::{$this->functionCall}([
                'email' => $user['email']
            ],
            [
                'name'      => $user['name'],
                'password'  => $user['password'],
                'image'     => $user['image'],
            ]);
            $newitem->syncRoles($superAdminRole);
        }
    }
}
