<style>
    
    .nav-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .nav-links {
        display: flex;
        gap: 1rem;
    }

    .nav-links a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.3s ease-in-out;
    }

    .nav-links a:hover {
        color: #007bff;
    }

    .brand a {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .page {
        display: none; /* Caché par défaut */
        padding: 2rem;
        animation: fadeIn 0.5s ease-in-out;
    }

    .page.active {
        display: block; /* Affiché lorsqu'actif */
    }
    .progress {  
        height: 8px;
        border-radius: 4px;  
        background-color: rgba(255, 255, 255, 0.2);  
    }  

    .progress .progress-bar {  
        background-color: #4ecdc4;  
        border-radius: 4px;  
    }  

    .progress-text {  
        display: flex;  
        justify-content: space-between;  
        margin-bottom: 1rem;  
        font-size: 1rem;  
    }  
    .border-dashed {
        border: 2px dashedrgb(181, 182, 184) !important;
   }

   .dropdown-menu {
    display: block !important;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
    }

    .dropdown:hover .dropdown-menu {
    opacity: 1;
    pointer-events: auto;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style> 
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 

<div class="">
    <div class="container tab-content" id="myTabContent">
        <div class="w-100">
            <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                <div class="titre-ch-p">
                    <div class="card-title d-flex align-self-center mb-0 me-3">
                        <span class="card-icon align-self-center">
                            <span class="svg-icon svg-icon-primary">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-gestionprojet.svg')) !!}
                            </span>
                        </span>
                        <h3 class="card-label align-self-center mb-0 ms-2" style="color:gray">
                        <a ng-href="#!/list-gestionprojet">{{ __('customlang.gestionprojet') }}</a> &nbsp;| 
                        </h3>
                        <h3 class="card-label align-self-center  text-muted mb-0 ms-2">
                            <a ng-href="#!/detail-projet/@{{projetView.id}}">@{{ projetSelected }}</a> &nbsp;|
                            @{{ moduleSelected }}
                            
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-lg-12 col-xxl-12">
                    <div
                        class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                        <div class="card rounded-1">
                            <div class="card-header p-5">
                                <div class="card-label w-100 d-flex justify-content-between align-items-center cursor-pointer"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#filtres" aria-expanded="false"
                                    aria-controls="filtresdossier">
                                    <div class="card-title">
                                        <div class="card-label h3">
                                            <span class="svg-icon">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                            </span>
                                            Filtres
                                        </div>
                                    </div>
                                    <span class="svg-icon svg-no-rotate bg-primary cursor-pointer"
                                        style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse"
                                        data-bs-target="#filtres" aria-expanded="false"
                                        aria-controls="filtresdossier">
                                        {!!
                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg'))
                                        !!}
                                    </span>
                                </div>
                            </div>
                            <div id="filtres" class="card collapse">
                                <div class="card-body">
                                    <form ng-submit="pageChanged('gestionprojet')">
                                       
                                        <div class="form-row row animated fadeIn mt-delete">
                                            <div class="col-md-12 form-group">
                                                <input type="text" class="form-control" id="search_list_projet"
                                                    ng-model="search_list_projet"
                                                    placeholder="Rechercher par code, nom, type, client ..."
                                                    ng-model-options="{ debounce: 500 }"
                                                    ng-change="pageChanged('projet')">
                                            </div>
                                        </div>
                                        <div class="form-row row animated fadeIn mt-delete">
                                            <div class="col-md-6 form-group">
                                                <div class="d-flex flex-column mb-8 fv-row">
                                                    <label for="type_projet_projet"
                                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                        <span >Type de projet</span>
                                                    </label>
                                                    <select id="type_projet_list_projet"
                                                        class="form-control form-control-solid select2 modalselect2"
                                                        style="width: 100% !important;">
                                                        <option value="">--</option>
                                                        <option value="@{{ item.id }}"
                                                            ng-repeat="item in dataPage['typeprojets']">
                                                            @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <div class="d-flex flex-column mb-8 fv-row">
                                                    <label for="client_projet"
                                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                        <span >client</span>
                                                    </label>
                                                    <select id="client_list_projet"
                                                        class="form-control form-control-solid select2 modalselect2"
                                                        style="width: 100% !important;">
                                                        <option value="">--</option>
                                                        <option value="@{{ item.id }}"
                                                            ng-repeat="item in dataPage['clients']">
                                                            @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="w-100 text-center pb-4">
                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('projet', {justWriteUrl : 'projets-pdf'})">
                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                <i class="fa fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('projet', {justWriteUrl : 'projets-excel'})">
                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                <i class="fa fa-file-excel"></i>
                                            </button>

                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('projet', true)">
                                                <i class="fa fa-times"></i>
                                                <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

            <div class="row">  
                <div class="col-md-12">
                    <nav class="" style="border-bottom: 2px solid rgb(171, 176, 184);">
                        <div class="container">
                            <div class="nav-content border-2 border-light-dark">
                                <div class="nav-links" style="margin-left:0px, position:absolute">
                                    <ul class="navbar-nav d-flex flex-row gap-8 ">
                                        <li class="nav-item border-bottom pb-2" ng-repeat="item in dataPage['departements']">
                                            <a class="nav-link cursor-pointer  fs-4" style="color:rgb(171, 176, 184)" ng-click="activateLink($event,item.str_nom)"> 
                                                <span class="svg-icon-primary">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-depart.svg')) !!}
                                                </span>
                                                <span class="text-dark">@{{item.nom}}</span>&nbsp;
                                                <span class="fw-bold fs-3 badge badge-primary" ng-repeat="p in dataPage['projets']" ng-if="p.nom == projetSelected ">@{{p.nombre_tache}}<span>
                                            </a>
                                        </li>
                                     </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                                    
                    <div id="@{{item.str_nom}}" class="page" ng-class="{'active fw-bold text-primary': activePage === item.str_nom}" ng-repeat="item in dataPage['departements']" >
                       
                        <div class="row">  
                            <div class="col-md-3 p-3" ng-repeat="module in dataPage['projetmodules']" ng-if="item.id === module.departement_id && projetSelected === module.projet.nom" > 
                                <div >
                                    <a  class=" btn-outline-dark text-decoration-none" ng-href="#!/detail-departement/@{{item.departement_id}}">
                                        <div class="card project-card p-1">  
                                            <div class="card-body" style="padding: 0.8rem"> 
                                                <ul class="d-flex list-unstyled text-nowrap" style="justify-content: space-between;">  
                                                    <li class="pt-2">  
                                                        <h2 class="fw-bold text-primary">@{{module.nom}}</h2>  
                                                    </li>  
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle pe-0"
                                                            role="button"
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false"
                                                            style="cursor: pointer">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </a>
                                                        
                                                        <!-- Menu dropdown -->
                                                        <ul class="dropdown-menu d-flex flex-row p-2" style="min-width: auto; width: 150px;">
                                                            <ul class="dropdown-menu d-flex flex-row p-1" style="min-width: auto; width: 120px;">
                                                                <li class="px-1"><a class="dropdown-item p-1 text-muted" ng-click="showModalUpdate('fonctionnalitemodule', module.id, {forceChangeForm: false, isClone:true, queryType:'projetmodules', title: '{{ __('customlang.cloture') }}'}, 'null');"><i class="fas fa-plus me-2 text-success"></i>Ajouter</a></li>
                                                                <li class="px-1"><a class="dropdown-item p-1 text-muted" ng-href="#!/detail-projetmodule/@{{module.id}}"><i class="fas fa-eye  me-2 text-primary"></i>Voir</a></li>
                                                                <li class="px-1"><a class="dropdown-item p-1 text-muted " ng-click="deleteElement('projetmodule', module.id)"><i class="fas fa-trash-alt me-2 text-danger"></i>Supprimer</a></li>
                                                            </ul>
                                                        </ul>
                                                    </li>
                                                </ul>  
                                                <p class="text-left text-muted">@{{module.description}}</p>  
                                                <div class="progress-text"  style='color:black'>  
                                                    <span><i class='fas fa-tasks' style='color:black'></i> &nbsp; Progression</span>
                                                    <span>@{{ module.nombre_tache_close }}/@{{ module.nombre_tache }}</span>  
                                                </div>  
                                                <div class="pb-3" style="display:flex; align-items: center;">
                                                    <div class="progress border rounded-1" style="border-color:rgb(232 237 237); width: 100%; height: 8px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning border border-warning" role="progressbar" style="width: @{{module.progression}}%"   
                                                            aria-valuenow="@{{module.progression}}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div> 
                                                    <span class="text-primary ms-2">@{{module.progression}}%</span>  
                                                </div>
                                                <div class="d-flex" style="justify-content: space-between">
                                                    <span class="text-dark">
                                                        <i></i>
                                                        Assigné
                                                    </span>
                                                    <span class="d-flex avatar-group" ng-if="dataPage.planifications.length">
                                                        <!-- Pré-chargez les images une seule fois -->
                                                        <span ng-repeat="planning in dataPage.planifications track by planning.id" 
                                                             ng-init="userPhoto = planning.personnel.user">
                                                          
                                                          <!-- Filtrage plus efficace avec ng-show -->
                                                          <div ng-repeat="pa in planning.planification_assignes | filter:{projet_id: module.projet_id} track by pa.id"
                                                               ng-show="module.fonctionnalite_modules.some(fm => fm.id === pa.fonctionnalite_module_id)">
                                                            
                                                            <img ng-src="{{('') }}@{{ userPhoto }}"
                                                                 width="25px" height="25px"
                                                                 class="avatar border border-warning rounded-circle"
                                                                 style="transform: translateX(@{{ 30 * $index }}px); z-index: @{{ $index }};"
                                                                 alt="@{{ planning.personnel.display_text }}"
                                                                 tooltip="@{{ planning.personnel.display_text }}"
                                                                 loading="lazy" />
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>  
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <!-- Qualité -->
                            <div class="col-md-3 p-3"  ng-repeat="module in dataPage['projetmodules']" ng-if="item.nom == 'Qualité' && projetSelected === module.projet.nom" > 
                                <a ng-href="" class=" btn-outline-dark text-decoration-none" ng-href="#!/detail-departement/@{{item.departement_id}}">
                                    <div class="card project-card ">  
                                        <div class="card-body" style="padding: 0.8rem"> 
                                            <ul class="d-flex list-unstyled text-nowrap" style="justify-content: space-between;">  
                                                <li class="pt-2">  
                                                    <h2 class="fw-bold text-primary">@{{module.nom}}</h2>  
                                                </li>  
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle pe-0"
                                                        role="button"
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false"
                                                        style="cursor: pointer">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </a>
                                                    
                                                    <!-- Menu dropdown -->
                                                    <ul class="dropdown-menu d-flex flex-row p-2" style="min-width: auto; width: 150px;">
                                                        <ul class="dropdown-menu d-flex flex-row p-1" style="min-width: auto; width: 120px;">
                                                            <li class="px-1"><a class="dropdown-item p-1 text-muted" ng-click="showModalUpdate('fonctionnalitemodule', module.id, {forceChangeForm: false, isClone:true, queryType:'projetmodules', title: '{{ __('customlang.cloture') }}'}, 'null');"><i class="fas fa-plus me-2 text-success"></i>Ajouter</a></li>
                                                            <li class="px-1"><a class="dropdown-item p-1 text-muted" ng-href="#!/detail-projetmodule/@{{module.id}}"><i class="fas fa-eye  me-2 text-primary"></i>Voir</a></li>
                                                            <li class="px-1"><a class="dropdown-item p-1 text-muted " ng-click="deleteElement('projetmodule', module.id)"><i class="fas fa-trash-alt me-2 text-danger"></i>Supprimer</a></li>
                                                        </ul>
                                                    </ul>
                                                </li>
                                            </ul>  
                                            <p class="text-left text-muted">@{{module.description}}</p>  
                                            <div class="progress-text"  style='color:black'>  
                                                <span><i class='fas fa-tasks' style='color:black'></i> &nbsp; Progression</span>  
                                                <span>@{{ module.nombre_tache_close }}/@{{ module.nombre_tache }}</span>  
                                            </div>  
                                            <div class="pb-3" style="display:flex; align-items: center;">
                                                <div class="progress border border-primary rounded-1" style="width: 100%; height: 8px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning border border-warning" role="progressbar" style="width: @{{module.progression}}%"   
                                                        aria-valuenow="@{{module.progression}}" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div> 
                                                <span class="text-primary ms-2">@{{module.progression}}%</span>  
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between">
                                                <span class="text-dark">
                                                    <i></i>
                                                    Assigné
                                                </span>
                                                <span class="symbol-label d-flex position-relative" style="width: 40px; height: 40px;margin-right:14px" ng-repeat ="planning in dataPage['planifications']" >
                                                    <div ng-repeat="pa in planning.planification_assignes" ng-if="pa.projet_id==module.projet_id">
                                                        <div class=""  ng-repeat="fm in module.fonctionnalite_modules"  ng-if="fm.id == pa.fonctionnalite_module_id && ">
                                                            <img src="{{ ('planning.personnel.user') }}" width="25px" height="25px" class="position-absolute border border-warning rounded-circle" style="left: 30px; z-index: 3;" alt="" />
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>  
                                    </div> 
                                </a>
                            </div>

                            <div class="col-md-3 p-3" ng-if="item.nom !== 'Qualite'"> 
                                <a ng-click="showModalAdd('projetmodule')" class="border-dashed p-3 rounded-1 cursor-pointer d-flex justify-content-center align-items-center gap-2 ">
                                    <span class="svg-icon svg-icon-3">
                                        {!!
                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-module.svg'))
                                        !!}
                                    </span>
                                </a>
                            </div>
                        </div> 
                    </div>
                </div> 
            </div> 
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        const departementNom = document.getElementById('departementNom').value; 
    };
</script>