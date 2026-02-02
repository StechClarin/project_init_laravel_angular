<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('tacheassigne')|| auth()->user()->can('creation-tacheassigne') || auth()->user()->can('modification-tacheassigne') )
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-0" target="_self" ng-click="pageChanged('tacheprojet')">
                        <span class="nav-icon">
                            <span class="svg-icon">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-planification.svg')) !!}
                            </span>
                        </span>
                        <span class="nav-text">
                            Taches crées
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-bs-toggle="tab" href="#page-tab-01" target="_self" ng-click="pageChanged('planificationassigne')">
                        <span class="nav-icon">
                            <span class="svg-icon">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-planification.svg')) !!}
                            </span>
                        </span>
                        <span class="nav-text">
                            Taches palnifiées
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#page-tab-1" target="_self" ng-click="emptyForm('tacheassigne_calendar');loadDataCalendar('tacheassigne', false, {tagFilter:'tacheassigne_calendar'})">
                        <span class="svg-icon">
                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-calendar.svg')) !!}
                        </span>
                        </span>
                        <span class="nav-text">Calendrier</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="page-tab-0" role="tabpanel" aria-labelledby="page-tab-0">
            <div class="">
                <div class="container tab-content" id="myTabContent">
                    <div class="w-100">
                        <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                            <div class="titre-ch-p">
                                <div class="card-title d-flex align-self-center mb-0 me-3">
                                    <span class="card-icon align-self-center">
                                        <span class="svg-icon svg-icon-primary">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-planification.svg')) !!}
                                        </span>
                                    </span>
                                    <h3 class="card-label align-self-center mb-0 ms-2">
                                        {{ __('customlang.tacheprojet') }} &nbsp;
                                    </h3>
                                    <span class="badge badge-primary p-3"> @{{paginations['tacheprojet'].totalItems | currency:"":0 | convertMontant}}</span>
                                    <!-- <span class="badge badge-warning p-3"> @{{paginations['tacheprojet'].totalItemsWithStatus1 | currency:"":0 | convertMontant}}</span> -->
                                    <!-- <span class="badge badge-danger p-3"> @{{paginations['tacheprojet'].totalItemsWithStatus2 | currency:"":0 | convertMontant}}</span> -->
                                </div>
                            </div>
                            <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                                data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                @if(auth()->user()->can('creation-tacheprojet') || auth()->user()->can('modification-tacheprojet'))
                                <a href="" class="menu-link bg-primary px-6 py-4 rounded-3" data-kt-menu-trigger="{default:'click', lg: 'hover'}" ng-click="showModalAdd('tacheprojet')" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <span class="svg-icon svg-icon-3">
                                            {!!
                                            file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg'))
                                            !!}
                                        </span>
                                    </span>
                                    <span class="menu-title text-white text-uppercase fw-bold">Ajouter</span>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 overtop-filterbar menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
                                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                                    @if(auth()->user()->can('creation-tacheprojet'))
                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('tacheprojet')">
                                        <a href="" class="menu-link px-3 py-2">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <span class="svg-icon svg-icon-3">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                </span>
                                            </span>
                                            <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                        </a>
                                    </div>
                                    <div class=" menu-item px-3 my-0" ng-click="showModalAdd('tacheprojet', {is_file_excel:true, title: 'Type d\'activités'})">
                                        <a href="" class="menu-link px-3 py-2">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <span class="svg-icon svg-icon-3">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-excel.svg')) !!}
                                                </span>
                                            </span>
                                            <span class="menu-title">{{ __('customlang.fichier_excel') }}</span>
                                        </a>
                                    </div>
                                    @endif
                                    @if(auth()->user()->can('creation-canal') || auth()->user()->can('modification-canal'))
                                    <div class="menu-item px-3 my-0" title="Télécharger un fichier excel modèle">
                                        <a href="canal.feuille" class="menu-link px-3 py-2">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <span class="svg-icon svg-icon-3">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                </span>
                                            </span>
                                            <span class="menu-title">Trame Excel</span>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-xxl-12">
                                <div style="z-index: 5;" class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
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
                                                <form ng-submit="pageChanged('tacheprojet')">

                                                    <div class="form-row row animated fadeIn mt-delete">
                                                       
                                                        <div class="col-md-6 form-group">
                                                            <div class="d-flex flex-column mb-8 fv-row">
                                                                <select id="personnel_list_tacheprojet"
                                                                    class="form-control form-control-solid select2 modalselect2"
                                                                    style="width: 100% !important;">
                                                                    <option value="">Personnel</option>
                                                                    <option value="@{{ item.id }}"
                                                                        ng-repeat="item in dataPage['personnels']">
                                                                        @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <div class="d-flex flex-column mb-8 fv-row">
                                                                <select id="projet_list_tacheprojet"
                                                                    class="form-control form-control-solid select2 modalselect2"
                                                                    style="width: 100% !important;">
                                                                    <option value="">Projet</option>
                                                                    <option value="@{{ item.id }}"
                                                                        ng-repeat="item in dataPage['projets']">
                                                                        @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="w-100 text-center pb-4">
                                                        <!-- <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('tacheprojet', {justWriteUrl : 'tacheprojets-pdf'})">
                                                            <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                            <i class="fa fa-file-pdf"></i>
                                                        </button>
                                                        <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('tacheprojet', {justWriteUrl : 'tacheprojets-excel'})">
                                                            <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                            <i class="fa fa-file-excel"></i>
                                                        </button> -->

                                                        <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                            <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                        <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('tacheprojet', true)">
                                                            <i class="fa fa-times"></i>
                                                            <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-custom gutter-b mb-2 rounded-1">
                                    <div class="card-body p-5">
                                        <div class="row">
                                            <div class="col-6 col-md-6 mb-4" ng-repeat="item in dataPage['tacheprojets']">
                                                <div class="card shadow-sm h-55 d-flex flex-row overflow-hidden">

                                                    <!-- Bandeau de gauche : badge coloré selon le status -->
                                                    <div class="d-flex align-items-center justify-content-center px-2"
                                                        ng-class="{
                                                      'bg-danger':   item.status === 0,
                                                      'bg-warning':  item.status === 1,
                                                      'bg-success':  item.status === 2
                                                    }"
                                                        style="width: 6px;">
                                                    </div>

                                                    <!-- Contenu principal -->
                                                    <div class="card-body d-flex flex-column justify-content-between p-3 w-100 h-50">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <small class="text-muted">
                                                                @{{ item.date_debut2 || 'Non débutée' }} →
                                                                @{{ item.date_fin2   || 'Non terminée' }}
                                                            </small>
                                                            <span class="badge" ng-class="{
                                                              'badge-danger':  item.status === 0,
                                                              'badge-warning': item.status === 1,
                                                              'badge-success': item.status === 2
                                                            }">
                                                                @{{ item.status === 0 ? 'Non débutée' : (item.status === 1 ? 'En cours' : 'Terminée') }}
                                                            </span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <h1 class="card-title fs-6 mb-1">@{{ item.nom_tache }}</h1>
                                                                <p class="card-text mb-1 small"><strong>projet :</strong> @{{ item.projet.nom }}</p>
                                                                <p class="card-text mb-1 small"><strong>Tag :</strong> @{{ item.tag.nom }}</p>
                                                                <p class="card-text mb-1 small"><strong>Durée :</strong> @{{ item.duree_convertie }}</p>
                                                                <span ng-if="item.priorite.nom.toLowerCase() === 'urgent'" class="badge badge-pill badge-danger">
                                                                    @{{ item.priorite.nom }}
                                                                </span>
                                                                <span ng-if="item.priorite.nom.toLowerCase() === 'moyenne'" class="badge badge-pill badge-warning">
                                                                    @{{ item.priorite.nom }}
                                                                </span>
                                                                <span ng-if="item.priorite.nom.toLowerCase() === 'faible'" class="badge badge-pill badge-secondary">
                                                                    @{{ item.priorite.nom }}
                                                                </span>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <p class="card-text text-break"><strong>Description:</strong><br>
                                                                    @{{ item.description }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4 ">
                                                                <div class="justy-content-center">
                                                                    <p class="card-text text-break"><strong>Assigné à:</strong>
                                                                        @{{ item.personnel.prenom+" "+item.personnel.nom}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column align-items-end pe-3 py-2">
                                                            <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-openTP-@{{ item.id }}">
                                                                <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-openTP-@{{ item.id }}">
                                                                    <span class="hamburger bg-dark hamburger-1"></span>
                                                                    <span class="hamburger bg-dark hamburger-2"></span>
                                                                    <span class="hamburger bg-dark hamburger-3"></span>
                                                                </label>
                                                                @if(auth()->user()->can('suppression-tacheprojet'))
                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('tacheprojet', item.id)" title="étiquette">
                                                                    <i class="flaticon2-trash"></i>
                                                                </button>
                                                                <button class="menu-btn-item btn btn-sm btn-primary btn-icon font-size-sm" ng-click="deleteElement('tacheprojet', item.id)" title="étiquette">
                                                                    <i class="fa fa-tags"></i>
                                                                </button>
                                                                @endif
                                                                @if(auth()->user()->can('modification-tacheprojet'))
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('tacheprojet', item.id, 'null', 'datails_tacheprojet')" title="{{ __('customlang.modifier') }}">
                                                                    <i class="flaticon2-edit"></i>
                                                                </button>

                                                                <button ng-if="item.status == 0" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.debuter')}}" ng-click="showModalStatutNotif($event, 'tacheprojet', 1, item, {mode:2, title: 'debuter la tache'})">
                                                                    <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                                                </button>
                                                                <button ng-if="item.status == 1" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.terminé')}}" ng-click="showModalStatutNotif($event, 'tacheprojet', 2, item, {mode:2, title: 'terminer la tache'})">
                                                                    <i class="fa fa-hourglass-end"></i>
                                                                </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!-- Actions -->


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card p-5 rounded-1">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="d-flex align-items-center me-3">
                                            <span class="text-muted me-3 d-none d-md-inline">{{__('customlang.affichage_par')}}</span>
                                            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['projet'].entryLimit" ng-change="pageChanged('projet')">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            <nav aria-label="...">
                                                <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['tacheprojet'].totalItems" ng-model="paginations['tacheprojet'].currentPage" max-size="paginations['tacheprojet'].maxSize" items-per-page="paginations['tacheprojet'].entryLimit" ng-change="pageChanged('tacheprojet')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="page-tab-01" role="tabpanel" aria-labelledby="page-tab-01">

            <div class="">
                <div class="container tab-content" id="myTabContent">
                    <div class="w-100">
                        <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                            <div class="titre-ch-p">
                                <div class="card-title d-flex align-self-center mb-0 me-3">
                                    <span class="card-icon align-self-center">
                                        <span class="svg-icon svg-icon-primary">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-planification.svg')) !!}
                                        </span>
                                    </span>
                                    <h3 class="card-label align-self-center mb-0 ms-2">
                                        {{ __('customlang.tacheassigne') }} &nbsp;
                                    </h3>
                                    <span class="badge badge-primary p-3"> @{{paginations['planificationassigne'].totalItems | currency:"":0 | convertMontant}}</span>
                                    <!-- <span class="badge badge-warning p-3"> @{{paginations['planificationassigne'].totalFiltreStatus1 | currency:"":0 | convertMontant}}</span>
                                        <span class="badge badge-danger p-3"> @{{paginations['planificationassigne'].totalFiltreStatus2 | currency:"":0 | convertMontant}}</span> -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xxl-12">
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
                                            <form ng-submit="pageChanged('tacheassigne')">

                                                <div class="form-row row animated fadeIn mt-delete">
                                                    <div class="col-md-12 form-group">
                                                        <input type="text" class="form-control" id="search_list_projet"
                                                            ng-model="search_list_projet"
                                                            placeholder="Rechercher par code, Personnel, projet,  ..."
                                                            ng-model-options="{ debounce: 500 }"
                                                            ng-change="pageChanged('projet')">
                                                    </div>
                                                </div>
                                                <div class="form-row row animated fadeIn mt-delete">
                                                    <div class="col-md-6 form-group">
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <select id="type_projet_list_projet"
                                                                class="form-control form-control-solid  search-personnel select2 modalselect2"
                                                                style="width: 100% !important;">
                                                                <option value="">Select personnel</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <select id="nom_list_tag"
                                                                class="form-control form-control-solid select2 modalselect2"
                                                                style="width: 100% !important;">
                                                                <option value="">Tag</option>
                                                                <option value="@{{ item.id }}"
                                                                    ng-repeat="item in dataPage['tags']">
                                                                    @{{ item.nom }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class="w-100 text-center pb-4">
                                                    <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('tacheassigne', {justWriteUrl : 'tacheassignes-pdf'})">
                                                        <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                        <i class="fa fa-file-pdf"></i>
                                                    </button>
                                                    <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('tacheassigne', {justWriteUrl : 'tacheassignes-excel'})">
                                                        <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                        <i class="fa fa-file-excel"></i>
                                                    </button>

                                                    <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                        <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('tacheassigne', true)">
                                                        <i class="fa fa-times"></i>
                                                        <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-custom gutter-b mb-2 rounded-1">
                                <div class="card-body p-5">
                                    <div class="row">
                                        <div class="col-6 col-md-6 mb-4" ng-repeat="item in dataPage['planificationassignes']">
                                            <div class="card shadow-sm h-55  d-flex flex-row overflow-hidden">

                                                <!-- Bandeau de gauche : badge coloré selon le status -->
                                                <div class="d-flex align-items-center justify-content-center  px-2"
                                                    ng-class="{
                                                      'bg-danger':   item.status === 0,
                                                      'bg-warning':  item.status === 1,
                                                      'bg-success':  item.status === 2
                                                    }"
                                                    style="width: 6px;">
                                                </div>

                                                <!-- Contenu principal -->
                                                <div class="card-body d-flex flex-column justify-content-between p-3 w-100 h-50">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <small class="text-muted">
                                                            @{{ item.date_debut || 'Non débutée' }} →
                                                            @{{ item.date_fin   || 'Non terminée' }}
                                                        </small>
                                                        <span class="badge" ng-class="{
                                                              'badge-danger':  item.status === 0,
                                                              'badge-warning': item.status === 1,
                                                              'badge-success': item.status === 2
                                                            }">
                                                            @{{ item.status === 0 ? 'Non débutée' : (item.status === 1 ? 'En cours' : 'Terminée') }}
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h1 class="card-title fs-6 mb-1">@{{ item.tache_fonctionnalite.tache.nom }}</h1>
                                                            <p class="card-text mb-1 small"><strong>Tâche :</strong>
                                                                @{{ item.projet.nom }}
                                                            </p>
                                                            <p class="card-text text-truncate mb-1"><strong>Tag :</strong>
                                                                @{{ item.tag.nom }}
                                                            </p>
                                                            <p class="card-text text-truncate"><strong>Durée :</strong>
                                                                @{{ item.tache_fonctionnalite.duree }}
                                                            </p>
                                                            <span ng-if="item.priorite.nom.toLowerCase() === 'urgent'" class="badge badge-pill badge-danger">
                                                                @{{ item.priorite.nom }}
                                                            </span>
                                                            <span ng-if="item.priorite.nom.toLowerCase() === 'moyenne'" class="badge badge-pill badge-warning">
                                                                @{{ item.priorite.nom }}
                                                            </span>
                                                            <span ng-if="item.priorite.nom.toLowerCase() === 'faible'" class="badge badge-pill badge-secondary">
                                                                @{{ item.priorite.nom }}
                                                            </span>

                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="card-text text-break"><strong>Description:</strong><br>
                                                                @{{ item.description }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div class="justy-content-center">
                                                                <p class="card-text text-break"><strong>Assigné à:</strong>
                                                                    @{{ item.personnel.nom+" "+item.personnel.prenom}}
                                                                </p>
                                                            </div>
                                                            <div class="justify-content-end mb-0">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="d-flex flex-column align-items-end pe-3 py-2 m-3">
                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-openPA-@{{ item.id }}">
                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-openPA-@{{ item.id }}">
                                                                <span class="hamburger bg-dark hamburger-1"></span>
                                                                <span class="hamburger bg-dark hamburger-2"></span>
                                                                <span class="hamburger bg-dark hamburger-3"></span>
                                                            </label>
                                                            @if(auth()->user()->can('suppression-tacheprojet'))
                                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('tacheprojet', item.id)" title="étiquette">
                                                                <i class="flaticon2-trash"></i>
                                                            </button>
                                                            <button class="menu-btn-item btn btn-sm btn-primary btn-icon font-size-sm" ng-click="deleteElement('tacheprojet', item.id)" title="étiquette">
                                                                <i class="fa fa-tags"></i>
                                                            </button>
                                                            @endif
                                                            @if(auth()->user()->can('modification-tacheprojet'))
                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('tacheprojet', item.id, 'null', 'datails_tacheprojet')" title="{{ __('customlang.modifier') }}">
                                                                <i class="flaticon2-edit"></i>
                                                            </button>

                                                            <button ng-if="item.status == 0" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.debuter')}}" ng-click="showModalStatutNotif($event, 'tacheprojet', 1, item, {mode:2, title: 'debuter la tache'})">
                                                                <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                                            </button>
                                                            <button ng-if="item.status == 1" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.terminé')}}" ng-click="showModalStatutNotif($event, 'tacheprojet', 2, item, {mode:2, title: 'terminer la tache'})">
                                                                <i class="fa fa-hourglass-end"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Actions -->


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card p-5 rounded-1">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="d-flex align-items-center me-3">
                                        <span class="text-muted me-3 d-none d-md-inline">{{__('customlang.affichage_par')}}</span>
                                        <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['projet'].entryLimit" ng-change="pageChanged('projet')">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <nav aria-label="...">
                                            <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['tacheassigne'].totalItems" ng-model="paginations['tacheassigne'].currentPage" max-size="paginations['tacheassigne'].maxSize" items-per-page="paginations['tacheassigne'].entryLimit" ng-change="pageChanged('tacheassigne')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>