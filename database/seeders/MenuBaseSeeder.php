<?php

namespace Database\Seeders;

use App\Models\{LinkRouteController, ModeLink, Module, Page};
use Illuminate\Database\Seeder;

class MenuBaseSeeder extends Seeder
{
    private $modules;
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
        $functionCall = "updateOrCreate";
        if (config('app.env') === 'production')
        {
            $functionCall = "firstOrCreate";
        }

        $mode_links = array();
        array_push($mode_links, array("nom" => "liste-view", "description" => ""));
        array_push($mode_links, array("nom" => "liste-card", "description" => ""));
        array_push($mode_links, array("nom" => "card-view", "description" => ""));
        foreach ($mode_links as $item)
        {
            $new_mode_link = ModeLink::$functionCall([
                'nom' => $item['nom']
            ], [
                'description' => $item['description'],
            ]);
        }

        /**
         * Modules
         */
        $this->modules = [
            [
                "title"       => "Dashboard",
                "title_en"    => "Dashboard",
                "icon"        => "icon-dashboard",
                "description" => null,
                "order"       => 1,
                "mode_link"   => "card-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Dashboard",
                        "title_en"    => "Dashboard",
                        "icon"        => "icon-dashboard",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/dashboard",
                        "permissions" => ["dashboard"],
                    ]
                ]
            ],
            [
                "title"       => "Backoffice",
                "title_en"    => "Backoffice",
                "icon"        => "icon-back-office",
                "description" => null,
                "order"       => 2,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Priorités",
                        "title_en"    => "Priority",
                        "icon"        => "icon-priorite",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/list-priorite",
                        "permissions" => ["priorite"],
                    ],
                    [
                        "title"       => "Tags",
                        "title_en"    => "Tag",
                        "icon"        => "icon-tag",
                        "description" => null,
                        "order"       => 2,
                        "link"        => "#!/list-tag",
                        "permissions" => ["tag"],
                    ],

                    [
                        "title"       => "Types de tâche",
                        "title_en"    => "Type of task",
                        "icon"        => "icon-typetache",
                        "description" => null,
                        "order"       => 3,
                        "link"        => "#!/list-typetache",
                        "permissions" => ["typetache"],
                    ],
                    [
                        "title"       => "Contacts",
                        "title_en"    => "Contact",
                        "icon"        => "icon-contact",
                        "description" => null,
                        "order"       => 4,
                        "link"        => "#!/list-contact",
                        "permissions" => ["contact"],
                    ],
                    [
                        "title"       => "Contacts Site",
                        "title_en"    => "Contact Site",
                        "icon"        => "icon-contact",
                        "description" => null,
                        "order"       => 5,
                        "link"        => "#!/list-contactsite",
                        "permissions" => ["contact"],
                    ],
                    [
                        "title"       => "Newsletters",
                        "title_en"    => " Newsletter",
                        "icon"        => "icon-email",
                        "description" => null,
                        "order"       => 6,
                        "link"        => "#!/list-newsletter",
                        "permissions" => ["newsletter"],
                    ],
               

                    [
                        "title"       => "Secteurs d'activité",
                        "title_en"    => "Activity field",
                        "icon"        => "icon-secteuractivite",
                        "description" => null,
                        "order"       => 7,
                        "link"        => "#!/list-secteuractivite",
                        "permissions" => ["secteuractivite"],
                    ],
                    
                    [
                        "title"       => "Noyaux Guindy",
                        "title_en"    => "Guindy Cores",
                        "icon"        => "icon-pays",
                        "description" => null,
                        "order"       => 8,
                        "link"        => "#!/list-noyauxinterne",
                        "permissions" => ["noyauxinterne"],
                    ],
                    [
                        "title"       => "Modalités de paiement",
                        "title_en"    => "Terms of payment",
                        "icon"        => "icon-modalitepaiement",
                        "description" => null,
                        "order"       => 9,
                        "link"        => "#!/list-modalitepaiement",
                        "permissions" => ["modalitepaiement"],
                    ],
                    [
                        "title"       => "Modes de paiement",
                        "title_en"    => "Methods of payment",
                        "icon"        => "icon-modepaiement",
                        "description" => null,
                        "order"       => 10,
                        "link"        => "#!/list-modepaiement",
                        "permissions" => ["modepaiement"],
                    ],

                    [
                        "title"       => "Pays",
                        "title_en"    => "Countries",
                        "icon"        => "icon-pays",
                        "description" => null,
                        "order"       => 11,
                        "link"        => "#!/list-pays",
                        "permissions" => ["pays"],
                    ],

                    [
                        "title"       => "Canals",
                        "title_en"    => "Channels",
                        "icon"        => "icon-sav",
                        "description" => null,
                        "order"       => 12,
                        "link"        => "#!/list-canal",
                        "permissions" => ["canal", "canalslack"],
                    ],

                    [
                        "title"       => "Motifs Entre/Sortie de caisse",
                        "title_en"    => "Category/Type of spent",
                        "icon"        => "icon-categoriedepense",
                        "description" => null,
                        "order"       => 13,
                        "link"        => "#!/list-motifentresortiecaisse",
                        "permissions" => ["entrecaisse","sortiecaisse"],
                    ],

                    [
                        "title"       => "Types de client",
                        "title_en"    => "Customer types",
                        "icon"        => "icon-typeclient",
                        "description" => null,
                        "order"       => 14,
                        "link"        => "#!/list-typeclient",
                        "permissions" => ["typeclient"],
                    ],

                    [
                        "title"       => "Types de projet",
                        "title_en"    => "Project types",
                        "icon"        => "icon-projet",
                        "description" => null,
                        "order"       => 15,
                        "link"        => "#!/list-typeprojet",
                        "permissions" => ["typeprojet"],
                    ],
                    [
                        "title"       => "Departements",
                        "title_en"    => "Departement",
                        "icon"        => "icon-projet",
                        "description" => null,
                        "order"       => 16,
                        "link"        => "#!/list-departement",
                        "permissions" => ["departement"],
                    ],
                    [
                        "title"       => "Fonctionnalités",
                        "title_en"    => "Fonctionnality",
                        "icon"        => "icon-fonction",
                        "description" => null,
                        "order"       => 17,
                        "link"        => "#!/list-fonctionnalite",
                        "permissions" => ["fonctionnalite"],
                    ],
                    [
                        "title"       => "Taches",
                        "title_en"    => "Tasks",
                        "icon"        => "icon-task",
                        "description" => null,
                        "order"       => 18,
                        "link"        => "#!/list-tache",
                        "permissions" => ["tache"],
                    ],
                    [
                        "title"       => "Mesures / gravites",
                        "title_en"    => "Measure / gravite",
                        "icon"        => "icon-mesure",
                        "description" => null,
                        "order"       => 18,
                        "link"        => "#!/list-mesure",
                        "permissions" => ["mesure","gravite"],
                    ],
                   




                ]
            ],

            [
                "title"       => "Gestion Projets",
                "title_en"    => "Management Projects",
                "icon"        => "icon-gestionprojet",
                "description" => null,
                "order"       => 3,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Projets",
                        "title_en"    => "Projects",
                        "icon"        => "icon-projet",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/list-gestionprojet",
                        "permissions" => ["gestionprojet"],
                    ],
                    [
                        "title"       => "Planifications",
                        "title_en"    => "Planing",
                        "icon"        => "icon-planification",
                        "description" => null,
                        "order"       => 2,
                        "link"        => "#!/list-planification",
                        "permissions" => ["planification"],
                    ],
                    [
                        "title"       => "Taches assignées",
                        "title_en"    => "Assigned Tasks",
                        "icon"        => "icon-planification",
                        "description" => null,
                        "order"       => 3,
                        "link"        => "#!/list-tacheprojet",
                        "permissions" => ["personnel"],
                    ],

                
                ]
            ],
            [
                "title"       => "Clients",
                "title_en"    => "Customers",
                "icon"        => "icon-client",
                "description" => null,
                "order"       => 4,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Clients",
                        "title_en"    => "Customers",
                        "icon"        => "icon-client",
                        "description" => null,
                        "order"       => 0,
                        "link"        => "#!/list-client",
                        "permissions" => ["client"],
                    ],

                
                ]
            ],
            [
                "title"       => "Projets",
                "title_en"    => "Projects",
                "icon"        => "icon-projet",
                "description" => null,
                "order"       => 5,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Projets",
                        "title_en"    => "Projects",
                        "icon"        => "icon-projet",
                        "description" => null,
                        "order"       => 0,
                        "link"        => "#!/list-projet",
                        "permissions" => ["projet"],
                        "modules"     => [],
                        "pages"       =>[]
        
                    ],
                 
                ]
            ],


            [
                "title"       => "SAV",
                "title_en"    => "SAV",
                "icon"        => "icon-sav",
                "description" => null,
                "order"       => 6,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Assistances",
                        "title_en"    => "Assistance",
                        "icon"        => "icon-sav",
                        "description" => null,
                        "order"       => 0,
                        "link"        => "#!/list-assistance",
                        "permissions" => ["assistance"],
                    ],
                    [
                        "title"       => "Rapports d'assistance",
                        "title_en"    => "Reports of Assistance",
                        "icon"        => "icon-rapportassistance",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/list-rapportassistance",
                        "permissions" => ["rapportassistance"],
                    ],

                    // [
                    //     "title"       => "Test qualité",
                    //     "title_en"    => "Test quality",
                    //     "icon"        => "icon-sav",
                    //     "description" => null,
                    //     "order"       => 2,
                    //     "link"        => "#!/list-testqualite",
                    //     "permissions" => ["testqualite"],
                    // ],
                ]
            ],

            [
                "title"       => "Gestion Commerciale",
                "title_en"    => "commercial management",
                "icon"        => "icon-gestioncommerciale",
                "description" => null,
                "order"       => 7,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Projets en Prospection",

                        "title_en"    => "Projects in Prospecting",
                        "icon"        => "icon-prospection",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/list-prospection",
                        "permissions" => ["prospection"],
                    ],
                ]
            ],
            [
                "title"       => "Comptabilité",
                "title_en"    => "Customers",
                "icon"        => "icon-demandeabsence",
                "description" => null,
                "order"       => 8,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Entre/Sortie de caisse",
                        "title_en"    => "Category/Type of spent",
                        "icon"        => "icon-demandeabsence",
                        "description" => null,
                        "order"       => 0,
                        "link"        => "#!/list-entresortiecaisse",
                        "permissions" => ["entrecaisse","sortiecaisse"],
                    ],
                    [
                        "title"       => "Caisse",

                        "title_en"    => "Caisse",
                        "icon"        => "icon-projet",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/list-caisse",
                        "permissions" => ["caisse"],
                    ],
                    [
                        "title"       => "Dépenses",

                        "title_en"    => "Expenses",
                        "icon"        => "icon-modepaiement",
                        "description" => null,
                        "order"       => 2,
                        "link"        => "#!/list-depense",
                        "permissions" => ["depense"],
                    ],
                    [
                        "title"       => "Catégories/Types de dépense",
                        "title_en"    => "Category/Type of spent",
                        "icon"        => "icon-categoriedepense",
                        "description" => null,
                        "order"       => 3,
                        "link"        => "#!/list-categorietypedepense",
                        "permissions" => ["categoriedepense","typedepense"],
                    ],
                   
                
                ]
            ],
            [
                "title"       => "Ressources humaines",
                "title_en"    => "Human resources",
                "icon"        => "icon-typeclient",
                "description" => null,
                "order"       => 9,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Personnels",
                        "title_en"    => "Staff",
                        "icon"        => "icon-typeclient",
                        "description" => null,
                        "order"       => 0,
                        "link"        => "#!/list-personnel",
                        "permissions" => ["personnel"],
                    ],
                    [
                        "title"       => "Demandes d'absence",
                        "title_en"    => "Answers Requests",
                        "icon"        => "icon-demandeabsence",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/list-demandeabsence",
                        "permissions" => ["demandeabsence"],
                    ],
                    [
                        "title"       => "Avance sur salaire",
                        "title_en"    => "Salary Advance",
                        "icon"        => "icon-avancesalaire",
                        "description" => null,
                        "order"       => 2,
                        "link"        => "#!/list-avancesalaire",
                        "permissions" => ["avancesalaire"],
                    ],
                    [
                        "title"       => "Pointages",
                        "title_en"    => "Attendance",
                        "icon"        => "icon-pointage",
                        "description" => null,
                        "order"       => 3,
                        "link"        => "#!/list-pointage",
                        "permissions" => ["pointage"],
                    ],
                    [
                        "title"       => "Evenements RH",
                        "title_en"    => "Events RH",
                        "icon"        => "icon-event",
                        "description" => null,
                        "order"       => 4,
                        "link"        => "#!/list-evenement",
                        "permissions" => ["evenement"],
                    ],
                ]
            ],
            [
                "title"       => "Etats",
                "title_en"    => "stats",
                "icon"        => "icon-stat",
                "description" => null,
                "order"       => 11,
                "mode_link"   => "liste-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Etats projet",
                        "title_en"    => "Project state",
                        "icon"        => "icon-stat",
                        "description" => null,
                        "order"       => 0,
                        "link"        => "#!/list-bilan",
                        "permissions" => ["dashboard"],
                    ],
                    // [
                    //     "title"       => "Etat client",
                    //     "title_en"    => "Customer state",
                    //     "icon"        => "icon-stat",
                    //     "description" => null,
                    //     "order"       => 1,
                    //     "link"        => "#!/list-etatclient",
                    //     "permissions" => ["etatclient"],
                    // ],
                ]
            ],

            [
                "title"       => "Outils Admin",
                "title_en"    => "Admin Tools",
                "icon"        => "icon-outil-admin",
                "description" => null,
                "order"       => 12,
                "mode_link"   => "card-view",
                "modules"     => [],
                "pages"       => [
                    [
                        "title"       => "Profils & Permissions",
                        "title_en"    => "Profiles & Permissions",
                        "icon"        => "icon-profil",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/list-profil",
                        "permissions" => ["role"],
                    ],
                    [
                        "title"       => "Gestion des utilisateurs",
                        "title_en"    => "Users management",
                        "icon"        => "icon-utilisateur",
                        "description" => null,
                        "order"       => 2,
                        "link"        => "#!/list-user",
                        "permissions" => ["user"],
                    ],
                    [
                        "title"       => "Liste des préférences",
                        "title_en"    => "Preferences list",
                        "icon"        => "icon-preference",
                        "description" => null,
                        "order"       => 3,
                        "link"        => "#!/list-preference",
                        "permissions" => ["preference"],
                    ],
                    [
                        "title"       => "Niveaux d'habilitation",
                        "title_en"    => "Clearance levels",
                        "icon"        => "icon-niveauhabilite",
                        "description" => null,
                        "order"       => 4,
                        "link"        => "#!/list-niveauhabilite",
                        "permissions" => ["niveauhabilite"],
                    ],
                ]
            ]
        ];

        foreach ($this->modules as $module)
        {
            $new_module = Module::{$this->functionCall}([
                'icon' => $module['icon']
            ],
            [
                'title'          => $module['title'],
                'title_en'       => $module['title_en'],
                'icon'           => $module['icon'],
                'description'    => $module['description'],
                'order'          => $module['order'],
                'mode_link_id'   => isset($module['mode_link']) && ModeLink::where('nom', $module['mode_link'])->first() ? ModeLink::where('nom', $module['mode_link'])->first()->id : null,
            ]);

            foreach ($module['modules'] as $sub_module)
            {
                $new_sub_module = Module::{$this->functionCall}([
                    'icon'      => $sub_module['icon'],
                    'module_id' => $new_module->id
                ],
                [
                    'module_id'      => $new_module->id,
                    'title'          => $sub_module['title'],
                    'title_en'       => $sub_module['title_en'],
                    'icon'           => $sub_module['icon'],
                    'description'    => $sub_module['description'],
                    'order'          => $sub_module['order'],
                ]);

                foreach ($sub_module['pages'] as $page)
                {
                    $new_sub_page = Page::{$this->functionCall}([
                        'link' => $page['link']
                    ],
                    [
                        'module_id'      => $new_sub_module->id,
                        'title'          => $page['title'],
                        'title_en'       => $page['title_en'],
                        'icon'           => $page['icon'],
                        'description'    => $page['description'],
                        'order'          => $page['order'],
                        'link'           => $page['link'],
                        'permissions'    => $page['permissions'],
                    ]);
                }
            }

            foreach ($module['pages'] as $page)
            {
                $new_page = Page::{$this->functionCall}([
                    'link' => $page['link'],
                ],
                [
                    'module_id'      => $new_module->id,
                    'title'          => $page['title'],
                    'title_en'       => $page['title_en'],
                    'icon'           => $page['icon'],
                    'description'    => $page['description'],
                    'order'          => $page['order'],
                    'link'           => $page['link'],
                    'permissions'    => $page['permissions'],
                ]);
            }
        }

        // Les pages qui ne pourront pas être intégrées à des modules
        $pages = [
            [
                "title"       => "Index",
                "title_en"    => "Index",
                "icon"        => "fa fa-info",
                "description" => null,
                "order"       => 0,
                "link"        => "#!/index",
                "permissions" => [],
            ],
            [
                "title"       => "Accueil",
                "title_en"    => "Home",
                "icon"        => "fa fa-info",
                "description" => null,
                "order"       => 1,
                "link"        => "#!/accueil",
                "permissions" => [],
            ],
            [
                "title"       => "Detail marchandise",
                "title_en"    => "Product details",
                "icon"        => "fa fa-info",
                "description" => null,
                "order"       => 2,
                "link"        => "#!/detail-marchandise",
                "permissions" => [],
            ],
            [
                "title"       => "Detail entrepôt",
                "title_en"    => "Warehouse detail",
                "icon"        => "fa fa-info",
                "description" => null,
                "order"       => 3,
                "link"        => "#!/detail-entrepot",
                "permissions" => [],
            ],
            [
                "title"       => "Detail dossier",
                "title_en"    => "Detail dossier",
                "icon"        => "fa fa-info",
                "description" => null,
                "order"       => 4,
                "link"        => "#!/detail-dossier",
                "permissions" => [],
            ],
            [
                "title"       => "Detail utilisateur",
                "title_en"    => "User detail",
                "icon"        => "fa fa-info",
                "description" => null,
                "order"       => 5,
                "link"        => "#!/detail-utilisateur",
                "permissions" => [],
            ],
            [
                "title"       => "Detail Client",
                "title_en"    => "Detail Customer",
                "icon"        => "fa fa-info",
                "description" => null,
                "order"       => 6,
                "link"        => "#!/detail-client",
                "permissions" => [],
            ]

        ];
        foreach ($pages as $page) {

            $new_page = Page::{$this->functionCall}([
                'link'           => $page['link'],
            ],
            [
                'title'          => $page['title'],
                'title_en'       => $page['title_en'],
                'description'    => $page['description'],
                'order'          => $page['order'],
                'link'           => $page['link'],
                'permissions'    => $page['permissions'],
                'can_be_managed' => false,
            ]);
        }



        // Les pages qui ne pourront pas être intégrées à des modules
        $link_route_controllers = [
            [
                "route_name"             => "soustypecotation",
                "controller_name"        => "TypeCotation"
            ],
            [
                "route_name"             => "souschapitrenomenclaturedouaniere",
                "controller_name"        => "ChapitreNomenclatureDouaniere"
            ],
            [
                "route_name"             => "remboursement",
                "controller_name"        => "AvanceSalaire"
            ],
        ];
        foreach ($link_route_controllers as $link_route_controller)
        {
            $new_link_route_controller = LinkRouteController::{$this->functionCall}([
                'route_name'            => $link_route_controller['route_name']
            ],
            [
                'controller_name'      => $link_route_controller['controller_name'],
            ]);
        }
    }
}
