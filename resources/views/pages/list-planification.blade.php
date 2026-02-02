<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('planification')|| auth()->user()->can('creation-planification') || auth()->user()->can('modification-planification') )
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-0" target="_self" ng-click="pageChanged('planification')">
                        <span class="nav-icon">
                            <span class="svg-icon">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-planification.svg')) !!}
                            </span>
                        </span>
                        <span class="nav-text">
                            Planification
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#page-tab-1" target="_self" ng-click="emptyForm('planification_calendar');loadDataCalendar('planification', false, {tagFilter:'planification_calendar'})">
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
    <div class="">
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
                                            {{ __('customlang.planification') }} &nbsp;
                                        </h3>
                                        <span class="badge badge-primary p-3"> @{{paginations['planification'].totalItems | currency:"":0 | convertMontant}}</span>
                                    </div>
                                </div>
                                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                    @if(auth()->user()->can('creation-planification') || auth()->user()->can('modification-planification'))
                                    <a href="" class="menu-link bg-primary px-6 py-4 rounded-3" data-kt-menu-trigger="{default:'click', lg: 'hover'}" ng-click="showModalAdd('planification')" data-kt-menu-attach="parent"
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
                                    {{-- <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 overtop-filterbar menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
                                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        @if(auth()->user()->can('creation-planification'))
                                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('planification')">
                                            <a href="" class="menu-link px-3 py-2">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                    </span>
                                                </span>
                                                <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                    </a>
                                </div>
                                <div class=" menu-item px-3 my-0" ng-click="showModalAdd('planification', {is_file_excel:true, title: 'Type d\'activités'})">
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
                            </div> --}}
                            @endif
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
                                            <form ng-submit="pageChanged('planification')">

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
                                                    <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('planification', {justWriteUrl : 'planifications-pdf'})">
                                                        <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                        <i class="fa fa-file-pdf"></i>
                                                    </button>
                                                    <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('planification', {justWriteUrl : 'planifications-excel'})">
                                                        <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                        <i class="fa fa-file-excel"></i>
                                                    </button>

                                                    <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                        <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('planification', true)">
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
                                    <div class="tab-content">
                                        <div class="table-responsive">
                                            <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                <thead>
                                                    <tr class=" bg-primary text-white">
                                                        <th style="min-width: 120px">{{ __('customlang.date_debut') }}</th>
                                                        <th style="min-width: 120px">{{ __('customlang.date_fin') }}</th>
                                                        <th style="min-width: 120px">Assigné a</th>
                                                        <th style="min-width: 120px">projet</th>
                                                        <th style="min-width: 120px">Status</th>
                                                        @if(auth()->user()->can('suppression-planification') || auth()->user()->can('modification-planification') || auth()->user()->can('creation-planification'))
                                                        <th style="min-width: 100px">
                                                            {!!
                                                            file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg'))
                                                            !!}
                                                        </th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="" ng-repeat="item in dataPage['planifications']">
                                                        <td>
                                                            <span class="text-muted fw-bold text-capitalize">@{{item.date_debut_fr}}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted fw-bold text-capitalize">@{{item.date_fin_fr}}</span>
                                                        </td>
                                                        <td>
                                                            <a type="button" class=" shadow  float-center rounded p-1" ng-href="#!/detail-planification/@{{item.id}}">
                                                                <span class="badge text-muted fw-bold text-uppercase text-white ">@{{item.personnel.display_text}}</span>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{-- <span class="text-muted fw-bold badge badge-fill-dark text-capitalize" ng-if="item.nombre_projet == 1">@{{item.projet.nom}}</span> --}}
                                                            <span class="text-white fw-bold badge badge-dark text-capitalize" ng-if="item.nombre_projet < 10">0@{{item.nombre_projet}}</span>
                                                        </td>
                                                        <td>
                                                            <span class="border border-2 border-warning text-nowrap text-warning rounded fw-bold p-1" ng-if="item.status == 0">En cours</span>
                                                            <span class="border border-2 border-danger text-nowrap text-primary rounded fw-bold p-1" ng-if="item.status == 1">Terminé</span>
                                                        </td>
                                                        @if(auth()->user()->can('suppression-planification') || auth()->user()->can('modification-planification') || auth()->user()->can('planification'))
                                                        <td class="pr-0 text-right">
                                                            <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                                <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                    <span class="hamburger bg-dark hamburger-1"></span>
                                                                    <span class="hamburger bg-dark hamburger-2"></span>
                                                                    <span class="hamburger bg-dark hamburger-3"></span>
                                                                </label>
                                                                @if(auth()->user()->can('suppression-planification'))
                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('planification', item.id)" title="{{ __('customlang.supprimer') }}">
                                                                    <i class="flaticon2-trash"></i>
                                                                </button>
                                                                @endif
                                                                @if(auth()->user()->can('modification-planification'))
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('planification', item.id, 'null', 'datails_planification')" title="{{ __('customlang.modifier') }}">
                                                                    <i class="flaticon2-edit"></i>
                                                                </button>
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalDetaile('planification', item.id, 'null', 'datails_planification')" title="{{ __('customlang.details') }}">
                                                                    <i class="flaticon2-info"></i>
                                                                </button>
                                                                {{-- <button ng-if="!item.status" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event, 'projet', 1, item, {mode:2, title: 'Activer un projet'})">
                                                                <i class="fa fa-thumbs-up"></i>
                                                                </button>
                                                                <button ng-if="item.status" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event, 'projet', 0, item, {mode:2, title: 'Désactiver  un projet'})">
                                                                    <i class="fa fa-thumbs-down"></i>
                                                                </button> --}}
                                                                @endif
                                                            </div>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                            <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['planification'].totalItems" ng-model="paginations['planification'].currentPage" max-size="paginations['planification'].maxSize" items-per-page="paginations['planification'].entryLimit" ng-change="pageChanged('planification')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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

    <div class="tab-pane fade" id="page-tab-1" role="tabpanel" aria-labelledby="page-tab-1">
        <div class="">
            <div class="container tab-content" id="myTabContent">
                <div class="w-100">
                    <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                        <div class="titre-ch-p">
                            <div class="card-title d-flex align-self-center mb-0 me-3">
                                <span class="card-icon align-self-center">
                                    <span class="svg-icon svg-icon-primary">
                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-calendar.svg')) !!}
                                    </span>
                                </span>
                                <h3 class="card-label align-self-center mb-0 ms-2">
                                    Calendrier &nbsp;
                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class=" row">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-custom gutter-b mb-2 rounded-1">
                                <div class="card-body p-5">
                                    <div class="tab-content">
                                        <div class="table-responsive" id="calendar" style="overflow-x: auto;">
                                            <table class="table table-bordered table-striped table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center m-0 table-fixed w-" >

                                                <thead>
                                                    <!-- Entête principal -->
                                                    <tr class="bg-light">
                                                        <th colspan="7" class="p-4 position-relative">
                                                            <button class="btn btn-sm btn-outline-primary position-absolute start-0 top-50 translate-middle-y ms-3" ng-click="goToPreviousWeek()">
                                                                &larr;
                                                            </button>

                                                            <div>
                                                                <div class="h4 mb-0">@{{ monthLabel }}</div>
                                                                <div class="small text-muted">@{{ yearLabel }}</div>
                                                            </div>

                                                            <button class="btn btn-sm btn-outline-primary position-absolute end-0 top-50 translate-middle-y me-3" ng-click="goToNextWeek()">
                                                                &rarr;
                                                            </button>
                                                        </th>
                                                    </tr>


                                                    <!-- Entête secondaire -->
                                                    <tr class="bg-primary text-white">
                                                        <th class="col-2">Développeur</th>
                                                        <th ng-repeat="day in currentWeek">
                                                            @{{ day.label }} <br>
                                                            <small>@{{ day.date | date:'dd/MM' }} </small>
                                                        </th>
                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <tr class="border" ng-repeat="personnel in getUniquePersonnels(dataPage['planificationassignes'])">
                                                        <td class="text-start fw-bold">
                                                            @{{ personnel.nom + ' ' + personnel.prenom || '---' }}
                                                        </td>

                                                        <td ng-repeat="day in currentWeek" class="position-relative" style="height: 150px;">
                                                            <div class="h-100 d-flex flex-column justify-content-start align-items-start p-1 overflow-hidden" ng-click="showModalAdd('detail_palanification')" style="max-height: 140px;">

                                                                <div ng-repeat="item in dataPage['planificationassignes']"
                                                                    ng-if="item.personnel.id == personnel.id && isSameDay(item.day, day.date)"
                                                                    class="w-100 text-truncate"
                                                                    title="@{{ item.projet.nom }} - @{{ item.fonctionnalite_module.fonctionnalite.nom }} - @{{ item.tache_fonctionnalite.tache.nom }} - @{{ item.tag.nom }}">

                                                                    <div class="text-start small">
                                                                        <strong>@{{ item.projet.nom }}</strong><br>
                                                                        <span>*@{{ item.fonctionnalite_module.fonctionnalite.nom }} - @{{ item.tache_fonctionnalite.tache.nom }}</span>
                                                                        <span>@{{ item.tag.nom }}</span><br>
                                                                        <span>-------------------------------</span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
</div>
</div>