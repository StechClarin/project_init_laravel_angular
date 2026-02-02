
var app = angular.module('BackEnd', ['ngRoute', 'ngSanitize', 'ngLoadScript', 'ui.bootstrap', 'angular.filter', 'ngCookies', 'dx']);
//rechercher markme pour touver la LISTE, l'AJOUT, la MODIFICATION et la SUPPRESSION
// var BASE_URL = '//' + location.host + '/';
var BASE_URL = '//' + location.host + '/guindy_manager/public/';
var imgupload = BASE_URL + '/assets/media/upload.jpg';
var imgupload = BASE_URL + '/assets/media/upload.jpg';
var imglogo = BASE_URL + '/assets/media/logos/logo.svg';
var msg_erreur = 'Une Erreur est survenue sur le serveur, veuillez contacter le support technique';
app.service('getPageServiceAnnotate', function ($templateCache, $q, $http) {
    var factory =
    {
        data: false,
        getPages: function () {
            var deferred = $q.defer();

            var pages = ["dashboard", "accueil", "bilan"];
            var countpage = 0;
            $.each(pages, function (keyItem, valueItem) {
                //console.log(dataget);
                $http({
                    method: 'GET',
                    url: 'page/' + valueItem,
                }).then(function successCallback(contentHtml) {
                    $templateCache.put(valueItem + '.html', contentHtml['data']);
                    countpage++;

                    factory.data = countpage

                    if (countpage == 2) {
                        deferred.resolve(factory.data);
                    }
                    console.log('run success', valueItem + '.html', $templateCache.get(valueItem + '.html'));
                }, function errorCallback(error) {
                    console.log('run error', error);
                    deferred.reject(error);
                });

            });

            return deferred.promise;
        }
    };
    return factory;
});


function unauthenticated(error) {
    if (error.status === 401) {
        iziToast.error({
            title: "",
            message: "Votre session utilisateur a expiré...",
            position: 'topRight'
        });

        setTimeout(function () {
            window.location.reload();
        }, 2000);
    }
}

app.filter('range', function () {
    return function (input, total) {
        total = parseInt(total);
        for (var i = 0; i < total; i++)
            input.push(i);
        return input;
    };
});


// Pour mettre les espaces sur les montants
app.filter('convertMontant', [
    function () { // should be altered to suit your needs
        return function (input) {
            input = input + "";
            return input.replace(/,/g, " ");
        };
    }]);


app.filter('ConvertDecimal', [
    function () {
        return function (input) {

            return Math.round((input) * 100) / 100

        };
    }]);

app.filter('isInArray', [
    function () {
        return function (items, data) {

            var retour = [];

            items.forEach(function (item) {
                if (!$angular.element($0).scope().isInArrayData(null, item.id, dataInTabPane['details_taxedouaniere']['data'], 'taxe')) {
                    retour.push(item);
                }
            });

            return retour;
            console.log('here jacques => ', items, anotherArgument);
            // return false;
        };
    }]);


// Permet de convertir une chaine en nombre pour être editable dans un input number
app.directive('stringToNumber', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return parseFloat(value);
            });
            ngModel.$formatters.push(function (value) {
                return parseFloat(value);
            });
        }
    };
});

app.directive('textToBoolean', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return value === 'true';
            });

            ngModel.$formatters.push(function (value) {
                return value ? 'true' : 'false';
            });
        }
    };
});

app.directive('disableClick', function () {
    return {
        restrict: 'A',
        link: function (scope, element) {
            element.on('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                // Vous pouvez également ajouter une classe CSS pour indiquer que la div est désactivée
            });
        }
    };
});

app.factory('theme', function ($cookies) {
    var factory =
    {
        pathCookie: { path: '/' },
        nameCookie: 'theme',
        data: false,
        setCurrent: function (valueCookie, nameCookie = factory.nameCookie, pathCookie = factory.pathCookie) {
            $cookies.putObject(nameCookie, valueCookie, pathCookie);
        },
        getCurrent: function (nameCookie = factory.nameCookie, pathCookie = factory.pathCookie) {
            var valueCookie = $cookies.getObject(nameCookie);
            if (nameCookie === "theme" && !valueCookie) {
                valueCookie = "theme-light";
            }
            return valueCookie;
        },
        removeCurrent: function ($scope) {
            $cookies.remove(factory.nameCookie, factory.pathCookie);
        },
    };
    return factory;
});

app.factory('Init', function ($http, $q) {
    var factory =
    {
        data: false,
        getElement: function (element, listeattributs, listeattributs_filter = null, is_graphQL = true, dataget) {

            // POUR REPRENDRE LES FILTRES AU NIVEAU DES ATTRIBUTS
            add_text_filter = '';
            if (listeattributs_filter != null && element.indexOf('(') !== -1) {
                args_filter = element.substr(element.indexOf('('), element.length + 1);
                console.log('args_filter', args_filter);
                $.each(listeattributs_filter, function (key, attr) {
                    attrBefore = attr;
                    attrAfter = "";
                    if (attr.indexOf('{') !== -1) {
                        attrBefore = attr.substr(0, attr.indexOf('{'));
                        attrAfter = attr.substr(attr.indexOf('{'), attr.length + 1);
                    }
                    console.log('attrBefore ===>', attrBefore, 'attrAfter ===>', attrAfter);
                    add_text_filter = ((key === 0) ? ',' : '') + attrBefore + args_filter + attrAfter + (listeattributs_filter.length - key > 1 ? ',' : '') + add_text_filter;
                });
                add_text_filter = ',' + add_text_filter.substr(0, add_text_filter.length);
                //console.log("args_filter" , args_filter, add_text_filter   )
            }

            console.log('ici add_text_filter', listeattributs, listeattributs_filter, is_graphQL);

            //console.log(dataget);
            element = encodeURIComponent(element);
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BASE_URL + (is_graphQL ? 'graphql?query= {' + element + ' {' + listeattributs + (add_text_filter ? ',' : '') + add_text_filter + '} }' : element),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: dataget
            }).then(function successCallback(response) {
                /*lorsque la requete contient des paramètres, il faut decouper pour recupérer le tableau*/
                if (is_graphQL) {
                    factory.data = response['data']['data'][!element.indexOf('(') != -1 ? element.split('(')[0] : element];
                    console.log('hereeeeeee 1 ', element, response['data']['data']);
                }
                else {
                    factory.data = response['data'];
                    console.log('hereeeeeee 2', factory.data);
                }
                deferred.resolve(factory.data);
            }, function errorCallback(error) {
                unauthenticated(error);
                deferred.reject(msg_erreur);
            });
            return deferred.promise;
        },
        getElementPaginated: function (element, listeattributs, listeattributs_filter) {
            // POUR REPRENDRE LES FILTRES AU NIVEAU DES ATTRIBUTS
            add_text_filter = '';
            if (listeattributs_filter != null && element.indexOf('(') !== -1) {
                args_filter = element.substr(element.indexOf('('), element.length + 1);
                console.log('args_filter', args_filter);
                $.each(listeattributs_filter, function (key, attr) {
                    attrBefore = attr;
                    attrAfter = "";
                    if (attr.indexOf('{') !== -1) {
                        attrBefore = attr.substr(0, attr.indexOf('{'));
                        attrAfter = attr.substr(attr.indexOf('{'), attr.length + 1);
                    }
                    console.log('attrBefore ===>', attrBefore, 'attrAfter ===>', attrAfter);
                    add_text_filter = ((key === 0) ? ',' : '') + attrBefore + args_filter + attrAfter + (listeattributs_filter.length - key > 1 ? ',' : '') + add_text_filter;
                });
                add_text_filter = ',' + add_text_filter.substr(0, add_text_filter.length);
                //console.log("args_filter" , args_filter, add_text_filter   )
            }


            // Pour faire le nettoyage au cas où j'ai deux arguments qui sont remontés
            elementStr = element.substr(element.indexOf('(') + 1, (element.indexOf(')') - element.indexOf('(')) - 1);
            console.log('elementStr =>', elementStr);

            var indices = [];
            elementStr = elementStr.split(",");
            $.each(elementStr, function (key, attr) {
                if (!!attr) {
                    indices = [];
                    elementStr.filter(function (yourArray, index) {
                        if (yourArray.split(":")[0] == attr.split(":")[0]) {
                            indices.push(index)
                        }
                    });

                    if (indices.length == 2) {
                        elementStr.splice(key, 1);
                    }
                }
            });

            element = element.substr(0, element.indexOf('(')) + "(" + elementStr.join(",") + ")";
            console.log('elementStr =>', elementStr, element);

            element = encodeURIComponent(element);
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BASE_URL + 'graphql?query={' + element + '{metadata{total,per_page,current_page,last_page},data{' + listeattributs + (add_text_filter ? ',' : '') + add_text_filter + '}}}'
            }).then(function successCallback(response) {
                console.log(response, 'bonjour response !!!')
                factory.data = response['data']['data'][!element.indexOf('(') != -1 ? element.split('(')[0] : element];
                deferred.resolve(factory.data);
            }, function errorCallback(error) {
                unauthenticated(error);
                deferred.reject(error);
            });
            return deferred.promise;
        },
        changeStatut: function (element, data, action = 'statut') {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BASE_URL + element + '/' + action,
                headers: {
                    'Content-Type': 'application/json'
                },
                data: data
            }).then(function successCallback(response) {
                factory.data = response['data'];
                deferred.resolve(factory.data);
            }, function errorCallback(error) {
                unauthenticated(error);
                console.log('erreur serveur', error);
                deferred.reject(msg_erreur);
            });
            return deferred.promise;
        },
        saveElementAjax: function (element, data, optionals = { is_file_excel: false, blockUI_on_modal: false, for_delete: true }) {
            var deferred = $q.defer();
            var doAction = (optionals.is_file_excel ? 'import' : 'save');
            if (optionals.for_delete && optionals.for_delete == true) {
                doAction = 'delete/' + data.id;
            }

            if (!!optionals.route) {
                doAction = optionals.route;
            }
            $.ajax
                (
                    {
                        url: BASE_URL + element + '/' + doAction,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        DataType: 'text',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        beforeSend: function () {
                            if (optionals.blockUI_on_modal) {
                                $('#modal_add' + element).blockUI_start();
                            }
                        }, success: function (response) {
                            $('#modal_add' + element).blockUI_stop();
                            factory.data = response;
                            deferred.resolve(factory.data);
                        },
                        error: function (error) {
                            unauthenticated(error);
                            $('#modal_add' + element).blockUI_stop();
                            deferred.reject(msg_erreur);
                        }
                    }
                );
            return deferred.promise;
        }
    };
    return factory;
});


//-------------CONFIGURATION DES ROUTES--------------------//
app.config(function ($routeProvider) {
    $routeProvider
        .when("/:namepage?/:itemId?", {
            templateUrl: function (elem, attrs) {
                return "page/" + (elem["namepage"] ? elem["namepage"] : "index");
            },
        })
});
//-------------/CONFIGURATION DES ROUTES--------------------//


// Spécification fonctionnelle du controller
app.controller('BackEndCtl', function (Init, theme, $templateCache, $location, $scope, $cookies, $filter, $log, $q, $route, $routeParams, $timeout, $compile, $http) {

    //pie chart
    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("myPieChart");
        if (container) {
            const slices = container.querySelectorAll(".pie");
            const totalSlices = slices.length;
            const anglePerSlice = 360 / totalSlices;

            slices.forEach((slice, index) => {
                const className = Array.from(slice.classList).find(c => c.startsWith('pieSlice-'));
                if (className) {
                    const color = className.split('-')[1];
                    const rotate = index * anglePerSlice;

                    slice.style.backgroundColor = color;
                    slice.style.transform = `rotate(${rotate}deg)`;
                    slice.style.clipPath = `polygon(50% 50%, 
                        ${50 + 50 * Math.cos(0)}% ${50 + 50 * Math.sin(0)}%, 
                        ${50 + 50 * Math.cos((anglePerSlice * Math.PI) / 180)}% ${50 + 50 * Math.sin((anglePerSlice * Math.PI) / 180)}%)`;
                }
            });
        }
    });

    //pop humor modal
    $timeout(function () {
        const showMoodModal = document.body.dataset.showMoodModal === "true";

        if (showMoodModal) {
            const modalEl = document.getElementById('modal_addmood');
            const moodModal = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });

            moodModal.show();

            const buttons = modalEl.querySelectorAll('button[type="submit"]');

            buttons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    const form = document.getElementById('form_addmood');
                    const moodValue = this.value;
                    const csrf = form.querySelector('input[name="_token"]').value;

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                        },
                        body: JSON.stringify({ mood: moodValue })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                moodModal.hide();
                                console.log("Merci ! Votre humeur a été enregistrée." + err);
                            } else {
                                console.log("Erreur lors de l'enregistrement." + err);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            console.log("Erreur de connexion. Veuillez réessayer." + err);
                        });
                });
                window.location.refreshElementsNeeds();
            });
        }
    }, 0);

    console.log('BASE_URL', BASE_URL);
    var listofrequests_assoc =
    {
        //-------------DEBUT ==> MES REQUETES PERSONNALISEES--------------------//
        //markme-LISTE

        "banques": [
            "id,nom,description",
        ],
        "bureaus": [
            "id,code,nom",
        ],
        "personnels": [
            "id,nom,display_text,prenom,date_naissance,lieu_naissance,telephone,email,adresse,date_embauche,anciennete,connectivite,fonction,role_id,role{id,name},nomcp,telephonecp,emailcp,planificationassignes{id,tache_fonctionnalite_id,tache_fonctionnalite{duree,tache{nom}},status,date_debut,date_fin},tacheprojets{projet{id,nom},nom_tache,duree,date_debut2,date_fin2,status}",
        ],
        "detailspointages": [
            "id,personnel{id,nom,prenom},pointage{id,presonnel_id,date_debut,date_debut_fr,date_fin,date_fin_fr},heure_arrive,heure_depart,retard,absence,justificatif,description"
        ],
        "clients": [
            "id,type_client_id,tag,modalite_paiement_id,display_text,code,nom,image,status,status_fr,color_status,description,type_client{id,nom},telephone,email,modalite_paiement{id,nom},details{id,nom,telephone,email,fonction}",
        ],
        "projets": [
            "id,type_projet_id,noyauxinterne_id,noyauxinterne{id,nom},progression,display_text,client_id,nombre_tache,code,nom,status,status_fr,color_status,description,date_cloture,date_cloture_fr,date_debut,date_debut_fr,date_fin,date_fin_fr,date_prochain_renouvellement,identifiant_test,mot_de_passe_test,lien_test,identifiant_prod,mot_de_passe_prod,lien_prod,hebergeur,serveur,tarif,type_projet{id,nom,display_text},client{id,display_text}",
        ],
        "assistances": [
            "id,date,date_fr,duree,projet_id,rapporteur,canal_id,tag_id,type_tache_id,canal_slack_id,canal_slack{id,nom,slack_id},collecteur_id,assigne_id,tag{id,nom},display_text,code,status,status_fr,color_status,detail,projet{id,nom,display_text},canal{id,nom},collecteur{id,name,display_text},assigne{id,name,display_text},rapport_assistance{id,date,date_fr,status,libelle,description,projet_id,rapport_email{id,destinataire,objet,file}}",
        ],
        "rapportassistances": [
            "id,date,date_fr,libelle,description,status,projet_id,rapport_email{id,date_fr,destinataire,objet,file},details{id,rapport_assistance_id,assistance_id,assistance{id,rapporteur,canal_id,tag_id,type_tache_id,collecteur_id,assigne_id,tag{id,nom},display_text,code,status,status_fr,color_status,detail,projet{id,nom,display_text},canal{id,nom},collecteur{id,name,display_text},assigne{id,name,display_text}}}",
        ],
        "detailrapports": [
            "id,rapport_assistance_id,assistance_id,assistance{id,code,date,date_fr,color_status,description,date_fr,date,projet_id,projet{id,nom},tag_id,tag{id,display_text},canal{id,display_text},collecteur_id,collecteur{id,display_text},rapporteur_id,rapporteur{id,display_text},assigne_id,assigne{id,display_text}}",
        ],
        "fournisseurs": [
            "id,code,nom,prenom,faxe,fixe,ninea,rcc,image,adresse_postale,status,status_fr,color_status,adresse_geographique,description,telephone,email",
            ",pay_id,pay{id,display_text},contacts{id,nom,telephone,email,fonction},details{id,nom}",
        ],
        "groupepermissions": [
            "id,name,tag,permissions{id,name,display_name,guard_name,type_permission{id,name,couleur}}",
        ],
        "indexs": [
            "nbre_entrepots,nbre_clients,nbre_marchandises,nbre_livreurs"
        ],
        "modalitepaiements": [
            "id,nom,description,nbre_jour,findumois",
        ],
        "modeles": [
            "id,nom,description",
        ],
        "modepaiements": [
            "id,nom"
        ],
        "modereglements": [
            "id,nom"
        ],
        "modefacturations": [
            "id,nom,value"
        ],
        "notifs": [
            "id,message,link,page_id,module_id,created_at_fr"
        ],
        "notifpermusers": [
            "id,view,permission_id,user_id,notif_id,notif{id,message,icon,toast,link,created_at_fr},link"
        ],
        "niveauhabilites": [
            "id,nom,niveau"
        ],
        "pages": [
            "id,title,libelle,icon,image,description,order,module_id,permissions,can_be_managed,link"
        ],
        "pays": [
            "id,nom,cedeao"
        ],
        "permissions": [
            "id,name,display_name,guard_name,type_permission{id,name,couleur}",
        ],
        "preferences": [
            "id,nom,display_name,valeur"
        ],
        "regimes": [
            "id,code,nom,type_dossier_id,type_dossier{id,nom,display_text},detailsins{id,nom,display_text},detailsouts{id,nom,display_text}",
        ],
        "roles": [
            "id,name,guard_name,permissions{id,name,display_name,guard_name}"
        ],
        "typeclients": [
            "id,nom,description,nbre_client",
        ],
        "priorites": [
            "id,nom,description,display_text",
        ],
        "mesures": [
            "id,nom,description,display_text",
        ],
        "gravites": [
            "id,nom,description,display_text",
        ],
        "tags": [
            "id,nom,priorite_id,priorite{id,nom},description,display_text",
        ],
        "pointages": [
            "id,personnel_id,personnel{id,nom,prenom,display_text},temps_au_bureau,date_debut,date_debut_fr,date_fin,date_fin_fr,created_at,created_at_fr,details{id,date,heure_arrive,heure_depart,retard,absence,justificatif,description}",
        ],
        "tacheassignes": [
            "id,personnel_id,personnel{id,nom,prenom},projet_id,projet{id,nom},tache_id,tache{id,nom},date_debut,date_debut_fr,duree,date_fin,date_fin_fr,description,status,created_at"
        ],
        "evenements": [
            "id,date,date_debut,date_fin,date_fr,observation,positif_negatif,temps,personnel_id,personnel{id,nom,prenom,display_text},projet_id,projet{id,nom},mesure_id,mesure{id,nom},gravite_id,gravite{id,nom},description,display_text",
        ],
        "noyauxinternes": [
            "id,nom,description,display_text",
        ],
        "entresortiecaisses": [
            "id,caisse_id,caisse{id,nom},motifentresortiecaisse_id,motifentresortiecaisse{id,nom},montant,description,display_text",
        ],

        "caisses": [
            "id,nom,description,display_text",
        ],

        "motifentresortiecaisses": [
            "id,nom,description,display_text",
        ],


        "departements": [
            "id,nom,str_nom,description,nombre_tache,icon,data,display_text,projet_departements{id,progression,nombre_tache,nombre_tache_close,projet{id,nom}}",
        ],
        "canals": [
            "id,nom,description,display_text",
        ],
        "canalslacks": [
            "id,nom,slack_id,display_text",
        ],
        "typetaches": [
            "id,nom,display_text,description,nbre_tache",
        ],
        "categoriedepenses": [
            "id,nom,description,nbre_depense",
        ],
        "typedepenses": [
            "id,nom,description,categorie_depense_id,categorie_depense{id,nom},nbre_depense",
        ],
        "depenses": [
            "id,nom,montant,description,typedepense_id,typedepense{id,nom},created_at,created_at_fr,created_by{id,name},display_text",
        ],
        "secteuractivites": [
            "id,nom,description,nbre_client",
        ],
        "typeprojets": [
            "id,nom,description,nbre_projet,display_text",
        ],
        "typepermissions": [
            "id,name,couleur",
        ],
        "typerepartitions": [
            "id,nom"
        ],
        "unitemesures": [
            "id,nom,abreviation",
        ],
        "users": [
            "id,name,email,image,color_status,status_fr,status,is_on_line,role_id,role{id,name,guard_name},created_at_fr, last_login",
            // "affectations{id,departement_id,departement{nom},etat}"
        ],
        "demandeabsences": [
            "id,date,date_fr,heure_debut,heure_fin,date_fin,date_fin_fr,date_debut,date_debut_fr,description,motif,employe_id,employe{id,nom,display_text},status",
        ],
        "avancesalaires": [
            "id,date,date_fr,montant,montant_fr,restant_fr,restant,status,etat,employe_id,employe{id,nom,display_text},remboursements{id,date,date_fr,montant,restant,montant_total}",
        ],
        "remboursements": [
            "id,date,date_fr,montant,etat,restant,avance_salaire_id",
        ],
        "rapportemails": [
            "id,date_fr,destinataire,objet,file",
        ],
        "projetprospects": [
            "id,date,date_fr,client_id,nom,client{id,display_text},commentaires,status,noyaux_interne_id,noyaux_interne{id,nom,display_text}",
        ],
        "surmesures": [
            "id,date,date_fr,client_id,nom,commentaires,client{id,display_text},status",
        ],

        "newsletters": [
            "id,email,display_text"

        ],
        "contactsites": [
            "id,nom,email,message,created_at_fr,created_at_fr,display_text",
        ],
        "contacts": [
            "id,nom,prenom,telephone,email,display_text",
        ],
        "projetdepartements": [
            "id,projet_id,progression,nombre_tache,nombre_tache_close,projet{id,nom,status,description,date_cloture_fr,date_cloture,date_debut_fr,date_debut},departement_id,departement{id,nom,description,str_nom,display_text,image}",
        ],
        "fonctionnalites": [
            "id,nom,version,display_text,description,str_nom",
            // "id,nom,version,display_text,description,str_nom,tache_fonctionnalites{id,tache_id,fonctionnalite_id,duree,status,visas{id,tache_fonctionnalite_id,user_id,visa,last_visa},visa_finals{id,tache_fonctionnalite_id,user_id,visa,last_visa},visa_qualite{id,tache_fonctionnalite_id,user_id,commentaire,visa},visa_cto_cdp{id,tache_fonctionnalite_id,user_id,commentaire,visa},tache{id,nom,display_text}}",
            // "id,nom,display_text,fonctionnalite_module{id,projet_module_id,fonctionnalaite_id},tache_fonctionnalite{id,tache_id,fonctionnalite_id}",    
        ],
        "taches": [
            "id,nom,type_tache_id,display_text,description"
        ],
        "tachefonctionnalites": [
            "id,tache_id,fonctionnalite_module_id,duree,status,tache{id,nom,type_tache_id,type_tache{id,nom},display_text}   "
        ],
        "projetmodules": [
            "id,nom,description,display_text,status,departement_id,projet_id,nombre_tache,nombre_tache_close,progression,projet{id,nom},fonctionnalite_modules{id,projet_module_id,duree,fonctionnalite_id,status}"
        ],
        "visas": [
            "id,tache_fonctionnalite_id,user_id,visa,last_visa"
        ],
        "visafinals": [
            "id,tache_fonctionnalite_id,user_id,visa,last_visa"
        ],
        "fonctionnalitemodules": [
            "id,fonctionnalite_id,fonctionnalite{id,nom,description},projet_module_id,projet_id,duree"
        ],
        "planifications": [
            "id,date_debut,date_debut_fr,date_fin,date_fin_fr,personnel_id,personnel{id,nom,display_text,prenom},status,nombre_tache,nombre_projet,details{id,personnel_id,personnel{id,nom,prenom},day,description,planification_id,projet_id,projet{nom},fonctionnalite_module_id,fonctionnalite_module{fonctionnalite{nom}},date,tache_fonctionnalite_id,tache_fonctionnalite{tache{nom}},status,tag_id,tag{nom},priorite{id,nom}}"
        ],
        "planificationassignes": [
            "id,day,planification_id,projet_id,projet{nom},personnel_id,personnel{id,nom,prenom},date,fonctionnalite_module_id,fonctionnalite_module{fonctionnalite{nom}},tache_fonctionnalite_id,tache_fonctionnalite{duree,tache{nom}},description,date_debut,date_fin,duree_effectue,status,tag_id,tag{nom},priorite{id,nom}",
        ],
        "tacheprojets": [
            "id,personnel_id,personnel{id,nom,prenom},projet_id,projet{id,nom},tag_id,tag{id,nom},priorite_id,priorite{id,nom},nom_tache,date,date_debut,date_debut_fr,date_debut2,date_debut2_fr,date_fin,date_fin_fr,date_fin2,date_fin2_fr,description,duree,duree_convertie,status"
        ],



        //-------------FIN ==> MES REQUETES PERSONNALISEES--------------------//
    };

    //--------------------------------------------//
    //-----------------UTILITAIRES----------------//
    //--------------------------------------------//

    const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> OUI',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> NON',
        customClass: {
            popup: 'bg-body',
            confirmButton: 'btn btn-light-success',
            cancelButton: 'btn btn-light-danger me-2'
        },
        buttonsStyling: false
    });


    // A l'ouverture du modal, on check
    $('.modal[role="dialog"]').on('show.bs.modal', function (e) {
        closeMenuContextuel();
    });

    $scope.selectedPersonnelId = null;

    $scope.onSelectPersonnel = function (personnel) {
        if (personnel && personnel.id) {
            $scope.selectedPersonnelId = personnel.id;
        } else {
            $scope.selectedPersonnelId = null;
        }
    };



    // A la fermeture du modal, on check
    $('.modal[role="dialog"]').on('hide.bs.modal', function (e) {
        var tmpid = $(document.activeElement).attr('class')

        $scope.detailParentId = null;
        $scope.showSlick = false;

        startTagForm = "modal_add";
        endTagForm = $(this).attr('id').substr(startTagForm.length, $(this).attr('id').length);

        if (endTagForm === "checkoption" && $scope.canCloseModal !== true) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }

        if ($(this).hasClass("block-close")) {
            if ($(document.activeElement).attr('type') === "button" && $(document.activeElement).attr('data-bs-dismiss') === "modal") {
                return;
            }

            e.preventDefault();
            e.stopPropagation();
            return false;
        }

        console.log('startTagForm*********', startTagForm, "***********", endTagForm);

        //$scope.emptyForm(endTagForm);
        //$(".select2").val("").change();



        if ($('.select2').find('.select2-selection--single[aria-expanded="true"]').length > 0) {
            e.preventDefault();
        }
        else {
            askConfirmation = false;

            var form = $('#form_add' + endTagForm);
            var formdata = (window.FormData) ? (new FormData(form[0])) : null;
            var send_data = (formdata !== null) ? formdata : form.serialize();

            var inputs = form.serializeArray();
            var fo = '';
            $.each(inputs, function (i, field) {
                fo = field.value;
                if (!!fo.trim() && field.name != "_token" && field.name != "id") {
                    askConfirmation = true;
                    return false;
                }
            });
            //fo = fo.trim();
            console.log("ici mon tag ", inputs);

            if (!askConfirmation) {
                tagType = '_' + endTagForm;
                $.each($scope.dataInTabPane, function (keyItem, valueItem) {
                    tagType = '_' + endTagForm;
                    if (keyItem.indexOf(tagType) !== -1) {
                        console.log('********************', keyItem, keyItem.substring(0, keyItem.length - (tagType.length)), JSON.stringify($scope.dataInTabPane[keyItem]['data']));
                        getNewItems = $scope.dataInTabPane[keyItem]['data'].filter(item => !item.id);
                        if (getNewItems.length > 0) {
                            askConfirmation = true;
                        }
                        return !askConfirmation;
                    }
                });
            }

            if (tmpid.indexOf('btn') != -1) {
                askConfirmation = false;
            }
            if (askConfirmation) {
                var currentModal = $(this);
                title = "Fermeture du modal";
                msg = "Voulez-vous vraiment quitter le modal car vous avez des données en cours... ?";

                timeStamp = e.timeStamp;

                t = e.target;


                swalWithBootstrapButtons.fire({
                    title: title,
                    text: msg,
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (endTagForm === "nomenclaturedouaniere") {
                            $scope.forDetail = false;
                        }

                        $scope.emptyForm(endTagForm, true);

                        // window.dispatchEvent(e);

                        // // currentModal.data('bs.modal', null);
                        currentModal.css("display", "none").removeAttr('aria-modal').removeClass('show')
                            .attr('aria-hidden', true);
                        currentModal.modal('dispose');
                        $('body')
                            .removeClass('modal-open')
                            .find('.modal-backdrop').remove();

                        $('body').css("overflow", "scroll");

                        $('[class^="iziToast-"]').hide({ transitionOut: 'fadeOut' });
                        setTimeout(function () {
                            $('[class^="iziToast-"]').remove();
                        }, 1000);
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) { }
                });

                console.log('modal**************', currentModal.data);
                e.preventDefault();
            }
            else {
                // Pour éviter que le scroll ne se désactive lors de la fermeture d'un modal dans un autre
                if ($('.modal.show').length > 0) {
                    setTimeout(function () {
                        console.log('jacques modal show hereu =====');
                        $('body').addClass('modal-open');
                    }, 1000);
                }
                else {

                    $scope.emptyForm(endTagForm, true); // On vide les filtres lors de la fermeture
                }

                if (endTagForm === "nomenclaturedouaniere") {
                    $scope.forDetail = false;
                }
            }
        }
    });

    $scope.reste_a_payer = 0;
    $scope.total_a_payer = 0;
    $scope.total_retirer = 0;
    // Play Audio Sound
    $scope.playAudio = function (nameFile = 'notif', type = '.mp3') {
        var audio = new Audio(BASE_URL + '/assets/audio/' + nameFile + type);
        audio.play();
    };

    //pour afficher le champs uniquement les samedis
    $scope.isSaturday = (new Date()).getDay() === 6;
    console.log('letsgo', $scope.isSaturday);


    $scope.isInArrayFilter = function (tagForm = 'details_taxedouaniere', tagDataAvalaible = 'taxedouanieres2') {
        if (!!$scope.dataPage && !!$scope.dataPage[tagDataAvalaible]) {
            return $scope.dataPage[tagDataAvalaible].filter(function (item) {
                var retour = false;
                tagForms = tagForm;
                if (!Array.isArray(tagForm)) {
                    tagForms = [tagForm];
                }

                $.each(tagForms, function (keyTag, valueTag) {
                    if ($scope.isInArrayData(null, item.id, $scope.dataInTabPane[valueTag]['data'], 'taxe')) {
                        retour = true;
                    }
                });
                return !retour;
            });
        }
    };

    $scope.isInArrayData = function (e, idItem, data, typeItem = "menu", scopeName = null) {
        response = false;
        can_do = true;
        pageToIgnore = ['list-ordretransit'];

        can_do = !pageToIgnore.includes($scope.currentTemplateUrl);
        if (can_do === true) {
            if (!!scopeName) {
                var profondeurs = scopeName.split('.');
                data = $scope[profondeurs[0]];

                $.each(profondeurs, function (keyItem, valueItem) {
                    if (keyItem > 0) {
                        data = data[valueItem];
                    }
                });
            }
            console.log('here jacques', e, idItem, scopeName, data);

            $.each(data, function (key, value) {
                valeur = value;
                if (typeof value === 'object' &&
                    !Array.isArray(value) &&
                    value !== null) {
                    valeur = value.id;
                }
                console.log('here am i', valeur, idItem);
                if (valeur == idItem) {
                    response = true;
                }
            });
        }
        return response;
    };

    $scope.isContainsInArray = function (e, idItem, data,) {
        response = false;
        if (Array.isArray(data)) {
            var t = data.filter((e) => e.id === idItem);
            response = t.length > 0;
        }
        return response;
    };


    // Retour en arrière
    $scope.goBack = function () {
        window.history.back();
    };

    // Refresh Current Detail Page
    $scope.reloadFromSomePage = function () {
        if ($scope.linknav.indexOf("detail-") !== -1) {
            // window.location.reload();
        }
    };

    // automatically open the ticket page
    $scope.openTicket = function (item) {
        var urlTicket = BASE_URL + 'generate-ticketcommandeproduction-pdf/' + item.id;
        var ticket = window.open(urlTicket, '_blank');
        ticket.focus();
    };

    $scope.printPdf = function (url, print = true, filterId = null) {
        console.log('printPdf >', url, print);
        var urlTicket = url;
        if (!!filterId) {
            url += '?id:' + filterId;
        }
        $('body').blockUI_start();

        try {
            var iframe = document.createElement('iframe');
            iframe.style.display = print ? 'none' : 'block';
            iframe.src = url;
            document.body.appendChild(iframe);

            iframe.onload = function () {
                $('body').blockUI_stop();
                if (print) {
                    try {
                        iframe.contentWindow.print();
                        setTimeout(function () {
                            document.body.removeChild(iframe);
                        }, 3500);
                    }
                    catch (printError) {
                        console.error('Print error:', printError);
                        document.body.removeChild(iframe);
                        var ticket = window.open(urlTicket);
                        ticket.focus();
                    }
                }
            };
        }
        catch (e) {
            $('body').blockUI_stop();
            console.error('Print error (catch block):', e);
            var ticket = window.open(urlTicket);
            ticket.focus();
        }
    };


    $scope.initNotif = {
        progressBar: true,
        close: true,
        closeOnClick: true,
        timeout: false,
        title: "",
        message: "",
        position: 'topRight',
        linkUrl: null,
        onClose: function (instance, toast, closedBy) {
            //$scope.openNotif(instance.linkUrl);
        }
    };


    $scope.showToast = function (title, msg, type = "success", withTimeout = 5000, linkUrl = null, optionals = {}) {
        console.log('!!!!!!!!!! arrive dans la fonction', type);

        let configInitNotif = Object.assign({}, $scope.initNotif);

        if (!!optionals) {
            if (!!optionals.position) {
                configInitNotif.position = optionals.position;
            }
        }

        configInitNotif.timeout = withTimeout;
        if (!(withTimeout > 0)) {
            configInitNotif.progressBar = false;
        }
        configInitNotif.title = title;
        configInitNotif.message = msg;
        configInitNotif.linkUrl = linkUrl;

        if (type.indexOf("success") !== -1) {
            iziToast.success(configInitNotif);
        }
        else if (type.indexOf("warning") !== -1) {
            iziToast.warning(configInitNotif);
        }
        else if (type.indexOf("error") !== -1) {
            iziToast.error(configInitNotif);
        }
        else if (type.indexOf("info") !== -1) {
            iziToast.info(configInitNotif);
        }

        if (!withTimeout) {
            $scope.playAudio();
        }
    };

    /************************************/
    /************* SELECT 2 *************/
    /************************************/

    // to rewrite url of select2 search
    function dataUrlEntity(query, entity, itemDom = null) {
        console.log('dataUrlEntity=>', entity, itemDom);
        const selectItem = $('#' + itemDom);
        let addfiltres = ""
        if (selectItem.length === 0) {
            console.error('Element with id ' + itemDom + ' not found.');
            return '';
        }
        if (selectItem.attr('data-addfilters')) {
            addfiltres = ',' + selectItem.attr('data-addfilters');
        }
        rewriteelement = entity + 's(count:30'
            + ((query.term) ? ',search:' + '"' + query.term + addfiltres + '"' : "");
        // + ')';
        if (rewriteelement) {
            rewriteelement += ')';
            rewriteelement = encodeURIComponent(rewriteelement);
        }
        hereAttr = "id,display_text";

        if (!!$('#' + itemDom).attr("data-attrs")) {
            hereAttr = $('#' + itemDom).attr("data-attrs");
        }

        rewriteelement = BASE_URL + 'graphql?query={' + rewriteelement + "{" + hereAttr + "}}";
        console.log('url', rewriteelement);
        return rewriteelement;
    }

    // To get Data of search select2
    function processResultsForSearchEntity(getData, entity, itemDom = null) {
        console.log('this context', getData, entity);
        if (entity) {
            getData = getData.data[entity + 's'];
            console.log('kholal', getData);
            if (!$('#' + itemDom).is('[class*=search_]') || !!$('#' + itemDom).attr("set-data-page")) {
                $scope.dataPage[entity + 's'] = getData;
            }
        }
        else {
            getData = [];
        }

        var resultsData = [];
        $.each(getData, function (keyItem, valueItem) {
            if (entity) {
                contentToPush = { id: valueItem.id, text: valueItem.display_text };
            }
            else contentToPush = null;

            if (contentToPush) {
                resultsData.push(contentToPush);
            }
        });

        console.log('getData  aoudy=> ', getData, '/ dataPage => ', $scope.dataPage[entity + 's'], 'results =>', resultsData);

        return {
            results: resultsData
        };
    }
    $scope.TotalLivraison = 0;
    //  to detect all changes of select2



    // To configure ajax options of select2
    function setAjaxToSelect2OptionsForSearch(getEntity, itemDom = null) {
        return {
            url: query => dataUrlEntity(query, getEntity, itemDom),
            data: null,
            dataType: 'json',
            processResults: function (getData) {
                return processResultsForSearchEntity(getData, getEntity, itemDom);
            },
            cache: true
        };
    };

    // $scope.sendToSlack = function(item) {
    //     if (!item.canalslack || !item.canalslack.slack_id) {
    //         alert("Aucun canal Slack associé !");
    //         return;
    //     }

    //     let message = `*Rapport d'Assistance*\n\n
    //     *Date:* ${item.date_fr}\n
    //     *Projet:* ${item.projet.nom}\n
    //     *Détails:* ${item.detail}\n
    //     *Nature:* ${item.tag.nom}\n
    //     *Durée:* ${item.duree} min\n
    //     *Assigné à:* @${item.assigne.name}\n
    //     *Statut:* ${item.status_fr}\n
    //     *Collecté par:* ${item.collecteur.name}\n
    //     *Rapporté par:* ${item.rapporteur};
    //     Statut : ${item.status === 0 ? 'En cours' : item.status === 1 ? 'En attente' : 'Clôturé'}`;

    //     let data = {
    //         channel: item.canalslack.slack_id,
    //         message: message
    //     };

    //     console.log("Message à envoyer sur Slack:", data);

    //     $http.post('routes/web.php/send-to-slack', data) 
    //     .then(function(response) {
    //         console.log("Message envoyé sur Slack !");
    //             alert(response.data.success || response.data.error);
    //             console.log("quoi.?");
    //         })
    //         .catch(function(error) {
    //             alert("Erreur lors de l'envoi du message !");
    //             console.error(error);
    //         });
    // };


    $scope.sendToSlack = function (item) {
        console.log("Item complet:", JSON.parse(JSON.stringify(item)));

        // Vérification robuste du canal Slack
        if (!item.canal_slack || !item.canal_slack.slack_id) {
            // alert("Erreur : Aucun canal Slack configuré ou ID manquant");
            return;
        }

        // Construction sécurisée du message
        const getSafeValue = (value, defaultValue = 'Non renseigné') => {
            return value !== undefined && value !== null ? value : defaultValue;
        };
        const rawDetails = item.detail || '';

        const formattedDetails = rawDetails
            .split('\n')
            .filter(line => line.trim() !== '')
            .map(detail => `\t◦ ${detail.trim()}`)
            .join('\n');

        const messageParts = [
            // `*${"Rapport d'Assistance"}*`,
            // `${getSafeValue(item.date_fr)}`,
            `*Collecté par :* @${getSafeValue(item.collecteur?.name)}`,
            `*Rapporté par :* ${getSafeValue(item.rapporteur)}`,
            `• *Détails :*`,
            formattedDetails,
            `@${getSafeValue(item.assigne?.name)} `,
        ];


        const message = messageParts.join('\n');
        console.log("Message Slack généré:", message);

        // Envoi à l'API
        $http.post('/guindy_manager/public/send-to-slack', {
            channel: item.canal_slack.slack_id,
            message: message
        })
            .then(response => {
                // alert('Message envoyé avec succès à Slack');
                console.log("Réponse Slack:", response.data);
            })
            .catch(error => {
                console.error("Erreur d'envoi Slack:", error);
                // alert(`Erreur: ${error.data?.error || 'Problème de communication avec Slack'}`);
            });
    };





    // $scope.playAudio = function ()
    // {
    //     var audio = new Audio(BASE_URL+'sounds/newnotif.mp3');
    //     audio.play();

    // };

    window.Echo.channel('rt')
        .listen('RtEvent', (e) => {
            console.log('event page dans bingo');
            // Si je détecte que nous   sur la page de la liste items concerné, on fait un refresh en passant par le pageChanged
            if ($scope.linknav.indexOf("list-" + e.data.type) !== -1) {
                $timeout(function () {
                    $scope.pageChanged(e.data.type);
                }, 3000);
            }
        });



    var user_id = $('body').attr('data-user_id');
    var channelNotifName = 'notifs.' + user_id;
    window.Echo.channel(channelNotifName)
        .listen('SendNotifEvent', (e) => {
            console.log("ici dans ma donnees  event", e)
            var notif_id = e.notif_perm_user.id;
            reqwrite = "notifpermusers" + "(id:" + notif_id + ")";
            setTimeout(function () {
                Init.getElement(reqwrite, listofrequests_assoc["notifpermusers"]).then(function (data) {
                    var notifpermuser = data[0];
                    if (notifpermuser && notifpermuser.notif) {
                        console.log('récupération de la notification', notifpermuser.notif);
                        $scope.playAudio();
                        $scope.showToast("", notifpermuser.notif.message, "info", false, notifpermuser.link);
                        if (notifpermuser.notif.icon != "import") {
                            $scope.pageChanged(notifpermuser.notif.icon);
                        }
                        $scope.getElements("notifpermusers");
                    }
                }, function (msg) {
                    $scope.showToast('', msg, 'error');
                });
            }, 15000);
        });

    $scope.reInit = function (selector = "", classReinit = null) {

        //console.log("diop reinit class",classReinit);

        $scope.cpt = 1;
        console.log('reInit =>', selector);
        setTimeout(function () {

            if (!classReinit || classReinit == "select2") {

                // select2
                $('.select2' + selector)
                    .off('change')
                    .on('change', OnChangeSelect2)
                    .each(function (key, value) {
                        if ($(this).data('select2')) {
                            $(this).select2('destroy');
                        }
                        var select2Options = {
                            //width: 'resolve',
                            placeholder: $(this).attr('placeholder') ? $(this).attr('placeholder').toUpperCase() : null
                        };

                        var wdselect;
                        if ($(this).attr('class').indexOf('modal') !== -1) {
                            console.log('select2 modal *********************', $(this).attr('id'));
                            select2Options.dropdownParent = $(this).parent().parent();
                            wdselect = '100%';
                        }

                        // Pour le initSearchEntity
                        var tagSearch = 'search_';
                        if ($(this).attr('class').indexOf(tagSearch) !== -1) {
                            // wdselect = ($(this).parent().width() - 50) + 'px';
                            //wdselect = '85%';
                            wdselect = '82%';

                            allClassEntity = $(this).attr('class').split(' ').filter(function (cn) {
                                return cn.indexOf(tagSearch) === 0;
                            });
                            if (allClassEntity.length > 0) {
                                getEntity = allClassEntity[0].substring(tagSearch.length, allClassEntity[0].length);
                                console.log('getEntity********************', $(this).attr('id'), getEntity);
                                select2Options.minimumInputLength = 2;

                                if (!!$(this).attr("maximumSelectionLength")) {
                                    select2Options.maximumSelectionLength = $(this).attr("maximumSelectionLength");
                                    select2Options.language = {
                                        maximumSelected: function (e) {
                                            return "Vous ne pouvez sélectionner que " + e.maximum + " élément";
                                        }
                                    }
                                }

                                select2Options.ajax = setAjaxToSelect2OptionsForSearch(getEntity, $(this).attr('id'));
                            }
                        }


                        if ($(this).parent().hasClass('input-group') && $(this).parent().find('.input-group-append').length == 0) {
                            console.log('here am i');
                            var btnEmptySelect = $compile(angular.element(`<div style="display: flex; align-items: center;" class="input-group-append" >
                                <button style="display: flex; height: 33px; align-items: center; " type="button" class="ms-2 btn btn-sm btn-light-danger" title="Vider le bouton de selection" ng-click="emptyForm('` + $(this).attr('id') + `')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>`))($scope);

                            angular.element($(this).parent()).append(btnEmptySelect);
                        }
                        else if (!$(this).parent().hasClass('input-group')) {
                            wdselect = '100%';
                        }
                        // Pour affecter la bonne taille au champ select2 distant
                        if (!!wdselect) {
                            // $(this).css("width", wdselect + "% !important");
                            $(this).attr('style', 'width: ' + wdselect + ' !important;');
                            console.log("id select2 =>", $(this).attr('id'), " => ", wdselect);
                        }

                        console.log('select2', select2Options);
                        $(this).select2(select2Options);
                    });

            }

            // mobile-app-menu-btn
            $('.mobile-app-menu-btn').click(function () {
                $('.hamburger', this).toggleClass('is-active');
                $('.app-inner-layout').toggleClass('open-mobile-menu');
            });

            if (!classReinit || classReinit == "toggle") {
                // bootstrapToggle
                $('[data-toggle="toggle"]')
                    .bootstrapToggle('destroy')
                    .bootstrapToggle();
            }

            if (!classReinit || classReinit == "popover") {
                // Format options
                $('[data-toggle="popover"]').popover()
            }

            if (!classReinit || classReinit == "datedropper" || classReinit == "timedropper") {


                // datedropper day
                $('.datedropper').pickadate({
                    format: 'dd/mm/yyyy',
                    selectMonths: true,
                    selectYears: true,
                    formatSubmit: 'dd/mm/yyyy',
                    onOpen: function () {
                        var $input = $(this.$node);

                        let datePickerTop = $input.attr('date-picker-top') === "true";

                        if (datePickerTop) {
                            var $picker = this.$root, $container = $input.closest('div'), $td = $input.closest('td');
                            $picker.addClass('custom-datepicker');

                        }


                    }
                }).attr('autocomplete', 'off')
                    .attr('readonly', 'true');



                // datedropper month
                $('.datemonth').pickadate({
                    format: 'mm/yyyy',
                    formatSubmit: 'mm/yyyy',
                    hiddenPrefix: 'prefix__',
                    hiddenSuffix: '__suffix',
                    selectMonths: true,
                    selectYears: true,
                }).attr('autocomplete', 'off')
                    .attr('readonly', 'true');

                // datedropper month
                $('.dateyear').pickadate({
                    format: 'yyyy',
                    formatSubmit: 'yyyy',
                    hiddenPrefix: 'prefix__',
                    hiddenSuffix: '__suffix',
                    selectYears: true,
                }).attr('autocomplete', 'off')
                    .attr('readonly', 'true');

                $('.timedropper').pickatime({
                    format: 'H:i',
                    formatSubmit: 'H:i',
                    clear: 'clair',
                    close: 'Fermer',
                });

                $('.datetimedropper').pickatime({
                    format: 'dd/mm/yyyy H:i',
                    formatSubmit: 'H:i',
                    clear: 'clair',
                    close: 'Fermer',
                });


                // Pour affecter la date du jour par défaut à certains champs
                //$('.date-today').val($scope.donneDateToday());
                $('.date-today').each(function () {
                    if ($(this).hasClass('set-date-today')) {
                        //$(this).val($scope.getDateOfTheDay());
                    }
                });

            }

            if (classReinit) {
                if (classReinit == "owl-carousel") {
                    $('.owl-carousel').owlCarousel('destroy').owlCarousel({
                        loop: false,
                        margin: 10,
                        nav: false,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 3
                            },
                            1000: {
                                items: 3
                            }
                        }
                    });
                }
                else if (classReinit == "slick-slider-responsive") {
                    if ($(".slick-slider-responsive").hasClass('slick-initialized')) {
                        $(".slick-slider-responsive").slick('unslick');
                    }
                    $(".slick-slider-responsive").slick({
                        dots: true,
                        arrows: false,
                        infinite: false,
                        speed: 500,
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        initialSlide: 0,
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 3,
                                    infinite: true,
                                    dots: true
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 2,
                                    initialSlide: 2
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                }
                else if (classReinit == "knob") {
                    $('.knob').knob({

                        'width': 65,
                        'height': 65,
                        'max': 100,

                        change: function (value) {
                            //console.log("change : " + value);
                        },
                        release: function (value) {
                            //console.log(this.$.attr('value'));
                            console.log("release : " + value);
                        },
                        cancel: function () {
                            console.log("cancel : ", this);
                        },
                        format: function (value) {
                            return value + '%';
                        },
                        draw: function () {

                            // "tron" case
                            if (this.$.data('skin') == 'tron') {

                                this.cursorExt = 1;

                                var a = this.arc(this.cv)  // Arc
                                    , pa                   // Previous arc
                                    , r = 1;

                                this.g.lineWidth = this.lineWidth;

                                if (this.o.displayPrevious) {
                                    pa = this.arc(this.v);
                                    this.g.beginPath();
                                    this.g.strokeStyle = this.pColor;
                                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                                    this.g.stroke();
                                }

                                this.g.beginPath();
                                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                                this.g.stroke();

                                this.g.lineWidth = 2;
                                this.g.beginPath();
                                this.g.strokeStyle = this.o.fgColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                                this.g.stroke();

                                return false;
                            }
                        }
                    });
                }
            }

        }, 1000);
    };

    // TODO: a supprimer
    // $scope.addfield = function (type = null, from) {
    //     var objet = null;
    //     if (type == 'document_image') {
    //         var index = parseInt(Math.random() * 1000);
    //         objet = {
    //             'id': index,
    //             'name': 'img' + index + 'produit',
    //             'identify': 'affimg' + index + 'produit',
    //             'erase_id': 'erase_img' + index + 'produit',
    //             'value': 'image' + index
    //         };
    //         $scope.dataInTabPane['images_' + from]['data'].push(objet);
    //     }
    // }

    $scope.generateAddFiltres = function (currentpage) {
        currentpage = `_list_${currentpage}`;
        var addfiltres = "";
        var title = "";
        var currentvalue = "";
        var can_add = true;
        $("input[id$=" + currentpage + "], textarea[id$=" + currentpage + "], select[id$=" + currentpage + "]").each(function () {
            title = $(this).attr("id");
            title = title.substring(0, title.length - currentpage.length);
            currentvalue = $(this).val();
            let currentvalue1 = $(this).val();

            let toInt = false, toBool = false;

            if ($(this).attr("type-value")) {
                if ($(this).attr('type-value') === "int") {
                    toInt = true;
                }
                else if ($(this).attr('type-value') === "bool") {
                    toBool = true;
                }
            }

            if (currentvalue && title.indexOf('searchtexte') === -1) {
                console.log('here =>', currentpage, 'titre filtre ==>', $(this).attr("id"), title, 'value =>', currentvalue);

                can_add = true;

                if ($(this).is("select")) {
                    title = `${title}_id`;
                    if ($(this).prop("multiple")) {
                        if (currentvalue.length == 0) {
                            can_add = false;
                        }
                        else {
                            currentvalue1 = `"${currentvalue}"`;
                            if (toInt) {
                                currentvalue1 = parseInt(currentvalue);
                            }
                            if (toBool) {
                                currentvalue1 = currentvalue == "true" ? true : false;
                            }
                            currentvalue = currentvalue1;
                            console.log('title =>', title, 'currentvalue =>', currentvalue);
                        }
                    }
                    if ($(this).attr("data-rewrite-attr") && $(this).attr("data-rewrite-attr").toLowerCase() == "text") {
                        title = title.replace('_id', '');
                        if (currentvalue1) {
                            currentvalue1 = `"${currentvalue}"`;

                            if (toInt) {
                                currentvalue1 = parseInt(currentvalue);
                            }
                            if (toBool) {
                                currentvalue1 = currentvalue == "true" ? true : false;
                            }

                            currentvalue = currentvalue1;
                        }
                        console.log("jacques ======>", title, currentvalue);
                    }
                }
                else if ($(this).is("input") || $(this).is("textarea")) {
                    console.log('radio', $(this).attr('name'));
                    if ($(this).attr('type') === 'radio') {
                        title = $(this).attr('name');

                        currentvalue = $("#" + $(this).attr("id") + "[name='" + title + "']:checked").attr("data-value");
                        if (addfiltres.indexOf(title) !== -1 || !currentvalue) {
                            can_add = false;
                        }
                        console.log('title =>', title, 'currentvalue =>', currentvalue);
                    }
                    if ($(this).attr('type') === 'checkbox') {
                        // rien pour le moment
                    }
                    if ($(this).attr('type') === 'number') {

                    }
                    if ($(this).attr('type') === 'date' || $(this).attr('type') === 'time' || $(this).attr('type') === 'text' || $(this).is("textarea")) {
                        currentvalue1 = `"${currentvalue}"`;
                        if (toInt) {
                            currentvalue1 = parseInt(currentvalue);
                        }
                        currentvalue = currentvalue1;
                    }
                }

                if (currentvalue && title.indexOf('searchoption') !== -1) {
                    title = currentvalue;
                    currentvalue = $('#searchtexte' + currentpage).val();
                    currentvalue1 = `"${currentvalue}"`;
                    if (toInt) {
                        currentvalue1 = parseInt(currentvalue);
                    }
                    currentvalue = currentvalue1;

                    if (!currentvalue) {
                        can_add = false;
                    }
                }

                if ($(this).hasClass('filter') && $(this).attr('data-filter')) {
                    title = $(this).attr('data-filter');
                }

                if (can_add) {
                    addfiltres = `${addfiltres},${title}:${currentvalue}`;
                }
            }

        });


        return addfiltres;
    };

    $scope.isPortrait = true;
    $scope.isMobile = false;
    $scope.goToPortrait = function (isPortrait) {
        $scope.isPortrait = isPortrait;
    }

    $(document).ready(function () {
        window.onresize = function (event) {
            var width = $(window).width();
            if (width >= 1060) {
                $scope.isPortrait = false;
                $scope.$apply();
            }
            else {
                $scope.isPortrait = true;
                $scope.isMobile = true;
                $scope.$apply();
            }
        };
    })

    $scope.redefineSetTimeOut = function (currentSelect, setValue = null) {
        let val = "";
        if (currentSelect.prop("multiple")) {
            val = [];
        }
        if (setValue !== null && setValue !== undefined) {
            val = setValue;
        }

        setTimeout(function () {
            let additionalData = [currentSelect.attr('additionalData') ?? null];
            currentSelect.val(val).trigger("change", additionalData);
        }, 0);
    };

    $scope.emptyForm = function (type, fromPage = false, optionals = { addFilters: false, tagFilter: null, tagToIgnore: null, setDefaultValue: true }) {
        var tagTofilter = type;
        var tagToIgnore = [];
        if (!!optionals.tagFilter) {
            tagTofilter = optionals.tagFilter
        }

        if (!!optionals.tagToIgnore) {
            tagToIgnore = optionals.tagToIgnore
        }

        $scope.disableEditFret = true;



        if (type.toLowerCase() === "ordretransit") {
            $scope["typeImportationOT"] = null;
            $scope["item_typeImportationOT"] = null;
            $scope["typeDossierOT"] = null;
            $scope["typeDossierSelected"] = null;
            $scope["item_typeDossierOT"] = null;
            $scope["noNeedFactureFret"] = false;
            $scope.skipedValue = {};
            $scope.showContainer = false;
            $.each($scope.racineHistory, function (u, v) {
                $scope.racineHistory[u].title = $scope.racineHistory[u].previousTitle;
            });

            $scope.showNumeroContainer = false;
            $scope.dataPage['typedossiers2'] = $scope.dataPage['typedossiers'];

            let endTag = "_ordretransit_iscorrect";
            let myTab = ["bls", "ffs", "ffts", "asres", "dpis", "bscs"];
            for (let i = 0; i < myTab.length; i++) {
                $scope[myTab[i] + endTag] = false;
            }

            $scope.applyScope();
        }

        if (type.toLowerCase().indexOf("dossier") !== -1) {
            let endTag = "_dossier_iscorrect";
            if (type.toLowerCase() === "dossier") {
                let myTab = ["manifestes", "notedetails", "rattachement", "declaration", "bae"];
                for (let i = 0; i < myTab.length; i++) {
                    $scope[myTab[i] + endTag] = false;
                }
            }
            else if (type.toLowerCase().endsWith("_dossier") !== -1) {
                $scope[type + "_iscorrect"] = false;
            }
        }

        if (type.toLowerCase() === "detailordretransit") {
            $scope.stepLink = 1;
            $scope.currentStepLink = null;
            $scope.showPrevBtnWizard = false;
            $scope.showNextBtnWizard = true;
            $scope.canClikOnglet = false;

            var allOnglet = $("#tab-detailordretransit-0 li a");

            allOnglet.removeClass('active');

            allOnglet.each(function () {
                var ongletId = $(this).attr('href');
                $(ongletId).removeClass('show active');
            });

            setTimeout(function () {
                var allOnglet1 = $("#tab-detailordretransit-0 li:not(.d-none) a");

                allOnglet1.on('click', function (event) {
                    if ($scope.canClikOnglet === true) {
                        $scope.currentStepLink = $(this).attr('href');
                        $scope.stepLink = allOnglet1.index($(this)) + 1;

                        $scope.showPrevBtnWizard = $scope.stepLink !== 1;
                        $scope.showNextBtnWizard = $scope.stepLink !== allOnglet1.length;

                        var hasOtherOnglets = $($scope.currentStepLink + " li:not(.d-none) a");

                        if (hasOtherOnglets.length > 0) {
                            $scope.stepLink += 1;
                            $scope.currentStepLink = hasOtherOnglets.first().attr('href');
                            hasOtherOnglets.first().tab('show');
                        }

                        $scope.applyScope();
                    }


                    // Empêcher le comportement par défaut du lien (si nécessaire)
                    event.preventDefault();
                });
            }, 1500);




            allOnglet.first().tab('show');
        }

        if (type.toLowerCase() === "marchandise") {
            $scope.disableEdit = true;
            $scope.typeMarchandiseIdModal = 2;
            setTimeout(() => {
                $("#nomenclature_complet_" + type).attr('disabled', true).attr('readonly', true);
            }, 1500);

        }

        if (type.toLowerCase() === "client") {
            $scope.gestion_entrepot_client = false;
        }

        if (type.toLowerCase() === "nomenclaturedouaniere") {
            $scope.codeNomenclature = "";
            $scope.selectedChap = null;
            $scope.code_chapitre_nomenclaturedouaniere = "";
            $scope.code_produit_nomenclaturedouaniere = "";
            $scope.code_uemoa_nomenclaturedouaniere = "";
            $scope.code_senegal_nomenclaturedouaniere = "";
        }

        $scope.roleview = null;
        $scope.dataInTabPane['permissions_role']['data'] = [];
        var eltToSetDefault = [];
        let dfd = $.Deferred();
        $('.ws-number').val("");

        $("[href^='#tab-add" + tagTofilter + "']").first().click(); // Pour ramener l'activation sur le first tab du formulaire
        $("input[id$=" + tagTofilter + "], textarea[id$=" + tagTofilter + "], select[id$=" + tagTofilter + "], button[id$=" + tagTofilter + "]").each(function () {
            title = $(this).attr("id");

            console.log("ici dans mon filtre  empty forme 1", title.indexOf('list_' + tagTofilter) == -1, tagTofilter)

            if ((title.indexOf('list_' + tagTofilter) == -1 || fromPage) && !tagToIgnore.includes($(this).attr("id"))) {
                console.log("ici dans mon filtre  empty forme 2", title, $(this).is("select"));

                if ($(this).is("select")) {


                    //currentSelect.val("").change();
                    if ($(this).attr('class').indexOf('search_') !== -1) {
                        $(this).find('option').each(function () {
                            $(this).remove();
                        });

                        // Ajouter pour permettre au formulaire de retourner quand même la propriété mais sans valeur
                        // Car si c'est retiré, en sérializant le formulaire, nous n'aurons pas l'attribut remonté dans les données
                        if ($(this).find('option[value=""]').length == 0) {
                            $(this).append(new Option('', ''));
                        }
                    }

                    currentSelect = $(this);
                    $scope.redefineSetTimeOut(currentSelect);
                    if (!!currentSelect.attr('data-options')) {

                        eltToSetDefault.push({
                            currentSelect: currentSelect.attr('id'),
                            datas: currentSelect.attr('data-options'),
                            useUpdateItem: currentSelect.attr('data-update-item')
                        });
                    }



                    // $(this).val('');
                }
                else if ($(this).is(":checkbox") || $(this).is(":radio")) {
                    //l'attribut data-default permet de prendre par defaut la valeur de l'attribut
                    let valueDefault = $(this).attr("data-default") === "true";

                    $(this).prop('checked', valueDefault);
                    if (!!$(this).attr("ng-model")) {
                        $scope[$(this).attr("ng-model")] = valueDefault;
                    }
                    if ($(this).attr("id").indexOf('_list') !== -1) {
                        $(`[name^='${$(this).attr("name")}']`).prop('checked', true);
                    }
                    if ($(this).is("[data-toggle]")) {
                        $(this).bootstrapToggle('destroy').bootstrapToggle();
                    }
                }
                else if ($(this).is(":file")) {
                    if ($(this).hasClass('filestyle')) {
                        $(this).filestyle('clear');

                        if ($(this).hasClass('reset-filestyle')) {
                            $(this).filestyle('placeholder', 'Aucun fichier choisi');

                            $("#clear_" + $(this).attr('id')).attr('name', '');
                        }
                    }
                    else {
                        getId = $(this).attr('id').substring(0, ($(this).attr('id').length - tagTofilter.length));
                        $('#' + getId + tagTofilter).val("");
                        $('#aff' + getId + tagTofilter).attr('src', imgupload);
                    }
                }
                else if ($(this).is(':input[type="color"]')) {
                    $(this).val("#ffffff").trigger("change");
                }
                // Pour affecter la date du jour par défaut sur certains champs après le emptyform
                else if ($(this).hasClass('datedropper') && $(this).hasClass('date-today')) {
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();

                    today = dd + '/' + mm + '/' + yyyy;
                    // var currentDate= new Date().toISOString().substring(0, 10)
                    console.log("ici dans le empty forme de ma date ", $(this).attr('id'))
                    $(this).val(today).trigger('change');
                }
                else if ($(this).hasClass('datedropper')) {
                    $(this).val("");
                    console.log("ici dans le empty forme de ma date 111 ", $(this).attr('id'))
                }
                else if ($(this).hasClass('datetimedropper')) {
                    $(this).val("");
                }
                else if ($(this).hasClass('qrcode_input')) {
                    $(this).val("");
                    $('#affqrcode_' + tagTofilter).attr('src', qrcodeImgDefault);
                }
                else if ($(this).hasClass('barcode_input')) {
                    $(this).val("");
                    $('#affbarcode_' + tagTofilter).attr('src', barcodeImgDefault);
                }
                else {
                    let valueDefault = "";
                    if ($(this).attr("data-default") !== undefined && $(this).attr("data-default") !== null && $(this).attr("data-default") !== "") {
                        valueDefault = $(this).attr("data-default");
                    }
                    $(this).val(valueDefault);
                }

                if (!$(this).hasClass('datedropper')) {
                    $(this).attr('disabled', false).attr('readonly', false);
                }
                if (!$(this).hasClass('datetimedropper')) {
                    $(this).attr('disabled', false).attr('readonly', false);
                }
            }
        });


        if (optionals && optionals.setDefaultValue === true) {
            $.each(eltToSetDefault, function (key, value) {
                let currentElt = $("#" + value.currentSelect);
                let timeOut = 2000;
                let keyElt = "id";

                if (currentElt.attr('data-use-timeout') !== undefined) {
                    if (!isNaN(parseInt(currentElt.attr('data-use-timeout')))) {
                        timeOut = parseInt(currentElt.attr('data-use-timeout'));
                    }
                }

                if (!!currentElt.attr('data-key')) {
                    keyElt = currentElt.attr('data-key');
                }

                setTimeout(() => {
                    let useScope = $scope["dataPage"];

                    if (!!value.useUpdateItem && !!$scope.updateItem) {
                        useScope = $scope["updateItem"][value.useUpdateItem];
                    }

                    if (!!useScope) {
                        let datas = useScope[value.datas];

                        if (datas && datas.length === 1) {
                            $scope.redefineSetTimeOut($(`#${value.currentSelect}`), datas[0][keyElt]);
                        }
                    }

                }, timeOut);
            });
        }

        // Pour rénitialiser les radio buttons à "tout"
        $("[type=radio].true").prop("checked", true).change();

        // On vide le tableau des items ici
        $.each($scope.dataInTabPane, function (keyItem, valueItem) {
            tagType = '_' + tagTofilter;
            if (keyItem.indexOf(tagType) !== -1) {
                $scope.dataInTabPane[keyItem]['data'] = []
            }
        });




        // Si on clique sur le bouton annuler
        if (fromPage) {
            console.log("ici dans mon filtre  empty forme ", type, optionals.tagFilter)
            $scope.pageChanged(type, optionals);

            //$scope.pageChanged(type);
        }

        return dfd.promise();
    };

    // $scope.emptyForm = function (type, fromPage = false, optionals)
    // {
    //     console.log("ici dans mon empty forme ",type)

    //     let dfd = $.Deferred();
    //     $('.ws-number').val("");
    //     $("[href^='#tab-add" + type + "']").first().click(); // Pour ramener l'activation sur le first tab du formulaire
    //     $("input[id$=" + type + "], textarea[id$=" + type + "], select[id$=" + type + "], button[id$=" + type + "]").each(function ()
    //     {

    //         title = $(this).attr("id");

    //         if(title.indexOf('list_'+type)==-1 )
    //         {
    //             if ($(this).is("select"))
    //             {
    //                 currentSelect = $(this);
    //                 $scope.redefineSetTimeOut(currentSelect);
    //                 //currentSelect.val("").change();
    //                 if ($(this).attr('class').indexOf('search_')!==-1)
    //                 {
    //                     $(this).find('option').each(function()
    //                     {
    //                         $(this).remove();
    //                     });
    //                 }
    //                 $(this).val('');
    //             }


    //             else if ($(this).is(":checkbox") || $(this).is(":radio"))
    //             {
    //                 $(this).prop('checked', false);
    //                 if ($(this).attr("id").indexOf('_list')!==-1)
    //                 {
    //                     $( `[name^='${$(this).attr("name")}']` ).prop('checked', true);
    //                 }
    //                 if ($(this).is("[data-toggle]"))
    //                 {
    //                     $(this).bootstrapToggle('destroy').bootstrapToggle();
    //                 }
    //             }
    //             else if ($(this).is(":file"))
    //             {
    //                 if ($(this).hasClass('filestyle'))
    //                 {
    //                     $(this).filestyle('clear');
    //                 }
    //                 else
    //                 {
    //                     getId = $(this).attr('id').substring(0, ($(this).attr('id').length - type.length));
    //                     $('#' + getId + type).val("");
    //                     $('#aff' + getId + type).attr('src', imgupload);
    //                 }
    //             }
    //             else if ($(this).hasClass('datedropper'))
    //             {
    //                 $(this).val("");
    //             }
    //             else if ($(this).hasClass('datetimedropper'))
    //             {
    //                 $(this).val("");
    //             }

    //             else if ($(this).hasClass('qrcode_input'))
    //             {
    //                 $(this).val("");
    //                 $('#affqrcode_' + type).attr('src', qrcodeImgDefault);
    //             }
    //             else if ($(this).hasClass('barcode_input'))
    //             {
    //                 $(this).val("");
    //                 $('#affbarcode_' + type).attr('src', barcodeImgDefault);
    //             }
    //             else
    //             {
    //                 $(this).val("");
    //             }

    //             if (!$(this).hasClass('datedropper'))
    //             {
    //                 $(this).attr('disabled', false).attr('readonly', false);
    //             }
    //             if (!$(this).hasClass('datetimedropper'))
    //             {
    //                 $(this).attr('disabled', false).attr('readonly', false);
    //             }
    //         }
    //     });



    //     // On vide le tableau des items ici
    //     $.each($scope.dataInTabPane, function(keyItem, valueItem)
    //     {
    //         tagType = '_' + type;
    //         if (keyItem.indexOf(tagType)!==-1)
    //         {
    //             $scope.dataInTabPane[keyItem]['data'] = []
    //         }
    //     });


    //     // Si on clique sur le bouton annuler
    //     if (fromPage)
    //     {
    //         if(type=='bingocloture')
    //         {
    //             type='bingo'
    //         }
    //         $scope.pageChanged(type, optionals);
    //     }

    //     return dfd.promise();
    // };

    // Pour les dates
    $scope.transformToInternationDateString = function (value) {
        if (value.indexOf('/') !== -1) {
            let valueArray = value.split('/')
            value = valueArray[1] + "/" + valueArray[0] + "/" + valueArray[2];
        }
        return value;
    }

    $scope.getDateWithMoment = function (dateValue, dateFormat) {
        return moment(dateValue, dateFormat).fromNow();
    };

    $scope.addDayToDate = function (date, nbr) {
        console.log("nbr => ", nbr)
        console.log("jourDabutString => ", date)
        //date = date.split("/");
        //date = new Date(date[1] + '/' + date[0] + '/' + date[2]);
        let newDate = new Date(date);

        let newDate_2 = newDate.setDate(newDate.getDate() + nbr);

        console.log('newDate_2 => ', newDate_2)

        return new Date(newDate_2);

        let ladate = new Date(newDate_2).toISOString();

        console.log('nbr => ', ladate)

        return ladate.split('T')[0];
    }


    // Generer le link file pour les exports
    $scope.generateDocument = function (type) {
        let url = 'generate-' + type;

        if ($scope.writeUrl !== "") {
            url += "?" + $scope.writeUrl.substr(1, $scope.writeUrl.length);
        }
        console.log('writeUrl', $scope.writeUrl);
        window.open($scope.BASE_URL + url, '_blank');
    };

    $scope.setDateToInitial = function (timestamp) {
        let dateString = new Date(timestamp);

        let jourNum = dateString.getDay();
        let jourStr = ""

        switch (jourNum) {
            case 0:
                jourStr = "Dim"
                break;
            case 1:
                jourStr = "Lun"
                break;
            case 2:
                jourStr = "Mar"
                break;
            case 3:
                jourStr = "Mer"
                break;
            case 4:
                jourStr = "Jeu"
                break;
            case 5:
                jourStr = "Ven"
                break;
            case 6:
                jourStr = "Sam"
                break;

            default:
                break;
        }

        return jourStr + " " + dateString.getDate()
    }




    $scope.saveElementInCookies = function (e, type = null) {
        startTagForm = "form_add";
        endTagForm = $(e.target).parents('form').attr('id').substr(startTagForm.length, $(e.target).parents('form').attr('id').length);

        if (e != null) {
            e.preventDefault();
        }

        // console.log('saveElementInCookies => ', $(e.target).parents('form').attr('id'));
        // var form = $('#form_add' +  type);
        var form = $('#' + $(e.target).parents('form').attr('id'));

        // A ne pas supprimer
        let form1 = [], form2 = {};
        $.each($scope.dataInTabPane, function (keyItem, valueItem) {
            tagType = '_' + endTagForm;
            if (keyItem.indexOf(tagType) !== -1) {
                tagDataInPage = keyItem.substring(0, (keyItem.length - (1 + endTagForm.length)));
                form1.push({ [tagDataInPage]: valueItem.data })
                //Rajouter Par diop pour gerer les tableaux dans la fonction checkInForm
                form2[tagDataInPage] = valueItem.data;
                // alert()
            }
        });

        swalWithBootstrapButtons.fire({
            /*title: "test",*/
            text: "Voulez vous sauvegarder les informations dans le brouillon ?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                data_form = { ...form.serializeObject(), ...form2, ...form1 };
                $cookies.putObject(endTagForm, data_form);
                console.log("ici le form 2", $cookies.getObject(endTagForm));

                $scope.showToast('', 'Sauvegarde réussie', 'success');
            }
            else if (result.dismiss === Swal.DismissReason.cancel) { }
        });

    };


    $scope.checkInForm = function (type, item, optionals = { forceChangeForm: false, isClone: false, transformToType: null }) {
        // var item = $cookies.getObject(type);

        console.log('checkInForm ===> item *************', type, item);

        var form = $('#form_add' + type);
        defineNewTimeOutAdd = 1500;

        form.parent().parent().blockUI_start();
        if (true) // all editing is manage here
        {
            defineNewTimeOut = 0;
            $.each(item, function (keyItem, valueItem) {
                if (keyItem.includes("hashKey")) {
                    return;
                }

                if (keyItem != "id") {

                    if (!Array.isArray(item[keyItem])) {
                        can_do = true;
                        can_set = false;
                        tagForm = keyItem;

                        // On set directement la propriété
                        if (keyItem.indexOf('_id') !== -1) {
                            tagForm = keyItem.substring(0, (keyItem.length - 3));
                            console.log('here am i', keyItem);
                        }
                        else if (keyItem.endsWith('_fr')) {
                            can_do = false;
                        }
                        else if (keyItem.indexOf('date') !== -1 && $('#' + tagForm + '_' + type).length > 0) {
                            let date_value = item[keyItem + ($('#' + tagForm + '_' + type).attr('type').toLowerCase() == 'text' ? "_fr" : "")];
                            let currentElt = $('#' + tagForm + '_' + type);
                            if (currentElt.hasClass('use-date-today') && !(!!date_value)) {
                                date_value = $scope.getDateOfTheDay();
                            }

                            // if (currentElt.attr("ng-model")) {
                            //     $scope[currentElt.attr("ng-model")] = date_value;
                            //     $scope.applyScope();
                            // }
                            let setIdInForm = '#' + tagForm + '_' + type;
                            $scope.forceChangeValueForm(setIdInForm, date_value, defineNewTimeOut);

                            //currentElt.val(date_value).trigger("change");
                            can_do = false;
                        }
                        else if (typeof item[keyItem] === 'object' && item[keyItem]) {
                            var findSearchClass = $('#' + tagForm + '_' + type).attr('class') ? $('#' + tagForm + '_' + type).attr('class').match(/(^|\s)(search\_[^\s]*)/) : null;
                            console.log('jacques here =====>', keyItem, findSearchClass, tagForm);

                            // Pour le select2 remote, il faut faire un traitement spécifique
                            if (findSearchClass && findSearchClass.length > 0) {
                                //findSearchClass =

                                // $('#' + tagForm + '_' + type).hasClass('search_' + tagForm.replaceAll('_', ''))
                                // tagForm = tagForm.replaceAll('_', '');

                                tagFormScope = findSearchClass[2].split('_')[1];
                                tagFormScope = tagFormScope.replaceAll('_', '');
                                //tagForm = tagForm.replaceAll('_', '');
                                can_set = true;
                                defineNewTimeOut = 0;
                                $scope[tagFormScope + 'Selected'] = item[keyItem];
                                $scope.dataPage[tagFormScope + 's'] = [];
                                $scope.dataPage[tagFormScope + 's'].push(item[keyItem]);

                                let additionalData = [$('#' + tagForm + '_' + type).attr('additionalData') ?? null];

                                $('#' + tagForm + '_' + type).append(new Option(item[keyItem].display_text, item[keyItem].id, false, true)).trigger("change", additionalData);
                                //$('#' + tagForm + '_' + type).val(item[keyItem].id).change();

                                console.log('jacques ========> icii select distant', tagForm, item, item[keyItem].id, $scope.dataPage[tagFormScope + 's']);
                            }
                            else {
                                can_do = false;
                            }

                            // // Pour le select2 remote, il faut faire un traitement spécifique
                            // if ($('#' + tagForm + '_' + type).hasClass('search_' + tagForm.replaceAll('_', ''))) {
                            //     tagForm = tagForm.replaceAll('_', '');
                            //     can_set = true;
                            //     defineNewTimeOut = 0;
                            //     $scope[tagForm + 'Selected'] = item[keyItem];
                            //     $scope.dataPage[tagForm + 's'] = [];
                            //     $scope.dataPage[tagForm + 's'].push(item[keyItem]);
                            //     $('#' + tagForm + '_' + type).val(item[keyItem]).change();

                            //     $('#' + tagForm + '_' + type).append(new Option(item[keyItem].display_text, item[keyItem].id, false, true)).change();


                            //     console.log('jacques ========>', tagForm, $scope.dataPage[tagForm + 's']);
                            // }
                            // else
                            // {
                            //     can_do = false;
                            // }
                        }

                        //console.log('keyItem ===== >', keyItem, item[keyItem]);

                        if (can_do) {


                            if (!can_set && !(item[keyItem] === undefined || item[keyItem] === null || item[keyItem] === "")) {
                                //tagForm = tagForm.replaceAll('_', '');
                                setIdInForm = '#' + tagForm + '_' + type;
                                if ($('[id ^=' + tagForm + '][id $=' + type + ']').is(':radio'))
                                // if ($(setIdInForm).is(':radio'))
                                {
                                    setIdInForm = '#' + tagForm + '_' + item[keyItem] + '_' + type;
                                }
                                //console.log('keyItem ===== >', setIdInForm,tagForm, new Date().toTimeString());
                                $scope.forceChangeValueForm(setIdInForm, item[keyItem], defineNewTimeOut);
                                defineNewTimeOut += defineNewTimeOut;
                            }
                            if (can_set) {
                                defineNewTimeOut = 1500;
                                defineNewTimeOutAdd += defineNewTimeOut;
                                can_set = false;
                            }
                            //typeof item[keyItem]== "boolean"

                        }
                    }
                    else if (Array.isArray(item[keyItem])) {
                        if (typeof item[keyItem] === "object") {
                            // object
                            console.log("item[keyItem] after check", keyItem, item[keyItem]);
                            $scope.checkdataInTabPane(type, item[keyItem], keyItem);
                        }
                        // Pour le select2 multiple
                        tagForm = keyItem;
                        if ($('#' + tagForm + '_' + type).prop('multiple')) {
                            liste_selectmultiples = [];
                            if (typeof item[tagForm][0] === 'object') {
                                $.each(item[tagForm], function (keyItem, valueItem) {
                                    liste_selectmultiples.push(valueItem.id);
                                });
                            }
                            else {
                                liste_selectmultiples = item[tagForm]; // dans le cas d'un retour en tableau avec les Ids directement
                            }

                            var findSearchClass = $('#' + tagForm + '_' + type).attr('class') ? $('#' + tagForm + '_' + type).attr('class').match(/(^|\s)(search\_[^\s]*)/) : null;
                            if (findSearchClass && findSearchClass.length > 0) // Pour le rafraichissement des champs select2 multiple distant
                            {
                                $.each(item[tagForm], function (keyItem, valueItem) {
                                    $('#' + tagForm + '_' + type).append(new Option(valueItem.display_text, valueItem.id, false, true)).trigger("change");
                                });
                            }
                            else {

                                $('#' + tagForm + '_' + type).val(liste_selectmultiples).trigger("change", ["ignore"]);
                            }
                        }
                        else {
                            keyItemPos = keyItem.lastIndexOf(type) !== -1 ? keyItem.lastIndexOf(type) : keyItem.indexOf('_');
                            // Si le tableau ne contient pas le mot clé de la donnée, la propriété ici sera tagDataInPage_{type}
                            if (keyItemPos === -1) {
                                tagDataInPage = keyItem;
                            }
                            // Si le tableau le contient et qu'il se trouve au tout début, on récupère ce qui vient après le mot clé en y ajoutant un s et on fera la concaténation avec le type
                            else if (keyItemPos == 0) {
                                startRecup = "";
                                tagDataInPage = keyItem.substring((type.length + 1), (keyItem.length - 1)) + 's';
                                console.log('tagDataInPage =>', keyItemPos, "de=>", ((type.length + 1)), 'jusqua=>', (keyItem.length - 1), tagDataInPage, keyItem, item[keyItem]);
                            }
                            // Si le tableau le contient et qu'il se trouve après le début, on récupère ce qui vient avant le mot clé et on fera la concaténation avec le type
                            else if (keyItemPos > 0) {
                                tagDataInPage = keyItem.substring(keyItemPos + 1);
                                console.log('tagDataInPage ==>', (keyItem.length - 1), keyItem.indexOf(type), keyItemPos, tagDataInPage, keyItem, item[keyItem]);
                            }
                            console.log('je pense que tagDataInPage ==> ', tagDataInPage + '_' + type, " keyItem ==>", keyItem);
                            if ($scope.dataInTabPane && $scope.dataInTabPane[tagDataInPage + '_' + type]) {
                                $scope.dataInTabPane[tagDataInPage + '_' + type]['data'] = item[keyItem];
                            }
                        }
                    }
                }
            });

            if (!!item.files) // pour tout ce qui est fichier multiple
            {
                // alert('here');
                $.each(item.files, function (keyItem, valueItem) {
                    $(document).ready(function () {
                        $('#' + valueItem.name).val("").attr('required', false).removeClass('required');
                        $('#' + valueItem.identify).attr('src', ((isValide(valueItem.url) == 1) ? valueItem.url : 'assets/media/svg/icons/sidebar/icon-file-check.svg')).trigger('change');
                    });
                });
            }


            var liste_selectmultiples = [];
            if (type.indexOf("role") !== -1) {
                $scope.roleview = item;
                $.each(item.permissions, function (key, value) {
                    $("[id^=permission_role][data-permission-id=" + value.id + "]").prop('checked', true);
                });
                $scope.addToRole();
            }
            else if (type.indexOf('user') !== -1) {
                setTimeout(function () {
                    var liste_selectmultiples = [];
                    console.log('ici le resultat de mon item =>', item)

                    if (item.user_point_bingos) {
                        liste_selectmultiples = [];
                        $.each(item.user_point_bingos, function (keyItem, valueItem) {
                            liste_selectmultiples.push(valueItem.point_bingo_id);
                        });
                        $('#pointbingos_' + type).val(liste_selectmultiples).trigger("change");
                    }
                    $('#role_' + type).val(item.role_id).trigger("change");

                    // $('#email_' + type).attr('readonly', true);
                }, 2000);

            }
            else if (type.indexOf('entrepot') !== -1) {
                setTimeout(function () {
                    $('#num_id_douaniere_' + type).val(item.num_id_douaniere).trigger("change");
                }, 2000);
            }
            else if (type.indexOf('dossier') !== -1) {
                setTimeout(function () {
                    //$('#type_dossier_' +item.type_dossier_id+"_"+ type).val(item.item.type_dossier_id).trigger("change");
                    $('#type_dossier_' + item.type_dossier_id + "_" + type).prop('checked', true);
                }, 1000);

                $scope.traitementSpecifique('manifestes_dossier', optionals);
            }
            else if (type.indexOf('ordretransit') !== -1) {
                $scope.traitementSpecifique('bls_ordretransit', optionals);
                $scope.traitementSpecifique('ffs_ordretransit', optionals);
                $scope.traitementSpecifique('ffts_ordretransit', optionals);
                $scope.traitementSpecifique('asres_ordretransit', optionals);
                $scope.traitementSpecifique('dpis_ordretransit', optionals);
                $scope.traitementSpecifique('bscs_ordretransit', optionals);
                $scope.traitementSpecifique('documents_ordretransit', optionals);
            }
            else if (type.indexOf('preference') !== -1) {
                setTimeout(function () {
                    $('.valed').addClass("d-none");
                    $('.colored').addClass("d-none");
                    if (item.valeur == '' || item.valeur == ' ' || item.valeur == null) {
                        $('.colored').removeClass("d-none");
                    }
                    else {
                        $('.valed').removeClass("d-none");
                    }
                    console.log("ici dans ma preference ", item.valeur)

                }, 1000);
            }


            // Si les tabpanes contient des lignes select2 à refresh, cela se fera dynamiquement
            $.each($scope.dataInTabPane, function (keyItem, valueItem) {
                tagType = '_' + type;
                if (keyItem.indexOf(tagType) !== -1) {
                    $.each($scope.dataInTabPane[keyItem]['data'], function (key, oneItem) {

                        if (keyItem === "users_client") {
                            $scope.dataInTabPane[keyItem]['data'][key].imageName = "img_users_" + key;
                            $scope.dataInTabPane[keyItem]['data'][key].eraseName = "img_users_" + key + "_erase";
                        }


                        // dans le cadre d'une clone, on ne doit pas récupérer les ids pour éviter que les données soient écrasées
                        if (!!optionals && !(!optionals.isClone && !optionals.transformToType)) {
                            delete $scope.dataInTabPane[keyItem]['data'][key].id;
                        }

                        setTimeout(function () {
                            $.each(oneItem, function (keyOneItem, valueOneItem) {
                                if (keyOneItem.indexOf('_id') != -1) {
                                    $('#' + keyOneItem.substring(0, keyOneItem.length - 3) + '_' + keyItem + '_' + [key]).val(oneItem[keyOneItem]).trigger('change', ["custom"]);
                                }
                            });
                        }, 1000);
                    });
                }
            });



        }


        // Si le model contient une image dans son formulaire
        if (item.image !== undefined) {
            $('#img' + type)
                .val("")
                .attr('required', false).removeClass('required');
            $('#affimg' + type).attr('src', (item.image ? item.image : imgupload));
        }

        // Si le modal contient des champs password
        $('#password_' + type).val("").removeClass('required');
        $('#confirmpassword_' + type).val("").removeClass('required');
        $('#password_confirm_' + type).val("").removeClass('required');

        $("#modal_add" + type).modal('show');
        setTimeout(function () {
            form.parent().parent().blockUI_stop();
        }, defineNewTimeOutAdd + parseInt(defineNewTimeOutAdd / 2));
    };
    $scope.checkTabInForm = function (type, item, tagForm) {

    }


    $scope.forceChangeValueForm = function (idAttr, valueAttr, timeOut) {
        console.log('jacques ==========>', idAttr, valueAttr, timeOut);
        console.log('timeOut====================', timeOut, idAttr);
        if (!!$(idAttr).attr("scope-to-set")) {
            $scope[$(idAttr).attr("scope-to-set")] = valueAttr;
            $scope.applyScope();
        }
        setTimeout(function () {
            // Pour l'image, au rechargement, on va set le placeholder
            if ($(idAttr + '[type=file]').length == 1) {
                $(idAttr + '[type=file]').parent().find('input[type=text]').attr('placeholder', valueAttr);
                return;
            }

            if ($(idAttr).is(":checkbox") || $(idAttr).is(":radio")) {
                setTimeout(() => {

                    $(idAttr).prop("checked", valueAttr).trigger("change");

                    //Set le ng-model du input Radio ou checkbox s'il existe
                    if (!!$(idAttr).attr("ng-model")) {
                        $scope[$(idAttr).attr("ng-model")] = valueAttr;
                        $scope.applyScope();
                    }

                }, (!!$(idAttr).attr("data-timeout") ? parseInt($(idAttr).attr("data-timeout")) : 0));
            }
            else {

                setTimeout(() => {
                    let additionalData = [$(idAttr).attr('additionalData') ?? null];
                    console.log('jacques ==========> 1', idAttr, valueAttr, parseInt($(idAttr).attr("data-timeout")));

                    $(idAttr).val(valueAttr).trigger("change", additionalData);

                    if (!!$(idAttr).attr("ng-model")) {
                        //$scope[$(idAttr).attr("ng-model")] = valueAttr;
                        $scope.applyScope();
                    }
                }, (!!$(idAttr).attr("data-timeout") ? parseInt($(idAttr).attr("data-timeout")) : 0));
            }
            //Un element qui a un l'attribut emitChange egal a true
            //declenchera la fonction radioChanged ne pas oublier l'attribut scopeItem pour recuperer l'item en cours
            if ($(idAttr).attr("emitChange") === "true") {
                let firstArg = $(idAttr).attr("id");

                if (!!$(idAttr).attr("idEmit")) {
                    firstArg = $(idAttr).attr("idEmit");
                }

                let myObj = null;

                if (!!$(idAttr).attr("scopeItem")) {
                    myObj = JSON.parse($(idAttr).attr("scopeItem"));
                }

                // $scope.$emit('radioChanged', firstArg, myObj);
            }
        }, timeOut);
    };

    $scope.datatoggle = function (href, addclass) {
        $(href).attr('class').match(addclass) ? $(href).removeClass(addclass) : $(href).addClass(addclass);
    };


    $scope.eraseFile = function (idInput, index = 0) {
        console.log("diop erase file", idInput, index);
        if (idInput.indexOf('_ordretransit') !== -1 || idInput.indexOf('_dossier') !== -1) {
            imgupload = BASE_URL + 'assets/media/svg/icons/sidebar/icon-file-upload.svg';
            // A l'avenir on pourra jouer sur l'attribut url
            // supprimer cet attribut et au niveau du controller
            // si l'id est défini et l'url non défini, on comprend que l'image a été supprimé
            // et on fait le traitement

            let dataTabPane = $('#' + idInput).attr("data-tabpane");

            if (!!dataTabPane && !!$scope.dataInTabPane[dataTabPane]) {
                $scope.dataInTabPane[dataTabPane]['data'][index].files[0].erase = $scope.dataInTabPane[dataTabPane]['data'][index].files[0].name;
                if ($scope.dataInTabPane[dataTabPane]['data'][index].files[0].name.indexOf('_') === -1) {
                    $scope.dataInTabPane[dataTabPane]['data'][index].files[0].name = $scope.dataInTabPane[dataTabPane]['data'][index].files[0].name + '_';

                    idInput = $scope.dataInTabPane[dataTabPane]['data'][index].files[0].name;
                }
                if ('id' in $scope.dataInTabPane[dataTabPane]['data'][index].files[0]) {
                    delete $scope.dataInTabPane[dataTabPane]['data'][index].files[0].id;
                }
                console.log("erase =>", $scope.dataInTabPane[dataTabPane]['data'][index].files[0]);
            }

        }

        if (idInput.indexOf('img_users') !== -1) {
            imgupload = $scope.defaultFileUploadImg;
        }



        $('#' + idInput).val("");
        $('#erase_' + idInput).val("yes");
        $('#aff' + idInput).attr('src', imgupload);

        $scope.checkIfDocsCorrect($('#' + idInput).attr("data-tabpane"), true)
    };


    // Cocher tous les checkbox / Décocher tous les checkbox
    $scope.cocherTout = false;
    $scope.checkAllOruncheckAll = function (idAll = '#permission_all_role', nameAttr, valueAttr, elName = 'mycheckbox', optionals) {
        var cocherOuNon = $(idAll).prop('checked');

        $("[for=" + idAll.replace('#', '') + "]").find("[for=kt_roles_select_all]").html((cocherOuNon == true ? 'Unselect' : 'Select') + ' all');

        $scope.cocherTout = cocherOuNon;
        var el = '.' + elName;

        if (!!nameAttr && !!valueAttr) {
            el = el + ('[' + nameAttr + '=' + valueAttr + ']');
        }

        console.log("el ===>", el);

        $(el).prop('checked', cocherOuNon);

        $scope.addToRole(null, undefined, optionals);
    };

    // Permet d'ajouter une permission à la liste des permissions d'un role
    // $scope.addToRole = function (e, itemId, idAll = '#permission_all_role')
    $scope.itemIds = [];
    $scope.itemIds2 = [];
    $scope.addToRole = function (e, itemId, optionals = { tagInput: 'permission_role', scopeName: 'dataInTabPane.permissions_role.data', attrName: 'data-permission-id', className: 'mycheckbox', btnAllId: 'permission_all_role' }) {
        $scope.dataReference = $scope[optionals.scopeName];

        if (optionals.scopeName.indexOf('.') !== -1) {
            var profondeurs = optionals.scopeName.split('.');
            $scope.dataReference = $scope[profondeurs[0]];

            $.each(profondeurs, function (keyItem, valueItem) {
                if (keyItem > 0) {
                    $scope.dataReference = $scope.dataReference[valueItem];
                }
            });
        }

        $scope.dataReference = [];
        $("[id^=" + optionals.tagInput + "]").each(function (key, value) {
            if ($(this).prop('checked')) {
                var permission_id = $(this).attr(optionals.attrName);
                $scope.dataReference.push(Number(permission_id));
            }
        });

        // TODO : a revoir
        if (optionals.scopeName.indexOf('.') === -1) {
            $scope[optionals.scopeName] = $scope.dataReference;
        }
        else {
            $scope.dataInTabPane[optionals.scopeName.split('.')[1]]['data'] = $scope.dataReference;
        }

        console.log("here am iiii", optionals.scopeName, $scope.dataReference, $scope[optionals.scopeName]);

        $('#' + optionals.btnAllId).prop('checked', ($("[id^=" + optionals.tagInput + "]").length == $scope.dataReference.length));
        $("[for=" + optionals.btnAllId + "]").find("[for=kt_roles_select_all]").html(($('#' + optionals.btnAllId).prop('checked') == true ? 'Unselect' : 'Select') + ' all');

        // if (!!e)
        // {
        $("[id^=type_role_]").each(function (key, value) {
            nb_checked = $("[id^=" + optionals.tagInput + "]" + '[data-typepermission-id=' + $(this).attr('data-type-id') + ']').filter(':checked').length;
            nb_total = $("[id^=" + optionals.tagInput + "]" + '[data-typepermission-id=' + $(this).attr('data-type-id') + ']').length;
            console.log('===+>', nb_checked, nb_total, $(this).attr('data-type-id'));

            $(this).prop('checked', (nb_checked > 0 && nb_total == nb_checked))
        });
        // }
    };

    //--------------------------------------------//
    //-----------------/UTILITAIRES----------------//
    //--------------------------------------------//


    $scope.cpt = 1;
    // additionalData est utilisé pour des besoins specifiques
    // pour précisement distinguer le change du dom d'avec le change depuis le code
    // par exemple lors de la modification des elements
    function OnChangeSelect2(e, additionalData) {
        console.log('on capte levent**************');
        var getId = $(this).attr("id");

        var checkIdIsCorrect = $(this).attr("data-id-iscorrect");
        var getValue = $(this).val();
        console.log('getId', getId, 'value', getValue, getValue === null, getValue === "undefined", getValue === "", !getValue, !!getValue)

        if ($(this).attr('data-setNgModel')) {
            $('#' + $(this).attr('data-setNgModel')).val(getValue).change();
            $scope[$(this).attr('data-setNgModel')] = null;
            $scope["displayText_" + $(this).attr('data-setNgModel')] = null;
            if (!!getValue) {
                $scope[$(this).attr('data-setNgModel')] = getValue;
                $scope["displayText_" + $(this).attr('data-setNgModel')] = $(this).children("option:selected").text();
            }
        }
        //pour recuperer tous les elements du projets selectionners
        if (getId.indexOf('projet_details_planification') !== -1) {
            if (getValue) {
                $scope.getElements("fonctionnalitemodules", { queries: ["projet_id:" + getValue] });
            }
            else {
                $scope.getElements("fonctionnalitemodules", { queries: ["projet_id:" + 0] });
            }
        }
        else if (getId.indexOf('fonctionnalite_fonctionnalite_module_planification') !== -1) {
            if (getValue) {
                $scope.getElements("tachefonctionnalites", { queries: ["fonctionnalite_module_id:" + getValue] });
            }
        }
        else if (getId.indexOf('fonctionnalite_module_details_planification') !== -1) {

            if (getValue) {
                $scope.fonctionnaliteSelected = getValue;
                $scope.getElements("tachefonctionnalites", { queries: ["fonctionnalite_module_id:" + getValue] });
            }
            else {
                $scope.fonctionnaliteSelected = null;
            }
        }
        //pour set l'attribut dans le tabPane a un index bien defini
        let tagTabPane = $(this).attr('data-useTabPane');
        let tagTabPaneIndex = parseInt($(this).attr('data-index'));
        if (!!tagTabPane && !!$(this).attr("ng-modelKey") && !!$scope.dataInTabPane[tagTabPane]['data']) {

            if (!isNaN(tagTabPaneIndex) && !!$scope.dataInTabPane[tagTabPane]['data'][tagTabPaneIndex]) {
                $scope.dataInTabPane[tagTabPane]['data'][tagTabPaneIndex][$(this).attr("ng-modelKey")] = getValue;
            }
            else if ($(this).attr("data-index") === "all") {
                let u = null;
                let p = $(this).attr("ng-modelKey");
                if (p.endsWith("_id")) {
                    u = p.substring(0, (p.length - 3));
                }

                $.each($scope.dataInTabPane[tagTabPane]['data'], function (key, value) {

                    value[p] = !isNaN(parseInt(getValue)) ? parseInt(getValue) : null;

                    if (!!u && !!$scope.dataPage[u + "s"]) {
                        let getItem = $scope.dataPage[u + "s"].find(item => item.id === parseInt(getValue));
                        value[u] = getItem;
                    }
                });

            }
        }


        if (!!$(this).attr('data-scopeModel') && !!$(this).attr('datas')) {
            let valObj = $(this).attr('data-keyObj') ?? "file_required"
            let allValue = $(this).attr('data-scopeModel').split(',');
            let allObject = valObj.split(',');
            let timeOut = $(this).attr('default-timeOut') ?? 0;
            let useScope = $scope;
            let allDefaultValue = ["1"];

            if (!!tagTabPane && !isNaN(tagTabPaneIndex)) {
                useScope = $scope.dataInTabPane[tagTabPane]['data'][tagTabPaneIndex];
            }

            if (!!$(this).attr('default-value')) {
                allDefaultValue = $(this).attr('default-value').split(',');
            }

            if (!!allDefaultValue && allDefaultValue.length === allValue.length && allValue.length === allObject.length) {
                for (let i = 0; i < allValue.length; i++) {
                    let y = allValue[i];
                    useScope[y] = allDefaultValue[i] === "1";

                    if (!!getValue) {
                        setTimeout(() => {
                            var tt = $scope.getObjetInTab($(this).attr('datas'), parseInt(getValue), allObject[i]);
                            useScope[y] = tt;
                            $scope.applyScope();
                            if (!!tagTabPane && y === 'file_required') {
                                $scope.checkIfDocsCorrect(tagTabPane, true)
                            }
                        }, timeOut);
                    }

                }
            }

            $scope.applyScope();
        }
        var endTagForm;

        if (!!getId) {
            endTagForm = getId.split("_")[getId.split("_").length - 1];
        }
        console.log("diop additional data", additionalData, getId, endTagForm);
        if (!additionalData) {
            let p = $(this).attr("sub-check-iscorrect") === "true";

            if (p && !!tagTabPane) {
                $scope.checkIfDocsCorrect(tagTabPane, true, !!getValue)
            }
            if (!!checkIdIsCorrect) {
                $scope.checkIfDocsCorrect(checkIdIsCorrect, false)
            }
            if (getId === "nomenclature_douaniere_marchandise") {
                $("#nomenclature_complet_marchandise").val("");

                if (!!getValue) {

                    optionals = { justTheseAttrs: "id,nom,chapitres_reverse{nom}", queries: [], setStateCursorToLoading: true, isPromise: true };
                    optionals.queries.push("id:" + getValue);

                    $scope.getElements("nomenclaturedouanieres", optionals).then(function (data) {
                        if (data.length === 1) {
                            var item = data[0];

                            var u = (item.chapitres_reverse ?? []).map(function (chapitre) {
                                if (!!chapitre && !!chapitre.nom) {
                                    return chapitre.nom.trim();
                                }
                                return "";

                            }).join(' --> ');

                            setTimeout(() => {
                                $("#nomenclature_complet_marchandise").val(item.nom + " --> " + u);
                            }, 500)

                        }

                    }
                        , function (msg) {
                            $scope.showToast("ERREUR", msg, 'error');
                        });
                }
            }
            else if (getId.indexOf("_nomenclaturedouaniere") !== -1) {
                /* if (getId === "chapitre_nomenclature_douaniere_nomenclaturedouaniere")
                {
                    $scope.selectedChap = null ;
                    if (!!getValue)
                    {
                        getCurrentItem = $scope.dataPage['chapitrenomenclaturedouanieres'].filter(item => (item.id == parseInt(getValue)));
                        if (getCurrentItem.length > 0)
                        {
                            $scope.selectedChap = getCurrentItem[0] ;
                        }
                        optionals = {justTheseAttrs: "id,nom,code", queries: [], setStateCursorToLoading: true, isPromise: true };
                        optionals.queries.push("chapitre_nomenclature_douaniere_id:" + getValue);

                        $scope.getElements("souschapitrenomenclaturedouanieres", optionals).then(function (data)
                        {
                            $scope.dataPage['souschapitrenomenclaturedouanieres'] = data ;
                            if ($scope.dataPage['souschapitrenomenclaturedouanieres'].length === 1)
                            {
                                setTimeout(()=>{
                                    $("#sous_chapitre_nomenclature_douaniere_nomenclaturedouaniere").val($scope.dataPage['souschapitrenomenclaturedouanieres'][0].id).trigger("change");
                                },800)
                            }

                        }
                        , function (msg)
                        {
                            $scope.showToast("ERREUR", msg, 'error');
                        });
                    }
                    else
                    {
                        let opt = {justTheseAttrs: "id,nom,code"};

                        $scope.getElements("souschapitrenomenclaturedouanieres",opt);
                    }

                } */

                if (getId === "sous_chapitre_nomenclature_douaniere_nomenclaturedouaniere") {
                    $scope.selectedChap = null;
                    if (!!getValue) {
                        optionals = { justTheseAttrs: "parents{id,code}", queries: [], setStateCursorToLoading: true, isPromise: true };
                        optionals.queries.push("id:" + getValue);
                        $scope.getElements("chapitrenomenclaturedouanieres", optionals).then(function (data) {
                            if (!!data) {
                                data = data[0];
                                $.each(data.parents, function (key, value) {
                                    if (value.code !== null && value.code !== undefined) {
                                        $scope.selectedChap = value;
                                        $scope.makeCodeNomenclature();
                                        return false;
                                    }
                                });
                            }
                        });
                    }
                }

                //$scope.makeCodeNomenclature();
            }
            else if (getId.indexOf('_ordretransit') !== -1) {
                if (getId.indexOf('marchandise_') !== -1) {
                    if ($scope.dataPage['marchandises'].length > 0) {
                        getCurrentItem = $scope.dataPage['marchandises'].filter(item => (item.id == getValue));
                        if (getCurrentItem.length > 0) {
                            $('#poids_' + getId.split('marchandise_')[1]).val(getCurrentItem[0].poids);
                        }
                    }
                }
                if (getId.indexOf("type_marchandise_") !== -1) {
                    $scope.manageMarchandise(getValue);
                }

                if (getId.indexOf("_marchandises_ordretransit") !== -1) {
                    if (getId.indexOf('type_dossier_') !== -1) {
                        getCurrentItem = $scope.dataPage['typedossiers2'].filter(item => (item.id == parseInt(getValue)));
                        if (getCurrentItem.length > 0) {
                            $scope["showExoTvaInMarchandise"] = getCurrentItem[0].show_exo;
                        }
                        else {
                            $scope["showExoTvaInMarchandise"] = false;
                        }
                    }
                }
                if (getId.indexOf("marchandises_ordretransit_") !== -1) {
                    if (!!$("#" + getId).attr("indextab") && $scope.dataInTabPane['marchandises_ordretransit']['data'].length > 0) {
                        if (getId.indexOf("type_dossier_") !== -1) {
                            let i = parseInt($("#" + getId).attr("indextab"));
                            let bgStyle = "";
                            let show_exo = true;
                            getCurrentItem = $scope.dataPage['typedossiersAll'].filter(item => (item.id == getValue));
                            if (getCurrentItem.length > 0) {
                                bgStyle = getCurrentItem[0].bgStyle ?? "";
                                show_exo = getCurrentItem[0].show_exo ?? true;
                            }

                            $scope.dataInTabPane['marchandises_ordretransit']['data'][i].bgStyle = bgStyle;
                            $scope.dataInTabPane['marchandises_ordretransit']['data'][i].show_exo = show_exo;
                        }

                        if (getId.indexOf("nomenclature_asuivre_") !== -1) {
                            let i = parseInt($("#" + getId).attr("indextab"));
                            let show_indication = false;
                            getCurrentItem = $scope['nomenclatureAsuivres'].filter(item => (item.id == getValue));
                            if (getCurrentItem.length > 0) {
                                show_indication = getCurrentItem[0].input_required ?? false;
                            }
                            $scope.dataInTabPane['marchandises_ordretransit']['data'][i].show_indication = show_indication;
                        }
                    }

                }


                if (getId === "client_ordretransit") {
                    setTimeout(function () {
                        $scope.manageClientWizard(getValue);
                    }, 0);

                }

                // En rajoutant le préfixant *all_* cela, permet de set toutes les lignes en fonction d'une valeur
                if (getId.indexOf('all_') !== -1) {
                    console.log('getCurrentItem =>', getId.split('all_'));
                    $('[id^=' + getId.split('all_')[1] + '_]').val(getValue).trigger('change');
                }
            }
            else if (getId.indexOf('_dossier') !== -1) {
                /* if (getId.indexOf('ordre_transit_') !== -1 && $scope.dataPage['ordretransits'].length > 0)
                {
                    getCurrentItem = $scope.dataPage['ordretransits'].filter(item => (item.id == getValue));
                    if (getCurrentItem.length > 0)
                    {
                        optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
                        optionals.queries.push("ordre_transit_id:" + getCurrentItem[0].id);
                        $scope.getElements("ordretransitbls", optionals).then(function (data)
                        {
                            $scope.dataPage['ordretransitbls'] = data;
                            console.log("les ordretransitbls remontés par le filtre gteId ==>", getId," data ==>", data);
                        }
                        , function (msg)
                        {
                            $scope.showToast("ERREUR", msg, 'error');
                        });
                    }
                }
                else */ if (getId.indexOf('famille_debour_') !== -1 && !!$scope.dataPage['familledebours'] && $scope.dataPage['familledebours'].length > 0) {
                    $scope.dataPage['articlefacturations2'] = [];
                    $scope.dataPage['fournisseurs2'] = [];
                    getCurrentItem = $scope.dataPage['familledebours'].filter(item => (item.id == getValue));
                    if (getCurrentItem.length > 0) {
                        optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
                        optionals.queries.push("famille_debour_id:" + getCurrentItem[0].id);
                        $scope.getElements("articlefacturations", optionals).then(function (data) {
                            $scope.dataPage['articlefacturations2'] = data;
                        }
                            , function (msg) {
                                $scope.showToast("ERREUR", msg, 'error');
                            });
                    }
                }
                else if (getId.indexOf('article_facturation_') !== -1 && $scope.dataPage['articlefacturations'].length > 0) {
                    $scope.dataPage['fournisseurs2'] = [];
                    getCurrentItem = $scope.dataPage['articlefacturations'].filter(item => (item.id == getValue));
                    if (getCurrentItem.length > 0) {
                        optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
                        optionals.queries.push("article_facturation_id:" + getCurrentItem[0].id);
                        $scope.getElements("fournisseurs", optionals).then(function (data) {
                            $scope.dataPage['fournisseurs2'] = data;
                        }
                            , function (msg) {
                                $scope.showToast("ERREUR", msg, 'error');
                            });
                    }
                }
                else if (getId.indexOf('article_notedetails_') !== -1) {
                    let readOnly = false, nomenclatureId = "", showQteComplementaire = "", labelQteComplementaire = "", designation = "", showValeurMercuriale = "";
                    if (!!getValue) {
                        let optionals = { queries: ["id:" + getValue], justTheseAttrs: "id,nom,marchandise{nomenclature_douaniere_id,nomenclature_douaniere{qte_complementaire,valeur_mercurial,unite_mesure{abreviation}}}", setStateCursorToLoading: true, isPromise: true };
                        $scope.getElements("ordretransitmarchandises", optionals).then(function (data) {
                            if (data && data.length === 1) {
                                readOnly = true;
                                designation = data[0].nom;
                                nomenclatureId = data[0].marchandise.nomenclature_douaniere_id;
                                showQteComplementaire = data[0].marchandise.nomenclature_douaniere.qte_complementaire;
                                showValeurMercuriale = data[0].marchandise.nomenclature_douaniere.valeur_mercurial !== null;
                                if (showQteComplementaire === true) {
                                    labelQteComplementaire = !!data[0].marchandise.nomenclature_douaniere.unite_mesure ? '(' + data[0].marchandise.nomenclature_douaniere.unite_mesure.abreviation + ')' : "";
                                }
                                else {
                                    $("#qte_complementaire_notedetails_dossier").val("").trigger("change", ["ignore"]);
                                }

                                $("#designation_notedetails_dossier").val(designation).trigger("change", ["ignore"]);
                                $("#nomenclature_douaniere_notedetails_dossier").val(nomenclatureId).trigger("change", ["ignore"]);
                                $("#show_qte_complementaire_notedetails_dossier").val(showQteComplementaire).trigger("change", ["ignore"]);
                                $("#show_valeur_mercuriale_notedetails_dossier").val(showValeurMercuriale).trigger("change", ["ignore"]);
                                $("#valeur_mercuriale_notedetails_dossier").val(data[0].marchandise.nomenclature_douaniere.valeur_mercurial).trigger("change", ["ignore"]);
                                $("#label_qte_complementaire_notedetails_dossier").val(labelQteComplementaire).trigger("change", ["ignore"]);
                                $scope.allowNgDisabled("nomenclature_douaniere_notedetails_dossier", readOnly);
                            }
                        });

                    }
                    else {
                        $("#designation_notedetails_dossier").val(designation).trigger("change", ["ignore"]);
                        $("#nomenclature_douaniere_notedetails_dossier").val(nomenclatureId).trigger("change", ["ignore"]);
                        $("#show_qte_complementaire_notedetails_dossier").val(showQteComplementaire).trigger("change", ["ignore"]);
                        $("#label_qte_complementaire_notedetails_dossier").val(labelQteComplementaire).trigger("change", ["ignore"]);
                        $("#valeur_mercuriale_notedetails_dossier").val("").trigger("change", ["ignore"]);
                        $("#show_valeur_mercuriale_notedetails_dossier").val(false);
                        $scope.allowNgDisabled("nomenclature_douaniere_notedetails_dossier", readOnly);
                    }





                }

                else if (getId.indexOf("nomenclature_douaniere_notedetails_") !== -1) {
                    let showQteComplementaire = "", labelQteComplementaire = "", showValeurMercuriale = "";
                    if (!!getValue) {
                        let optionals = { queries: ["id:" + getValue], justTheseAttrs: "qte_complementaire,valeur_mercurial,unite_mesure{abreviation}", setStateCursorToLoading: true, isPromise: true };
                        $scope.getElements("nomenclaturedouanieres", optionals).then(function (data) {
                            if (data && data.length === 1) {
                                showQteComplementaire = data[0].qte_complementaire;
                                showValeurMercuriale = data[0].valeur_mercurial !== null;
                                if (showQteComplementaire === true || showValeurMercuriale === true) {
                                    labelQteComplementaire = !!data[0].unite_mesure ? '(' + data[0].unite_mesure.abreviation + ')' : "";
                                }
                                else {
                                    $("#qte_complementaire_notedetails_dossier").val("").trigger("change", ["ignore"]);
                                }

                                $("#show_qte_complementaire_notedetails_dossier").val(showQteComplementaire).trigger("change", ["ignore"]);
                                $("#show_valeur_mercuriale_notedetails_dossier").val(showValeurMercuriale).trigger("change", ["ignore"]);
                                $("#valeur_mercuriale_notedetails_dossier").val(data[0].valeur_mercurial).trigger("change", ["ignore"]);
                                $("#label_qte_complementaire_notedetails_dossier").val(labelQteComplementaire).trigger("change", ["ignore"]);
                            }
                        });
                    }
                    else {
                        $("#show_qte_complementaire_notedetails_dossier").val(showQteComplementaire).trigger("change", ["ignore"]);
                        $("#valeur_mercuriale_notedetails_dossier").val("").trigger("change", ["ignore"]);
                        $("#show_valeur_mercuriale_notedetails_dossier").val(showValeurMercuriale).trigger("change", ["ignore"]);
                        $("#label_qte_complementaire_notedetails_dossier").val(labelQteComplementaire).trigger("change", ["ignore"]);
                    }
                }
                else if (getId.indexOf("origine_notedetails_") !== -1) {
                    $scope.showOptionCedeao = "";
                    if (!!getValue) {
                        getCurrentItem = $scope.dataPage['pays'].filter(item => (item.id === parseInt(getValue)));

                        if (getCurrentItem.length === 1) {
                            $scope.showOptionCedeao = getCurrentItem[0].cedeao;
                            $("#show_option_cedeao_notedetails_dossier").val($scope.showOptionCedeao).trigger("change", ["ignore"]);
                        }
                    }
                    else {
                        $("#show_option_cedeao_notedetails_dossier").val($scope.showOptionCedeao).trigger("change", ["ignore"]);
                    }
                }
                /* else if (getId.indexOf("type_dossiers_client") !== -1)
                {
                    let newValue = [] ;
                    if (Array.isArray(getValue))
                    {
                        $.each(getValue, function (key, value)
                        {
                            let y = $scope.dataPage['typedossiers'].filter((i)=> i.id === parseInt(value));
                            if (y.length === 1 && y[0].show_for_client === true)
                            {
                                let it = y[0] ;

                                if ((it.details ?? []).length > 0)
                                {
                                    $.each((it.details ?? []), function (k,v){
                                        newValue.push(String(v.id))
                                    });

                                }
                            }
                        });

                        if (newValue.length > 0)
                        {
                            getValue = newValue ;
                            $("#" + getId).val(newValue).trigger("change",["ignore"]);
                        }

                        console.log("diop value", getValue);
                        $scope.manageValidationDirection(getValue);
                        //$scope.getValueTypeDossier = getValue;
                    }




                } */

                // En rajoutant le préfixant *all_* cela, permet de set toutes les lignes en fonction d'une valeur
                if (getId.indexOf('all_') !== -1) {
                    console.log('getCurrentItem =>', getId.split('all_'));

                    $('[id^=' + getId.split('all_')[1] + '_]').val(getValue).trigger('change');
                }
            }
            else if (getId.indexOf("_client") !== -1) {
                if (getId.indexOf("type_marchandises_") !== -1) {
                    //filtrer les marchandises selon le type choisi
                    //plus necessaire pour le moment vu que dans le modal client y'a plus d'ajout de marchandises
                    /* if (Array.isArray(getValue))
                    {
                        if (getValue.length <= 0)
                        {
                            $scope.dataPage['marchandises2'] = $scope.dataPage['marchandises'] ;
                        }
                        else
                        {
                            optionals = { queries: [], setStateCursorToLoading: true, isPromise: true, justTheseAttrs: "id,nom"};
                            optionals.queries.push('type_marchandise_ids:"' + getValue.join() + '"');
                            $scope.getElements("marchandises", optionals).then(function (data)
                            {
                                $scope.dataPage['marchandises2'] = data ;
                            }
                            , function (msg)
                            {
                                $scope.showToast("ERREUR", msg, 'error');
                            });
                        }

                    } */
                }
            }
            else if (getId.indexOf("_marchandise") !== -1) {
                if (getId.indexOf("marque_marchandise") !== -1) {

                    if (!!getValue) {
                        getCurrentItem = $scope.dataPage['marques'].filter(item => (item.id == getValue));
                        if (getCurrentItem.length > 0) {
                            optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
                            optionals.queries.push("marque_id:" + getCurrentItem[0].id);
                            $scope.getElements("modeles", optionals).then(function (data) {
                                $scope.dataPage['modeles'] = data;
                            }
                                , function (msg) {
                                    $scope.showToast("ERREUR", msg, 'error');
                                });
                        }
                    }
                    else {
                        $scope.getElements("modeles");
                    }
                }
                if (getId.indexOf("modele_marchandise") !== -1) {

                    if (!!getValue) {
                        getCurrentItem = $scope.dataPage['modeles'].filter(item => (item.id == getValue));
                        if (getCurrentItem.length > 0) {
                            optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
                            optionals.queries.push("id:" + getCurrentItem[0].id);
                            $scope.getElements("modeles", optionals).then(function (data) {
                                if (data.length === 1) {
                                    item = data[0];
                                    $("#marque_marchandise").val(item.marque.id).trigger("change", ["ignore"]);
                                }
                            }
                                , function (msg) {
                                    $scope.showToast("ERREUR", msg, 'error');
                                });
                        }
                    }
                }
                setTimeout(() => {
                    $scope.makeNomMarchandise();
                    $scope.makeCodeVehicule();
                }, 800)

            }
            else if (getId.endsWith("_debour")) {
                if (getId.indexOf("famille_debour_") !== -1) {
                    if (!!getValue) {
                        getCurrentItem = $scope.dataPage['familledebours'].filter(item => (item.id == getValue));
                        if (getCurrentItem.length > 0) {
                            optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
                            optionals.queries.push("famille_debour_id:" + getCurrentItem[0].id);
                            $scope.getElements("articlefacturations", optionals).then(function (data) {
                                $scope.dataPage['articlefacturations'] = data;
                            }
                                , function (msg) {
                                    $scope.showToast("ERREUR", msg, 'error');
                                });
                        }
                    }
                    else {
                        $scope.getElements("articlefacturations");
                    }
                }
                if (getId.indexOf("article_facturation_") !== -1) {

                    if (!!getValue) {
                        getCurrentItem = $scope.dataPage['articlefacturations'].filter(item => (item.id == getValue));
                        if (getCurrentItem.length > 0) {
                            optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
                            optionals.queries.push("id:" + getCurrentItem[0].id);
                            $scope.getElements("articlefacturations", optionals).then(function (data) {
                                if (data.length === 1) {
                                    item = data[0];
                                    $("#famille_debour_debour").val(item.famille_debour_id).trigger("change", ["ignore"]);
                                }
                            }
                                , function (msg) {
                                    $scope.showToast("ERREUR", msg, 'error');
                                });
                        }
                    }
                }
            }
        }
        else {
            if (getId === "client_ordretransit") {
                $scope.manageClientWizard(getValue, false);
            }
        }

        // Pour tout ce qui est update des elements des tabpanes
        if (!!$(this).attr('data-tabpane')) {
            var getAttrId = getId.substring(0, getId.indexOf('_' + $(this).attr('data-tabpane')));

            that = $(this);

            $.each($scope.dataInTabPane[$(this).attr('data-tabpane')]['data'], function (KeyItem, queryItem) {
                if (getId === getAttrId + '_' + that.attr('data-tabpane') + '_' + KeyItem) {
                    tagAttr = getAttrId;
                    if ($('#' + (getAttrId + '_' + that.attr('data-tabpane') + '_' + KeyItem)).is('select')) {
                        tagAttr = getAttrId + '_id';
                    }
                    $scope.dataInTabPane[that.attr('data-tabpane')]['data'][KeyItem][tagAttr] = getValue;
                    console.log('Jacques here =>', getId, tagAttr, getValue);
                    return false;
                }
            });
        }

        if ($(this).attr('data-setNgModel')) {
            console.log('set data Id', $(this).attr('data-setNgModel'));
            $('#' + $(this).attr('data-setNgModel')).val(getValue).change();
        }

        $scope.applyScope();
    }

    $scope.fetchChapitre = function () {

        if (!!$scope.code_chapitre_nomenclaturedouaniere) {
            var t = String($scope.code_chapitre_nomenclaturedouaniere).trim().length;
            if (t === 4) {
                setTimeout(() => {
                    $("#sous_chapitre_nomenclature_douaniere_nomenclaturedouaniere").val("").trigger("change");
                }, 500);

                optionals = { justTheseAttrs: "id,nom,code", queries: ['code: "' + $scope.code_chapitre_nomenclaturedouaniere + '"'], setStateCursorToLoading: true, isPromise: true };

                $scope.getElements("chapitrenomenclaturedouanieres", optionals).then(function (data) {
                    if (data.length === 1) {
                        setTimeout(() => {
                            $("#sous_chapitre_nomenclature_douaniere_nomenclaturedouaniere").val(data[0].id).trigger("change");
                        }, 500)
                    }

                });
            }

        }
    }

    $scope.makeCodeNomenclature = function () {
        let codeChap = "";
        if ($scope.selectedChap !== undefined && $scope.selectedChap !== null) {
            $scope.code_chapitre_nomenclaturedouaniere = $scope.selectedChap.code ?? "";
            codeChap = $scope.selectedChap.code ?? "--";
        }

        $scope.codeNomenclature = codeChap + "." + ($scope.code_produit_nomenclaturedouaniere ?? "--") + "." + ($scope.code_uemoa_nomenclaturedouaniere ?? "--") + "." + ($scope.code_senegal_nomenclaturedouaniere ?? "--");
    }

    $scope.getTypeName = function (id, type) {
        var found = $scope.dataPage[type].find(function (f) {
            return f.id === id;
        });
        return found ? found.nom : '';
    };

    $scope.makeNomMarchandise = function () {
        if (parseInt($scope.typeMarchandiseIdModal) === 2) {
            let marqueId = parseInt($("#marque_marchandise").val());
            let modeleId = parseInt($("#modele_marchandise").val());
            let energieId = parseInt($("#energie_marchandise").val());
            let cylindre = $("#cylindre_marchandise").val();
            let nomC = $("#nom_complementaire_marchandise").val();
            let nomMarque = $scope.getElementInTab('marques', marqueId, 'nom');
            let nomModele = $scope.getElementInTab('modeles', modeleId, 'nom');
            let energie = $scope.getElementInTab('energies', energieId, 'nom');
            let rtr = "";
            if (!!nomMarque) {
                rtr += nomMarque + " -- ";
            }
            if (!!nomModele) {
                rtr += nomModele + " -- ";
            }
            if (!!nomC) {
                rtr += nomC + " -- ";
            }
            if (!!cylindre) {
                rtr += cylindre + " -- ";
            }
            if (!!energie) {
                rtr += energie;
            }
            $("#nom_marchandise").val(rtr);
            $scope.nomMarchandise = rtr;
            $scope.applyScope();
        }
    }

    $scope.preventComma = function (event) {
        if (event.key === ',') {
            event.preventDefault();
        }
    };

    $scope.getFirstLetters = function (inputString) {
        var words = inputString.split(' ');
        var result = '';

        for (var i = 0; i < words.length; i++) {
            result += words[i].charAt(0);
        }

        return result.toUpperCase();
    }

    $scope.makeCodeVehicule = function () {
        if (!(!!$scope.updateItem)) {
            let marqueId = parseInt($("#marque_marchandise").val());
            let modeleId = parseInt($("#modele_marchandise").val());
            let clients = $("#clients_marchandise").val();

            let nomMarque = $scope.getElementInTab('marques', marqueId, 'nom');
            let nomModele = $scope.getElementInTab('modeles', modeleId, 'nom');
            let rtr = "";

            if (clients.length === 1) {
                let clientId = parseInt(clients[0]);
                let nomClient = $scope.getElementInTab('clients', clientId, 'display_text');
                let valueInc = $scope.getElementInTab('clients', clientId, 'last_value_inc');
                if (!!nomClient) {
                    rtr += $scope.getFirstLetters(nomClient);
                }
                if (!!nomMarque) {
                    rtr += $scope.getFirstLetters(nomMarque);
                }
                if (!!nomModele) {
                    rtr += $scope.getFirstLetters(nomModele);
                }
                if (!!nomClient) {
                    rtr += valueInc < 10 ? String(valueInc).padStart(2, '0') : String(valueInc)
                }

            }

            $("#code_vehicule_marchandise").val(rtr);
        }
    }



    $scope.checkIfDocsCorrect = function (tagForm, isTabPane = false, subCondition = null, forFactureFret = false) {
        if (isTabPane === true) {
            let t = $scope.dataInTabPane[tagForm]['data'].length > 0;
            var yy = [];
            $.each($scope.dataInTabPane[tagForm]['data'], function (key, value) {
                let u = value.files;
                let noNeedFile = value.file_required === false /* && value.choose_debour !== true */;
                if (!!u && u.length > 0) {
                    u = u[0];
                }

                if (noNeedFile === true) {
                    yy.push(true);
                }
                else if (!!u && !!u['name']) {
                    if (!!u['id']) {
                        yy.push(true);
                    }
                    else {
                        yy.push(!!$("#" + u['name'] ?? "").val());
                    }

                }
            });
            $scope[tagForm + "_iscorrect"] = t && yy.length === $scope.dataInTabPane[tagForm]['data'].length && yy.every(function (i) { return i === true });

            let finalRes = true;

            if (subCondition !== null) {
                finalRes = subCondition;
            }

            //console.log("I am checking before",$scope[tagForm + "_iscorrect"]);
            $scope[tagForm + "_iscorrect"] = ($scope[tagForm + "_iscorrect"] === true) && (finalRes === true);
            console.log("I am checking", $scope[tagForm + "_iscorrect"], finalRes, subCondition);




        }
        else {
            var res = [];
            $("input[id$=" + tagForm + "], textarea[id$=" + tagForm + "], select[id^=" + tagForm.split('_')[0] + "][id$=" + tagForm.split('_')[1] + "], select[id*=" + tagForm.split('_')[0] + '_' + "][id$=" + tagForm.split('_')[1] + "] ").each(function () {
                if (!$(this).hasClass("ignore-check")) {
                    res.push(!!$(this).val())
                }
            });

            $scope[tagForm + "_iscorrect"] = res.every(function (i) { return i === true });
        }

        if ($scope.dataInTabPane["ffts_ordretransit"]['data'].length === 0 && $scope["noNeedFactureFret"] === true) {
            $scope["ffts_ordretransit_iscorrect"] = true;
        }

        $scope.applyScope();

        let endTag = "";
        let myTab = [];
        let rtrScope = "";
        if (tagForm.indexOf("_ordretransit") !== -1) {
            rtrScope = "isAllDocsCorrect";
            endTag = "_ordretransit_iscorrect";
            myTab = ["bls", "ffs", "ffts", "asres", "dpis", "bscs"];
        }
        else if (tagForm.indexOf("_dossier") !== -1) {
            rtrScope = "isAllDossierDocsCorrect";
            endTag = "_dossier_iscorrect";
            myTab = ["manifestes"];
        }


        setTimeout(() => {
            $scope[rtrScope] = myTab.every(function (i) { return $scope[i + endTag] === true });
            $scope.applyScope();
        }, 1000);
    }

    $scope.onFileChange = function (event) {
        var inputFile = event.target;

        if (inputFile.files && inputFile.files[0]) {
            // Vous pouvez maintenant accéder au fichier via inputFile.files[0]
            // Ici, vous pouvez effectuer des vérifications supplémentaires ou déclencher une action
            console.log("Image téléchargée :", inputFile.files[0].name);
        } else {
            console.log("Aucune image sélectionnée");
        }
    };

    $scope.getElementInTab = function (tagData, value, valueToReturn) {
        if (!!tagData && !!$scope.dataPage && !!$scope.dataPage[tagData]) {
            getCurrentItem = $scope.dataPage[tagData].filter(item => (item.id == value));

            if (getCurrentItem.length > 0) {

                return getCurrentItem[0][valueToReturn];
            }
            return null;
        }

    }

    $scope.getObjetInTab = function (tagData, value, valueToReturn) {
        if (!!tagData && !!$scope[tagData]) {
            getCurrentItem = $scope[tagData].filter(item => (item.id == parseInt(value)));

            if (getCurrentItem.length > 0) {
                if (!!valueToReturn) {
                    return getCurrentItem[0][valueToReturn];
                }
                return getCurrentItem[0];
            }
            return null;
        }

    }

    $scope.findElementInTab = function (tabValue, value, valueToReturn) {

        if (Array.isArray(tabValue)) {
            getCurrentItem = tabValue.filter(item => (item.id == parseInt(value)));

            if (getCurrentItem.length > 0) {
                if (!!valueToReturn) {
                    return getCurrentItem[0][valueToReturn];
                }
                return getCurrentItem[0];
            }
            return null;
        }

    }

    $scope.BASE_URL = BASE_URL;



    //---DEBUT ==> Les tableaux de données---//
    //markme-LISTE

    $scope.users = [];
    $scope.roles = [];
    $scope.permissions = [];
    $scope.dashboards = [];

    $scope.preferences = [];

    $scope.modepaiements = [];
    $scope.modalitepaiements = [];
    $scope.banques = [];
    $scope.devises = [];

    $scope.typecotations = [];
    $scope.soustypecotations = [];
    $scope.typeexpeditions = [];
    $scope.uniteprestations = [];
    $scope.typeprestations = [];
    $scope.indexs = [];
    $scope.typeprestataires = [];
    $scope.typeclients = [];
    $scope.clients = [];

    //---FIN ==> Les tableaux de données---//
    // queries

    //Map des types ou dans le getElement on doit garder les data dans le scope type et toType

    $scope.keepToType = {
        "typedossiers": true,
        "typeimportations": true,
        "typemarchandises": true
    };


    // optionals
    // * toType Permet de pouvoir charger un contenu type dans une autre collection totype car par défaut
    // * le scope de chargement d'un elt type est le scope type équivalent
    $scope.getElements = function (type, optionals = { queries: null, addFilters: false, typeIds: null, otherFilters: null, justWriteUrl: null, isPromise: false, setStateCursorToLoading: false, toType: null, justTheseAttrs: null }) {
        console.log("ici dans ma donnees")
        var listeattributs_filter = [];
        var rewriteType = type;
        var rewriteToType = optionals && optionals.toType ? optionals.toType : type;
        var rewriteattr = listofrequests_assoc[type];

        if (optionals && ((optionals.queries && optionals.queries.length > 0) || optionals.addFilters)) {
            rewriteType = rewriteType + "(";

            $.each(optionals.queries, function (KeyItem, queryItem) {
                rewriteType = rewriteType + (KeyItem > 0 ? ',' : '') + queryItem;
            });
            if (optionals.addFilters) {
                $scope.writeUrl = $scope.generateAddFiltres(type);
                rewriteType += $scope.generateAddFiltres(type);
            }

            rewriteType = rewriteType + ")";
        }

        if (optionals && !!optionals.justTheseAttrs) {
            rewriteattr = optionals.justTheseAttrs;
        }
        if (optionals && optionals.justWriteUrl) {
            $scope.generateDocument(optionals.justWriteUrl);
        }
        else {
            if (optionals && optionals.isPromise) {
                var deferred = $q.defer();
            }

            Init.getElement(rewriteType, rewriteattr, listeattributs_filter).then(function (data) {
                if (optionals && optionals.isPromise && deferred) {
                    console.log('just avant le crash', deferred);

                    deferred.resolve(data);
                }
                else {
                    //pour des besoins specifiques j'ai besoin de garder le scope du toType
                    //et le scope du toType
                    if ($scope.keepToType[type] === true) {
                        $scope.dataPage[rewriteType] = data;
                    }

                    $scope.dataPage[rewriteToType] = data;
                    $scope.manageDataAfterGet(rewriteToType, data);
                    $scope.applyScope();
                    console.log('getElements ****************** optionals => ', optionals, 'rewriteType = ', rewriteType, ' listofrequests_assoc = ', listofrequests_assoc[type], "getElements ****************** data=>", $scope.dataPage[type]);
                }
            }, function (msg) {
                if (optionals && optionals.isPromise) {
                    deferred.reject(msg);
                }
                else {
                    $scope.showToast("ERREUR", msg, 'error');
                }
            });

            if (optionals && optionals.isPromise) {
                return deferred.promise;
            }
        }

    };

    $scope.manageDataAfterGet = function (type, data) {
        if (type === "maxdepths") {
            if (!!data[0].value) {
                $scope.maxDepths = [];
                for (let index = 1; index <= data[0].value; index++) {
                    $scope.maxDepths.push(index);
                }
            }
            else {
                $scope.maxDepths = [1];
            }
        }
    }

    $scope.manageTab = function (id) {

        $scope.dataPage['chapitrenomenclaturedouanieres'] = [];
        $scope.currentTab = id;
        var idValue = "onglet-chapitre-" + id;
        setActiveTab(idValue);
    }


    $scope.writeUrl = null;

    $scope.pageChanged = function (currentpage, optionals = { tagFilter: null, justWriteUrl: null, option: null, saveStateOfFilters: false, queries: null, justTheseAttrs: null, dataCalculated: null, toType: null, ignore_char: false }) {
        // Pour décocher le checkbox dans les entêtes
        $("input[class*=' mycheck_all_']").prop('checked', false);
        $scope.itemIds = [];
        $scope.itemIds2 = [];

        addrewriteattr = optionals.dataCalculated;
        var rewriteelement = "";
        var rewriteToType = optionals && optionals.toType ? optionals.toType : null;
        let finalType = optionals && optionals.ignore_char === true ? currentpage : currentpage + "s";

        var rewriteattr = listofrequests_assoc[finalType] ? listofrequests_assoc[finalType][0] : null;

        if (rewriteattr) {

            var tagFilter = currentpage;
            if (optionals) {
                if (optionals.justTheseAttrs) {
                    rewriteattr = optionals.justTheseAttrs;
                }
                addFiltresQueries = "";
                if (optionals.queries && optionals.queries.length > 0) {
                    $.each(optionals.queries, function (KeyItem, queryItem) {
                        addFiltresQueries = addFiltresQueries + (KeyItem > 0 ? ',' : '') + queryItem;
                    });
                }
                if (optionals.tagFilter) {
                    tagFilter = optionals.tagFilter;

                }
            }

            $scope.writeUrl = "";
            $scope.writeUrl = $scope.writeUrl
                + $scope.generateAddFiltres(tagFilter)
                + ',' + addFiltresQueries;

            console.log("ici dans  page change  link nav", currentpage)
            if (optionals && optionals.justWriteUrl) {
                $scope.generateDocument(optionals.justWriteUrl);
            }
            else {
                if (!$scope.paginations[currentpage]) {
                    $scope.paginations[currentpage] = angular.copy($scope.defaultPagination);
                    console.log('here jacques', currentpage);
                }
                rewriteelement = finalType + '(page:' + $scope.paginations[currentpage].currentPage + ',count:' + $scope.paginations[currentpage].entryLimit
                    + $scope.writeUrl
                    + ')';

                if (rewriteelement && rewriteattr) {
                    Init.getElementPaginated(rewriteelement, rewriteattr, addrewriteattr).then(function (data) {
                        $scope.paginations[currentpage].currentPage = data.metadata.current_page;
                        console.log("fatiqué", $scope.paginations[currentpage].currentPage);
                        $scope.paginations[currentpage].totalItems = data.metadata.total;
                        $scope.dataPage[finalType] = data.data;

                        // if (Array.isArray(data.data)) {
                        //     let count0 = 0, count1 = 0, count2 = 0;
                        //     angular.forEach(data.data, function (item) {
                        //         if (item.status === 0) count0++;
                        //         if (item.status === 1) count1++;
                        //         if (item.status === 2) count2++;
                        //     });

                        //     $scope.paginations[currentpage].totalItemsWithStatus0 = count0;
                        //     $scope.paginations[currentpage].totalItemsWithStatus1 = count1;
                        //     $scope.paginations[currentpage].totalItemsWithStatus2 = count2;
                        // }

                        //



                        $scope.initMenuContextuel();

                    }, function (msg) {
                        $('.item-back').blockUI_stop();
                        $scope.showToast("ERREUR", msg, 'error');
                    });
                }
            }
        }
    };



    /* Permet de switcher de thème de bingo */
    $scope.switchTheme = function (newTheme) {
        console.log(newTheme);
        var begin = 'theme';
        $("body").removeClass(function (index, className) {
            return (className.match(new RegExp("\\b" + begin + "\\S+", "g")) || []).join(' ');
        }).addClass(newTheme);
        theme.setCurrent(newTheme);
        $scope.switchThemeActive();
    };

    $scope.switchThemeActive = function () {
        return theme.getCurrent();
    };

    $scope.isPortrait = false;
    $scope.goToPortrait = function () {
        $scope.isPortrait = !$scope.isPortrait;
    };

    $scope.isOpen = false;
    $scope.openMenu = function () {
        $scope.isOpen = !$scope.isOpen;
        if ($scope.isOpen) {
            setTimeout(function () {
                console.log("11");
                $("#kt_aside2").css({ "width": "0px", "display": "none", "transition": "all .1s ease" });
                $("#kt_content").css({ "width": "100%" });
                $("#kt_wrapper").css({ "padding-left": "0px", "z-index": "99" });
            }, 500)
        }
        else {
            setTimeout(function () {
                $("#kt_aside2").css({ "width": "100px", "display": "flex", "transition": "all .2s ease" });
                $("#kt_content").css({ "width": "calc(100% - 100px)" });
                $("#kt_wrapper").css({ "padding-left": "100px", "z-index": "9" });
            }, 500)
        }
    }

    $(document).on('click', '#kt_aside2', function (e) {
        $scope.isOpen = false;
        console.log("11");
    });

    $(document).on('click', '.btn-group .dropdown-menu', function (e) {
        e.stopPropagation();
    });

    $scope.AddLengthBonus = function () {
        $scope.InputBonus.push({ val: null });
    };

    $scope.DisplayBouls = []
    $scope.createBoule = function (val, parts = 6) {
        //parts=15;
        val = 90
        var array = [];
        for (var i = 1; i <= val; i++) {
            array[i] = i;
        }
        let result = [];
        for (let j = val + 1; i > 1; i--) {
            var Tab = array.splice(1, Math.ceil(val / parts));
            if (Tab.length > 0) {
                result.push(Tab);
            }
        }
        for (let k = 0; k < result.length; k++) {
            // console.log("ici dans ma donnee format teste", result[k].length)

            for (let l = 0; l < result[k].length; l++) {
                var value = result[k][l]
                result[k][l] = { val: value }
            }
        }
        $scope.DisplayBouls = result;
        console.log("ici dans ma fonction qui lance 32", $scope.DisplayBouls)
        $timeout(function () {
            $scope.$apply();
        });
        return result;

        //$scope.DisplayBouls =result;

    }
    $scope.ParamsBingo = { quen: 5, bingo: 15, bonus: 1 };
    // $scope.InputBonus = [{val:null},{val:null},{val:null},{val:null},{val:null},{val:null},{val:null}];
    $scope.BouleAddedToDisplay = []
    $scope.CurrentBoule = 0;
    $scope.CurrentBouleColor = 'b';
    $scope.PlayInProgres = false;
    $scope.descatverElement = function (ev, value, tagNameId, color) {
        ev.preventDefault();
        var id = tagNameId + 'croix' + value;
        if ($scope.PlayInProgres == false) {
            iziToast.error({
                message: "Veuillez d'abord lancer le jeu ",
                position: 'topRight'
            });
        }
        else if ($scope.BouleAddedToDisplay.length == $scope.bingoView.type_bingo.valeur) {
            iziToast.error({
                message: "Vous avez atteind le nombre de tirage ",
                position: 'topRight'
            });
        }
        else {

            if (!$('#' + id).hasClass('desable-boule')) {
                $('#' + id).removeClass('cursor-pointer');
                $('#' + id).removeClass('d-none');
                $('#' + id).addClass('desable-boule');

                $('#' + tagNameId + 'color' + value).addClass('d-none');
                $('#' + tagNameId + 'color-hide' + value).removeClass('d-none');

                // boul1-croix
                //$('#Boule-current').attr('src', src);
                $scope.CurrentBouleColor = color;
                $('#Boule-current-text').html(value);
                $scope.CurrentBoule = value;
                $scope.BouleAddedToDisplay.unshift({ val: value, color: color })
                $scope.playAudio('boule', '.mp4');
                $scope.BouleInit = $scope.BouleInit + 1
            }
        }

        console.log("ici dans  la fonction desactiver Element", id)
    }


    $scope.cacheFilters = {};
    $canWrite = true;
    $scope.$watch("writeUrl", function (newValue, oldValue, scope) {
        if (!newValue) {
            console.log("writeUrl la nouvelle valeur est vide", $scope.linknav);
        } else {
            console.log('writeUrl old = ', oldValue, 'new = ', newValue);
        }

        $assocName = $scope.linknav.substr(1, $scope.linknav.length);

        if ($canWrite && $scope.linknavOld.indexOf('detail') !== -1 && $assocName in $scope.cacheFilters) {
            $canWrite = false;
            $scope.linknavOld = $scope.linknav;
        } else
            $canWrite = true;

        if ($assocName && $canWrite && $scope.linknav.indexOf('detail') === -1) {
            $scope.cacheFilters[$assocName] = newValue;
        }

        console.log("writeUrl $assocName", $assocName, "cacheFilters", $scope.cacheFilters, "$canWrite", $canWrite);

    });


    // Au moment du chargement
    // Gérer par les cookies
    // $scope.switchTheme(theme.getCurrent());



    $scope.urlWrite = "";
    $scope.writeUrlEtat = function (type, addData = null) {
        console.log("$scope.writeUrl");
        var urlWrite = "";
        $("input[id$=" + type + "], textarea[id$=" + type + "], select[id$=" + type + "]").each(function () {
            var attr = $(this).attr("id").substr(0, $(this).attr("id").length - (type.length + 1));
            urlWrite = urlWrite + ($(this).val() && $(this).val() !== "" ? (urlWrite ? "&" : "") + attr + '=' + $(this).val() : "");
        });
        $scope.urlWrite = urlWrite ? "?" + urlWrite : urlWrite;
        console.log($scope.urlWrite);
    };

    // Genterate Pdf
    $scope.generateDocument = function (type) {
        let url = 'generate-' + type;

        if ($scope.writeUrl !== "") {
            url += "?" + $scope.writeUrl.substr(1, $scope.writeUrl.length);
        }
        window.open($scope.BASE_URL + url, '_blank');

    };

    $scope.openNotif = function (linkUrl, target = "_self") {
        if (linkUrl.indexOf('#!') === -1) {
            target = '_blank';
        }
        console.log('BASE_URL', BASE_URL, '$scope.BASE_URL', $scope.BASE_URL, 'linkUrl', linkUrl);
        var urlPage = BASE_URL + linkUrl;
        window.open(urlPage, target);
    };


    $scope.panier = [];


    //$scope.getElements("notifpermusers");


    $scope.palettes = ["Material", "Soft Pastel", "Harmony Light", "Pastel", "Bright", "Soft", "Ocean", "Office", "Vintage", "Violet", "Carmine", "Dark Moon", "Soft Blue", "Dark Violet", "Green Mist"];
    $scope.paletteExtensionModes = ["Alternate", "Blend", "Extrapolate"];
    $('.force-disabled').attr('disabled', 'disabled');

    $scope.orderByOptions = [{
        'order': 'ASC',
        'display': 'Croissant'
    }, {
        'order': 'DESC',
        'display': 'Décroissant'
    }];

    $scope.reInitDataToDefault = function (scopeData, keys, reInit, addAtEachLine = null) {
        $.each(keys, function (KeyItem, valueItem) {
            nameItem = valueItem.item;

            if (addAtEachLine) {
                let can_add_at_each_line = true;

                if (valueItem.othersProps && valueItem.othersProps.addAtEachLine === false) {
                    can_add_at_each_line = false;
                }

                if (can_add_at_each_line) {
                    nameItem = nameItem + addAtEachLine;
                }

            }
            scopeData[nameItem] = angular.copy(reInit);

            if (typeof reInit === "object" && valueItem.othersProps && valueItem.othersProps.addAtEachLine !== false) {
                Object.assign(scopeData[nameItem], valueItem.othersProps);
            }
        });


        console.log('$scope.paginations =====> ', scopeData);
    }

    // Pour detecter le changement des routes avec Angular
    $scope.linknav = "/";
    $scope.linknavOld = "/";
    $scope.getElements('roles');
    $scope.getElements('preferences');

    // EMULATION DU MENU CONTEXTUEL

    $scope.initMenuContextuel = function () {
        let enableMenu = $('body').attr('enable_menu_contextuel') === "true";

        if (enableMenu) {
            setTimeout(function () {
                // Recompiler les éléments avec des directives Angular
                $('.menu-leftToRight [ng-click]').each(function () {
                    $compile(angular.element($(this)))($scope);
                });

                $scope.$apply();

                var $doc = $('body .withMenuContextuel1'),
                    $c1 = $("#c1"),
                    $c2 = $("#c2");

                $doc.each(function () {
                    var $context = $(".context:not(.sub)[data-context-menu=item]");
                    var $element = $(this);

                    $element.off("contextmenu").on("contextmenu", function (e) {
                        var siblings = '.menu-leftToRight > [ng-click], .menu-leftToRight > [href]:not([href="#"])';
                        if ($element.find(siblings).length > 0) {
                            e.preventDefault();
                            $context.find(" > li").not(".top").remove();

                            $element.find(siblings).each(function () {
                                var attrName = $(this).attr('ng-click') ? 'ng-click' : 'href';
                                var baliseName = $(this).attr('ng-click') ? 'span' : 'a';
                                var zIndex = $(this).parent().attr("zIndex");

                                if (zIndex) {
                                    $context.css('z-index', parseInt(zIndex));
                                }

                                var child = angular.element(`<li class="text-white" ng-click="${$(this).attr('ng-click')}" title="${$(this).attr('title')}">
                                    <${baliseName} class="" href="${$(this).attr('href')}">${$(this).html()} ${$(this).attr('title')}</${baliseName}>
                                </li>`);

                                angular.element($context).prepend($compile(child)($scope));
                            });

                            $context.find("i").not(".text-white").addClass('text-white');

                            var $window = $(window),
                                $sub = $context.find(".sub");

                            $sub.removeClass("oppositeX oppositeY");

                            // Positionner le menu au clic en tenant compte du scroll
                            var x = e.clientX + $(window).scrollLeft();
                            var y = e.clientY + $(window).scrollTop();

                            // Obtenir les dimensions du menu contextuel
                            var w = $context.width();
                            var h = $context.height();

                            // Ajuster la position si le menu dépasse les bords de la fenêtre
                            var ww = $window.width();
                            var wh = $window.height();

                            if (x + w > ww + $(window).scrollLeft()) {
                                x = ww + $(window).scrollLeft() - w - 10;
                            }

                            if (y + h > wh + $(window).scrollTop()) {
                                y = wh + $(window).scrollTop() - h - 10;
                            }

                            $context.css({
                                left: x,
                                top: y
                            });

                            $context.addClass("is-visible");

                            $('body').off("mousedown").on("mousedown", function (e) {
                                var $tar = $(e.target);
                                if (!$tar.is($context) && !$tar.closest(".context").length && !$tar.is($c1) && !$tar.is($c2)) {
                                    $context.removeClass("is-visible");
                                    $(this).off(e);
                                }
                            });
                        }
                    });

                    $context.off("mousedown touchstart").on("mousedown touchstart", "li:not(.nope)", function (e) {
                        if (e.which === 1) {
                            var $item = $(this);
                            $item.removeClass("active");

                            setTimeout(function () {
                                $item.addClass("active");
                            }, 10);
                        }
                    });
                });

                $c1.on("input change", function () {
                    var color = $(this).val();
                    document.body.style.setProperty("--color1", color);
                });

                $c2.on("input change", function () {
                    var color = $(this).val();
                    document.body.style.setProperty("--color2", color);
                });

            }, 100);
        }
    };


    const closeMenuContextuel = () => {
        $context = $(".context:not(.sub)[data-context-menu=item]");
        if ($context.hasClass("is-visible")) {
            $context.removeClass("is-visible");
        }
    }

    //FIN

    $scope.$on('$routeChangeStart', function (next, current, prev) {
        /******* Réintialisation de certaines valeurs *******/
        $scope.getElements("notifpermusers");

        $('.force-disabled').attr('disabled', 'disabled');

        $('.select2').on('select2:opening', function (e) {
            console.log('Pour problème select2 repetitif');
            $scope.cpt = 1;
        });

        var t = $('body').attr('data-client_id');

        $scope.isAuthUserClient = !!t;



        // Pour afficher le modal des infos details
        $scope.detailParentId = null;
        $scope.linknav = $location.path();
        if (prev) {
            $scope.linknavOld = prev.originalPath;
        }
        $scope.currentTemplateUrl = current.params.namepage ? current.params.namepage : "index";
        $scope.writreUrl = null;

        $scope.dataToDefault = [

            { item: "permission", othersProps: null },
            { item: "role", othersProps: null },
            { item: "user", othersProps: null },

            { item: "preference", othersProps: null },

            { item: "nomenclatureclient", othersProps: null },
            { item: "modepaiement", othersProps: null },
            { item: "pays", othersProps: { addAtEachLine: false } },
            { item: "modalitepaiement", othersProps: null },
            { item: "banque", othersProps: null },
            { item: "devise", othersProps: null },
            { item: "coursdevise", othersProps: null },
            { item: "typecotation", othersProps: null },
            { item: "soustypecotation", othersProps: null },
            { item: "typeexpedition", othersProps: null },
            { item: "uniteprestation", othersProps: null },
            { item: "typeprestation", othersProps: null },
            { item: "prestation", othersProps: null },
            { item: "typeprestataire", othersProps: null },
            { item: "prestataire", othersProps: null },
            { item: "typeclient", othersProps: null },
            { item: "client", othersProps: null },
            { item: "personnel", othersProps: null },
            { item: "marque", othersProps: null },
            { item: "modele", othersProps: null },
            { item: "gabarit", othersProps: null },
            { item: "debour", othersProps: null },
            { item: "energie", othersProps: null },
            { item: "marchandise", othersProps: null },
            { item: "vehicule", othersProps: null },
            { item: "livreur", othersProps: null },
            { item: "typeentrepot", othersProps: null },
            { item: "entrepot", othersProps: null },
            { item: "typedossier", othersProps: null },
            { item: "validationdossier", othersProps: null },
            { item: "compagniemaritime", othersProps: null },
            { item: "dossier", othersProps: null },
            { item: "typeimportation", othersProps: null },


        ];

        $scope.dataPage = [];
        $scope.reInitDataToDefault($scope.dataPage, $scope.dataToDefault, [], "s");

        $scope.defaultPagination = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0,
            totalFiltre0: 0,
            totalFiltre1: 0,
            totalFiltre2: 0

        };

        $scope.paginations = [];
        $scope.reInitDataToDefault($scope.paginations, $scope.dataToDefault, $scope.defaultPagination);

        var getNameItem = $scope.currentTemplateUrl.toLowerCase();

        if (true) {
            if ($scope.currentTemplateUrl.toLowerCase().indexOf('detail-') === -1) {

                getNameItem = getNameItem.substring(5, getNameItem.length);
                let optionals = {};
                if (getNameItem === "pays") {
                    optionals = { ignore_char: true }
                }

                $scope.pageChanged(getNameItem, optionals);
            }

            $scope.getElementsNeeds = [];
            $scope.pageChangedNeeds = [];
            // alert($scope.currentTemplateUrl.toLowerCase().indexOf('detail-projetmodule'))
            if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-articlefacturation') !== -1) {
                $scope.getElementsNeeds.push({ type: 'familledebours' }, { type: 'optionfacturations' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-tag') !== -1) {
                $scope.getElementsNeeds.push({ type: 'priorites' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-tacheprojet') !== -1) {
                $scope.getElementsNeeds.push({ type: 'personnels' }, { type: 'projets', optionals: { queries: ['status:true'] } }, { type: 'planificationassignes' }, { type: 'tachefonctionnalites' }, { type: 'tags' }, { type: 'priorites' }, { type: 'tacheprojets' });
                // if (typeof $scope.pageChanged === 'function') {
                //     $scope.pageChanged('tacheprojet');
                // }
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-tache') !== -1) {
                $scope.getElementsNeeds.push({ type: 'typetaches' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-modele') !== -1) {
                $scope.getElementsNeeds.push({ type: 'marques' }, { type: 'gabarits' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-user') !== -1) {
                $scope.getElementsNeeds.push({ type: 'roles' }, { type: 'niveauhabilites' });
                $scope.pageChanged('user');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-profil') !== -1) {
                $scope.getElementsNeeds.push({ type: 'groupepermissions' }, { type: 'typepermissions' });
                $scope.pageChanged('role');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-categorietypedepense') !== -1) {
                $scope.getElementsNeeds.push({ type: 'categoriedepenses' }, { toType: 'categoriedepenses2' });
                $scope.pageChanged('categoriedepense');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-motifentresortiecaisse') !== -1) {
                $scope.getElementsNeeds.push({ type: 'motifentrecaisses' }, { toType: 'motifentrecaisses2' });
                $scope.pageChanged('motifentrecaisse');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-entresortiecaisse') !== -1) {
                $scope.getElementsNeeds.push({ type: 'motifentresortiecaisses' }, { type: 'caisses' });

                $scope.pageChanged('entrecaisse');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-noyauxinterne') !== -1) {
                $scope.pageChanged('noyauxinterne');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-client') !== -1) {
                $scope.getElementsNeeds.push({ type: 'modefacturations' }, { type: 'typeclients' }, { type: 'modalitepaiements' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-projet') !== -1) {
                $scope.getElementsNeeds.push({ type: 'typeprojets' }, { type: 'clients', optionals: { queries: ['status:true'] } }, { type: 'noyauxinternes' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-assistance') !== -1) {
                $scope.getElementsNeeds.push({ type: 'canals' }, { type: 'canalslacks' }, { type: 'tags' }, { type: 'typetaches' }, { type: 'personnels' }, { type: 'projets', optionals: { queries: ['status:true'] } });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-rapportassistance') !== -1) {
                $scope.getElementsNeeds.push({ type: 'assistances' }, { type: 'projets', optionals: { queries: ['status:true'] } }, { type: 'canals' }, { type: 'tags' }, { type: 'typetaches' }, { type: 'users' }, { type: 'clients', optionals: { queries: ['status:true'] } });
            }


            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-rapportemails') !== -1) {
                $scope.getElementsNeeds.push({ type: 'assistances' }, { type: 'projets', optionals: { queries: ['status:true'] } }, { type: 'canals' }, { type: 'tags' }, { type: 'typetaches' }, { type: 'users' }, { type: 'clients', optionals: { queries: ['status:true'] } });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-demandeabsence') !== -1) {
                $scope.getElementsNeeds.push({ type: 'personnels' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-depense') !== -1) {
                $scope.getElementsNeeds.push({ type: 'typedepenses' }, { type: 'users' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-prospection') !== -1) {
                $scope.getElementsNeeds.push({ type: 'noyauxinternes' }, { type: 'projetprospects' }, { type: 'surmesures' }, { type: 'clients', optionals: { queries: ['status:true'] } }, { type: 'typeprojets' }, { type: 'typeclients' });
                $scope.pageChanged('projetprospect');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-gestionprojet') !== -1) {
                $scope.getElementsNeeds.push({ type: 'surmesures' }, { type: 'typeprojets' }, { type: 'projetdepartements' }, { type: 'projets', optionals: { queries: ['status:true'] } });
                $scope.pageChanged('projet');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-surmesure') !== -1) {
                $scope.getElementsNeeds.push({ type: 'clients', optionals: { queries: ['status:true'] } });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-avancesalaire') !== -1) {
                $scope.getElementsNeeds.push({ type: 'personnels' }, { type: 'remboursements' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-pointage') !== -1) {
                $scope.getElementsNeeds.push({ type: 'personnels' }, { type: 'personnels' }, { type: 'mesures' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-evenement') !== -1) {
                $scope.getElementsNeeds.push({ type: 'personnels' }, { type: 'projets' }, { type: 'gravites' }, { type: 'mesures' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('index') !== -1) {
                $scope.getElementsNeeds.push({ type: 'indexs' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('dashboard') !== -1) {
                $scope.getElementsNeeds.push({ type: 'users' }, { type: 'assistances' });
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('detail-projet') !== -1 && $scope.currentTemplateUrl.toLowerCase().indexOf('detail-projetmodule') != 0) {
                $scope.getElementsNeeds.push({ type: 'departements' }, { type: 'fonctionnalites' }, { type: 'projetdepartements' },);
                console.log("warren =====> ", $scope.projetSelected);

            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('detail-departement') !== -1) {
                $scope.getElementsNeeds.push({ type: 'departements' }, { type: 'fonctionnalites' }, { type: 'taches' }, { type: 'projetmodules' }, { type: 'projets', optionals: { queries: ['status:true'] } }, { type: 'planifications' });
                $scope.projetSelected = $cookies.get('nom_projet');
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('detail-projetmodule') !== -1 && $scope.currentTemplateUrl.toLowerCase().indexOf('detail-projet') == 0) {
                $scope.getElementsNeeds.push({ type: 'departements' }, { type: 'projetdepartements' }, { type: 'fonctionnalites' }, { type: 'projetmodules' }, { type: 'visas' }, { type: 'visafinals' }, { type: 'fonctionnalitemodules' });

                $scope.moduleSelected = $cookies.get('module');
                console.log("warren module ===== ", $scope.moduleSelected);
            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-personnel') !== -1) {
                $scope.getElementsNeeds.push({ type: 'roles' });

            }
            else if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-planification') !== -1) {
                $scope.getElementsNeeds.push({ type: 'fonctionnalites' }, { type: 'taches' }, { type: 'projets', optionals: { queries: ['status:true'] } }, { type: 'fonctionnalitemodules' }, { type: 'tachefonctionnalites' }, { type: 'tags' }, { type: 'priorites' }, { type: 'planificationassignes' });

            }
            console.log("ici current template ", $scope.currentTemplateUrl)
        }
        if ($scope.currentTemplateUrl.toLowerCase().indexOf('detail-') !== -1) {
            getNameItem = getNameItem.substring(7, getNameItem.length);
            console.log("ici dans la page detail  bingo", getNameItem)

            var itemId = current.params.itemId;
            if (itemId) {
                var req = getNameItem + 's';
                rewriteReq = req + "(id:" + itemId + ")";
                Init.getElement(rewriteReq, listofrequests_assoc[req]).then(function (data) {
                    if (data.length == 0) {
                        $scope.goBack();
                    }
                    else {
                        $scope.IdView = data[0].id
                        $scope[getNameItem + 'View'] = data[0];
                        if (getNameItem + 'View' == "projetView") {
                            console.log('salut', $scope.projetView);
                            $cookies.put('nom_projet', $scope.projetView.display_text);
                        }
                        if (getNameItem + 'View' == "departementView") {
                            $cookies.put('activePage', $scope.departementView.str_nom);
                            $scope.activePage = $cookies.get('activePage');
                        }
                    }
                }, function (msg) { });
            }
        }


        // Download dependent data
        $.each($scope.getElementsNeeds, function (keyItem, valueItem) {
            console.log('here am i jacques ==>', valueItem.optionals);

            $scope.getElements(valueItem.type, valueItem.optionals);
        });

        $.each($scope.pageChangedNeeds, function (keyItem, valueItem) {
            $scope.pageChanged(valueItem.type, valueItem.optionals);
        });

    });


    $scope.formatDate = function (str) {
        date = str.split('/');
        return date[2] + "-" + date[1] + "-" + date[0];
    };

    $scope.refreshElementsNeeds = function (elementsNeeds = null, canshowToast = true) {
        var promises = [];

        if (elementsNeeds === null) {
            elementsNeeds = $scope.getElementsNeeds;
        }

        return new Promise(function (resolve, reject) {
            $.each(elementsNeeds, function (keyItem, valueItem) {
                var type = valueItem.type;
                var optionals = valueItem.optionals;
                var listeattributs_filter = [];
                var rewriteType = type;
                var urlType = type;
                var rewriteToType = optionals && optionals.toType ? optionals.toType : type;
                var rewriteattr = listofrequests_assoc[type];
                let keyFilter = "id";;
                if (optionals) {
                    if (!!optionals.keyFilter) {
                        keyFilter = optionals.keyFilter;
                    }

                    if (!!optionals.justTheseAttrs) {
                        rewriteattr = optionals.justTheseAttrs;
                    }
                    if (optionals.queries && optionals.queries.length > 0) {
                        urlType = urlType + "(";

                        $.each(optionals.queries, function (KeyItem, queryItem) {
                            urlType = urlType + (KeyItem > 0 ? ',' : '') + queryItem;
                        });

                        urlType = urlType + ")";
                    }
                }

                keyFilter = "id";

                var promise = Init.getElement(urlType, rewriteattr, listeattributs_filter).then(function (data) {
                    if (data /* && data.length > 0 */) {

                        if (!!$scope.dataPage[valueItem.type]) {
                            let items = data.filter(o1 => !$scope.dataPage[valueItem.type].some(o2 => o1[keyFilter] === o2[keyFilter]));
                            $scope.dataPage[valueItem.type].push(...items);
                            let myData = $scope.dataPage[valueItem.type].filter(o1 => data.some(o2 => o1[keyFilter] === o2[keyFilter]));

                            if (type === "typedossiers") {
                                $scope.dataPage[rewriteType] = myData;
                            }

                            $scope.dataPage[rewriteToType] = myData;
                        }


                    }
                },
                    function (msg) {
                        reject(msg); // Reject the promise if an error occurs
                    });

                promises.push(promise);
            });

            Promise.all(promises).then(function () {
                if (canshowToast) {
                    $scope.showToast('', 'Les données ont bien été actualisées', 'success');
                }
                resolve({ "success": true });

            })
                .catch(function (error) {
                    console.error("Une erreur s'est produite lors du traitement des données:", error);
                    reject(error); // Reject the promise if an error occurs during the final processing
                });
        });
    };




    $scope.checkdataInTabPane = function (type, data, idForm) {
        console.log("data onglet 12=> ", $('#' + idForm.substring(0, idForm.indexOf('_id')) + '_' + type), idForm);

        if (data.length) {
            if (idForm.indexOf('[]') !== -1) {
                tagForm = idForm.substring(0, idForm.indexOf('[]')).replaceAll('_', '');
            }
            else {
                tagForm = idForm;
            }
            $('#' + tagForm + '_' + type).val(data).trigger("change", ["ignore"]);
        }
        else {

            $.each(data, function (keyItem2, valueItem2) {
                $scope.dataInTabPane[keyItem2 + '_' + type]['data'] = valueItem2;
            });
        }

        if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
            $scope.$apply();
        }

    }

    $scope.addDaysToDate = function (date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        var ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(result);
        var mo = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(result);
        var da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(result);
        var retour = ye + "-" + mo + "-" + da;
        return retour;
    }

    $scope.toggleWindows = function () {
        $scope.isActiveTab = !$scope.isActiveTab;
    }

    $scope.addStyle = function (item) {
        $.each($scope.racineHistory, function (key, value) {

            if (value.id === 2) {
                $scope.racineHistory[key].bgStyle = item.bgStyle;
                $scope.racineHistory[key].fgStyle = item.fgStyle;
                $scope.racineHistory[key].subStyle = "padding:0.4rem;border-radius:6px";
            }
        });
    }

    $scope.radioChanged = function (elementId, item) {
        $scope.$emit('radioChanged', elementId);
    }

    // Réagir à l'événement personnalisé radioChanged
    $scope.$on('radioChanged', function (event, elementId, item) {
        if (elementId === 'date_debut_planification' || elementId === 'date_debut_planification') {
            $scope.generateDaysInterval(elementId);
        }
        if (elementId === 'date_debut_pointage' || elementId === 'date_debut_pointage') {
            $scope.generateDaysInterval(elementId);
        }
    });

    $scope.applyScope = function () {
        if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
            $scope.$apply();
        }
    }

    document.addEventListener('keydown', function (event) {
        //if (event.shiftKey && event.code === "Space")
        //if (event.metaKey && event.shiftKey)
        if (event.altKey && event.shiftKey) {
            let tagModal = "modal_addsearchpage";

            let inputTag = "search_list_pages";

            let u = $("#" + tagModal).is(':visible');

            if (u !== true) {
                $scope.getElements("pages", { queries: ["autre:0"] });
                $scope.showModalAdd('searchpage');
            }
            else {
                $("#" + tagModal).modal('hide');
                $scope.emptyForm("pages", false, { tagFilter: inputTag });
            }
        }
    });


    $scope.goToPage = function (item) {
        let inputTag = "search_list_pages";
        $("#modal_addsearchpage").modal('hide');
        $scope.emptyForm("pages", false, { tagFilter: inputTag });

        setTimeout(() => {
            window.location.href = item;
        }, 500);
    }

    $scope.$on('$routeChangeSuccess', function (next, current, prev) {
        $scope.initMenuContextuel();

        let u = navigator.userAgent;
        if (u.indexOf("Macintosh") !== -1) {
            $scope.shorcutIndice = "(⌥ + ⇧)";
            //$scope.shorcutIndice = "(⌘ + ⇧)";
        }
        else {
            //$scope.shorcutIndice = "(⊞ + ⇧)";
            $scope.shorcutIndice = "(alt + ⇧)";
        }

        $scope.isActiveTab = false;
        setTimeout(function () {
            // les elements du thème à init
            KTMenu.init();

            $scope.reInit();
        }, 1000);

        // Pour déclencher un click automatiquement sur les tabPanes lorsque nous sommes dans les pages détails
        if ($scope.currentTemplateUrl.toLowerCase().indexOf('detail-') !== -1) {
            setTimeout(function () {
                $('a[href^="#detail-pane"]').each(function () {
                    angular.element($(this)).triggerHandler('click');
                });
            }, 1000);
        }

        if ($scope.currentTemplateUrl.toLowerCase().indexOf('list-ordretransit') !== -1) {
            //$scope.updateText();
        }

        // Pour détecter les changements au niveau des btns radios
        $('[type=radio]').off('change').on('change', function () {
            //Dans le seul but d'ignorer les boutons radio dont l'action declenche une autre fonction specifique
            let ignoreThisId = $(this).attr('ignoreItem') === "true";
            if (ignoreThisId !== true) {
                if (!!$(this).attr('scope')) {
                    $scope[$(this).attr('scope')] = $(this).val();
                }


                //la variable lastWord permet de recuperer le dernier element de l'id
                var idElt = $(this).attr('id')
                let lastWord = $(this).attr('id')

                const inputString = $(this).attr('id');
                const parts = inputString.split("_");
                if (parts.length > 1) {
                    lastWord = parts[parts.length - 1];
                    lastWord = "_" + lastWord;
                }

                if (!!$(this).val()) {
                    //Mettre ici le code pour le traitement de l'action du bonton radio
                }

                //apply scope
                $scope.applyScope();

                //Permet de faire un reInit que sur le type concernei
                $scope.reInit('[id*="' + lastWord + '"]');


                console.log("changement detecté sur le btn radio => ", $(this).attr('scope'), $scope[$(this).attr('scope')], $(this).val(), $(this).attr('id'));
            }

        });
    });


    //Si le reInit n'est pas appelei nous sommes obligei de traitement le changement du select
    $scope.handleSelectChange = function (id, index) {

        if (id !== undefined && index !== undefined) {
            if ($scope.dataInTabPane['marchandises_ordretransit']['data'].length > 0) {
                let getValue = $("#" + id).val();
                $scope.dataInTabPane['marchandises_ordretransit']['data'][index].type_dossier_id = getValue;

                let bgStyle = "";
                getCurrentItem = $scope.dataPage['typedossiersAll'].filter(item => (item.id == parseInt(getValue)));


                if (getCurrentItem.length > 0) {
                    bgStyle = getCurrentItem[0].bgStyle ?? "";
                }

                $scope.dataInTabPane['marchandises_ordretransit']['data'][index].bgStyle = bgStyle;
            }
        }
    };
    $scope.handleRadioChange = function () {
        // Handle the radio button change event here
        console.log('Selected option:', $scope.selectedOption);
    };


    // Permet de changer le statut du formulaire a editable ou non
    function changeStatusForm(type, status, disabled = false) {
        var doIt = false;
        // Pour mettre tous les chamnps en lecture seule
        $("input[id$=_" + type + "], textarea[id$=_" + type + "], select[id$=_" + type + "], button[id$=_" + type + "]").each(function () {
            doIt = ($(this).attr('id').indexOf('detailnumCH') === -1);
            if (doIt) {
                console.log($(this).hasClass('btn'));
                $(this).attr($(this).hasClass('btn') || disabled ? 'disabled' : 'readonly', status);

            } else {

            }
        });
    }

    //Debut Fonction Wizard Modal Add Ordre Transit

    $scope.stepWizard = 1;
    $scope.previousStepWizard = 1;

    let tagOt = "_ordretransit";

    $scope.racineHistory = [
        {
            "id": 1,
            "title": "Choix du client",
            "icon": "fa fa-user-circle",
            "previousIcon": "fa fa-user-circle",
            "previousTitle": "Choix du client",
            "scopeValue": "displayText_clientOT",
        },
        {
            "id": 2,
            "title": "Choix du type de déclaration",
            "icon": "fa fa-folder-open",
            "previousIcon": "fa fa-folder-open",
            "previousTitle": "Choix du type de déclaration",
            "scopeValue": "item_typeDossierOT",
        },
        {
            "id": 3,
            "title": "Choix du type d'importation",
            "icon": "fa fa-file-import",
            "previousIcon": "fa fa-file-import",
            "previousTitle": "Choix du type d'importation",
            "scopeValue": "item_typeImportationOT"
        },
        {
            "id": 4,
            "title": "Choix du type de marchandise",
            "icon": "fa fa-list",
            "previousIcon": "fa fa-list",
            "previousTitle": "Choix du type de marchandise",
            "scopeValue": "item_typeMarchandiseOT"
        },
        {
            "id": 5,
            "title": "Etape finale",
            "icon": "fa fa-check-circle",
            "previousIcon": "fa fa-check-circle",
            "previousTitle": "Etape finale"
        }
    ];

    $scope.titleRacine =
    {
        1: "Client : ",
        2: "Type de déclaration : ",
        3: "Type d'importation : ",
        4: "Type Marchandise : ",
        5: "Etape finale : "
    },

        $scope.racineHistoryTmp = [
            {
                "id": 1,
                "scopeValue": "displayText_clientOT",
                "title": "Choix du client",
                "previousTitle": "Choix du client",
            },
            {
                "id": 2,
                "scopeValue": "item_typeDossierOT",
                "title": "Choix du type de déclaration",
                "previousTitle": "Choix du type de déclaration"
            },
            {
                "id": 3,
                "scopeValue": "item_typeImportationOT",
                "title": "Choix du type d'importation",
                "previousTitle": "Choix du type d'importation"
            },
            {
                "id": 4,
                "scopeValue": "item_typeMarchandiseOT",
                "title": "Choix du type de marchandise",
                "previousTitle": "Choix du type de marchandise"
            },
            {
                "id": 5,
                "title": "Etape finale",
                "previousTitle": "Etape finale"
            }
        ];

    // Add a watcher to monitor multiple variables
    /* $scope.$watchGroup(['typeDossierOT', 'typeImportationOT'], function(newValues, oldValues) {
      var newValue1 = newValues[0];
      var newValue2 = newValues[1];
      var oldValue1 = oldValues[0];
      var oldValue2 = oldValues[1];

      if (!!newValue1 && newValue1 !== oldValue1)
      {
          console.log('New value of variable1: ' + newValue1);
          console.log('Old value of variable1: ' + oldValue1);
      }


      //console.log('New value of variable2: ' + newValue2);

      //console.log('Old value of variable2: ' + oldValue2);
    }); */

    function generateArray(start, end, skipEnd = true) {
        var resultArray = [];

        for (var i = start; (skipEnd === true ? i < end : i <= end); i++) {
            resultArray.push(i);
        }

        return resultArray;
    }


    $scope.isSkiped = function (value) {
        return !!$scope.skipedValue && $scope.skipedValue[value] === true;
    };

    $scope.showBSC = true;

    $scope.switchWizard = function (next = 1, optionals = { stepValue: null }) {
        $scope.previousStepWizard = $scope.stepWizard;


        if (optionals && optionals.stepValue !== null && optionals.stepValue >= 1 && optionals.stepValue <= 5) {

            let rtr = false;
            let canSwitch = true;

            if (!!$scope.skipedValue && $scope.skipedValue[optionals.stepValue] === true) {
                canSwitch = false;
            }

            if (canSwitch) {

                if (optionals.stepValue > $scope.stepWizard) {
                    let myArray = generateArray($scope.stepWizard, optionals.stepValue);

                    $.each(myArray, function (k, v) {
                        if ($scope.checkPreviousStep(next, v) === true) {
                            rtr = true;
                            return false;
                        }
                    });
                }

                if (rtr === false) {
                    if (canSwitch) {
                        $scope.stepWizard = optionals.stepValue;
                    }
                }
            }
        }
        else {
            let rtr = $scope.checkPreviousStep(next, $scope.stepWizard);

            //pour forcer le switch sans le controle des values
            //rtr = false;

            if (rtr === false) {
                if (next === 1) {
                    $scope.stepWizard += 1;
                    if (!!$scope.skipedValue) {
                        var u = $scope.skipedValue[$scope.stepWizard];
                        if (u === true) {
                            $scope.stepWizard += 1;
                        }
                    }
                }
                else if (next === 0) {
                    $scope.stepWizard -= 1;
                    if (!!$scope.skipedValue) {
                        var u = $scope.skipedValue[$scope.stepWizard];
                        if (u === true) {
                            $scope.stepWizard -= 1;
                        }
                    }
                }
            }
        }

        if (!!$scope.skipedValue) {
            if ($scope.skipedValue[$scope.stepWizard] === true) {
                if (next === 1) {
                    $scope.stepWizard += 1;
                }
                else if (next === 0) {
                    $scope.stepWizard -= 1;
                }
            }
        }

        $scope.stepWizard = ($scope.stepWizard < 1) ? 1 : $scope.stepWizard;
        $scope.stepWizard = ($scope.stepWizard > 5) ? 5 : $scope.stepWizard;

        $scope.bgStyle1 = "";
        $scope.fgStyle1 = "";
        if ($scope.stepWizard === 5) {
            if (!!$scope.typeImportationOT) {
                $scope.showBSC = String($scope.typeImportationOT.nom).toLowerCase() === "groupage"
            }

            /*if($scope.dataPage['typemarchandises'].length === 1)
            {
                $scope.manageMarchandise($scope.dataPage['typemarchandises'][0].id);
            }*/
            $scope.bgStyle1 = $scope.bgStyle;
            $scope.fgStyle1 = $scope.fgStyle;
            $scope.reInit('[id*="ordretransit"]');

            var myVar = $("#onglet_ordretransit li:not(.d-none):first");
            var firstVisibleListItem = myVar.find('a').attr('href');

            $('#onglet_ordretransit li a').removeClass('active');
            $('#tabPaneFinal div.tab-pane.onlyHere').removeClass('show active');

            $("#" + myVar.attr("id") + " a").addClass('active');
            $(firstVisibleListItem).addClass('show active');
        }

        $scope.applyScope();

    }

    $scope.setTitleRacine = function (step, vvv, isIcon = false) {
        //Changement du titre de la racine
        $.each($scope.racineHistory, function (key, value) {

            if (value.id === step) {
                if (isIcon !== true) {
                    $scope.racineHistory[key].title = ($scope.titleRacine[step] ?? "") + (vvv ?? $scope[$scope.racineHistory[key].scopeValue] ?? $scope.racineHistory[key].previousTitle);
                }
                else {
                    $scope.racineHistory[key].icon = vvv;
                }
            }
        });
    }

    $scope.eventBtnRadio = function (event, scope) {
        $scope[scope] = event;
    }

    $scope.mapStepCheckValue = [
        {
            id: 1,
            scopeValue: "clientOT",
            msg: "Etape 1 ==> Renseigner d'abord le client"
        },
        {
            id: 2,
            scopeValue: "typeDossierOT",
            msg: "Etape 2 ==> Veuiller choisir un type de déclaration"
        },
        {
            id: 3,
            scopeValue: "typeImportationOT",
            msg: "Etape 3 ==> Veuiller choisir un type d'importation"
        },
        {
            id: 4,
            scopeValue: "typeMarchandiseOT",
            msg: "Etape 3 ==> Veuiller choisir un type de marchandise"
        },
    ];

    $scope.checkPreviousStep = function (from, stepWizard) {
        let msg = "";
        let showToast = false;
        if (from === 1) {
            //let y = $scope.mapStepCheckValue.filter((i)=> i.id === $scope.previousStepWizard)[0];
            let y = $scope.mapStepCheckValue.filter((i) => i.id === stepWizard)[0];
            if (!!y) {
                showToast = !(!!$scope[y.scopeValue]) && $scope.skipedValue[stepWizard] !== true;
                msg = y.msg;
                if (showToast) {
                    $scope.showToast("", msg, 'info');
                }
            }

        }
        return showToast;
    }
    $scope.moveToLastStep = function (event, valueDone) {
        let n = $scope.mapStepCheckValue.every((i) => {
            if (!!$scope[i.scopeValue]) {
                return true;
            }
            else {
                return false;
            }
        });

        if (n === true) {
            $scope.switchWizard(1, { stepValue: 5 });
        }
        else if (!!event && !!valueDone) {
            setTimeout(() => {
                $scope.switchWizard(1);
            }, 400)

        }
    }

    $scope.manageWizard = function () {
        var t = $('body').attr('data-client_id');

        $scope.showCancelBtn = {};

        $scope.stepWizard = 1;

        if ($scope.isAuthUserClient === true) {
            $scope.clientOT = parseInt(t);
            $('#form_addordretransit').blockUI_start();

            $scope.manageClientWizard(t);

            setTimeout(() => {

                $scope.skipedValue = $scope.skipedValue ?? {};

                $scope.skipedValue[1] = true;

                //Plus la peine pour le moment a cause de la foncton manageClientWizard qui fait un passage automatique
                //$scope.switchWizard(1 , {stepValue:0});

                $scope.showCancelBtn[2] = true;

                //Plus la peine pour le moment a cause de la foncton manageClientWizard qui fait un passage automatique
                /*  if (!!$scope.dataPage["typedossiers2"] && $scope.dataPage["typedossiers2"].length === 1)
                 {
                     $scope.skipedValue[2] = true;
                     if ($scope.skipedValue[3] !== false)
                     {
                         $scope.switchWizard(1);
                     }
                 } */

                if (!!$scope.skipedValue) {
                    if ($scope.skipedValue[$scope.stepWizard - 1] === true) {
                        $scope.showCancelBtn = {};
                        $scope.showCancelBtn[$scope.stepWizard] = true;
                    }

                }

                $scope.applyScope();

                $('#form_addordretransit').blockUI_stop();

            }, 1500)

        }
        else {
            $scope.skipedValue = {};
            $scope.skipedValue[1] = false;
        }


    }

    $scope.removeBtnSelected = function (dataType = "typedossiers", firstElt = "", secondElt = "") {
        $.each($scope.dataPage[dataType], function (u, h) {
            let id = firstElt + h.id + secondElt;
            if (h.selected !== null) {
                h.selected = null;
            }
            if ($("#" + id).prop('checked') === true) {

                $("#" + id).prop('checked', false);
            }
        })
    }
    $scope.manageMarchandise = function (getValue) {
        if (!!getValue) {
            let optionals = { queries: ["type_marchandise_id :" + getValue,], setStateCursorToLoading: true, isPromise: false };
            clientId = $("#client_ordretransit").val();
            if (!!clientId) {
                optionals.queries.push("client_id:" + clientId)
            }
            $scope.getElements("marchandises", optionals);
        }
        else {
            $scope.getElements("marchandises");
        }

    }

    $scope.listCheckOptions = [
        { "id": 1, "text": "Les codes HS ou nomenclature", "isChecked": false },
        { "id": 2, "text": "Le nom de la banque du fournisseur", "isChecked": false },
        { "id": 3, "text": "Le mode de transport (aérien ou mer)", "isChecked": false },
        { "id": 4, "text": "L'incoterm", "isChecked": false },
        { "id": 5, "text": "L'origine et la provenance de la marchandise", "isChecked": false },
        { "id": 6, "text": "Préciser la devise", "isChecked": false },
        { "id": 7, "text": "Groupage ou conteneur", "isChecked": false },
    ];

    $scope.checkElement = function (item) {
        $scope.checkAllOptions = $scope.listCheckOptions.every(item => item.isChecked === true);
    }

    $scope.checkAllElement = function () {
        $scope.listCheckOptions.forEach(item => item.isChecked = $scope.checkAllOptions);
    }

    $scope.validCheckOptions = function () {
        $scope.canCloseModal = true;


        let title = "", msg = "", type = "";
        if ($scope.checkAllOptions === true) {
            title = "Fichier Conforme";;
            msg = "Toutes les options sont validées";
            type = "success";
        }
        else {
            title = "Fichier Non Conforme";;
            msg = "Toutes les options ne sont pas validées";
            type = "error";

            $scope.eraseFile($scope.fileNameToUpload, $scope.fileNameIndex);
        }

        $scope.showToast(title, msg, type);

        $("#modal_addcheckoption").modal('hide');
        $scope.checkAllOptions = false;
        $scope.checkAllElement();

    }

    $scope.manageClientWizard = function (getValue, canSwitch = true) {
        $scope["typeImportationOT"] = null;
        $scope["typeDossierOT"] = null;
        $scope["typeMarchandiseOT"] = null;
        $scope["typeDossierSelected"] = null;
        $scope.bgStyle = "";
        $scope.bgStyle1 = "";
        $scope.fgStyle = "";
        $scope.fgStyle1 = "";
        $scope.showContainer = false;
        $scope["showExoTvaInMarchandise"] = false;
        $scope.dataPage['typedossiers'] = $scope.dataPage['typedossiersAll'];
        $scope.dataPage['typeimportations'] = $scope.dataPage['typeimportationsAll'];
        $scope.dataPage['typemarchandises'] = $scope.dataPage['typemarchandisesAll'];

        if (!!getValue) {
            $.each($scope.racineHistory, function (u, v) {
                $scope.racineHistory[u].title = $scope.racineHistory[u].previousTitle;
                $scope.racineHistory[u].icon = $scope.racineHistory[u].previousIcon;
            });

            $scope.skipedValue = {};
            $scope.removeBtnSelected("typedossiers", "type_dossier_", "_ordretransit");
            $scope.removeBtnSelected("typeimportations", "type_importation_", "_ordretransit");
            $scope.removeBtnSelected("typemarchandises", "type_marchandise_", "_ordretransit");

            optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
            optionals.queries.push("id:" + getValue);
            $scope.getElements("clients", optionals).then(function (data) {
                if (data.length === 1) {
                    //Init value
                    $scope.skipedValue[2] = false;

                    var item = data[0];

                    optionals = { queries: ["client_id :" + item.id, /* "show_for_client :false" */], setStateCursorToLoading: true, isPromise: true };
                    //optionals.queries.push("id:" + $(this).val());

                    let tabNeeds = [
                        { type: "typedossiers", optionals: optionals },
                    ];

                    $scope.refreshElementsNeeds(tabNeeds, false).then(function (result) {
                        //$scope.dataPage['typedossiers'] = [];
                        if (result["success"] === true) {
                            let data = $scope.dataPage['typedossiers'];

                            if (data.length === 1) {
                                //On saute le step 2
                                $scope.skipedValue[2] = true;

                                let h = data[0];
                                let id = "type_dossier_" + h.id + "_ordretransit";
                                $("#" + id).val(h.id).trigger("change");
                                $scope.$emit('radioChanged', id, h, false);
                            }

                            optionals.isPromise = false;

                            $scope.dataPage['typeimportations'] = [];

                            tabNeeds = [
                                { type: "typeimportations", optionals: optionals },
                                { type: "typemarchandises", optionals: optionals },
                                { type: "debours", optionals: optionals },
                            ];

                            $.each(tabNeeds, function (u, v) {
                                let opt = angular.copy(v.optionals);
                                if (v.type === "debours") {
                                    opt.queries.push("without_ot : true");
                                    opt.keyFilter = "libelle"
                                }
                                v.optionals = opt;
                            });

                            $scope.refreshElementsNeeds(tabNeeds, false).then(function (result) {
                                if ($scope["dataPage"]['typemarchandises'].length === 1) {
                                    //On saute le step 4
                                    $scope.skipedValue[4] = true;

                                    let h = $scope["dataPage"]['typemarchandises'][0];
                                    let id = "type_marchandise_" + h.id + "_ordretransit";
                                    $("#" + id).val(h.id).trigger("change");
                                    $scope.$emit('radioChanged', id, h, false);

                                    //$("#type_marchandise_ordretransit").val($scope["dataPage"]['typemarchandises'][0].id).trigger("change");
                                }
                            });

                            if (canSwitch) {
                                //Passage automatique apres selection du client
                                $scope.switchWizard(1);
                            }
                        }
                    });

                }


            }
                , function (msg) {
                    $scope.showToast("ERREUR", msg, 'error');
                });

        }

        if (canSwitch === false && !!$scope.updateItem) {
            $scope.moveToLastStep();
            /* setTimeout(() => {
               $scope.switchWizard(1, {stepValue: 5});
            }, 4500); */
        }

        //Mettre a jour le titre de la racine
        $scope.setTitleRacine(1);
    }


    $scope.stepLink = 1;
    $scope.currentStepLink = null;

    $scope.switchOTWizard = function (forTabPane, getValue) {
        var allOnglet = $("#" + forTabPane + "-0 li:not(.d-none) a");

        if (allOnglet.length > 0) {
            let currentHref = ""

            if (!(!!$scope.currentStepLink)) {
                currentHref = allOnglet.filter('.active').attr('href');
            }
            else {
                currentHref = $scope.currentStepLink;
            }

            let currentCursor = parseInt(currentHref.split('-').pop());

            currentHref = currentHref.slice(0, -1);

            if (isNaN(currentCursor)) {
                currentCursor = 1;
            }

            if (getValue === 0) {
                //Gerer le cas du precedent pour retourner sur l'onglet precedent le parent
                if (!!$scope.currentStepLink) {
                    var parentTab = allOnglet.filter('[href="' + $scope.currentStepLink + '"]').closest('.tab-pane');

                    let ulParent = $("#" + parentTab.attr('id') + " li:not(.d-none) a");

                    if (String($scope.currentStepLink).trim() === String(ulParent.first().attr('href')).trim()) {
                        let kk = parentTab.attr('id').split('-').pop();
                        if (!isNaN(kk)) {
                            $scope.stepLink -= 1;
                            currentCursor = kk;
                            currentHref = "#" + parentTab.attr('id').slice(0, -1);
                        }
                    }
                }

                currentCursor -= 1;
                $scope.stepLink -= 1;
            }
            else if (getValue === 1) {
                currentCursor += 1;
                $scope.stepLink += 1;
            }

            if (currentCursor < 0) {
                currentCursor = 1;
                $scope.stepLink = 1;
            }
            else if (currentCursor > allOnglet.length) {
                currentCursor = allOnglet.length;
                $scope.stepLink = allOnglet.length;
            }

            let nextHref = currentHref + currentCursor;

            var hasOtherOnglets = $(nextHref + " li:not(.d-none) a");

            allOnglet.filter('[href="' + nextHref + '"]').tab('show');

            if (hasOtherOnglets.length > 0) {
                $scope.stepLink += 1;
                $scope.currentStepLink = hasOtherOnglets.first().attr('href');
                hasOtherOnglets.first().tab('show');
            }
            else {
                $scope.currentStepLink = nextHref;
            }

            $scope.showPrevBtnWizard = $scope.stepLink !== 1;
            $scope.showNextBtnWizard = $scope.stepLink !== allOnglet.length;

            if ($scope.stepLink === allOnglet.length) {
                $scope.canClikOnglet = true;
            }

        }
    }

    //Fin Fonction Wizard Modal Add Ordre Transit

    $scope.manageValidationDirection = function () {
        if ($scope.gestion_entrepot_client === false) {
            $("#entrepots_client").val([]).trigger("change");
        }

        optionals = { queries: [], setStateCursorToLoading: true, isPromise: true };
        $scope.getElements("typedossiers", optionals).then(function (data) {
            $.each(data, function (key, value) {
                if (value.is_default === true) {
                    $scope.addToTabValidation([value]);
                }
                else if (value.show_for_client === true) {
                    if ($scope.gestion_entrepot_client === true) {
                        if (value.details && value.details.length > 0) {
                            $scope.addToTabValidation(value.details, value.id);
                        }
                        else {
                            $scope.addToTabValidation([value]);
                        }
                    }
                    else {
                        $scope.dataInTabPane['validationdossier_client']['data'] = $scope.dataInTabPane['validationdossier_client']['data'].filter((v) => v.parent_id !== value.id);
                    }

                }
            });
        }
            , function (msg) {
                $scope.showToast("ERREUR", msg, 'error');
            });

    }

    $scope.addToTabValidation = function (y, parentId) {
        $.each(y, function (key, value) {
            let o = {
                "type_dossier_id": value.id,
                "type_dossier": value,
                "parent_id": parentId ?? null,
                "etat": false
            };
            yy = $scope.dataInTabPane['validationdossier_client']['data'].filter((i) => i.type_dossier_id === o.type_dossier_id);

            if (yy.length === 0) {
                $scope.dataInTabPane['validationdossier_client']['data'].push(o);
            }

        });
    }

    $scope.allowEditOnTabPane = function (item, tag, index) {
        item.enableEdit = !item.enableEdit;
    }

    $scope.getTotal = function (tabToUse, keyToSum = 'montant', isTabPane = true, optionals = { profondeur: null, subcondition: null, ignoredValue: null, tagOrigin: null, forceNull: false }) {
        var total = 0;

        if (isTabPane === true) {
            tabToUse = $scope.dataInTabPane[tabToUse]['data'];
        }

        if (Array.isArray(tabToUse)) {
            tabToUse.forEach(item => {
                var myItem = 0;

                if (optionals && optionals.profondeur) {
                    myItem = parseInt(item[optionals.profondeur][keyToSum]);
                }
                else {
                    myItem = parseInt(item[keyToSum]);
                }

                if (!!myItem && !isNaN(myItem)) {
                    total += myItem;
                }

            });
        }

        return total;
    }

    // Permet d'afficher le formulaire
    $scope.currentTypeModal = null;
    $scope.currentTitleModal = null;
    $scope.paiementcomptant = true;
    $scope.showContainer = false;
    $scope.showNumeroContainer = false;
    $scope.disableEdit = true;
    $scope.disableEditFret = true;
    $scope.defaultFileUploadImg = BASE_URL + "assets/media/svg/icons/sidebar/icon-file-upload.svg";
    $scope.showModalAdd = function (type, optionals = { is_file_excel: false, title: null, fromUpdate: false, checkBeforeOpen: false, keepUpdateItem: false }) {
        let canOpenModal = true;
        optionals.is_file_excel = optionals.is_file_excel ?? false;
        optionals.fromUpdate = optionals.fromUpdate ?? false;
        optionals.title = optionals.title ?? null;
        if (optionals.checkBeforeOpen === true) {
            canOpenModal = $scope.checkSemiForm('nd_dossier');
        }

        if (optionals.keepUpdateItem !== true) {
            $scope.updateItem = null;
        }

        $scope.currentTitleModal = optionals.title;
        $scope.currentTypeModal = type;
        $scope.emptyForm((optionals.is_file_excel ? 'liste' : type));
        if (optionals.is_file_excel) {
            $scope.reInit('[id$="_liste"]');
        }
        else {
            $scope.currentTypeModal = type;
        }

        if (type.indexOf("role") !== -1) {
            //$(".mycheckbox").prop('checked', false);
            $scope.getElements('permissions');
        }




        $scope.nid = null;
        // Pour récupérer le prochain dernier type_value
        if (!optionals.fromUpdate) {
            if (type === "ordretransit") {
                //for wizard modal add ordre transit
                $scope.manageWizard();
            }

            if (type === "client") {
                $scope.manageValidationDirection();
            }

            if (type === "marchandise") {
                let pp = 'type_marchandise_2_marchandise';
                $("#type_marchandise_2_marchandise").prop("checked", "2").trigger('change');
                $scope.radioChanged(pp, { id: 2 }, false);
            }
            if (type === "projetmodule") {
                document.getElementById('nom_departement_projetmodule').value = $cookies.get('activePage');
                document.getElementById('nom_projet_departement_projetmodule').value = $cookies.get('nom_projet');
            }
            if (type === "fonctionnalitemodule") {
                document.getElementById('module_id_fonctionnalitemodule').value = $cookies.get('activePage');
            }




            if (type === "planification") {
                // $scope.getElements("professeurpratiquesalles");

                var interval_refresh_programme = setInterval(function () {
                    if ($('.select2.modal').length) {
                        clearInterval(interval_refresh_programme);
                    }
                }, 500);

                // DEv
                $scope.date_debut_programme = "";
                $scope.date_fin_programme = "";
                $scope.interval_dates = [];
                $currentTab = 0;


                $scope.submittedToTable = false;
                $scope.programmeErrors = []


                let ancienValueDateDebut = ""
                let ancienValueDateFin = ""
                $('#date_debut_planification').on('change', function () {
                    ancienValueDateDebut = $(this)
                    let result1 = dateProgrammeComparaison();

                    if (result1 === true) {
                        $scope.date_debut_programme = $('#date_debut_planification').val()
                        $(this).data('old', $(this).val())
                        $scope.generateDaysInterval("date_debut_planification")
                    }
                    else {
                        $('#date_debut_planification').val($(this).data('old'))
                    }
                })

                $('#date_fin_planification').on('change', function () {
                    ancienValueDateFin = $(this)
                    let result2 = dateProgrammeComparaison();

                    if (result2 === true) {
                        $scope.date_fin_programme = $('#date_fin_planification').val()
                        $(this).data('old', $(this).val())

                        $scope.generateDaysInterval("date_fin_planification")

                    } else {
                        $('#date_fin_planification').val($(this).data('old'))
                        // $scope.generateDaysInterval("date_fin_programme")
                    }
                })

                $scope.reInitForm = function (id) {
                    $('#projet_planification').select2({ id: "" })
                    $('#fonctionnalite_fonctionnalite_module_planification').select2({ id: "" })
                    $('#tache_tache_fonctionnalite_planification').select2({ id: "" })
                    $('#tag_planification').select2({ id: "" })
                    $("#description_planification").val("")

                    $scope.submittedToTable = false;
                }

                $("#modal_addplanification").modal('show');

            }


            if (type === "pointage") {

                var interval_refresh_programme = setInterval(function () {
                    if ($('.select2.modal').length) {
                        clearInterval(interval_refresh_programme);
                    }
                }, 500);

                // DEv
                $scope.date_debut_programme = "";
                $scope.date_fin_programme = "";
                $scope.interval_dates = [];
                $currentTab = 0;


                $scope.submittedToTable = false;
                $scope.programmeErrors = []


                let ancienValueDateDebut = ""
                let ancienValueDateFin = ""
                $('#date_debut_pointage').on('change', function () {
                    ancienValueDateDebut = $(this)
                    let result1 = dateProgrammeComparaison();

                    if (result1 === true) {
                        $scope.date_debut_programme = $('#date_debut_pointage').val()
                        $(this).data('old', $(this).val())
                        $scope.generateDaysInterval("date_debut_pointage")
                    }
                    else {
                        $('#date_debut_pointage').val($(this).data('old'))
                    }
                })

                $('#date_fin_pointage').on('change', function () {
                    ancienValueDateFin = $(this)
                    let result2 = dateProgrammeComparaison();

                    if (result2 === true) {
                        $scope.date_fin_programme = $('#date_fin_pointage').val()
                        $(this).data('old', $(this).val())

                        $scope.generateDaysInterval("date_fin_pointage")

                    } else {
                        $('#date_fin_pointage').val($(this).data('old'))
                        $scope.generateDaysInterval("date_fin_programme")
                    }
                })

                $scope.reInitForm = function (id) {
                    $('#heure_arrive_pointage').select2({ id: "" })
                    $('#heure_depart_pointage').select2({ id: "" })
                    $('#retard_pointage').select2({ id: "" })
                    $('#justificatif_pointage').select2({ id: "" })
                    $("#description_pointage").val("")

                    $scope.submittedToTable = false;
                }

                $("#modal_addpointage").modal('show');

            }

            if (type === "tacheassigne") {

                var interval_refresh_programme = setInterval(function () {
                    if ($('.select2.modal').length) {
                        clearInterval(interval_refresh_programme);
                    }
                }, 500);

                // DEv
                $scope.date_debut_programme = "";
                $scope.date_fin_programme = "";
                $scope.interval_dates = [];
                $currentTab = 0;


                $scope.submittedToTable = false;
                $scope.programmeErrors = []


                let ancienValueDateDebut = ""
                let ancienValueDateFin = ""
                $('#date_debut_tacheassigne').on('change', function () {
                    ancienValueDateDebut = $(this)
                    let result1 = dateProgrammeComparaison();

                    if (result1 === true) {
                        $scope.date_debut_programme = $('#date_debut_tacheassigne').val()
                        $(this).data('old', $(this).val())
                        $scope.generateDaysInterval("date_debut_tacheassigne")
                    }
                    else {
                        $('#date_debut_tacheassigne').val($(this).data('old'))
                    }
                })

                $('#date_fin_tacheassigne').on('change', function () {
                    ancienValueDateFin = $(this)
                    let result2 = dateProgrammeComparaison();

                    if (result2 === true) {
                        $scope.date_fin_programme = $('#date_fin_tacheassigne').val()
                        $(this).data('old', $(this).val())

                        $scope.generateDaysInterval("date_fin_tacheassigne")

                    } else {
                        $('#date_fin_tacheassigne').val($(this).data('old'))
                        $scope.generateDaysInterval("date_fin_programme")
                    }
                })

                $scope.reInitForm = function (id) {
                    $('#heure_arrive_tacheassigne').select2({ id: "" })
                    $('#heure_depart_tacheassigne').select2({ id: "" })
                    $('#retard_tacheassigne').select2({ id: "" })
                    $('#justificatif_tacheassigne').select2({ id: "" })
                    $("#description_tacheassigne").val("")

                    $scope.submittedToTable = false;
                }

                $("#modal_addtacheassigne").modal('show');

            }

            $scope.getElements("lastvalues", { justTheseAttrs: "value", queries: ['model:"' + type + 's"'], toType: 'lastvalue', isPromise: true }).then(function (data) {
                if (!!data[0].value) {
                    $scope.nid = parseInt(data[0].value) + 1;
                }
                else {
                    $scope.nid = null;
                }
            }, function (msg) {
            });
        }



        if ($cookies.getObject(type) && optionals.fromUpdate == false) {
            swalWithBootstrapButtons.fire({
                text: "Voulez vous réutiliser le brouillon ?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $scope.checkInForm(type, $cookies.getObject(type), optionals);
                    $cookies.remove(type, null);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Si on veut supprimer les cookies du type .
                    $cookies.remove(type, null);
                }
            });
        }

        if (canOpenModal) {
            // $("#modal_add" + (optionals.is_file_excel ? 'liste' : type)).css('display', 'block');
            $("#modal_add" + (optionals.is_file_excel ? 'liste' : type)).modal('show');
        }
    };

    $scope.generateDaysInterval = function (id) {

        console.log("WHAT")


        if ($scope.planningEdit !== null && $scope.planningEdit !== undefined) {

        } else {
            let result = dateProgrammeComparaison();

            if (result === false) {
                console.log("WHAT 2")
                return;
            }
        }

        let dateDebut = ""
        let dateFin = ""

        if (id === "date_debut_planification") {

            setTimeout(function () {

                dateDebut = $('#' + id)[0].value
                dateFin = $('#date_debut_planification')[0].value

                // let dateFin = $scope.date_fin_programme
                $scope.date_debut_programme = dateDebut

                // Appel fonction to set Interval Days
                if (!stringempty(dateDebut) && !stringempty(dateFin)) {
                    console.log('ICI')
                    $scope.setDaysInDatesInterval(dateDebut, dateFin, "debut")
                    // $scope.reInit()
                } else {

                }


            }, 500)

            return;


        } else if (id === "date_fin_planification") {

            dateFin = $('#' + id)[0].value

            console.log("B")
            setTimeout(function () {

                dateFin = $('#' + id)[0].value
                let dateDebut = $('#date_debut_planification')[0].value
                $scope.date_fin_programme = dateFin

                console.log('date fin scope => ', $scope.date_fin_programme)

                // Appel fonction to set Interval Days
                if (!stringempty(dateDebut) && !stringempty(dateFin)) {
                    $scope.setDaysInDatesInterval(dateDebut, dateFin, "fin")
                    // $scope.reInit()
                } else {


                }

            }, 500)

            return;
        }

        if (id === "date_debut_pointage") {
            // alert("A")
            setTimeout(function () {

                dateDebut = $('#' + id)[0].value
                dateFin = $('#date_debut_pointage')[0].value

                // let dateFin = $scope.date_fin_programme
                $scope.date_debut_programme = dateDebut

                // Appel fonction to set Interval Days
                if (!stringempty(dateDebut) && !stringempty(dateFin)) {
                    console.log('ICI')
                    $scope.setDaysInDatesInterval(dateDebut, dateFin, "debut")
                    // $scope.reInit()
                } else {

                }


            }, 500)

            return;


        } else if (id === "date_fin_pointage") {

            dateFin = $('#' + id)[0].value

            console.log("B")
            setTimeout(function () {

                dateFin = $('#' + id)[0].value
                let dateDebut = $('#date_debut_pointage')[0].value
                $scope.date_fin_programme = dateFin

                console.log('date fin pointage => ', $scope.date_fin_programme)

                // Appel fonction to set Interval Days
                if (!stringempty(dateDebut) && !stringempty(dateFin)) {
                    $scope.setDaysInDatesInterval(dateDebut, dateFin, "fin")
                    // $scope.reInit()
                } else {


                }

            }, 500)

            return;
        }

    }

    $scope.setDaysInDatesInterval = function (start, end, control) {

        console.log('planing :', $scope.interval_dates)
        let interValesDate = $scope.interval_dates;

        let startDate = transformDatePicker(start)
        let endDate = transformDatePicker(end)
        let dateArr = []
        let alreadyExist = []
        let indexToDelete = []

        //
        //
        // return;

        let idplanification = (new Date(startDate)).toLocaleDateString("fr").replace(/\//g, "").slice(0, 4) + (new Date(endDate)).toLocaleDateString("fr").replace(/\//g, "")

        let currentDate = startDate

        if (control === "debut") {

            let ref = $scope.interval_dates.findIndex(function (item) {
                return item.milisec === startDate;
            })

            if (ref !== -1) {
                for (let i = 0; i < $scope.interval_dates.length; i++) {
                    if ($scope.interval_dates[i].milisec < $scope.interval_dates[ref].milisec) {

                        if ($scope.interval_dates[i].dayProgrammes.length > 0) {
                            let ladate = new Date($scope.interval_dates[0].milisec)


                            let mois = "" + ladate.getMonth()
                            let jour = "" + ladate.getDate()
                            let annee = "" + ladate.getFullYear()

                            if (+mois < 10) {
                                mois = "0" + mois
                            }
                            if (+jour < 10) {
                                jour = "0" + jour
                            }

                            ladate = jour + '/' + mois + "/" + annee

                            try {

                                $("#date_debut_planification").val(ladate)
                                $("#date_debut_pointage").val(ladate)
                            } catch (e) {
                                console.log("error => ", e)
                            }

                            iziToast.error({
                                title: "ERREUR",
                                message: "Veuillez supprimer d'abord les programmes lié aux dates passées",
                                position: 'topRight'
                            });
                            return;
                        }

                    } else {
                        indexToDelete.unshift($scope.interval_dates[i])




                    }
                }

                $scope.$apply()

                $scope.deleteElementFromIntervalleScope(indexToDelete)

                indexToDelete = []
            }

        } else {
            let ref = $scope.interval_dates.findIndex(function (item) {
                return item.milisec === endDate;
            })



            if (ref !== -1) {


                for (let i = $scope.interval_dates.length - 1; i >= 0; i--) {
                    if ($scope.interval_dates[i].milisec > $scope.interval_dates[ref].milisec) {

                        if ($scope.interval_dates[i].dayProgrammes.length > 0) {


                            let ladate = new Date($scope.interval_dates[$scope.interval_dates.length - 1].milisec)


                            let mois = "" + ladate.getMonth()
                            let jour = "" + ladate.getDate()
                            let annee = "" + ladate.getFullYear()

                            if (+mois < 10) {
                                mois = "0" + mois
                            }
                            if (+jour < 10) {
                                jour = "0" + jour
                            }

                            ladate = jour + '/' + mois + "/" + annee



                            try {

                                $("#date_fin_planification").val(ladate)
                                $("#date_fin_pointage").val(ladate)
                            } catch (e) {
                                console.log("error => ", e)
                            }


                            iziToast.error({
                                title: "ERREUR",
                                message: "Veuillez supprimer d'abord les programmes lié aux dates futures",
                                position: 'topRight'
                            });
                            return;
                        }

                    }
                }
            }


        }


        // $scope.interval_dates = $scope.interval_dates.filter(function(item) {
        //     item.dayProgrammes.length > 0
        // })



        while (currentDate <= endDate) {

            let newDate = new Date(currentDate)
            let id = "day_" + newDate.toLocaleDateString("fr").replace(/\//g, "")

            alreadyExist.push({
                id: id,
                idplanification: idplanification,
                date: new Date(currentDate),
                milisec: currentDate,
                initial: getDateInitial(currentDate),
                dayProgrammes: []
            })

            if ($scope.interval_dates.length > 0) {
                let index = $scope.interval_dates.findIndex(function (item) {
                    return item.id === id
                })

                if (index !== -1) {
                    currentDate = addOneDay(newDate)
                    continue;
                }
            }

            // let ladate
            dateArr.push(
                {
                    id: id,
                    id_planification: idplanification,
                    date: new Date(currentDate),
                    milisec: currentDate,
                    initial: getDateInitial(currentDate),
                    dayProgrammes: []
                }
            )
            $scope.programmeErrors[id] = {
                projet_id: "",
                fonctionnalite_module_id: "",
                tache_fonctionnalite_id: "",
                tag_id: "",
                description: "",
            }

            currentDate = addOneDay(newDate)
        }

        if (control === "debut") {

            $scope.interval_dates.unshift(...dateArr)
        } else {
            $scope.interval_dates.push(...dateArr)
        }

        if (alreadyExist.length > 0 && alreadyExist.length < $scope.interval_dates.length) {

            if (alreadyExist[alreadyExist.length - 1].id !== $scope.interval_dates[$scope.interval_dates.length - 1].id) {
                for (let i = 0; i < $scope.interval_dates.length; i++) {
                    let element = $scope.interval_dates[i]
                    let indexInter = $scope.interval_dates.findIndex(function (item) {
                        return item.id === element.id
                    })

                    if (alreadyExist[i] === null || alreadyExist[i] === undefined) {

                        indexToDelete.push($scope.interval_dates[i])
                    }
                }
            }

            if (indexToDelete.length > 0) {
                $scope.deleteElementFromIntervalleScope(indexToDelete)
                indexToDelete = []
            }
        }



        $scope.reInit()

        $scope.$apply();

        // DEv TEST
        // $scope.updateListennerOnProgrammeForm()
        // Fin DEv Test

    }


    $scope.manageTabDate = function (item, index) {
        $scope.selectedDate = null;
        $scope.selectedIndex = index;

        // Mettre à jour la date sélectionnée
        if (item && item.date) {
            // alert("voici_item", item);
            $scope.selectedDate = new Date(item.date);

            $("#day_details_planification").val(item.date);
            $("#day_details_pointage").val(item.date);

            // Utiliser item.date à la place de dateStr
            const initialToFind = formatDateToInitial(item.date);
            // const match = ($scope.pointages || []).find(p => formatDateToInitial(p.date) === initialToFind);
            const dateObj = new Date(item.date);
            const formattedDate = ("0" + dateObj.getDate()).slice(-2) + "/" +
                ("0" + (dateObj.getMonth() + 1)).slice(-2) + "/" +
                dateObj.getFullYear();

            document.getElementById("date_details_pointage").value = formattedDate;

        }

        // Filtrer les détails en fonction de la date sélectionnée
        $scope.filteredDetails = $scope.dataInTabPane['details_planification']['data'].filter(detail => {
            const detailDate = new Date(detail.day);
            return detailDate.toDateString() === $scope.selectedDate.toDateString();
        });
        // $scope.filteredDetailsPointages = $scope.dataInTabPane['details_pointage']['data'].filter(detail => {
        //     const detailDate = new Date(detail.day);
        //     return detailDate.toDateString() === $scope.selectedDate.toDateString();
        // });
    };

    $scope.$watch('heure_arrive', function (newValue) {
        if (newValue) {
            // Convertit les deux heures en minutes pour comparaison
            const parts = newValue.split(':');
            const arriveMinutes = parseInt(parts[0]) * 60 + parseInt(parts[1]);

            const limiteMinutes = 8 * 60 + 45; // 08:45 = 525 minutes

            $scope.retard = arriveMinutes > limiteMinutes ? 'oui' : 'non';
        }
    });


    function formatDateToInitial(dateStr) {
        const jours = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
        const date = new Date(dateStr + "T00:00:00"); // Assure que la date n'est pas décalée
        const jour = jours[date.getDay()];
        const jourNum = date.getDate();
        return `${jour} ${jourNum}`;
    }


    $scope.changeTab = function (tabNumber = 0, tabIdName = "", page = "", tabId = null) {

        if (page === "detail-planning") {
            $scope.currentDayPlanning = tabIdName;

            setTimeout(function () {
                $('.tab-pane').removeClass('active');
                $('#active' + $scope.currentDayPlanning).addClass('active');
            }, 500);
            return;
        }

        if (tabNumber === 0) {
            setTimeout(function () {
                $('#active2').addClass("active");
                $scope.$apply();
            }, 1000);
        }

        if (tabNumber === 0 && tabIdName === "") {
            setTimeout(function () {
                for (let i = 0; i < $(".myProgrammeTab").length; i++) {
                    let attr = $(".myProgrammeTab")[i].getAttribute('class');
                    if (attr.indexOf("active") !== -1) {
                        $('.modal .tab-pane').removeClass('active');
                        $('#form_addprogramme-tab' + i).addClass('active');
                        break;
                    }
                }
            }, 500);

            setTimeout(function () {
                if ($('select').data('select2')) {
                    try {
                        $('.select2').select2('destroy');
                    } catch (e) { }
                }

                $('.select2').select2({});
            }, 500);
        } else {
            setTimeout(() => {
                const node = document.querySelector('#' + tabIdName);
                const parent = node ? node.parentNode : null;
                if (parent) {
                    parent.querySelectorAll('.tab-pane').forEach(tabpane => tabpane.classList.remove('active'));
                    parent.parentNode.querySelectorAll('.nav-link').forEach(navlink => navlink.classList.remove('active'));
                    $('#' + tabIdName).addClass('active');
                }
                if (tabIdName.indexOf("pills") !== -1) {
                    $('[id^=pills-] .nav-link').removeClass('active');
                }
                if (tabIdName.indexOf("active") !== -1) {
                    $('[id^=active-].nav-link').removeClass('active');
                }
            }, 50);
            setTimeout(() => {
                let target = null;
                if (tabId) {
                    target = $("#" + tabId);
                } else {
                    target = $('#' + tabIdName + "-tab .nav-link") ?? $('#' + tabIdName.replace('tab', 'link'));
                    console.info(target);
                }
                target = target.length ? target : $(this);
                if (target.length) {
                    setTimeout(() => {
                        target.addClass('active');
                    }, 100);
                }
            }, 50);
        }



        setTimeout(() => {
            //$scope.process_collapses();
        }, 1000);
    };

    $scope.planificationassignes = []; // Injectées depuis GraphQL
    $scope.currentDate = new Date();   // Jour actuel pour calculer la semaine

    // Fonction pour mettre à jour les jours de la semaine
    $scope.updateCalendar = function () {
        let startOfWeek = $scope.getStartOfWeek($scope.currentDate);

        $scope.currentWeek = [];

        for (let i = 0; i < 6; i++) { // Lundi à Samedi
            let day = new Date(startOfWeek);
            day.setDate(day.getDate() + i);

            $scope.currentWeek.push({
                label: $scope.getDayLabel(day),
                date: day
            });
        }

        // Mettre à jour le mois et l'année pour l'affichage
        $scope.monthLabel = startOfWeek.toLocaleString('default', { month: 'long' });
        $scope.yearLabel = startOfWeek.getFullYear();
    };

    $scope.getStartOfWeek = function (date) {
        let d = new Date(date);
        let day = d.getDay(); // 0=dimanche, 1=lundi
        let diff = d.getDate() - day + (day === 0 ? -6 : 1);
        return new Date(d.setDate(diff));
    };

    $scope.getDayLabel = function (date) {
        const days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        return days[date.getDay()];
    };

    $scope.isSameDay = function (day1, day2) {
        if (!day1 || !day2) return false;

        let date1 = new Date(day1);
        let date2 = new Date(day2);

        return date1.getFullYear() === date2.getFullYear() &&
            date1.getMonth() === date2.getMonth() &&
            date1.getDate() === date2.getDate();
    };
    $scope.getPlanificationsByPersonnel = function () {
        let groupByPersonnel = {};

        $scope.dataPage['planificationassignes'].forEach(function (assign) {
            if (!assign.personnel) return;

            let id = assign.personnel.id;
            if (!groupByPersonnel[id]) {
                groupByPersonnel[id] = {
                    personnel: assign.personnel,
                    assignments: []
                };
            }
            groupByPersonnel[id].assignments.push(assign);
        });

        // Retourne sous forme de tableau
        return Object.values(groupByPersonnel);
    };

    $scope.goToPreviousWeek = function () {
        $scope.currentDate.setDate($scope.currentDate.getDate() - 7);
        $scope.updateCalendar();
    };

    $scope.getUniquePersonnels = function (assignations) {
        let seen = {};
        let personnels = [];

        assignations.forEach(function (assign) {
            if (assign.personnel && !seen[assign.personnel.id]) {
                personnels.push(assign.personnel);
                seen[assign.personnel.id] = true;
            }
        });

        return personnels;
    };

    $scope.generateCurrentWeek = function (startDate) {
        $scope.currentWeek = [];
        let date = new Date(startDate);

        for (let i = 0; i < 6; i++) { // 6 jours fixes
            $scope.currentWeek.push({
                label: $scope.getDayLabel(date), // ex: "Lun", "Mar", ...
                date: new Date(date) // stocker la date du jour
            });

            date.setDate(date.getDate() + 1);
        }
    };
    // Navigation: semaine suivante
    $scope.goToNextWeek = function () {
        $scope.currentDate.setDate($scope.currentDate.getDate() + 7);
        $scope.updateCalendar();
    };

    // Appel initial
    $scope.updateCalendar();








    // $scope.forligne = function (e, type, action, idItem = 0, parent = 0) {
    //     e.preventDefault();
    //     // alert(type)
    //     if (type.indexOf("planification") !== -1) {
    //         // console.log('planning', type, idItem);
    //         $scope.submittedToTable = true
    //         let index2 = $scope.interval_dates.findIndex(function (item) {
    //             return item.id === idItem
    //         });

    //         let projetName = "";
    //         let fonctionnaliteName = "";
    //         let tacheName = "";
    //         let tagName = "";
    //         let description = "";
    //         if ($("#projet_planification-" + idItem).select2('data').length > 0) {
    //             projetName = $("#projet_planification-" + idItem).select2('data')[0].text
    //         }
    //         try {
    //             if ($("#fonctionnalite_fonctionnalite_planification-" + idItem).select2('data').length > 0) {
    //                 fonctionnaliteName = $("#fonctionnalite_fonctionnalite_module_planification-" + idItem).select2('data')[0].text
    //             }
    //             if ($("#tache_tache_fonctionnalite_planification-" + idItem).select2('data').length > 0) {
    //                 tacheName = $("#tache_tache_fonctionnalite_planification-" + idItem).select2('data')[0].text
    //             }
    //             if ($("#tag_planification-" + idItem).select2('data').length > 0) {
    //                 tagName = $("#tag_planification-" + idItem).select2('data')[0].text
    //             }
    //             if ($("#description_planification-" + idItem).select2('data').length > 0) {
    //                 description = $("#description_planification-" + idItem).select2('data')[0].text
    //             }
    //         }
    //         catch (err) {
    //             //comment-console.log(err)
    //         }
    //         let id = "";
    //         // if($('.iddayplanniing')[0].value !== "") {
    //         //     id = $('.iddayplanniing')[0].value;
    //         // }

    //         if ($scope.programmeEdit !== null && $scope.programmeEdit !== undefined) {
    //             id = $scope.programmeEdit.id
    //         }

    //         let ladate1 = new Date($scope.interval_dates[index2].milisec)

    //         let bundleForm = {
    //             id: id,
    //             date: ladate1,
    //             projet_id: $("#projet_planification-" + idItem).val(),
    //             fonctionnalite_module_id: $("#fonctionnalite_fonctionnalite_planification-" + idItem).val(),
    //             tache_fonctionnalite_id: $("#tache_tache_fonctionnalite_planification-" + idItem).val(),
    //             tag_id: $("#tag_planification-" + idItem).val(),
    //             description: $("#description_planification-" + idItem).val()
    //         }

    //         $('.iddayplanification').val('');


    //         if ($scope.hasError(bundleForm, idItem)) {

    //             console.log('planning :',bundleForm);

    //             return;
    //         }
    //         console.log('planning :',bundleForm);

    //         let index = $scope.interval_dates.findIndex(function (item) {
    //             return item.id === idItem
    //         })

    //         // console.log('planning :',index);

    //         if (index !== -1) {

    //             let ladate = new Date($scope.interval_dates[index].milisec)
    //             let date = { date: ladate }
    //             let programme = {
    //                 ...bundleForm,
    //                 ...date,
    //                 ...{ code_day: $scope.interval_dates[index].id },
    //                 ...{ code_planning: $scope.interval_dates[index].idplanification }
    //             }
    //             console.log('planning :',programme);

    //             $scope.interval_dates[index].dayProgrammes.push(programme)

    //             $scope.programmeEdit = undefined;

    //             $scope.emptyProgrammeForm(idItem)

    //             $("#projet_planification-" + idItem).val("")
    //             $("#fonctionnalite_fonctionnalite_planification-" + idItem).val("")
    //             $("#tache_tache_fonctionnalite_planification-" + idItem).val("")
    //             $("#tag_planification-" + idItem).val("")
    //             $("#description_planification-" + idItem).val("")

    //             try {
    //                 $('#fonctionnalite_fonctionnalite_planification-' + idItem).select2({
    //                     id: ""
    //                 })
    //                 $('#fonctionnalite_fonctionnalite_planification-' + idItem).select2({
    //                     id: ""
    //                 })
    //                 $('#tache_tache_fonctionnalite_planification-' + idItem).select2({
    //                     id: ""
    //                 })
    //                 // $(".select2.professeur").empty()
    //                 $("#tache_tache_fonctionnalite_planification-" + idItem).select2().val('').trigger("change");
    //                 $("#fonctionnalite_fonctionnalite_planification-" + idItem).select2().val('').trigger("change");
    //                 $("#tag_planification-" + idItem).select2().val('').trigger("change");
    //                 $("#projet_planification-" + idItem).select2().val('').trigger("change");
    //             } catch (e) {
    //                 //comment-console.log(e)
    //             }
    //         }
    //     }


    // };



    function dateProgrammeComparaison() {
        let selectedDate = document.getElementById("day_details_planification").value;

        let result = true;
        let message = ""
        let dateFinTmplt = $("#date_fin_planification").val()
        let dateDebutTmplt = $("#date_debut_planification").val()
        let today = new Date()
        today = today.setHours(0, 0, 0, 0)

        if (dateDebutTmplt.length > 0 && dateFinTmplt.length > 0) {
            let dateDebutStr = transformToInternationDateString(dateDebutTmplt)
            let dateFinStr = transformToInternationDateString(dateFinTmplt)
            dateDebutTimestamp = new Date(dateDebutStr).getTime()
            dateFinTimestamp = new Date(dateFinStr).getTime()
            if (dateDebutTimestamp > dateFinTimestamp) {
                message = "la date de debut doit etre inferieur a la date de fin"
                result = false;

            }
        }
        // if (dateFinTmplt.length > 0) {
        //     let dateFinStr = transformToInternationDateString(dateFinTmplt)
        //     dateFinTimestamp = new Date(dateFinStr).getTime()
        //     if (dateFinTimestamp < today) {
        //         message = "Veuillez mettre une date de fin superieur"
        //         result = false;
        //     }
        // }
        // if (dateFinTmplt.length > 0 && dateDebutTmplt.length > 0) {
        //     let dateFinStr = transformToInternationDateString(dateFinTmplt)
        //     let dateDebutStr = transformToInternationDateString(dateDebutTmplt)
        //     dateFinTimestamp = new Date(dateFinStr).getTime()
        //     dateDebutTimestamp = new Date(dateDebutStr).getTime()
        //     if (dateDebutTimestamp > dateFinTimestamp) {

        //         message = "Veuillez mettre une date de fin superieur"
        //         result = false;
        //     }
        // }

        if (result === false) {
            iziToast.error({
                title: "",
                message: '<span class="h4">' + message + '</span>',
                position: 'topRight'
            });


        }

        return result;
    }

    function transformToInternationDateString(value) {
        if (value.indexOf('/') !== -1) {
            let valueArray = value.split('/')
            value = valueArray[1] + "/" + valueArray[0] + "/" + valueArray[2];
        }

        return value;
    }

    $scope.deleteElementFromIntervalleScope = function (inputArrayToDelete) {



        if (inputArrayToDelete.length > 0) {
            for (let i = 0; i < inputArrayToDelete.length; i++) {

                if ($scope.interval_dates[inputArrayToDelete[i]] !== null && $scope.interval_dates[inputArrayToDelete[i]] !== undefined) {
                    if ($scope.interval_dates[inputArrayToDelete[i]].dayProgrammes.length > 0) {

                    } else {
                        $scope.interval_dates.splice(inputArrayToDelete[i], 1)
                    }
                }



                let index = $scope.interval_dates.findIndex(function (element) {
                    return inputArrayToDelete[i].id === element.id
                })

                $scope.interval_dates.splice(index, 1)
            }
        }

    }

    $scope.updateListennerOnProgrammeForm = function () {
        let indexError = $(".select2.professeur").data().errorindex
        setTimeout(function () {
            $(".select2.professeur").off('change');

            $(".select2.professeur").on("change", function (e) {
                $scope.pratiqueSelected = null;
                $scope.professeurSelected = null;


                // $(".select2.professeur_pratique").val("")
                // $(".select2.salle").val("")

                if ($(this).attr('id').indexOf("professeur_programme") !== -1) {
                    let itemId = $(this).val()
                    let idDay = $(this).attr('id').split('-')[1]

                    $scope.item_id = $(this).val();

                    let indexProf = $scope.professeurs.findIndex(function (item) {
                        return item.id == itemId
                    });

                    if (indexProf !== -1) {
                        $scope.professeurSelected = $scope.professeurs[indexProf]
                        if ($scope.programmeErrors[idDay] !== undefined) {
                            $scope.programmeErrors[idDay].professeur = ""
                        }
                    }
                }

                //console.log("changement détecté");
                if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
                    $scope.$apply();
                }
            });
        }, 500);

        setTimeout(function () {

            $(".select2.professeur_pratique").off('change');

            $(".select2.professeur_pratique").on("change", function (e) {

                if ($(this).attr('id').indexOf("professeur_pratique_programme") !== -1) {
                    let itemId = $(this).val()
                    // ce qui cause l'erreur select 2
                    // let itemIdSelect2 = $(this).select2().val()

                    let idDay = $(this).attr('id').split('-')[1]

                    $scope.pratiqueSelected = ""

                    let indexPratique = $scope.professeurpratiques.findIndex(function (item) {
                        return item.pratique_id == itemId
                    });

                    if (indexPratique !== -1) {
                        $scope.pratiqueSelected = $scope.professeurpratiques[indexPratique]
                        if ($scope.programmeErrors[idDay] !== undefined) {
                            $scope.programmeErrors[idDay].pratique = ""
                        }
                    }

                    if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
                        $scope.$apply();
                    }
                }
                else {
                    $scope.pratiqueSelected = null
                }
            });

            // $(".select2.genre").off('change');

        }, 500);

        // On genre
        setTimeout(function () {
            $(".select2.genre").off('change')
            $(".select2.genre").on('change', function (e) {

                if ($(this).attr("id").indexOf("genre_pratique") !== -1) {
                    let itemId = $(this).val()

                    let idDay = $(this).attr('id').split('-')[1]
                    // EREASE ERROR FORM



                    if (!stringempty(idDay)) {
                        $scope.programmeErrors[idDay].genre = ""
                    }


                    setTimeout(function () {
                        $scope.$apply()
                    }, 100)




                }
            });
        }, 500)

        // On Salle
        setTimeout(function () {
            $(".select2.salle").off('change')
            $(".select2.salle").on('change', function (e) {

                if ($(this).attr("id").indexOf("salle_pratique_programme") !== -1) {


                    let idDay = $(this).attr('id').split('-')[1]





                    if (!stringempty(idDay)) {
                        $scope.programmeErrors[idDay].salle = ""
                    }


                    $scope.$apply()

                }
            });
        }, 500)

        // On Niveau
        setTimeout(function () {
            $(".select2.niveau").off('change')
            $(".select2.niveau").on('change', function (e) {

                if ($(this).attr("id").indexOf("niveau_pratique") !== -1) {
                    // EREASE ERROR FORM

                    let idDay = $(this).attr('id').split('-')[1]

                    if (!stringempty(idDay)) {
                        $scope.programmeErrors[idDay].niveaux = ""
                    }


                    setTimeout(function () {
                        $scope.$apply()
                    }, 100)


                }
            });
        }, 500)
    }
    $scope.hasError = function (bundleForm, id = null, type = 1) {

        let result = false;
        try {
            let today = new Date().getTime()

            if (stringempty(bundleForm.projet_id)) {
                $scope.programmeErrors[id].projet_id = "Veuillez bien choisir le projet"
            } else {
                delete $scope.programmeErrors[id].projet_id;
            }


            if (stringempty(bundleForm.fonctionnalite_module_id)) {

                $scope.programmeErrors[id].fonctionnalite_module_id = "Veuillez bien choisir une fonctionnalité module"
            } else {
                delete $scope.programmeErrors[id].fonctionnalite_module_id;
                delete $scope.programmeErrors[id].tache_fonctionnalite_id;
                delete $scope.programmeErrors[id].description;
            }
            if (stringempty(bundleForm.tag_id) || bundleForm.tag_id != "") {
                $scope.programmeErrors[id].tag_id = "Veuillez bien choisir un tag"
            } else {
                delete $scope.programmeErrors[id].tag_id;
            }
            delete $scope.programmeErrors[id].tag_id;
            let tab = Object.keys($scope.programmeErrors[id])
            console.log("planning :" + tab);
            // alert(result +" - "+tab.length);

            for (let i = 0; i < tab.length; i++) {
                if ($scope.programmeErrors[id][tab[i]] !== "") {
                    result = true;
                    break;
                }
            }

        } catch (e) {
            //comment-console.log(e)
        }

        return result;

    }
    function stringempty(value) {
        // let retour = true
        if (value === null || value === undefined) {
            return true;
        }


        let valueVal = "" + value
        valueVal = valueVal.trim()


        return valueVal.length === 0
    }
    function addOneDay(currentDate) {
        let newDate = currentDate.setDate(currentDate.getDate() + 1);
        return newDate;
    }
    function transformDatePicker(value) {
        value = "" + value
        if (value.indexOf('.') !== -1) {
            let valueArray = value.split('.')
            value = valueArray[1] + "/" + valueArray[0] + "/" + valueArray[2];
        } else if (value.indexOf('-') !== -1) {
            let valueArray = value.split('-')
            value = valueArray[1] + "/" + valueArray[0] + "/" + valueArray[2];
        } else if (value.indexOf('/') !== -1) {
            let valueArray = value.split('/')
            value = valueArray[1] + "/" + valueArray[0] + "/" + valueArray[2];
        }

        return (new Date(value)).getTime()
    }

    function getDateInitial(timestamp) {
        let dateString = new Date(timestamp)

        let jourNum = dateString.getDay()
        let jourStr = ""

        switch (jourNum) {
            case 0:
                jourStr = "Dim"
                break;
            case 1:
                jourStr = "Lun"
                break;
            case 2:
                jourStr = "Mar"
                break;
            case 3:
                jourStr = "Mer"
                break;
            case 4:
                jourStr = "Jeu"
                break;
            case 5:
                jourStr = "Ven"
                break;
            case 6:
                jourStr = "Sam"
                break;

            default:
                break;
        }

        return jourStr + " " + dateString.getDate()
    }
    //Gestion de Nav Module


    $scope.activateLink = function (event, pageId) {
        console.log('salut', pageId);
        $cookies.put('activePage', pageId);
        angular.element(document.querySelectorAll('.nav-link')).removeClass('active fw-bold text-primary');
        angular.element(event.currentTarget).addClass('active fw-bold text-primary');
        $scope.showPage(pageId);
    };

    $scope.showPage = function (pageId) {
        $scope.activePage = $cookies.get('activePage') ?? 'qualité'
        console.log($scope.activePage, ' salut ', pageId);
        angular.element(document.querySelectorAll('.page')).removeClass('active');
        angular.element(document.getElementById(pageId)).addClass('active');
    };

    $scope.showPage($scope.activePage);


    $scope.openConsultationDossier = function (tag, id) {
        let currentObject = $("#modal_addconsultationdossier #object-consultationdossier"),
            currentObjectND = $("#modal_addconsultationdossier #object-notedetaildossier");
        currentObject.attr('data', '');
        currentObjectND.attr('data', 'generate-dossiernotedetails-pdf?dossier_id:' + id);
        currentObject.replaceWith(currentObject.clone());
        currentObjectND.replaceWith(currentObjectND.clone());
        $scope.currentDossier = null;
        $scope.currentUrlDossier = null;
        $scope.currentDossierId = id;

        $.each($scope.listeFichiers, function (key, value) {
            value.selected = false;
        });
        $scope.listeFichiers = [];


        $scope.getElements(tag, { queries: ["id:" + id], isPromise: true, setStateCursorToLoading: true }).then(function (data) {
            if (data && data.length === 1) {
                $scope.currentDossier = data[0];
                let tt = data[0];
                //$scope.currentUrlDossier = $scope.currentDossier["fichier_declaration"];

                $.each(tt.ordre_transit.files, function (key, value) {
                    let obj = {
                        id: $scope.listeFichiers.length + 1,
                        nom: value.origine,
                        db_name: value.origine,
                        url: value.url,
                        selected: false
                    }

                    $scope.listeFichiers.push(obj);
                });

                $.each($scope.listeFichiersTmp, function (key, value) {
                    $scope.listeFichiers.push(value);
                });

                $.each($scope.listeFichiers, function (key, value) {
                    if (!(!!value.url)) {
                        value.url = tt[value.db_name];
                    }
                });

                $.each(tt.files, function (key, value) {
                    let obj = {
                        id: $scope.listeFichiers.length + 1,
                        nom: value.origine + " - " + (key + 1),
                        db_name: value.origine,
                        url: value.url,
                        selected: false
                    }

                    $scope.listeFichiers.push(obj);
                });


            }

        });
        $scope.applyScope();
        let currentModal = $("#modal_addconsultationdossier");
        currentModal.modal('show');
    };

    $scope.determineFileType = function (url) {
        var extension = url.split('.').pop().toLowerCase();

        if (extension.indexOf('pdf') !== -1) {
            return 'application/pdf';
        }
        else if (extension.indexOf('mp4') !== -1 || extension.indexOf('webm') !== -1 || extension.indexOf('ogg') !== -1) {
            return 'video/mp4'; // ou 'video/webm' ou 'video/ogg' selon le type de fichier vidéo
        }
        else if (extension.indexOf('mp3') !== -1 || extension.indexOf('wav') !== -1 || extension.indexOf('ogg') !== -1) {
            return 'audio/mpeg'; // ou 'audio/wav' ou 'audio/ogg' selon le type de fichier audio
        }
        else if (extension.indexOf('docx') !== -1) {
            return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        }
        else if (extension.indexOf('xlsx') !== -1) {
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        }
        else {
            return 'image/jpeg'; // ou 'image/png' ou 'image/gif' selon le type de fichier image
        }
    }

    $scope.selectFichier = function (item) {
        let currentObject = $("#modal_addconsultationdossier #object-consultationdossier");
        let currentVideo = $("#modal_addconsultationdossier #video-consultationdossier");
        let currentAudio = $("#modal_addconsultationdossier #audio-consultationdossier");

        currentObject.attr('data', '');

        if (item.selected === true) {
            $scope.currentUrlDossier = null;
            $scope.currentDossier = null;
            item.selected = false;
        }
        else {
            $.each($scope.listeFichiers, function (key, value) {
                value.selected = false;
            });

            item.selected = true;
            $scope.currentUrlDossier = item.url;
            $scope.selectedFichier = item.id;

            let can_open = true;

            if (!(!!item.url)) {
                //item.url = BASE_URL + '/assets/media/404.svg';
                can_open = false;
            }

            if (can_open) {
                //currentObject.attr('data', item.url + "#toolbar=0&navpanes=0&scrollbar=0");
                if ($scope.determineFileType(item.url) === 'application/pdf' || $scope.determineFileType(item.url) === 'image/jpeg' || $scope.determineFileType(item.url) === 'image/png' || $scope.determineFileType(item.url) === 'image/gif') {
                    if (!currentVideo.hasClass("d-none")) {
                        currentVideo.addClass("d-none");
                    }
                    if (!currentAudio.hasClass("d-none")) {
                        currentAudio.addClass("d-none");
                    }

                    if (currentObject.hasClass("d-none")) {
                        currentObject.removeClass("d-none");
                    }

                    currentObject.attr('type', $scope.determineFileType(item.url));
                    currentObject.attr('data', item.url);
                    currentObject.replaceWith(currentObject.clone());
                }
                else if ($scope.determineFileType(item.url) === 'video/mp4' || $scope.determineFileType(item.url) === 'video/webm' || $scope.determineFileType(item.url) === 'video/ogg') {
                    if (!currentObject.hasClass("d-none")) {
                        currentObject.addClass("d-none");
                    }
                    if (!currentAudio.hasClass("d-none")) {
                        currentAudio.addClass("d-none");
                    }
                    if (currentVideo.hasClass("d-none")) {
                        currentVideo.removeClass("d-none");
                    }

                    currentVideo.attr('src', item.url);
                    currentVideo.replaceWith(currentVideo.clone());
                }
                else if ($scope.determineFileType(item.url) === 'audio/mpeg' || $scope.determineFileType(item.url) === 'audio/wav' || $scope.determineFileType(item.url) === 'audio/ogg') {
                    if (!currentObject.hasClass("d-none")) {
                        currentObject.addClass("d-none");
                    }
                    if (!currentVideo.hasClass("d-none")) {
                        currentVideo.addClass("d-none");
                    }
                    if (currentAudio.hasClass("d-none")) {
                        currentAudio.removeClass("d-none");
                    }
                }
            }
            else {
                if (!currentObject.hasClass("d-none")) {
                    currentObject.addClass("d-none");
                }

                if (!currentVideo.hasClass("d-none")) {
                    currentVideo.addClass("d-none");
                }

                if (!currentAudio.hasClass("d-none")) {
                    currentAudio.addClass("d-none");
                }

                $scope.currentUrlDossier = null;
                $scope.currentDossier = null;
                $scope.selectedFichier = null;

                $scope.showToast("", "Impossible d'ouvrir le fichier", 'warning', 5000, null, { position: 'topCenter' });
            }

        }
    }

    $scope.listeFichiersTmp = [
        // {
        //     id: 1,
        //     nom : "Connaissement",
        //     db_name : ["ordre_transit", "connaissement"],
        //     url: null,
        //     selected: false
        // },
        // {
        //     id: 2,
        //     nom : "BSC",
        //     db_name : "fichier_bae",
        //     url: null,
        //     selected: false
        // },
        // {
        //     id: 3,
        //     nom : "Facture Fournisseur",
        //     db_name : "fichier_bae",
        //     url: null,
        //     selected: false
        // },
        // {
        //     id: 4,
        //     nom : "Facture Fret",
        //     db_name : "fichier_bae",
        //     url: null,
        //     selected: false
        // },
        // {
        //     id: 5,
        //     nom : "Assurance",
        //     db_name : "fichier_bae",
        //     url: null,
        //     selected: false
        // },
        // {
        //     id: 6,
        //     nom : "DPI",
        //     db_name : "fichier_bae",
        //     url: null,
        //     selected: false
        // },
        {
            id: 1,
            nom: "Declaration",
            db_name: "fichier_declaration",
            url: null,
            selected: false
        },
        {
            id: 2,
            nom: "BAE",
            db_name: "fichier_bae",
            url: null,
            selected: false
        },
    ]



    $scope.openPreviewPdf = function (url, optionals = { files: false }) {
        let currentModal = $("#modal_addpreviewpdf");
        let currentObject = $("#modal_addpreviewpdf object");
        let currentHref = $("#modal_addpreviewpdf a");

        if (optionals.files === true) {
            if (Array.isArray(url) && url.length === 1) {
                let file = $('#' + url[0].name).prop('files');
                if (!!file && file.length === 1) {
                    url = URL.createObjectURL(file[0]);
                }
                else {
                    url = url[0].url;
                }
            }
            else {
                url = null;
            }
        }

        if (!!url) {
            currentObject.attr('data', url);
            currentObject.replaceWith(currentObject.clone());
            currentHref.attr('href', url);
            currentModal.modal('show');
        }
        else {
            $scope.showToast("", "Imposible d'afficher le fichier", 'warning');
        }


    }

    $scope.changeInTabPane = function (keyTab, valTab, tagPane = "manifestes_dossier") {
        $.each($scope.dataInTabPane[tagPane]['data'], function (key, value) {
            value[keyTab] = $scope[valTab];
        });
    };

    $scope.canSet = function (tagForm = "notedetails_dossier", tagId = "mynotedetail") {

        if (!!$scope.dataInTabPane && !!$scope.dataInTabPane[tagForm]) {
            let m = $scope.dataInTabPane[tagForm]['data'].length;

            let classeT = $("#" + tagId).find('.select2-container');
            if (classeT.length > 0) {
                classeT.each(function () {
                    $(this).addClass('text-capitalize');
                });

                if (m > 0) {
                    classeT.each(function () {
                        if ($(this).prev('select').length > 0) {
                            if (!$(this).prev('select').hasClass('ignore-disable')) {
                                $(this).addClass('disable-pointer');
                            }
                        }
                    });
                }
                else {
                    classeT.each(function () {
                        if ($(this).hasClass('disable-pointer')) {
                            $(this).removeClass('disable-pointer');
                        }
                    });
                }
            }
            $("#" + tagId + " input").filter(".form-control").each(function () {
                if ($(this).attr('ng-readonly') !== undefined && $(this).attr('ng-readonly') !== null) {
                    if ($(this).attr('disabled-edit') !== undefined && $(this).attr('disabled-edit') !== null) {
                        let rtr = $scope[$(this).attr('disabled-edit')];

                        $(this).attr('readonly', rtr === true);
                    }
                    if (m > 0) {
                        $(this).addClass('bg-disabled-input');
                    }
                    else {
                        $(this).removeClass('bg-disabled-input');
                    }
                }
            });

            return m > 0;
        }
    };

    $scope.setAdditionnalData = function (value) {
        $scope['additional_data_nd'] = value;
        $scope.applyScope();
    }

    $scope.setValeurAss = function (idElt, toIdElt = '') {
        let value = parseInt($("#" + idElt).val());

        if (isNaN(value)) {
            value = 0;
        }

        value = (value * 0.15 * 1.06) / 100;

        if (value > 0) {
            if (value < 6360) {
                value = 6360;
            }
        }
        else {
            value = '';
        }

        if (!!toIdElt) {
            $("#" + toIdElt).val(value);
        }
    }

    $scope.getTauxChange = function (deviseId) {
        let rtr = 1;
        getCurrentItem = $scope.dataPage['devises'].filter((item) => item.id === deviseId);
        if (getCurrentItem.length === 1) {
            rtr = getCurrentItem[0].taux_change;
        }
        return rtr;
    }

    $scope.convertMontantTauxChange = function (montant, deviseIn, deviseOut) {
        rtr = montant;
        getDeviseIn = $scope.dataPage['devises'].filter((item) => item.id === deviseIn);
        getDeviseOut = $scope.dataPage['devises'].filter((item) => item.id === deviseOut);

        if (getDeviseIn.length === 1 && getDeviseOut.length === 1) {
            if (getDeviseIn[0].devise_base) {
                rtr = montant * getDeviseOut[0].taux_change;
            }
            else {
                rtr = montant * (getDeviseIn[0].taux_change / getDeviseOut[0].taux_change);
            }
        }

        return rtr;
    }

    $scope.checkSemiForm = function (tagForm, optionals = { returnValue: false, ignoreRequired: false }) {
        let obj = {};
        $scope.returnErrors = {};

        let allElt = $("input[id$=" + "_" + tagForm + "]:not([type='hidden']), textarea[id$=" + "_" + tagForm + "]:not([type='hidden']), select[id$=" + "_" + tagForm + "]");

        let can_continue = true;

        allElt.each(function () {
            let checkValue = $(this).hasClass('required') && (!(!!$(this).val()) || $(this).val().trim().length === 0);

            if (optionals.ignoreRequired) {
                checkValue = false;
            }
            can_do = true;
            if ($(this).hasClass('ignore-elt')) {
                can_do = false;
                checkValue = false;
            }

            if (checkValue) {
                $scope.returnErrors[$(this).attr("id")] = "Veuillez renseigner ce champ";
                can_continue = false;
                return false;
            }
            else if (optionals.returnValue === true && can_do === true) {
                let indexTabName = $(this).attr('id').substring(0, ($(this).attr('id').length - tagForm.length - 1));

                if ($(this).attr("name") !== undefined && $(this).attr("name") !== null && $(this).attr("name") !== "") {
                    indexTabName = $(this).attr("name");

                    if (indexTabName.endsWith("_id")) {
                        indexTabName = indexTabName.substring(0, indexTabName.length - 3);
                    }
                }

                if ($(this).is("select")) {
                    let keySelect = "nom";

                    if (!!$(this).attr("key-select")) {
                        keySelect = $(this).attr("key-select");
                    }

                    if ($(this).attr("ignore-objet") !== "true") {
                        obj[indexTabName + "_id"] = parseInt($(this).val());
                        obj[indexTabName] = { [keySelect]: $(this).children("option:selected").text() }
                    }
                    else {
                        obj[indexTabName] = $(this).children("option:selected").text();
                    }
                }
                else if ($(this).is("input[type='number']")) {
                    let rr = parseInt($(this).val());
                    if (isNaN(rr)) {
                        rr = "";
                    }

                    obj[indexTabName] = rr;
                }
                else if ($(this).is("input[type='file']")) {
                    let files = $(this).prop("files");
                    if (files.length > 0) {
                        obj[indexTabName] = files[0];
                    }
                    else {
                        obj[indexTabName] = "";
                        obj[indexTabName + "_erase"] = "erase";
                    }

                }
                else if ($(this).is(":checkbox") || $(this).is(":radio")) {
                    obj[indexTabName] = $(this).prop("checked");
                }
                else if ($(this).is("input")) {
                    let hh = $(this).val();

                    if ($(this).is("[text-to-boolean]")) {
                        hh = hh === "true" ? true : false;
                    }

                    obj[indexTabName] = hh;
                }
            }
        });

        if (Object.keys($scope.returnErrors).length !== 0) {
            setTimeout(() => {
                $scope.returnErrors = {};
                $scope.applyScope();
            }, 2000)
        }

        console.log("diop log", obj);


        if (optionals.returnValue === true) {
            Object.keys(obj).forEach(function (key) {
                if (key !== "id" && optionals.ignoreRequired !== true && (obj[key] === undefined || obj[key] === null || obj[key] === "")) {
                    delete obj[key];
                }
            });

            return {
                can_continue: can_continue,
                obj: obj
            };
        }
        else {
            return can_continue;
        }


    };
    $scope.getRestantNd = function (firstTag, secondTag, useTab = null) {
        let t = $scope.getTotal('notedetails_dossier', secondTag);

        if (!!useTab && Array.isArray(useTab)) {
            t = $scope.getTotal(useTab, secondTag, false);
        }

        return $scope.getTotal($scope.updateItem.ordre_transit.marchandises, firstTag, false) - t;
    }

    $scope.deleteSemiForm = function (tagForm, optionals = null) {
        title = "Suppression";
        msg = "Etes-vous sûr de vouloir supprimer ? Il sera impossible de récupérer l'élément après suppression.";

        swalWithBootstrapButtons.fire({
            title: title,
            text: msg,
            icon: 'question',
            showCancelButton: true,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $scope.emptyForm(tagForm, false, { setDefaultValue: false, tagToIgnore: ['id' + tagForm] });
                if (!!optionals.tagTabPane) {
                    $scope.actionSurTabPaneTagData('delete', optionals.tagTabPane, 0, null, null, { deleteAll: true });
                }
                setTimeout(() => {
                    if (optionals) {
                        $scope.addElement(null, optionals.forType, optionals);
                    }

                }, 500);

            }
            else if (result.dismiss === Swal.DismissReason.cancel) { }
        });

    };

    $scope.updateModalNd = function (tagForm, index) {
        $scope.additionalDataNd = "ignore"
        let item = $scope.dataInTabPane[tagForm]['data'][index];
        if (!!item) {
            $scope.showModalAdd(tagForm, { checkBeforeOpen: true, keepUpdateItem: true });
            $("#id_" + tagForm).val(item.id);
            $("#index_" + tagForm).val(index);
            $scope.checkInForm(tagForm, item);
        }
    };

    $scope.checkBeforeAdd = function (tagForm) {
        let fromUpdate = !!$("#index_" + tagForm).val();
        let res = $scope.checkSemiForm(tagForm, { returnValue: true });

        if (res['can_continue'] === true) {
            if (fromUpdate === true) {
                let id = parseInt($("#id_" + tagForm).val());
                res['obj']['id'] = id;
            }

            if ($scope.checkQteAndWeight(res['obj'], fromUpdate)) {
                if (!fromUpdate) {
                    $scope.dataInTabPane[tagForm]['data'].push(res['obj']);
                }
                else {
                    let index = parseInt($("#index_" + tagForm).val());
                    $scope.dataInTabPane[tagForm]['data'][index] = res['obj'];
                }

                $("#modal_add" + tagForm).modal('hide');

                $scope.addElement(null, 'dossier', { toType: 'tab-gestiondossier-0-0-1', semiForm: true, keepModal: true, tagTabPane: 'notedetails_dossier' })
                //$scope.addElement(null,'nd_dossier', {toType:'dossier', semiForm: true, keepModal: true, tagTabPane: 'notedetails_dossier'})
                $scope.applyScope();

                //$scope.addElement(null,'dossier', {keepModal: true});
            }
        }
    };

    $scope.checkQteAndWeight = function (objectValue, fromUpdate = false) {
        let error = null, rtr = true;
        let qteRestante = $scope.getRestantNd('quantite', 'nb_colis');
        let poidsRestant = $scope.getRestantNd('poids', 'poids_brut');

        if (fromUpdate === true) {
            let y = $scope.dataInTabPane['notedetails_dossier']['data'].filter((i) => i.id !== objectValue['id']);
            qteRestante = $scope.getRestantNd('quantite', 'nb_colis', y);
            poidsRestant = $scope.getRestantNd('poids', 'poids_brut', y);
        }

        if (objectValue['nb_colis'] <= 0) {
            error = "Le nombre de colis doit être supérieur à 0";
        }
        else if (qteRestante <= 0) {
            error = "Le nombre de colis maximal est atteint";
        }
        else if (objectValue['nb_colis'] > qteRestante) {
            error = "Le nombre de colis ne doit pas dépasser " + qteRestante;
        }
        else if (qteRestante <= 0 || objectValue['nb_colis'] <= 0) {
            error = "Le nombre de colis maximal est atteint";
        }
        else if (objectValue['poids_brut'] <= 0) {
            error = "Le poids brut doit être supérieur à 0";
        }
        else if (poidsRestant <= 0) {
            error = "Le poids brut maximal est atteint";
        }
        else if (objectValue['poids_brut'] > poidsRestant) {
            error = "Le poids brut ne peut pas dépasser " + poidsRestant;
        }
        else if (objectValue['poids_net'] <= 0) {
            error = "Le poids net doit être supérieur à 0";
        }
        else if (objectValue['poids_net'] > poidsRestant) {
            error = "Le poids net ne peut pas dépasser " + poidsRestant;
        }
        else if (objectValue['valeur'] <= 0) {
            error = "La valeur facture doit être supérieur à 0";
        }

        if (!!error) {
            rtr = false;
            $scope.showToast("", error, 'warning');
        }
        return rtr;
    }

    $scope.nbArticle = function (index) {
        let qteRestante = $scope.getRestantNd('quantite', 'nb_colis');
        let poidsRestant = $scope.getRestantNd('poids', 'poids_brut');

        if (index !== null && index !== undefined) {
            rtr = index + 1;

            let y = $scope.dataInTabPane['notedetails_dossier']['data'].filter((u, i) => i !== index);
            qteRestante = $scope.getRestantNd('quantite', 'nb_colis', y);
            poidsRestant = $scope.getRestantNd('poids', 'poids_brut', y);
        }
        else {
            rtr = $scope.dataInTabPane['notedetails_dossier']['data'].length + 1;
        }
        $scope["qte_restante"] = qteRestante;
        $scope["ds_restant"] = poidsRestant;
        $scope['nb_article'] = rtr;
    }

    $scope.selectAllArticles = function (tagForm, tabs) {
        let value = $("#all_article_" + tagForm).prop('checked');

        let fromUpdate = !!$("#index_" + tagForm).val();

        let eltArticle = $("#article_" + tagForm);
        let inputsElt = [
            { id: "nb_colis", value: '' },
            { id: "poids_brut", value: '' },
            { id: "poids_net", value: '' },
        ];
        let res = "";
        let readOnly = false;

        if (tabs.length > 0 && value === true) {
            res = tabs[0].id;
            readOnly = true;

            inputsElt = [
                { id: "nb_colis", value: $scope.qte_restante },
                { id: "poids_brut", value: $scope.poids_restant },
                { id: "poids_net", value: $scope.poids_restant },
            ];
        }

        let can_do = true;

        if (fromUpdate && value === false) {
            can_do = false;
        }

        if (can_do) {
            eltArticle.val(res).trigger("change");
        }

        // setTimeout(() =>
        // {
        //     $("#nomenclature_douaniere_" + tagForm).attr('disabled', readOnly);
        // },500)

        inputsElt.forEach((input) => {
            if (!fromUpdate) {
                $("#" + input.id + "_" + tagForm).val(input.value);
            }

            $scope.allowReadOnly(input.id + "_" + tagForm, true, readOnly);
        });
    }



    $scope.showModalDetail = function (type, itemId) {
        var queryname = type;
        let optionals = { queries: ["avance_salaire_id:" + itemId] }
        if (optionals) {
            $scope.pageChanged(queryname, optionals)
        }
        else {
            $scope.pageChanged(queryname);
        }
        $("#modal_details" + type).modal('show');
    };

    $scope.updateText = function (tagId = "table_ordretransit", filterId = null) {
        var element = $("#" + tagId);
        let t = "is_collapse_" + tagId;
        $scope[t] = false;
        setTimeout(() => {
            if (element.hasClass("collapse")) {
                $scope[t] = true;
            }
            if (element.hasClass("show")) {
                $scope[t] = false;
            }

            $scope.applyScope();
        }, 500);

        var filterElement = $("#" + filterId);
        if (filterElement.length > 0) {
            if (filterElement.hasClass("show")) {
                filterElement.removeClass("show");
            }
        }


    }

    $scope.chooseItem = function (item,) {
        if (item !== null) {
            let can_do = false;
            let id = $scope.idToSetForChooseClient;
            if ($('#' + id).prop("multiple")) {
                maxLength = $("#" + id).attr("maximumSelectionLength");
                if (parseInt(maxLength) === 1) {
                    $("#" + id).val([]).trigger("change");
                }

                let u = $("#" + id).val().map(function (value) {
                    return parseInt(value, 10);
                });
                if (!u.includes(item.id)) {
                    /* u = [...u, ...[item.id]];
                    u = u.map(function(value) {
                        return String(value);
                    }); */

                    can_do = true;
                }
            }
            else {
                can_do = true;

            }
            if (can_do) {
                $('#' + id).append(new Option(item.nom, item.id, false, true)).trigger("change");
            }

            $("#modal_adddataclient").modal('hide');
        }
    }
    $scope.showMoreData = function (type, from = "client_ordretransit") {
        $scope.idToSetForChooseClient = from;
        console.log(type, from);
        $("#modal_adddata" + type).modal('show');
    };
    $scope.chstat = { 'id': '', 'statut': '', 'type': '', 'title': '' };
    $scope.showModalStatut = function (event, type, statut, obj = null, title = null,) {
        $scope.chstat.action = null;

        var id = 0;
        id = obj.id;
        $scope.chstat.id = id;
        $scope.chstat.statut = statut;
        $scope.chstat.type = type;
        $scope.chstat.title = $(event.target).attr('title') ? $(event.target).attr('title') : title;
        $scope.emptyForm('chstat');
        $("#modal_addchstat").modal('show');
    };


    $scope.chstat = { 'id': '', 'statut': '', 'type': '', 'title': '', 'commentaire': '' };
    $scope.showModalStatutNotif = function (event, type, statut, obj, optionals = { mode: 1, title: null, substatut: null, action: null, idTabPane: null }) {
        $scope.chstat.id = obj.id;
        console.log('here am i', statut);
        $scope.chstat.statut = statut;
        $scope.chstat.substatut = optionals && optionals.substatut ? optionals.substatut : null;
        $scope.chstat.action = optionals && optionals.action ? optionals.action : null;
        $scope.chstat.type = type;
        $scope.idTabPane = optionals && optionals.idTabPane != null ? optionals.idTabPane : null;
        //$scope.chstat.title     = optionals && optionals.title ? optionals.title : null;

        if (!optionals || !optionals.mode || optionals.mode == 1) {
            $scope.emptyForm('chstat');
            if (type === 'visa') {
                if ($scope.chstat.substatut === 'visa_qualite' && $scope.chstat.statut == 0 || $scope.chstat.substatut === 'visa_chef' && $scope.chstat.statut == 0) {
                    $("#modal_addchvisadown").modal('show');
                }
                else {

                    $("#modal_addchvisa").modal('show');
                }
            }
            else {
                $("#modal_addchstat").modal('show');
            }
        }
        else {
            if (type === "dossier") {

                if (obj.ordre_transit.type_dossier.nbre_type_dossier > 0 && optionals.title) {
                    $scope.chstat.substatut = "Ce dossier provient d'un ordre de transit mixte. Par conséquent, les autres dossiers de ce même Ordre Transit seront transformés";;
                }
            }
            swalWithBootstrapButtons.fire({
                title: optionals && optionals.title ? optionals.title : null,
                text: $scope.chstat.substatut,
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $scope.changeStatut(event, $scope.chstat.type);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) { }
            });
        }
    };



    // implémenter toutes les variations du formulaire
    $scope.changeStatut = function (e, type) {
        var action = $scope.chstat.action ? $scope.chstat.action : 'statut';
        var form = $('#form_addchstat');
        var send_data = { id: $scope.chstat.id, status: $scope.chstat.statut, substatut: $scope.chstat.substatut, commentaire: $scope.chstat.commentaire };
        var tmp_type = type;
        if (tmp_type === "client_user") {
            type = "user";
        }

        form.parent().parent().blockUI_start();
        Init.changeStatut(type, send_data, action).then(function (data) {
            form.parent().parent().blockUI_stop();

            if (data.data && (!data.data.errors && !data.errors)) {
                if (type == 'notifpermuser') {
                    $scope.chstat.title = "Notification marquée comme vue";
                    $scope.getElements('notifpermusers');
                }
                else if (tmp_type === "client_user") {
                    reqwrite = type + "s" + "(id:" + $scope.chstat.id + ")";
                    Init.getElement(reqwrite, "id,name,email,image,color_status,status_fr,status", []).then(function (data) {
                        console.log("diop id tab pane ", $scope.idTabPane);
                        if (!!data && data.length === 1 && $scope.idTabPane !== null) {

                            $scope.dataInTabPane['users_client']['data'][$scope.idTabPane].color_status = data[0].color_status;
                            $scope.dataInTabPane['users_client']['data'][$scope.idTabPane].status_fr = data[0].status_fr;
                            $scope.dataInTabPane['users_client']['data'][$scope.idTabPane].status = data[0].status;
                            $scope.idTabPane = null;
                        }

                    });

                }
                else if (type === "ordretransit") {
                    let elt = $("#modal_adddetail" + type);

                    if (elt.hasClass('block-close')) {
                        elt.removeClass('block-close');
                    }

                    elt.modal('hide');
                    $scope.pageChanged(type);
                    $scope.pageChanged("dossier");
                    $scope.showToast("OT Transformé en dossier", '<i class="fa fa-check-square"></i>', 'success');
                    elt.addClass('block-close');
                }
                else if (type === "dossier") {
                    $scope.pageChanged(type);
                    $scope.pageChanged("ordretransit");
                    $scope.showToast("Dossier Transformé en OT", '<i class="fa fa-check-square"></i>', 'success');
                }
                else if (type === "visa") {
                    $scope.pageChanged('fonctionnalite');
                    $scope.showToast("Valider", '<i class="fa fa-check-square"></i>', 'success');
                }
                else {
                    $scope.pageChanged(type);
                }

                if (type !== "ordretransit" && type !== "dossier") {
                    title = $scope.chstat.title ? $scope.chstat.title : 'ACTION';
                    typeToast = 'success';
                    if ($scope.chstat.statut == 0) {
                        //title = 'DÉSACTIVATION';
                        typeToast = 'warning';
                    }
                    $scope.showToast(title, '<i class="fa fa-check-square"></i>', typeToast);

                }

                $scope.reloadFromSomePage();
                $("#modal_addchstat").modal('hide');
                $("#modal_addchvisa").modal('hide');
                $("#modal_addchvisadown").modal('hide');
                console.log('=================>>>>', data.data);
                $scope.reloadFromSomePage();
            }
            else {
                $errors = data.errors ?? data.data.errors;
                let errs = null;
                if (typeof $errors == "object") {
                    errs = Object.keys(data.errors);
                    errs.forEach((elmt) => {
                        $scope.showToast('', ('<span class="h4 text-dark">' + (data.errors)[elmt] + '</span>'), 'error');
                    });
                }
                else {
                    $scope.showToast('', ('<span class="h4">' + $errors + '</span>'), 'error');
                }
            }
        }, function (msg) {
            form.parent().parent().blockUI_stop();
        });
    };

    $scope.updateEltInDossier = function (item, title = "", content = "", optionals = { for_delete: false, route: 'updatedevisedossier', addElement: false, fnCallBack: null, fnParams: null }) {

        swalWithBootstrapButtons.fire({
            title: title,
            text: content,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui Appliquer',
            cancelButtonText: 'Non Annuler',
            reverseButtons: true,
            stopKeydownPropagation: false,
            preConfirm: () => {

                return new Promise((resolve, reject) => {
                    if (!!optionals.fnCallBack && !!optionals.fnParams && !!$scope[optionals.fnCallBack] && Array.isArray(optionals.fnParams)) {
                        $scope[optionals.fnCallBack](...optionals.fnParams);
                    }

                    if (optionals.addElement !== true) {
                        var formData = new FormData();
                        formData.append('id', item.id);
                        Init.saveElementAjax('dossier', formData, optionals).then(function (data) {
                            resolve(data);

                            $scope.refreshUpdateItem('dossier', item);
                        })
                            .catch(error => {
                                iziToast.error({
                                    title: 'Erreur',
                                    message: 'Une erreur est survenue',
                                    position: 'topRight'
                                });
                                reject(error);
                            });
                    }
                    else {
                        $scope.addElement(null, 'dossier', { keepModal: true });

                        $scope.setValueInInput('change_taxe_liquidation', 'dossier', '');

                        resolve(true);
                    }

                });
            }
        }).then((result) => {
            if (result.isConfirmed) { }
            else if (result.dismiss === Swal.DismissReason.cancel) { }
        });
    }

    $scope.updateQteFromPoids = function () {
        if (!!$scope.label_qte_complementaire_notedetails_dossier) {
            if ($scope.label_qte_complementaire_notedetails_dossier.indexOf('kg') !== -1) {
                $("#quantite_notedetails_dossier").val($scope.poids_net_notedetails_dossier).trigger("change", ["ignore"]);
            }
        }
    }

    $scope.getTotalElements = function (type, keyCompare) {
        let count = 0;
        $scope.dataPage[type].forEach((item) => {
            if (item[keyCompare] !== null && item[keyCompare] === true) {
                count += 1;
            }
            else {
                return 0;
            }
        });

        return count;
    }


    //Add semi element in database
    $scope.getSemiElementForm = function (e, type, optionals) {
        if (e != null) {
            e.preventDefault();
        }

        $scope.returnErrors = {};
        var returnValue;

        if (optionals.semiForm === true && optionals.toType !== null) {
            var form = $('#form_add' + (optionals.is_file_excel ? 'liste' : type)).find("#" + optionals.toType).find(':input:not(.ignore-elt)');

            var fileInputs = form.filter(function () {
                let rtr = this.type === 'file', name = "";

                if (rtr === true) {
                    name = $(this).attr('name') + '_erase';
                }

                if ($("#clear_" + $(this).attr('id')).length > 0) {
                    $("#clear_" + $(this).attr('id')).attr('name', name);
                }

                return rtr;

            });

            if (form.length > 0) {
                var can_continue = true;
                form.each(function () {
                    if (optionals.ignoreRequired !== true) {
                        if ($(this).hasClass('required') && ($(this).val() === null || $(this).val() === undefined || $(this).val() === "" || $(this).val().trim().length === 0)) {
                            $scope.returnErrors[$(this).attr("id")] = "Veuillez renseigner ce champ";
                            can_continue = false;
                            return false;
                        }
                    }
                });

                if (!can_continue) {
                    if (Object.keys($scope.returnErrors).length !== 0) {
                        setTimeout(() => {
                            $scope.returnErrors = {};
                            $scope.applyScope();
                        }, 2000)
                    }
                    returnValue = false;
                }
                else {
                    var send_dataObj = form.serializeObject();

                    send_dataObj['id'] = $scope.getValueInSelect2('id', type);
                    send_dataObj['semi_form'] = true;

                    if (!!optionals.tagTabPane) {
                        tagType = '_' + type
                        let keyTab = optionals.tagTabPane.substring(0, optionals.tagTabPane.length - (tagType.length));
                        send_dataObj['is_' + keyTab] = true;
                    }

                    var formdata = new FormData();

                    for (let key in send_dataObj) {
                        formdata.append(key, send_dataObj[key]);
                    }

                    if (fileInputs.length > 0) {
                        fileInputs.each(function () {
                            var files = this.files;
                            for (var i = 0; i < files.length; i++) {
                                var file = files[i];
                                formdata.append(this.name, file);
                            }
                        });
                    }

                    returnValue = formdata;
                }
            }
        }

        return returnValue;

    }

    // Add element in database and in scope
    $scope.addElement = function (e, type, optionals = { from: 'modal', is_file_excel: false, keepModal: false, semiForm: null, toType: null, ignoreRequired: false, tagTabPane: null }) {
        // alert('ici');
        if (e != null) {
            e.preventDefault();
        }

        let keepModal = optionals && optionals.keepModal === true;

        var form = $('#form_add' + (optionals.is_file_excel ? 'liste' : type));
        var formdata = (window.FormData) ? (new FormData(form[0])) : null;
        var send_data = (formdata !== null) ? formdata : form.serialize();

        // A ne pas supprimer
        let send_dataObj = form.serializeObject();
        let can_save = true;

        //Ajouter pour gerer  le submit d'une partie du formulaire
        if (optionals.semiForm === true && optionals.toType !== null) {
            let res = $scope.getSemiElementForm(e, type, optionals);

            if (res === false) {
                can_save = false;
            }
            else {
                send_data = res;
            }
        }

        continuer = true;

        if (!optionals.is_file_excel) {

            $.each($scope.dataInTabPane, function (keyItem, valueItem) {
                tagType = '_' + type;
                // console.log("planning :",$scope.interval_dates[0].dayProgrammes);
                //    if (type === "planification" && $scope.interval_dates[0].dayProgrammes.length != 0) {
                //         console.log("planning : $scope.interval_dates => ", $scope.interval_dates)
                //         send_data.set("planifications", JSON.stringify($scope.interval_dates));
                //         send_data.set("isplanning", "planning");
                //     }
                if (!!optionals.tagTabPane) {
                    if (keyItem.indexOf(optionals.tagTabPane) !== -1) {
                        let keyTab = keyItem.substring(0, keyItem.length - (tagType.length));
                        send_data.append(keyTab, JSON.stringify($scope.dataInTabPane[keyItem]['data']));
                    }
                }
                else if (optionals.semiForm !== true) {
                    if (keyItem.indexOf(tagType) !== -1) {
                        send_data.append(keyItem.substring(0, keyItem.length - (tagType.length)), JSON.stringify($scope.dataInTabPane[keyItem]['data']));
                        console.log('********************', keyItem.substring(0, keyItem.length - (tagType.length)), JSON.stringify($scope.dataInTabPane[keyItem]['data']));
                    }
                }
            });
        }

        console.log("ici dans mon type =>", send_dataObj);

        optionals.blockUI_on_modal = false;

        if (can_save) {
            form.parent().parent().blockUI_start();

            Init.saveElementAjax(type, send_data, optionals).then(function (data) {
                console.log('Valeur de data = ', type, data, $scope.linknav);
                if (!keepModal) {
                    form.parent().parent().blockUI_stop();
                }

                if (data.data != null && !data.data.errors && !data.errors) {
                    if (!keepModal) {
                        $scope.emptyForm(type);
                    }

                    if (type.indexOf('role') !== -1) {
                        $scope.getElements('roles');
                    }
                    else {
                        getObj = data['data'][type + 's'] ? data['data'][type + 's'][0] : null;
                        $scope.clientSelected = null;
                        $scope.tierSelected = null;

                        if (type === "chapitrenomenclaturedouaniere") {
                            $scope.getElements('maxdepths');
                        }

                        if (type === "pays") {
                            optionals = { 'ignore_char': true };
                        }

                        if (!keepModal) {
                            $scope.pageChanged(type, optionals);
                        }


                    }
                    if (!keepModal) {
                        if (!send_dataObj.id && !optionals.is_file_excel && ($('.modal.show').length == 1)) {
                            swalWithBootstrapButtons.fire({
                                title: (!send_dataObj.id ? 'AJOUT' : 'MODIFICATION'),
                                text: "Êtes-vous sûr à présent de vouloir quitter le modal ?",
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Oui',
                                cancelButtonText: 'Non',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#modal_add" + (optionals.is_file_excel ? "liste" : type)).modal('hide');
                                }
                                else if (result.dismiss === Swal.DismissReason.cancel) { }
                            });
                        }
                        else {
                            $scope.showToast((!data.message ? (!send_dataObj.id ? 'AJOUT' : 'MODIFICATION') : ""), (!data.message ? "" : data.message), "success");
                            $("#modal_add" + (optionals.is_file_excel ? "liste" : type)).modal('hide');
                        }
                        if (type !== "fonctionnalitemodule") {
                            $scope.reloadFromSomePage();
                        }

                    }
                    else {
                        if (getObj) {
                            $scope.refreshUpdateItem(type, getObj);
                        }

                        if (type === "dossier") {
                            $scope.pageChanged(type, optionals);
                        }


                    }
                }
                else {
                    $errors = data.errors ?? data.data.errors
                    let errs = null;
                    if (typeof $errors == "object") {
                        errs = Object.keys(data.errors);
                        errs.forEach((elmt) => {
                            $scope.showToast('', ('<span class="h4 text-dark">' + (data.errors)[elmt] + '</span>'), 'error');
                        });
                    }
                    else {
                        $scope.showToast('', ('<span class="h4">' + $errors + '</span>'), 'error');
                    }
                }
            }, function (msg) {
                if (typeof data === 'undefined') {
                    form.parent().parent().blockUI_stop();
                    $scope.showToast((!send_data.id ? 'AJOUT' : 'MODIFICATION'), ('<span class="h4">Erreur depuis le serveur, veuillez contactez l\'administrateur</span>'), 'error')
                }
            });
        }

    };

    $scope.deleteProgrammeElement = function (type, item, dayId, index) {
        let indexDay = $scope.interval_dates.findIndex(function (itemintt) {
            return itemintt.id === dayId
        })

        if (item.id === "") {
            if (indexDay !== -1) {
                $scope.interval_dates[indexDay].dayProgrammes.splice(index, 1)
            }
        } else {
            $scope.deleteElement('programme', item.id, dayId)
        }
    }

    $scope.refreshUpdateItem = function (type, getObj) {
        $scope.getElements(type + 's', { queries: ["id:" + getObj.id], isPromise: true, setStateCursorToLoading: true }).then(
            function (data) {
                if (data && data.length === 1) {
                    item = data[0];
                    $scope.updateItem = item;
                    $scope.checkInForm(type, item);
                }
            });
    }


    // Rm element in database
    $scope.deleteElement = function (type, itemId, action = null, optionals = {}) {
        var msg = 'Voulez-vous vraiment effectuer cette suppression ?';
        var title = '';

        if (!(!!itemId) || (Array.isArray(itemId) && itemId.length == 0)) {
            $scope.showToast(title, 'Merci de cocher les lignes concernées', 'warning');
            return;
        }

        swalWithBootstrapButtons.fire({
            title: title,
            text: msg,
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Init.saveElementAjax(type, { id: itemId }, { for_delete: true }).then(function (data) {
                    console.log('deleted ====>', data, type);
                    if (data.data != null && !data.errors) {
                        if (action) {
                            if (type == 'markview_notif' || type == 'markallview_notif') {
                                $scope.getElements("notifpermusers");
                            }
                        }
                        else {
                            $scope.pageChanged(type);
                        }

                        $scope.showToast(title, 'Succès', 'success');

                        $scope.reloadFromSomePage();
                    }
                    else {
                        $scope.showToast(title, data.errors, 'error');
                    }
                }, function (msg) {
                    $scope.showToast(title, msg, 'error');
                });
            }
            else if (result.dismiss === Swal.DismissReason.cancel) { }
        });
    };

    $scope.getRandomValue = function (length) {
        var result = '';
        var characters = '0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
        // $(".genererPassword").val(result);
    };


    //---DEBUT => Fonction qui donne la date d'aujourd'hui---//
    $scope.donneDateToday = function () {
        var date = new Date().toJSON().slice(0, 16).replace(/-/g, '-');
        return date;
    };

    $scope.getDateOfTheDay = function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '/' + mm + '/' + yyyy;

        return today;
    }
    //---FIN => Fonction qui donne la date d'aujourd'hui---//


    //---DEBUT => Fonction qui récupère que la date en anglais sans heure, minute, seconde---//
    $scope.donneDateSansHeure = function (dateAvecHeure) {
        if (dateAvecHeure) {
            dateAvecHeure = dateAvecHeure.substring(0, 10);
        }
        return dateAvecHeure;
    };

    $scope.donneHeureSeulement = function (dateAvecHeure) {
        if (dateAvecHeure) {
            dateAvecHeure = dateAvecHeure.substring(11, 19);
        }
        return dateAvecHeure;
    };
    //---FIN => Fonction qui récupère que la date en anglais sans heure, minute, seconde---//

    //---DEBUT => Tester si la valeur est un entier ou pas---//
    $scope.estEntier = function (val, superieur = true, peutEtreEgaleAzero = false) {
        //tags: isInt, tester entier
        var retour = false;
        if (val == undefined || val == null) {
            retour = false;
        } else if (val === '') {
            retour = false;
        } else if (isNaN(val) == true) {
            retour = false;
        } else if (parseInt(val) != parseFloat(val)) {
            retour = false;
        } else {
            if (superieur == false) {
                //entier inférieur
                if (parseInt(val) <= 0 && peutEtreEgaleAzero == true) {
                    //]-inf; 0]
                    retour = true;
                } else if (parseInt(val) < 0 && peutEtreEgaleAzero == false) {
                    //]-inf; 0[
                    retour = true;
                } else {
                    retour = false;
                }
            } else {
                //entier supérieur
                if (parseInt(val) >= 0 && peutEtreEgaleAzero == true) {
                    //[0; +inf[
                    retour = true;
                } else if (parseInt(val) > 0 && peutEtreEgaleAzero == false) {
                    //]0; +inf[
                    retour = true;
                } else {
                    retour = false;
                }
            }
        }
        return retour;
    };
    //---FIN => Tester si la valeur est un entier ou pas---//


    //---DEBUT => Tester si la valeur est un réel ou pas---//
    $scope.estFloat = function (val, superieur = true, peutEtreEgaleAzero = false) {
        //tags: isFloat, tester réel
        var retour = false;
        if (val == undefined || val == null) {
            retour = false;
        } else if (val === '') {
            retour = false;
        } else if (isNaN(val) == true) {
            retour = false;
        } else {
            if (superieur == false) {
                //entier inférieur
                if (parseFloat(val) <= 0 && peutEtreEgaleAzero == true) {
                    //]-inf; 0]
                    retour = true;
                } else if (parseFloat(val) < 0 && peutEtreEgaleAzero == false) {
                    //]-inf; 0[
                    retour = true;
                } else {
                    retour = false;
                }
            } else {
                //entier supérieur
                if (parseFloat(val) >= 0 && peutEtreEgaleAzero == true) {
                    //[0; +inf[
                    retour = true;
                } else if (parseFloat(val) > 0 && peutEtreEgaleAzero == false) {
                    //]0; +inf[
                    retour = true;
                } else {
                    retour = false;
                }
            }
        }
        return retour;
    };
    $scope.date_en_anglais = function (datebi, avecHeure = false, enEntier = false) {
        //#tags: convertir, date, anglais;
        var heure = '';
        var jour = datebi.substring(0, 2);
        var mois = datebi.substring(3, 5);
        var an = datebi.substring(6, 10);
        if (avecHeure) {
            heure = ' ' + datebi.substring(11, 19);
        }
        if (enEntier) {
            var madate = an + '' + mois + '' + jour
        } else {
            var madate = an + '/' + mois + '/' + jour + '' + heure;
        }
        return madate;
    };
    //--FIN => Formater date en anglais--//


    //--DEBUT => Enlever toutes les espaces--//
    $scope.enleverLesEspaces = function (val) {
        //#tags: enlever,espace,retirer,supprimer
        return (
            val.toString().replace(/ /g, '')
        ) //
    };

    $scope.IdView = 0;
    //--FIN => Enlever toutes les espaces--//


    // Update produit in table
    $scope.updateProduitInTable = function (type, value) {

        console.log('Update', type);
        if (type == 'colis') {
            $scope.produitsInTable[value].colisage_arrivee = $("#colis" + value).val();
        } else {
            $scope.produitsInTable[value].unite_arrivee = $("#unite" + value).val();
        }
    };

    $scope.isEmpty = function (el) {
        return !$.trim(el)
    };

    $scope.dataInTabPane = {
        permissions_role: { data: [], rules: [] },
        contacts_client: { data: [], rules: [] },
        contacts_livreur: { data: [], rules: [] },
        marchandises_client: { data: [], rules: [] },
        validationdossier_client: { data: [], rules: [] },
        typedossiers_client: { data: [], rules: [] },
        users_client: { data: [], rules: [] },
        contacts_fournisseur: { data: [], rules: [] },
        details_fournisseur: { data: [], rules: [] },
        details_taxedouaniere: { data: [], rules: [] },
        details_familletaxedouaniere: { data: [], rules: [] },
        details_nomenclaturedouaniere: { data: [], rules: [] },
        detailsins_regime: { data: [], rules: [] },
        details_debour: { data: [], rules: [] },
        details_typedossier: { data: [], rules: [] },
        details_planification: { data: [], rules: [] },
        details_pointage: { data: [], rules: [] },
        planification: { data: [], rules: [] },
        detailsouts_regime: { data: [], rules: [] },
        detailsins_typeclient: { data: [], rules: [] },
        detailsouts_typeclient: { data: [], rules: [] },
        details_profilfacturation: { data: [], rules: [] },
        emplacements_entrepot: { data: [], rules: [] },
        conteneurs_ordretransit: { data: [], rules: [] },
        marchandises_ordretransit: { data: [], rules: [] },
        documents_ordretransit: { data: [], rules: [] },
        bls_ordretransit: { data: [], rules: [] },
        ffs_ordretransit: { data: [], rules: [] },
        ffts_ordretransit: { data: [], rules: [] },
        asres_ordretransit: { data: [], rules: [] },
        dpis_ordretransit: { data: [], rules: [] },
        bscs_ordretransit: { data: [], rules: [] },
        debours_dossier: { data: [], rules: [] },
        manifestes_dossier: { data: [], rules: [] },
        notedetails_dossier: { data: [], rules: [] },
        remboursements_remboursement: { data: [], rules: [] },
        details_rapportassistance: { data: [], rules: [] },
        fonctionnalitemodules_fonctionnalite: { data: [], rules: [] },

    };
    $scope.formatObjToAdd = function (item, from, optionals = null) {
        tagObj = optionals ? optionals.tagObj : null;

        obj = {
            "id": item.id,
        };

        if (!!tagObj) {
            obj[`${tagObj}`] = item;
            obj[`${tagObj}_id`] = item.id;
        }
        else {
            obj = item;
        }

        // obj[`${tagObj}`] = {nom: item.nom};

        if (from.indexOf('ordreachat') !== -1 || from.indexOf('commande') !== -1 || from.indexOf('reception') !== -1 || from.indexOf('stock') !== -1 || from.indexOf('assemblage') !== -1 || from.indexOf('production') !== -1) {
            obj.qte_unitaire = 0;
            obj.impact_po = false;
            obj.prix = null;
            if (from.indexOf('commande') !== -1 || from.indexOf('reception') !== -1) {
                obj.prix = 0;
                if (from === "commande") {
                    obj.qte_unitaire = 1;
                    obj.pourcentage_remise = 0;
                    obj.valeur_remise = 0;
                }
            }
            else if ((from.indexOf('production') !== -1 || from.indexOf('assemblage') !== -1) && optionals.parentKey == null) {
                obj.details = [];
            }
            /*else if (from.indexOf('assemblage') !== -1 && parentKey==null)
            {
                obj.details = [];
            }*/
            obj.description = null;
            if (item.currentPrixAchat) {
                obj.prix = item.currentPrixAchat;
            }
            if (item.current_prix_vente) {
                obj.prix = item.current_prix_vente;
            }
        }
        return obj;
    };

    $scope.actionInTabData = function (event, from = 'carte', item, optionals = { action: 1, parentKey: null, tagObj: "produit", deleteAll: false }) {

        tagObj = optionals.tagObj;
        if ($scope[from + 'view'] && !$scope[from + 'view'].can_updated) {
            iziToast.info({
                message: "Cette " + from + " n'est plus modifiable",
                position: 'topRight'
            });
            return;
        }
        else {
            var add = true;

            var tagForm = from.indexOf('_') !== -1 ? from : "details_" + from;
            // alert(''.tagForm);
            if (optionals.parentKey == null) {
                if (from.indexOf('rapportassistance') !== -1) {
                    var projetId = item.projet_id;
                    // alert('yango');
                    // Si le tableau contient au moins un élément
                    if ($scope.dataInTabPane[tagForm]['data'].length > 0) {
                        var projetExistant = $scope.dataInTabPane[tagForm]['data'][0].projet_id;

                        if (projetId != projetExistant) {
                            $scope.showToast("Panier", "Impossible d'ajouter une assistance d'un autre projet", 'error');
                            return;
                        }
                    }
                }


                if (Array.isArray(item)) // Si c'est un tableau
                {
                    //touche Ici
                    $('body').css('cursor', 'wait');
                    add = false;
                    $.each(item, function (keyItem, valueItem) {
                        // alert(valueItem);
                        getItem = $scope.dataInTabPane[tagForm]['data'].filter(value => Number(value[(!!tagObj ? `${tagObj}_id` : 'id')]) === Number(valueItem.id));
                        if (getItem.length == 0) {
                            obj = $scope.formatObjToAdd(valueItem, from, optionals);
                            $scope.dataInTabPane[tagForm]['data'].push(obj);
                        }


                    });
                    console.log('module ' + from, $scope.dataInTabPane[tagForm]);
                    $('body').css('cursor', 'inherit');
                }
                else {
                    add = true;
                    console.log('module ' + from, $scope.dataInTabPane[tagForm]);
                    $.each($scope.dataInTabPane[tagForm]['data'], function (key, value) {
                        if (Number(value[(!!tagObj ? `${tagObj}_id` : 'id')]) === Number(item.id)) {
                            console.log('value', value);
                            if (optionals.action == 0) {
                                $scope.dataInTabPane[tagForm]['data'].splice(key, 1);
                            }
                            else {
                                if ($scope.dataInTabPane[tagForm]['data'][key].quantite !== undefined) {
                                    $scope.dataInTabPane[tagForm]['data'][key].quantite += optionals.action;
                                    if ($scope.dataInTabPane[tagForm]['data'][key].quantite === 0) {
                                        $scope.dataInTabPane[tagForm]['data'].splice(key, 1);
                                    }
                                }
                            }
                            add = false;
                        }
                        return add;
                    });
                }
            }
            else {
                console.log("current=>", $scope.dataInTabPane[tagForm]['data'][optionals.parentKey], '+1=>', $scope.dataInTabPane[tagForm]['data'][optionals.parentKey + 1])
                $.each($scope.dataInTabPane[tagForm]['data'][optionals.parentKey]['details'], function (key, value) {
                    if (Number(value[(!!tagObj ? `${tagObj}_id` : 'id')]) === Number(item.medicament_id)) {
                        console.log('value subdetail', value);
                        if (optionals.action == 0) {
                            $scope.dataInTabPane[tagForm]['data'][optionals.parentKey]['details'].splice(key, 1);
                        }
                        else {
                            if ($scope.dataInTabPane[tagForm]['data'][optionals.parentKey]['details'][key].quantite !== undefined) {
                                $scope.dataInTabPane[tagForm]['data'][optionals.parentKey]['details'][key].quantite += optionals.action;
                                if ($scope.dataInTabPane[tagForm]['data'][optionals.parentKey]['details'][key].quantite === 0) {
                                    $scope.dataInTabPane[tagForm]['data'][optionals.parentKey]['details'].splice(key, 1);
                                }
                            }
                        }
                        add = false;
                    }
                    return add;
                });
            }

            if (add) {
                obj = $scope.formatObjToAdd(item, from, optionals);

                if (optionals.parentKey == null) {
                    console.log('from', from, optionals.parentKey, 'obj =>', obj);
                    if ((from === "vente" || from === "evenement") && obj.prix == 0) {
                        $scope.showToast("Composition", "La donnée n'a pas de prix", 'error');
                    }
                    else {
                        // console.log( 'Warren ====>', $scope.dataInTabPane[tagForm]['data'].push(obj));
                        $scope.dataInTabPane[tagForm]['data'].unshift(obj);
                    }
                }
                else {
                    console.log('arrrai', $scope.dataInTabPane[tagForm]['data'][optionals.parentKey]);
                    $scope.dataInTabPane[tagForm]['data'][optionals.parentKey]['details'].unshift(obj);
                }
            }
        }

    };

    $scope.actionSurTabPaneTagData = function (action, parentTag, parentCurrentIndex = 0, childTag = null, childCurrentIndex, selectMultiple = false, optionals = { obj: null, deleteAll: false, fromUpdate: false }) {
        var tagForm;
        var nameobjet_id = null
        var value_to_filter = null
        if (action == 'add') {

            var currentPositionParent, currentPositionChild;

            if (!$scope.dataInTabPane[parentTag]) {
                $scope.dataInTabPane[parentTag] = { data: [] };
            }

            if (childTag) {

                currentPositionParent = parentCurrentIndex;

                if (!$scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag]) {
                    $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag] = [];
                }
                indexChildForm = $('#index_' + currentPositionParent + '_' + childTag).val();

                if (!indexChildForm || !$scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag][indexChildForm]) {
                    currentPositionChild = $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag].length;
                    if (childTag !== 'images') {
                        $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag].push({});
                    }
                }
                else {
                    currentPositionChild = indexChildForm;
                }
                tagForm = currentPositionParent + "_" + childTag;
            }
            else {



                currentPositionParent = $scope.dataInTabPane[parentTag]['data'].length;
                if (!(optionals && optionals.obj)) {
                    $scope.dataInTabPane[parentTag]['data'].push({});
                }
                tagForm = parentTag;
            }


            if (!(optionals && optionals.obj)) {
                console.log('tagForm=>', tagForm);
                var findError = false;
                var ignoreInEmptyForm = [], uniqueElement = [];

                $("input[id$=" + "_" + tagForm + "], textarea[id$=" + "_" + tagForm + "], select[id$=" + "_" + tagForm + "]").each(function () {
                    nameobjet_id = null;
                    value_to_filter = null;

                    if ($(this).attr('ignoreInTabPane') !== 'true') {
                        getValue = $(this).val();

                        console.log("IN MULTI ", $(this).attr('id'), ' = ', $(this).val());
                        var indexNameInTab = $(this).attr('id').substring(0, ($(this).attr('id').length - tagForm.length - 1));
                        console.log("------------>  IN MULTI LAST CONDITION2", indexNameInTab);

                        console.log($(this).attr('id'), ' => indexNameInTab =>', indexNameInTab, "value =>", $(this).val(), "parent html=>");
                        if ($(this).hasClass('required') && !$(this).val()) {
                            findError = true;
                            if (childTag) {
                                $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag].splice((currentPositionChild), 1);
                            }
                            else {
                                $scope.dataInTabPane[parentTag]['data'].splice((currentPositionParent), 1);
                            }
                            console.log($(this).attr('id'), ' required => indexNameInTab =>', indexNameInTab, "value =>", $(this).val(), "parent html=>");

                            return !findError;
                        }

                        if ($(this).is("select")) {
                            let keySelect = "nom";

                            if (!!$(this).attr('key-select')) {
                                keySelect = $(this).attr('key-select')
                            }

                            if (childTag) {
                                if (!$(this).prop('multiple')) {

                                    $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag][currentPositionChild]['display_text'] = $(this).children("option:selected").text();
                                    $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag][currentPositionChild][indexNameInTab] = { [keySelect]: $(this).children("option:selected").text() };
                                    indexNameInTab = indexNameInTab + '_id';

                                    console.log("------------> IN CHILD TAG CONDITION NOT ", $scope.dataInTabPane[parentTag]['data']);
                                }
                                else {
                                    // $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag][currentPositionChild][indexNameInTab] = [];
                                    // $.each(getValue, function(keyItem, valueItem)
                                    // {
                                    //     getCurrentItem = $scope.dataPage[indexNameInTab].filter(item => Number(item.id) == Number(valueItem));
                                    //     console.log("select multiple", $scope.dataPage[indexNameInTab], getCurrentItem);

                                    //     if (getCurrentItem.length==1)
                                    //     {
                                    //         $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag][currentPositionChild][indexNameInTab].push(getCurrentItem[0]);
                                    //     }
                                    // });
                                    // indexNameInTab = indexNameInTab + '_id';
                                    // modification pour adaption au planning
                                    indexNameInTabOneObj = indexNameInTab.substr(0, indexNameInTab.length - 1);
                                    console.log(indexNameInTab, "==============>>>>>>>>")
                                    getValue = [];
                                    getValues = $(this).val();

                                    $.each(getValues, function (keyItem, valueItem) {
                                        getCurrentItem = $scope.dataPage[indexNameInTab].filter(item => Number(item.id) == Number(valueItem));
                                        if (getCurrentItem.length == 1) {
                                            var obj = {}; //
                                            obj[indexNameInTabOneObj + '_id'] = getCurrentItem[0]['id'];
                                            obj[indexNameInTabOneObj] = getCurrentItem[0];
                                            getValue.push(obj);
                                            value_to_filter = getCurrentItem[0]['id']
                                        }
                                    });

                                    console.log("------------> IN CHILD TAG CONDITION");

                                }
                            }
                            else {
                                if (!$(this).prop('multiple')) {
                                    $scope.dataInTabPane[parentTag]['data'][currentPositionParent]['display_text'] = $(this).children("option:selected").text();
                                    $scope.dataInTabPane[parentTag]['data'][currentPositionParent][indexNameInTab] = { [keySelect]: $(this).children("option:selected").text() };
                                    indexNameInTab = indexNameInTab + '_id';
                                    value_to_filter = $(this).children("option:selected").val()

                                    if ($(this).attr('id').indexOf('all_') !== -1) {
                                        ignoreInEmptyForm.push($(this).attr("id"))
                                    }

                                    console.log("------------> IN MULTI SELECT CONDITION1", getValue);
                                }
                                else {

                                    //Condition supplementaire ajoutee pour s'adapter au systeme de declinaisons du back
                                    if (indexNameInTab == "declinaisons") {
                                        $scope.dataInTabPane[parentTag]['data'][currentPositionParent][indexNameInTab] = [];
                                        getValues = $(this).val();
                                        $.each(getValues, function (keyItem, valueItem) {

                                            getCurrentItem = $scope.dataPage["tailles"].filter(item => Number(item.id) == Number(valueItem));

                                            if (getCurrentItem.length == 1) {
                                                console.log("DEBBUUUUUUUUUUUUG", getCurrentItem[0]);
                                                getCurrentItem[0].taille_id = getCurrentItem[0].id;
                                                console.log("DEBBUUUUUUUUUUUUG22222222", getCurrentItem[0]);
                                                $scope.dataInTabPane[parentTag]['data'][currentPositionParent][indexNameInTab].push(getCurrentItem[0]);
                                            }
                                        });

                                        indexNameInTab = indexNameInTab + '_id';

                                        console.log("------------> IN DECLINAISON CONDITION",);

                                    }
                                    else {
                                        // $.each(getValues, function (keyItem, valueItem) {
                                        //     getCurrentItem = $scope.dataPage[indexNameInTab].filter(item => Number(item.id) == Number(valueItem));
                                        //     if (getCurrentItem.length == 1) {
                                        //         $scope.dataInTabPane[parentTag]['data'][currentPositionParent][indexNameInTab].push(getCurrentItem[0]);
                                        //     }
                                        // });
                                        indexNameInTabOneObj = indexNameInTab.substr(0, indexNameInTab.length - 1);

                                        getValue = [];
                                        getValues = $(this).val();

                                        $.each(getValues, function (keyItem, valueItem) {

                                            if (!!$scope.dataPage[indexNameInTab]) {
                                                getCurrentItem = $scope.dataPage[indexNameInTab].filter(item => Number(item.id) == Number(valueItem));
                                                console.log("------------>  IN MULTI LAST CONDITION2", indexNameInTabOneObj);

                                                console.log("------------> IN MULTI SELECT ", getCurrentItem);

                                                if (getCurrentItem.length == 1) {
                                                    var obj = {}; //
                                                    obj[indexNameInTabOneObj + '_id'] = getCurrentItem[0]['id'];
                                                    obj[indexNameInTabOneObj] = getCurrentItem[0];
                                                    getValue.push(obj);
                                                    console.log("------------> IN MULTI SELECT VALUE", getValue);
                                                }
                                            }
                                        });
                                    }
                                }
                            }

                            if ($(this).hasClass('unique')) {
                                uniqueElement.push({ 'nameobjet_id': indexNameInTab, 'value': value_to_filter, 'message': $(this).attr('unique-message') });
                            }
                        }
                        else if ($(this).is(":checkbox")) {
                            getValue = $(this).prop('checked');
                            console.log('checkbox************', $(this).attr('checked'), $(this).prop('checked'));

                            //$(this).bootstrapTable('destroy').bootstrapTable();
                        }

                        if (childTag) {

                            $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag][currentPositionChild][indexNameInTab] = getValue;
                        }
                        else {
                            console.log('MULTI IN LAST CONDITION2 ', currentPositionParent, indexNameInTab, getValue);
                            $scope.dataInTabPane[parentTag]['data'][currentPositionParent][indexNameInTab] = getValue;
                        }

                    }
                    else {
                        ignoreInEmptyForm.push($(this).attr("id"))
                    }

                    if ($(this).attr('not-empty-form') === "true") {
                        ignoreInEmptyForm.push($(this).attr("id"))
                    }
                });

                if (!findError) {
                    $scope.emptyForm(tagForm, false, { tagToIgnore: ignoreInEmptyForm });
                }
                else {
                    $scope.showToast('', 'Veuillez remplir tous les champs obligatoires', 'error');
                }

                if (uniqueElement.length > 0) // Si une valeur doit être unique dans le tableau
                {

                    $.each(uniqueElement, function (key, value) {
                        var existInTab = $scope.dataInTabPane[parentTag]['data'].filter(item => (item[value['nameobjet_id']] === value['value']));
                        let message = value['message'] ?? "Ce " + value['nameobjet_id'].slice(0, -3) + " existe dans le tableau";

                        if (existInTab.length > 1) {
                            var index = $scope.dataInTabPane[parentTag]['data'].indexOf(existInTab[1]);
                            $scope.dataInTabPane[parentTag]['data'].splice(index, 1);
                            $scope.showToast("Ajout", message, "error");

                            return false;
                        }
                    });

                }


            }
            else {

                if (childTag) {
                    $tab = $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag];
                }
                else {
                    $tab = $scope.dataInTabPane[parentTag]['data'];
                }
                checkifExist = $tab.filter(item => (item.id == optionals.obj.id));

                //  $tab = [];

                if (checkifExist.length == 0) {
                    console.log("zakkk 1 ======>", $tab, optionals.obj, parentTag, $scope.dataInTabPane[parentTag]['data']);

                    $tab.push(optionals.obj);
                    console.log("zakkk 2 ======>", $tab);

                }
                else {
                    $scope.showToast("Ajout", "L'element est déjà présent", "error");
                    return;
                }
                console.log("jacques ======>", checkifExist.length, parentTag, $scope.dataInTabPane[parentTag]['data']);
            }
            $scope.reInit('[id$=' + tagForm + ']');

            if (tagForm.indexOf("remboursements_remboursement") !== -1) {
                $scope.calculerTotalReste();
            }

        }
        else if (action == 'delete') {
            if (childTag) {
                tagForm = currentPositionParent + "_" + childTag;
                if (!optionals.deleteAll) {
                    currentPositionParent = parentCurrentIndex;
                    $scope.dataInTabPane[parentTag]['data'][parentCurrentIndex][childTag].splice(childCurrentIndex, 1);
                    //tagForm = currentPositionParent + "_" + childTag;
                }
                else {
                    $scope.dataInTabPane[parentTag]['data'][parentCurrentIndex][childTag] = [];
                }
            }
            else {
                tagForm = parentTag;
                if (!optionals.deleteAll) {
                    $scope.dataInTabPane[parentTag]['data'].splice(parentCurrentIndex, 1);
                    //tagForm = parentTag;
                }
                else {
                    $scope.dataInTabPane[parentTag]['data'] = [];
                }
            }

            if (tagForm.indexOf("remboursements_remboursement") !== -1) {
                $scope.calculerTotalReste();
            }
        }
        /* if (tagForm.indexOf('typedossiers_client')!==-1 || tagForm.indexOf('users_client')!==-1 || tagForm.indexOf('documents_ordretransit')!==-1 || tagForm.indexOf('asres_ordretransit')!==-1 || tagForm.indexOf('dpis_ordretransit')!==-1 || tagForm.indexOf('bscs_ordretransit')!==-1 || tagForm.indexOf('bls_ordretransit')!==-1 || tagForm.indexOf('ffts_ordretransit')!==-1 ||  tagForm.indexOf('ffs_ordretransit')!==-1 || tagForm.indexOf('manifestes_dossier')!==-1 || tagForm.indexOf('marchandises_ordretransit') !== -1 || tagForm.indexOf('conteneurs_ordretransit') !== -1)
        {
            //$scope.checkIfDocsCorrect(tagForm,true) ;
            $scope.traitementSpecifique(tagForm, optionals);s
        } */
        // $scope.traitementSpecifique(tagForm, optionals, getValues, action);
    };



    let timeout;

    $scope.calculerTotalResteDebounced = function (index) {
        console.log('2025', index);
        clearTimeout(timeout);
        timeout = setTimeout($scope.calculerTotalReste(index), 200);
    };
    // Définition de la fonction de calcul  
    $scope.calculerTotalReste = function (index = null) {
        //  console.log("Warren remboursements:", $scope.updateItem, $scope.dataInTabPane['remboursements_remboursement']['data'].length); 
        if ($scope.dataInTabPane['remboursements_remboursement']['data'].length > 0) {
            if (index !== null) {
                let currentMontant = $scope.dataInTabPane['remboursements_remboursement']['data'][index].montant;
                $scope.dataInTabPane['remboursements_remboursement']['data'][index].montant = parseFloat(currentMontant) || 0;
            }
            let totalRetirer = $scope.total_a_payer;

            angular.forEach($scope.dataInTabPane['remboursements_remboursement']['data'], function (element) {
                let montant = parseInt(element.montant) || 0;
                totalRetirer -= montant;
                console.log("Warren montant :", montant);
            });
        }
        else {
            console.log("Warren remboursements:", $scope.updateItem);
            totalRetirer = $scope.total_a_payer || $scope.updateItem.restant;
        }

        $scope.reste_a_payer = totalRetirer;

        console.log("Warren remboursements:", $scope.reste_a_payer);
    };


    $scope.traitementSpecifique = function (tagForm, optionals = null, getValues = null, action = null) {
        console.log("here am i tagForm:", tagForm, optionals);
        // Permet de rajouter automatiquement une ligne de fichier
        // pour chaque ligne document
        if (tagForm.indexOf('documents_ordretransit') !== -1 || tagForm.indexOf('asres_ordretransit') !== -1 || tagForm.indexOf('dpis_ordretransit') !== -1 || tagForm.indexOf('bscs_ordretransit') !== -1 || tagForm.indexOf('ffs_ordretransit') !== -1 || tagForm.indexOf('ffts_ordretransit') !== -1 || tagForm.indexOf('bls_ordretransit') !== -1 || tagForm.indexOf('manifestes_dossier') !== -1) {
            var nid = $('#id_' + tagForm.split('_')[1]).val();
            if (!(!!nid)) {
                nid = $scope.nid;
            }

            var uuid = 'n_' + nid + '_u_' + $('body').attr('data-user_id');

            // on vérifie bien qu'il y a au moins une ligne avant de parcourir
            // pour éviter de faire le traitement unitilement
            if ($scope.dataInTabPane[tagForm]['data'].filter(item => (!(!!item.files) || item.files.length == 0)).length > 0) {
                $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                    console.log('addFileTo => ', valueItem, tagForm.split('_')[1]);
                    var file = {
                        // 'id': keyItem,
                        // 'index': index,
                        'name': 'img' + tagForm.split('_')[1] + tagForm + uuid + '_' + keyItem,
                        'identify': 'aff' + tagForm.split('_')[1] + tagForm + uuid + '_' + keyItem,
                        'erase_id': 'erase_img' + tagForm.split('_')[1] + tagForm + uuid + '_' + keyItem,
                        'value': 'image' + tagForm.split('_')[1] + tagForm
                    };

                    var files = [];
                    files.push(file);

                    if (!(!!$scope.dataInTabPane[tagForm]['data'][keyItem].files) || $scope.dataInTabPane[tagForm]['data'][keyItem].files.length == 0) {
                        $scope.dataInTabPane[tagForm]['data'][keyItem].files = files;
                    }
                });
            }
        }
        if (tagForm.indexOf('users_client') !== -1) {
            $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                $scope.dataInTabPane[tagForm]['data'][keyItem].imageName = "img_users_" + keyItem;
                $scope.dataInTabPane[tagForm]['data'][keyItem].eraseName = "img_users_" + keyItem + "_erase";
            });

        }
        if (tagForm.indexOf('typedossiers_client') !== -1) {
            $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                let idCheck = valueItem.id ?? valueItem.type_dossier_id;
                if (!!idCheck) {
                    getCurrentItem = $scope.dataPage['typedossiers'].filter((i) => i.id === parseInt(idCheck));
                    if (getCurrentItem.length === 1) {
                        let h = getCurrentItem[0];
                        if (h.nbre_type_dossier > 0) {
                            $scope.dataInTabPane[tagForm]['data'].splice(keyItem, 1);

                            $.each(h.details, function (key, item) {
                                let obj = { type_dossier_id: item.id, type_dossier: item, display_text: item.nom };
                                $scope.dataInTabPane[tagForm]['data'].push(obj);
                            });

                            //$.each($scope.dataInTabPane[tagForm]['data']
                        }

                    }
                }
                //$scope.dataInTabPane[tagForm]['data'][keyItem].imageName = "img_users_" + keyItem;
            });

            $scope.dataInTabPane[tagForm]['data'] = removeDuplicates($scope.dataInTabPane[tagForm]['data'], 'type_dossier_id');

            let getValueTypeDossier = [];

            $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                let idCheck = valueItem.id ?? valueItem.type_dossier_id;
                if (!!idCheck) {
                    getValueTypeDossier.push(idCheck);
                }
            });

            $scope.manageValidationDirection(getValueTypeDossier);
        }
        if (tagForm.indexOf('_ordretransit') !== -1) {
            if (tagForm.indexOf("conteneurs_") !== -1) {
                $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                    valueItem.quantite = 1;
                });
            }
            if (tagForm.indexOf("marchandises_") !== -1) {
                $scope.reInit();
                $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                    if (!!$scope.dataPage['typedossiers2'] && $scope.dataPage['typedossiers2'].length === 1) {
                        valueItem.type_dossier_id = $scope.dataPage['typedossiers2'][0].id;
                    }

                    if (!!valueItem.type_dossier_id && !(!!valueItem.id) && !!$scope.dataPage['typedossiers2']) {
                        getCurrentItem = $scope.dataPage['typedossiersAll'].filter((i) => i.id === parseInt(valueItem.type_dossier_id));
                        if (getCurrentItem.length === 1) {
                            if ($scope.dataPage['typedossiers2'].length > 1) {
                                $scope.dataInTabPane[tagForm]['data'][keyItem].bgStyle = getCurrentItem[0].bgStyle;
                            }

                            if ($scope.dataPage['typedossiers2'].length >= 1) {
                                $scope.dataInTabPane[tagForm]['data'][keyItem].show_exo = getCurrentItem[0].show_exo ?? true;
                            }
                        }
                    }

                    if (!!valueItem.nomenclature_asuivre_id && !(!!valueItem.id)) {
                        getCurrentItem = $scope['nomenclatureAsuivres'].filter((i) => i.id === parseInt(valueItem.nomenclature_asuivre_id));
                        if (getCurrentItem.length === 1) {
                            $scope.dataInTabPane[tagForm]['data'][keyItem].show_indication = getCurrentItem[0].input_required ?? false;
                        }
                    }

                    if (!!valueItem.marchandise_id && $scope.dataPage['marchandises'].length > 0) {

                        getCurrentMarchandise = $scope.dataPage['marchandises'].filter((i) => i.id === parseInt(valueItem.marchandise_id));

                        if (getCurrentMarchandise.length === 1) {
                            let nom = $scope.dataInTabPane[tagForm]['data'][keyItem].nom;
                            let nomBackup = $scope.dataInTabPane[tagForm]['data'][keyItem].nom_backup;
                            String(nomBackup).length > 0 ? nomBackup = " -- " + nomBackup : "";
                            let nomM = getCurrentMarchandise[0].nom;
                            if (!(!!$scope.dataInTabPane[tagForm]['data'][keyItem].id)) {
                                $scope.dataInTabPane[tagForm]['data'][keyItem].nom = nomM + nomBackup;
                            }

                        }
                    }
                });
            }
            if (tagForm.indexOf("asres_") !== -1) {
                $scope.reInit();
                $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                    if (!!valueItem.type_id && !(!!valueItem.id) && !!$scope['typeasres'] && $scope['typeasres'].length >= 1) {
                        getCurrentItem = $scope['typeasres'].filter((i) => i.id === parseInt(valueItem.type_id));
                        if (getCurrentItem.length === 1) {
                            $scope.dataInTabPane[tagForm]['data'][keyItem].show_others = getCurrentItem[0].show_others ?? false;
                            $scope.dataInTabPane[tagForm]['data'][keyItem].file_required = getCurrentItem[0].file_required ?? false;
                        }
                    }
                });
            }

            if (tagForm.indexOf("dpis_") !== -1) {
                $scope.reInit();
                $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                    if (!!valueItem.type_id && !(!!valueItem.id) && !!$scope['typedpis'] && $scope['typedpis'].length >= 1) {
                        getCurrentItem = $scope['typedpis'].filter((i) => i.id === parseInt(valueItem.type_id));
                        if (getCurrentItem.length === 1) {
                            $scope.dataInTabPane[tagForm]['data'][keyItem].show_others = getCurrentItem[0].show_others ?? false;
                            $scope.dataInTabPane[tagForm]['data'][keyItem].choose_debour = getCurrentItem[0].choose_debour ?? false;
                            $scope.dataInTabPane[tagForm]['data'][keyItem].file_required = getCurrentItem[0].file_required ?? false;
                            $scope.dataInTabPane[tagForm]['data'][keyItem].todo = getCurrentItem[0].todo ?? false;
                        }
                    }
                });
            }
            if (tagForm.indexOf("bscs_") !== -1) {
                $scope.reInit();
                $.each($scope.dataInTabPane[tagForm]['data'], function (keyItem, valueItem) {
                    if (!!valueItem.type_id && !(!!valueItem.id) && !!$scope['typebscs'] && $scope['typebscs'].length >= 1) {
                        getCurrentItem = $scope['typebscs'].filter((i) => i.id === parseInt(valueItem.type_id));
                        if (getCurrentItem.length === 1) {
                            $scope.dataInTabPane[tagForm]['data'][keyItem].show_others = getCurrentItem[0].show_others ?? false;
                            $scope.dataInTabPane[tagForm]['data'][keyItem].choose_debour = getCurrentItem[0].choose_debour ?? false;
                            $scope.dataInTabPane[tagForm]['data'][keyItem].file_required = getCurrentItem[0].file_required ?? false;
                        }
                    }
                });
            }
            if (tagForm.indexOf("ffs_") !== -1) {
                $scope.reInit();

            }
            if (tagForm.indexOf("ffts_") !== -1) {
                $scope.reInit();
            }

            $scope.checkTabFactureFret(tagForm);

            $scope.checkIfDocsCorrect(tagForm, true);
        }
        if (tagForm.indexOf("_dossier") !== -1) {
            $scope.checkIfDocsCorrect(tagForm, true);
        }
        if (tagForm.indexOf("_fonctionnalite") !== -1 && action == 'add') {
            const fonctionnalitesExtracted = {
                fonctionnalitemodules_fonctionnalite: {
                    data: [],
                    rules: []
                }
            };
            $scope.dataInTabPane[parentTag]['data'].forEach(item => {
                if (item && item.fonctionnalites) {
                    fonctionnalitesExtracted.fonctionnalitemodules_fonctionnalite.data =
                        fonctionnalitesExtracted.fonctionnalitemodules_fonctionnalite.data.concat(item.fonctionnalites);
                }
            });

            $scope.dataInTabPane[parentTag]['data'].length = 0;

            // $scope.dataInTabPane = fonctionnalitesExtracted;
            console.log('IN MULTI CONDITION', $scope.dataInTabPane[tagForm]['data']);
        }

    };

    $scope.checkTabFactureFret = function (tagForm) {
        if (tagForm.indexOf("ffs_") !== -1) {
            $scope["noNeedFactureFret"] = $scope.dataInTabPane[tagForm]['data'].filter((i) => i.inclut_fret === true).length > 0;
            $scope.checkIfDocsCorrect("ffts_ordretransit", true);
        }
    };

    function removeDuplicates(arr, key) {
        var uniqueKeys = new Set(); // Utilisation d'un ensemble pour stocker les valeurs uniques de la clé
        var newArray = []; // Le nouveau tableau sans les doublons

        for (var i = 0; i < arr.length; i++) {
            var obj = arr[i];
            var keyValue = obj['id'] ?? obj[key]; // Récupérer la valeur de la clé spécifiée
            if (!!keyValue) {
                if (!uniqueKeys.has(keyValue)) {
                    uniqueKeys.add(keyValue); // Ajouter la valeur au Set
                    newArray.push(obj); // Ajouter l'objet au nouveau tableau
                }
            }
        }

        return newArray;
    }



    $scope.actionSurTabPaneTagDataold = function (action, parentTag, parentCurrentIndex = 0, childTag = null, childCurrentIndex, optionals = { obj: null, deleteAll: false }) {

        var nameobjet_id = null
        var value_to_filter = null

        console.log('ici mon paramettre =>', parentTag)

        var tagForm;
        // Début de la logique de vérification du retard

        // Fin de la logique de vérification du retard
        if (!$scope.dataInTabPane[parentTag]) {
            $scope.dataInTabPane[parentTag] = { data: [] };
        }

        if (action == 'add') {
            var currentPositionParent, currentPositionChild;
            var findError = false;
            let newItem = {}; // Créez l'objet unique ici.

            if (childTag) {
                currentPositionParent = parentCurrentIndex;

                if (!$scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag]) {
                    $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag] = [];
                }
                indexChildForm = $('#index_' + currentPositionParent + '_' + childTag).val();
                if (!indexChildForm || !$scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag][indexChildForm]) {
                    currentPositionChild = $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag].length;
                } else {
                    currentPositionChild = indexChildForm;
                }
                tagForm = currentPositionParent + "_" + childTag;
            } else {
                currentPositionParent = $scope.dataInTabPane[parentTag]['data'].length;
                tagForm = parentTag;
            }

            if (!(optionals && optionals.obj)) {
                console.log('tagForm=>', tagForm);

                // 1. Collecte de toutes les données du formulaire, y compris la date et l'heure d'arrivée
                $("input[id$=" + "_" + tagForm + "], textarea[id$=" + "_" + tagForm + "], select[id$=" + "_" + tagForm + "]").each(function () {
                    let getValue = $(this).val();
                    const indexNameInTab = $(this).attr('id').substring(0, ($(this).attr('id').length - tagForm.length - 1));

                    if ($(this).hasClass('required') && !getValue) {
                        findError = true;
                        return false;
                    }

                    if ($(this).is("select")) {
                        if (!$(this).prop('multiple')) {
                            newItem[indexNameInTab + '_id'] = getValue;
                            newItem[indexNameInTab] = { nom: $(this).children("option:selected").text() };
                            if (indexNameInTab == 'credit_client') {
                                const nameItem = $(this).children("option:selected").text();
                                const formateCode = nameItem.split('=>')[1];
                                newItem['code'] = formateCode;
                            }
                        } else {
                            let valuesArray = [];
                            let getValues = $(this).val();

                            $.each(getValues, function (keyItem, valueItem) {
                                let getCurrentItem = $scope.dataPage[indexNameInTab].filter(item => Number(item.id) == Number(valueItem));
                                if (getCurrentItem.length == 1) {
                                    let obj = {};
                                    const indexNameOneObj = indexNameInTab.substr(0, indexNameInTab.length - 1);
                                    obj[indexNameOneObj + '_id'] = getCurrentItem[0].id;
                                    obj[indexNameOneObj] = getCurrentItem[0];
                                    valuesArray.push(obj);
                                }
                            });
                            newItem[indexNameInTab] = valuesArray;
                        }
                    } else if ($(this).is(":checkbox")) {
                        getValue = $(this).prop('checked');
                        newItem[indexNameInTab] = getValue;
                    } else {
                        newItem[indexNameInTab] = getValue;
                    }
                });

                // 2. Logique de vérification du retard, après la collecte des données
                if (!findError && tagForm.indexOf('details_pointage') !== -1) {
                    const dateInputValue = newItem.date;
                    const heureArriveValue = newItem.heure_arrive;

                    if (dateInputValue && heureArriveValue) {
                        const dateParts = dateInputValue.split('/');
                        const date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                        const jourDeSemaine = date.getDay(); // 0 = Dimanche, 6 = Samedi

                        let heureLimite = '08:45';
                        if (jourDeSemaine === 6) {
                            heureLimite = '09:00';
                        }

                        // Le check est fait ici
                        const estEnRetard = heureArriveValue > heureLimite;

                        // Mise à jour de la propriété 'retard' de l'objet newItem
                        newItem.retard = estEnRetard;
                    } else {
                        newItem.retard = false;
                    }
                }


                if (!findError) {
                    // 3. Ajout de l'objet complet au tableau, une seule fois
                    if (childTag) {
                        $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag].push(newItem);
                    } else {
                        $scope.dataInTabPane[parentTag]['data'].push(newItem);
                    }
                    $scope.emptyForm(tagForm);
                } else {
                    $scope.showToast('', 'Veuillez remplir tous les champs obligatoires', 'error');
                }
            } else {
                // Logique pour les objets externes (options.obj)
                if (childTag) {
                    $tab = $scope.dataInTabPane[parentTag]['data'][currentPositionParent][childTag];
                } else {
                    $tab = $scope.dataInTabPane[parentTag]['data'];
                }

                checkifExist = $tab.filter(item => (item.id == optionals.obj.id));
                if (checkifExist.length == 0) {
                    $tab.push(optionals.obj);
                } else {
                    $scope.showToast("Ajout", "L'élément est déjà présent", "error");
                    return;
                }
            }

            if (tagForm.indexOf("planification") !== -1) {
                $timeout(function () {
                    var link = document.getElementById('link' + $scope.selectedIndex);
                    if (link) {
                        link.click();
                    }
                }, 1000);
            }
        }
        else if (action == 'delete') {
            if (childTag) {
                if (!optionals.deleteAll) {
                    currentPositionParent = parentCurrentIndex;
                    $scope.dataInTabPane[parentTag]['data'][parentCurrentIndex][childTag].splice(childCurrentIndex, 1);
                    tagForm = currentPositionParent + "_" + childTag;
                }
                else {
                    $scope.dataInTabPane[parentTag]['data'][parentCurrentIndex][childTag] = [];
                }
            }
            else {
                if (!optionals.deleteAll) {
                    $scope.dataInTabPane[parentTag]['data'].splice(parentCurrentIndex, 1);
                    tagForm = parentTag;
                }
                else {
                    $scope.dataInTabPane[parentTag]['data'] = [];
                }
            }
        }
        // else if (action === 'update') {
        //     const dataToEdit = $scope.dataInTabPane[parentTag]['data'][parentCurrentIndex];
        //     const tagForm = parentTag;

        //     if (dataToEdit) {
        //         $("input[id$='_" + tagForm + "'], textarea[id$='_" + tagForm + "'], select[id$='_" + tagForm + "']").each(function () {
        //             const id = $(this).attr("id");
        //             const field = id.replace('_' + tagForm, '');

        //             let valueToSet = dataToEdit[field + '_id'] ?? dataToEdit[field] ?? null;

        //             if (typeof valueToSet === 'object' && valueToSet !== null && 'id' in valueToSet) {
        //                 valueToSet = valueToSet.id;
        //             }

        //             if ($(this).is("select")) {
        //                 $(this).val(valueToSet).trigger("change");
        //             } else if ($(this).is(":checkbox")) {
        //                 $(this).prop("checked", !!valueToSet);
        //             } else {
        //                 $(this).val(valueToSet);
        //             }
        //         });

        //         // Stocker l’index dans un champ hidden ou dans une variable
        //         $('#index_' + tagForm).val(parentCurrentIndex);
        //     }
        // }


    };

    $scope.setRestriction = function (from, type) {
        let y = from + type;
        let u = parseInt($("#" + y).val() ?? 0);
        return u;
    }

    $scope.getValueInSelect2 = function (from, type, toFloat = false) {
        let y = from + "_" + type;
        let u = 0;

        if (toFloat === true) {
            u = parseFloat($("#" + y).val() ?? 0);
        }
        else {
            u = parseInt($("#" + y).val() ?? 0);
        }

        return u;
    }

    $scope.setValueInInput = function (from, type, value, isSelect2 = false) {
        let y = from + "_" + type;
        if (isSelect2 === true) {
            $("#" + y).val(value).trigger("change");
        }
        else {
            $("#" + y).val(value);
        }

    }

    $('#aa_manifestes_dossier').on('keydown', function (e) {
        e.preventDefault();
    });
    $scope.currentYear = new Date().getFullYear().toString().slice(-2);
    $scope.allowReadOnly = function (idElt, useValue = false, value = null) {

        let elt = $("#" + idElt);
        if (useValue) {
            u = value;
        }
        else {
            u = parseInt($scope.typeMarchandiseIdModal) === 2;
        }

        if (elt.length > 0) {

            elt.attr('readonly', u);

            if (u === true) {
                elt.addClass('bg-disabled-input');
                if (elt.hasClass("datedropper")) {
                    if (elt.pickadate('picker')) {
                        elt.pickadate('picker').stop();
                        elt.removeClass("datedropper");
                    }

                }
            }
            else {
                elt.removeClass('bg-disabled-input');
                if (elt.hasClass("reset-datedropper") && !elt.hasClass("datedropper")) {
                    elt.addClass("datedropper");
                    $scope.reInit('[id*="' + idElt + '"]');
                }
            }
        }
        return u;
    }

    $scope.allowNgDisabled = function (idElt, value = null, useValue = false) {
        let elt = $("#" + idElt);
        if (useValue) {
            value = !elt.get(0).disabled;
        }

        if (elt.length > 0) {
            elt.attr('disabled', value);
        }
    }

    $scope.checkNumeroComptable = function () {
        if (String($scope.numeroComptable).trim().length > 4) {
            $scope.numeroComptable = parseInt(String($scope.numeroComptable).slice(0, 4));
        }
    };

    $scope.isCloned = false;
    $scope.updateItem = null;
    $scope.showModalUpdate = function (type, itemId, optionals = { forceChangeForm: false, isClone: false, transformToType: null, queryType: null }, tagForm = null) {
        $scope.isCloned = false
        $scope.forceChangeForm = optionals.forceChangeForm;
        var formatId = "id";
        var listeattributs_filter = [];

        $scope.programmeErrors = [];
        var queryType = type + "s";

        if (!!optionals.queryType) {
            queryType = optionals.queryType;
        }

        var listeattributs = listofrequests_assoc[queryType];

        reqwrite = queryType + "(" + formatId + ":" + itemId + ")";

        if (optionals.transformToType) {
            tmpType = type;
            type = optionals.transformToType;
        }

        $scope.showModalAdd(type, { fromUpdate: true });

        Init.getElement(reqwrite, listeattributs, listeattributs_filter).then(function (data) {
            var item = data[0];

            $scope.updateItem = item; // Pour récupérer l'objet courant qui entrain d'être mis à jour

            if (tagForm.indexOf("planification") !== -1) {
                $timeout(function () {
                    var link = document.getElementById('link0');
                    if (link) {
                        link.click();
                    }
                    console.log('Linkclick', document.getElementById('link0'));
                }, 1000);
            }
            if (type === "nomenclaturedouaniere") {
                $scope.codeNomenclature = item.code ?? "";
            }

            if (type === "marchandise") {
                $scope.typeMarchandiseIdModal = item.type_marchandise_id ?? "";
            }



            if (type === "dossier") {
                $scope.getElements("ordretransitbls", { queries: ['ordre_transit_id:' + item.ordre_transit_id] });
                $scope.getElements("devises", { toType: 'devises2', queries: ['ordre_transit_id:' + item.ordre_transit_id] });
                $scope.getElements("regimes", { queries: ['type_dossier_id:' + item.type_dossier_id] });
            }

            //pour remonter les radios
            //convention a respecter : id="nom_du_champ_type" ng-model="nom_du_champ" value="oui" ou value="non"
            function mapBooleansToRadios(item, type) {
                Object.keys(item).forEach(function (key) {
                    const val = item[key];
                    if (val === true || val === false || val === "true" || val === "false") {
                        $scope[key] = (val === true || val === "true") ? 'oui' : 'non';
                        const radioId = `${key}_${type}`;
                        setTimeout(() => {
                            $(`#${radioId}[value="${$scope[key]}"]`).prop("checked", true);
                        }, 0);
                    }
                });
            }

            if (type === "evenement") {
                mapBooleansToRadios(item, type);
            }

            if (type === "remboursement") {
                $scope.calculerTotalReste();
            }



            if (type === "planification") {


                $('#date_debut_planification').on('change', function () {
                    ancienValueDateDebut = $(this)
                    let result1 = dateProgrammeComparaison();

                    if (result1 === true) {
                        $scope.date_debut_programme = $('#date_debut_planification').val()
                        $(this).data('old', $(this).val())
                        $scope.generateDaysInterval("date_debut_planification")
                    }
                    else {
                        $('#date_debut_planification').val($(this).data('old'))
                    }
                })

                $('#date_fin_planification').on('change', function () {
                    ancienValueDateFin = $(this)
                    let result2 = dateProgrammeComparaison();

                    if (result2 === true) {
                        $scope.date_fin_programme = $('#date_fin_planification').val()
                        $(this).data('old', $(this).val())

                        $scope.generateDaysInterval("date_fin_planification")

                    } else {
                        $('#date_fin_planification').val($(this).data('old'))
                        $scope.generateDaysInterval("date_fin_planification")
                    }
                })


                let dayPlanification = [];

                dayPlanification.push(item);
                // $scope.planningEdit  = item;
                $scope.interval_date = [];
                setTimeout(() => {

                    for (let i = 0; i < dayPlanification.length; i++) {
                        const element = dayPlanification[i];
                        let newDate = new Date(transformDotDateToSlashDate(element.date_debut, true));
                        let currentDate = newDate.getTime();
                        let id = "day_" + newDate.toLocaleDateString("fr").replace(/\//g, "");
                        let dayProgrammes = [];

                        const elementProgramme = element.planification_assignes[0];
                        const tempProgramme = {
                            id: elementProgramme.id,
                            date: elementProgramme.date,
                            projet_id: elementProgramme.projet_id,
                            fonctionnalite_module_id: elementProgramme.fonctionnalite_module_id,
                            tache_fonctionnalite_id: elementProgramme.tache_fonctionnalite_id,
                            tag_id: elementProgramme.tag_id,
                        };

                        let dayplanning = {
                            id: id,
                            id_planning: item.code,
                            date: newDate,
                            milisec: currentDate,
                            initial: getDateInitial(currentDate),
                            dayProgrammes: [tempProgramme],
                        };

                        $scope.interval_date[i] = dayplanning;
                        console.log('Dayplanning ajouté:', $scope.interval_date[i]);;
                    }

                }, 1500);

                $scope.interval_dates = $scope.interval_date;
                console.log('planning 3:', $scope.interval_dates);

            }
            if (type === "pointage") {
                $('#date_debut_pointage').on('change', function () {
                    ancienValueDateDebut = $(this)
                    let result1 = dateProgrammeComparaison();

                    if (result1 === true) {
                        $scope.date_debut_programme = $('#date_debut_pointage').val()
                        $(this).data('old', $(this).val())
                        $scope.generateDaysInterval("date_debut_pointage")
                    }
                    else {
                        $('#date_debut_pointage').val($(this).data('old'))
                    }
                })

                $('#date_fin_pointage').on('change', function () {
                    ancienValueDateFin = $(this)
                    let result2 = dateProgrammeComparaison();

                    if (result2 === true) {
                        $scope.date_fin_programme = $('#date_fin_pointage').val()
                        $(this).data('old', $(this).val())

                        $scope.generateDaysInterval("date_fin_pointage")

                    } else {
                        $('#date_fin_pointage').val($(this).data('old'))
                        $scope.generateDaysInterval("date_fin_pointage")
                    }
                })


                let daypointage = [];

                daypointage.push(item);
                // $scope.planningEdit  = item;
                $scope.interval_date = [];
                setTimeout(() => {

                    for (let i = 0; i < daypointage.length; i++) {
                        const element = daypointage[i];
                        let newDate = new Date(transformDotDateToSlashDate(element.date_debut, true));
                        let currentDate = newDate.getTime();
                        let id = "day_" + newDate.toLocaleDateString("fr").replace(/\//g, "");


                        let dayplanning = {
                            id: id,
                            id_planning: item.code,
                            date: newDate,
                            milisec: currentDate,
                            initial: getDateInitial(currentDate),
                            dayProgrammes: [tempProgramme],
                        };

                        $scope.interval_date[i] = dayplanning;
                        console.log('Dayplanning ajouté:', $scope.interval_date[i]);;
                    }

                }, 1500);

                $scope.interval_dates = $scope.interval_date;
                console.log('planning 3:', $scope.interval_dates);

            }
            //pour remonter les radios

            if (type === "pointage") {
                mapBooleansToRadios(item, type);
            }



            console.log('showModalUpdate ==F=> item *************', type, JSON.stringify(item));

            if (!optionals.isClone && !optionals.transformToType) {
                $('#id_' + type).val(item.id);
            }
            else if (optionals.isClone) {
                $scope.isCloned = true;
                $('#id_clone_' + type).val(item.id);
            }
            setTimeout(() => {
                $scope.checkInForm(type, item, optionals);
            }, 400);

            $('#link0').trigger("click");
            $('#link0').trigger("click");
            // $scope.checkInForm(type, item, optionals);




        }, function (msg) {
            $scope.showToast("", msg, 'error');
        });


    };

    function transformDotDateToSlashDate(value, server = false) {
        if (value.indexOf('.') !== -1) {
            let valueArray = value.split('.')
            value = valueArray[1] + "/" + valueArray[0] + "/" + valueArray[2];
        } else if (value.indexOf('-') !== -1) {
            let valueArray = value.split('-')

            if (server === true) {
                value = valueArray[1] + "/" + valueArray[2] + "/" + valueArray[0];
            }

        }

        return value
    }

    //Fonction pour modification données provenant d'un select2 dynamique
    // TODO: a supprimer
    // $scope.editInSelect2 = function (type, id, typeForeign)
    // {
    //     //  console.log("type", type, "id", id, "typeForeign", typeForeign, '#' + type + '_id_' + typeForeign);
    //     var req = type + "s";
    //     rewriteReq = req + "(id:" + id + ")";
    //     Init.getElement(rewriteReq, listofrequests_assoc[req]).then(function (data) {
    //         if (data) {
    //             $scope.dataPage[req] = data;
    //             setTimeout(function () {
    //                 $('#' + type + '_id_' + typeForeign).val(id).trigger('change');
    //             }, 1000);
    //         }
    //     }, function (msg) {
    //         toastr.error(msg);
    //     });
    // };


    //--------------------------------------------=========================//
    //-----------------CALENDAR FEATURES----------------===================//
    //--------------------------------------------=========================//

    $scope.getInfosCalendar = function (type, date = null, opt = { toType: null }) {
        let tabInfosCalendar = [];
        let queries1 = [];

        if (type == 'evenement') {
            optionals = { justTheseAttrs: 'id,libelle,objet,status,date_debut,date_fin,type_evenement{id,libelle,reference}', setStateCursorToLoading: true, isPromise: true, addFilters: true, tagFilter: 'evenement_calendar' };

            if (opt.is_absence_request === false) {
                queries1 = ["is_absence_request : " + false];
            }
            else if (opt.is_absence_request === true) {
                queries1 = ["is_absence_request : " + true];
            }

            optionals['queries'] = queries1;
        }

        // if (type == 'planification') {
        //     optionals = { queries: ['source:"calendar"'], justTheseAttrs: 'id,date_debut,date_debut_fr,date_fin,date_fin_fr,personnel_id,status,personnel{id,display_text,user},nombre_tache,nombre_projet,planification_assignes{id,planification_id,projet_id,fonctionnalite_module_id,date,tache_fonctionnalite_id,status}', setStateCursorToLoading: true, isPromise: true, tagFilter: 'planification' };
        // }

        if (opt.tagFilter) {
            optionals['addFilters'] = true;
            optionals['tagFilter'] = opt.tagFilter;
        }
        optionals = { ...optionals, ...opt };

        $scope.getElements(type + "s", optionals).then(function (data) {
            console.log("ici les datas =>", data);
            $.each(data, function (keyItem, oneItem) {
                if (type == 'planification') {
                    tabInfosCalendar.push({
                        id: oneItem.id,
                        title: oneItem.display_text ? oneItem.display_text : oneItem.prestation.libelle,
                        start: $scope.getDateToday(oneItem.date_fr, false),
                        end: $scope.getDateToday(oneItem.date_fr, false)
                    });
                }
            });
            console.log("ici tabInfosCalendar papa => ", tabInfosCalendar,);
            // console.log("Die and Dump",onItem);
            $scope.readCalendar(type, date, tabInfosCalendar, optionals);
        })

        //return tabInfosCalendar;
    }

    $scope.getDateToday = function (dateStart = null, isDateEnd = false) {
        console.log("ici la date -> ", dateStart);
        let dateDay, day, month, year;
        if (dateStart) {
            // 14/07/2023
            if (isDateEnd) {
                day = parseInt(dateStart.split('-')[2]) < 31 ? parseInt(dateStart.split('-')[2]) + 1 : parseInt(dateStart.split('-')[2])
                month = dateStart.split('-')[1]
                year = dateStart.split('-')[0]
            }
            else {
                day = dateStart.split('/')[0]
                month = dateStart.split('/')[1]
                year = dateStart.split('/')[2]
            }

            if (day < 10 && day.length == 1) {
                day = '0' + day;
            }
            if (month < 10 && month.length == 1) {
                month = '0' + month;
            }

            dateDay = (year + '-' + month + '-' + day);
            console.log('Date date 1 new', dateDay);
        }
        else {
            date = new Date();
            year = date.getFullYear();
            month = date.getMonth() + 1;
            dt = date.getDate();

            if (dt < 10) {
                dt = '0' + dt;
            }
            if (month < 10) {
                month = '0' + month;
            }

            dateDay = (year + '-' + month + '-' + dt);
            console.log('Date date 2', dateDay);
        }
        return dateDay;
    }

    $scope.readCalendar = function (type, date = null, dataTab, optionals = { toType: null }) {
        var rewriteType = type;
        if (optionals.toType) {
            rewriteType = optionals.toType
        }

        var calendarEl = document.getElementById(rewriteType);
        var calendar = new FullCalendar.Calendar(calendarEl, {
            //height: '100%',
            timeZone: 'UTC',
            //expandRows: true,
            //slotMinTime: '08:00',
            //slotMaxTime: '20:00',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            initialView: 'dayGridMonth',
            //initialDate: '2023-03-12',
            initialDate: $scope.getDateToday(date),
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            selectable: true,
            nowIndicator: true,
            dayMaxEvents: true, // allow "more" link when too many events
            events: dataTab,

            eventClick: function (info) {
                $scope.showModalDetailCalendar(type, info.event.id);
            },
            dayMaxEventRows: true, // for all non-TimeGrid views
            views: {
                timeGrid: {
                    dayMaxEventRows: 2 // adjust to 6 only for timeGridWeek/timeGridDay
                }
            }
        });

        calendar.setOption('locale', 'fr');

        calendar.render();
    }
    $scope.showModalDetailCalendar = function (type, itemId) {
        $scope.detailCommandeCalendar = [];
        reqwrite = type + "s(id:" + itemId
        $scope.showModalAdd(type + 'calendar');

        if (type == 'planification') {
            reqwrite = reqwrite + ',source:"calendar")';
            var attributes = "id,date,date_fr,heure_debut,heure_fin,duree,commentaire,collaborateur_id,collaborateur{id,nom,adresse_email},prestation_contrat{id,contrat{client{nom}},prestation_id,prestation{id,libelle}}";
            Init.getElement(reqwrite, attributes).then(function (data) {
                if (!!data && data.length == 1) {
                    $scope.planificationCalendar = data[0];
                    console.log("ici dans la donnée =>", $scope.planificationCalendar);
                }
            }, function (msg) {
                $scope.showToast("", msg, 'error');
            });
        }
    }

    $scope.loadDataCalendar = function (type, filtre = false, optionals = { toType: null }) {
        rewriteType = type;
        if (optionals.toType) {
            rewriteType = optionals.toType
        }

        let dat = null
        if (filtre) {
            dat = $("#date_debut_list_" + rewriteType).val() ? $("#date_fin_list_" + rewriteType).val() : null;
        }

        setTimeout(() => {
            // $scope.readCalendar(type, dat);
            $scope.getInfosCalendar(type, dat, optionals)
        }, 1000);
    }
    //--------------------------------------------=========================//
    //-----------------CALANDAR FEATURES----------------===================//
    //--------------------------------------------=========================//
});

function setMontantFr(input) {
    input = input + "";
    return input.replace(/,/g, " ");
}



// Vérification de l'extension des elements uploadés
function isValide(fichier) {
    var Allowedextensionsimg = new Array("jpg", "JPG", "jpeg", "JPEG", "gif", "GIF", "png", "PNG", "svg", "SVG");
    var Allowedextensionsvideo = new Array("mp4");
    for (var i = 0; i < Allowedextensionsimg.length; i++)
        if ((fichier.lastIndexOf(Allowedextensionsimg[i])) != -1) {
            return 1;
        }
    for (var j = 0; j < Allowedextensionsvideo.length; j++)
        if ((fichier.lastIndexOf(Allowedextensionsvideo[j])) != -1) {
            return 2;
        }
    return 0;
}

function setActiveTab(id) {
    var depth = $("#" + id).attr("depth");
    var end = $("#" + id).attr("maxdepth");

    //Enlever la classe active dans tous les onglets
    for (let index = 0; index < end; index++) {
        $("#onglet-chapitre-" + index).removeClass("active");
    }

    //Activer l'onglet courant
    $("#" + id).addClass("active");
    $("#depth_list_chapitrenomenclaturedouaniere").val(depth);
}


// FileReader pour la photo
function Chargerphoto(idform, tag = null, typeFile = 'image') {
    var getTag = tag ?? "img" + idform;
    var fichier = document.getElementById(getTag);
    console.log('here pls', getTag, fichier, isValide(fichier.value));
    if (isValide(fichier.value) != 0 || typeFile.indexOf('image') === -1) {
        fileReader = new FileReader();
        if (isValide(fichier.value) == 1 || typeFile.indexOf('image') === -1) {
            fileReader.onload = function (event) {
                $("#aff" + getTag).attr("src", (isValide(fichier.value) == 1) ? event.target.result : 'assets/media/svg/icons/sidebar/icon-file-upload-successfully.svg');
                if (getTag.indexOf('ordretransit') !== -1 || (getTag.indexOf('dossier') !== -1)) {
                    $scope = angular.element(document.getElementsByTagName('body')).scope();
                    var keyItemSave;

                    var tagTabPane = $('#' + getTag).attr('data-tabpane');
                    var showCheckModal = $('#' + getTag).attr('show-check-modal') === "true";
                    var indexFile = parseInt($('#' + getTag).attr('data-idFile'));



                    $scope.fileNameToUpload = null;
                    $scope.fileNameIndex = null;

                    if (showCheckModal) {
                        if (!isNaN(indexFile)) {
                            $scope.fileNameToUpload = $scope.dataInTabPane[$('#' + getTag).attr('data-tabpane')]['data'][indexFile].files[0].name;
                            $scope.fileNameIndex = indexFile;
                        }

                        $scope.canCloseModal = false;
                        $("#modal_addcheckoption").modal('show');
                    }

                    $scope.checkIfDocsCorrect(tagTabPane, true);

                    $.each($scope.dataInTabPane[$('#' + getTag).attr('data-tabpane')]['data'], function (keyItem, valueItem) {
                        console.log('here pls', $scope.dataInTabPane[$('#' + getTag).attr('data-tabpane')]['data'][keyItem].files[0].name, valueItem.type_document_id);
                        // if ($scope.dataInTabPane[$('#' + getTag).attr('data-tabpane')]['data'][keyItem].files[0].name.indexOf('_')!==-1 && valueItem.numero == $('#' + getTag).attr('data-idFile'))
                        // {
                        //     $scope.dataInTabPane[$('#' + getTag).attr('data-tabpane')]['data'][keyItem].files[0].name = 'imgordretransit' + $('#' + getTag).attr('data-idFile');
                        //     keyItemSave = keyItem;
                        //     return false;
                        // }
                    });
                    // console.log('angular.element($0).scope().typedocumentsInTable =>', getTag, $scope.typedocumentsInTable);
                }

                //$("#aff" + getTag).attr("src", (isValide(fichier.value) == 1) ? event.target.result : 'assets/media/svg/icons/sidebar/icon-file-upload-successfully.svg');

                // $("#aff" + tagBalise + idform).attr("src", (isValide(fichier.value) == 1) ? event.target.result : 'assets/images/files/pdf.svg');

                // $("#aff" + getTag).attr("src", event.target.result);
            }, fileReader.readAsDataURL(fichier.files[0]);
            if (getTag == 'produit') {
                $("#imgproduit_recup").val("");
            }
        }
    }
    else {
        // alert("L'extension du fichier choisi ne correspond pas aux règles sur les fichiers pouvant être uploader");
        $('#' + getTag).val("");
        $('#aff' + getTag).attr("src", "");
        $('.input-modal').val("");
    }
}




// function Chargerphoto(idform, tag = null, typeFile = 'image')
// {
//     var fichier = document.getElementById("img" + idform);
//     (isValide(fichier.value) != 0) ?
//         (
//             fileReader = new FileReader(),
//                 (isValide(fichier.value) == 1) ?
//                     (
//                         fileReader.onload = function (event) {
//                             $("#affimg" + idform).attr("src", event.target.result);
//                         },
//                             fileReader.readAsDataURL(fichier.files[0]),
//                             (idform == 'produit') ? $("#imgproduit_recup").val("") : ""
//                     ) : null
//         ) : (
//             alert("L'extension du fichier choisi ne correspond pas aux règles sur les fichiers pouvant être uploader"),
//                 $('#img' + idform).val(""),
//                 $('#affimg' + idform).attr("src", ""),
//                 $('.input-modal').val("")
//         );
// }

function reCompile(element) {
    var el = angular.element(element);
    $scope = el.scope();
    $injector = el.injector();
    $injector.invoke(function ($compile) {
        $compile(el)($scope)
    })
    console.log('arrive dans la liaison');
    //14724 lignes avant nettoyage
}

function setStateCursorToLoading(deferred) {
    // Changement le cursor pendant le chargement
    const start = performance.now();
    $('body').css('cursor', 'wait');
    deferred.promise.then(function () {
        const elapsed = performance.now() - start;
        setTimeout(function () {
            $('body').css('cursor', 'inherit');
        }, (elapsed / 10 + 1000));
    });
}

// FileReader pour la photo //
function Chargerimage(idform, tag = null) {
    var tagBalise = "img";
    var rechercheTag = '';
    if (tag) {
        tagBalise = tag;
        rechercheTag = tag.split(idform);
        if (rechercheTag.length > 1) {
            tagBalise = rechercheTag[0];
        }
    }
    var fichier = document.getElementById(tagBalise + "" + idform);
    console.log("Chargerphoto", fichier);
    (isValide(fichier.value) != 0) ?
        (
            fileReader = new FileReader(),
            (isValide(fichier.value) == 1) ?
                (
                    fileReader.onload = function (event) {
                        $("#aff" + tagBalise + idform).attr("src", event.target.result);
                    },
                    fileReader.readAsDataURL(fichier.files[0]),
                    (idform == 'produit') ? $("#" + tagBalise + "produit_recup").val("") : ""
                ) : null
        ) : (
            // alert("L'extension du fichier choisi ne correspond pas aux règles sur les fichiers pouvant être uploader"),
            $('#' + tagBalise + '' + idform).val(""),
            $('#aff' + tagBalise + '' + idform).attr("src", ""),
            $('.input-modal').val("")
        );
}

