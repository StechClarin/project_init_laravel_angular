<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('rapportassistance')|| auth()->user()->can('creation-rapportassistance') || auth()->user()->can('modification-rapportassistance') )
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-0" target="_self" ng-click="pageChanged('rapportassistance');">
                        <span class="nav-icon">
                            <span class="svg-icon">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-rapportassistance.svg')) !!}
                            </span>
                        </span>
                        <span class="nav-text">
                            Rapport assistances
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#page-tab-1" target="_self" ng-click="manageTab(0);pageChanged('rapportemail');">
                        <span class="nav-icon">
                            <span class="svg-icon">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-email.svg')) !!}
                            </span>
                        </span>
                        <span class="nav-text">Email rapports</span>
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
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-rapportassistance.svg')) !!}
                                            </span>
                                        </span>
                                        <h3 class="card-label align-self-center mb-0 ms-2">
                                            Rapports assistance &nbsp;
                                        </h3>
                                        <span class="badge badge-primary p-3"> @{{paginations['rapportassistance'].totalItems | currency:"":0 | convertMontant}}</span>
                                    </div>
                                </div>
                                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                    @if(auth()->user()->can('creation-rapportassistance') || auth()->user()->can('modification-rapportassistance'))
                                    <a href="" class="menu-link bg-primary px-6 py-4 rounded-3" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
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
                                        @if(auth()->user()->can('creation-rapportassistance'))
                                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('rapportassistance')">
                                            <a href="" class="menu-link px-3 py-2">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                    </span>
                                                </span>
                                                <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('rapportassistance', {is_file_excel:true, title: 'rapports'})">
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
                                        @if(auth()->user()->can('creation-rapportassistance') || auth()->user()->can('modification-rapportassistance'))
                                        <div class="menu-item px-3 my-0" title="Télécharger un fichier excel modèle">
                                            <a href="rapportassistance.feuille" class="menu-link px-3 py-2">
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
                                    <div class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                                        <div class="card rounded-1">
                                            <div class="card-header p-5">
                                                <div class="card-label w-100 d-flex justify-content-between align-items-center cursor-pointer"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#filtres" aria-expanded="false"
                                                    aria-controls="filtresdossier">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="card-title">
                                                            <div class="card-label h3">
                                                                <span class="svg-icon ">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                                </span>
                                                                Filtres
                                                            </div>
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
                                                    <form ng-submit="pageChanged('rapportassistance')">
                                                        <div class="form-row row justify-content-center animated fadeIn mt-4">
                                                            <div class="col-md-12 form-group">
                                                                <select class="form-control select2 search_projet"
                                                                    id="projet_list_rapportassistance" placeholder="Projet">
                                                                </select>
                                                            </div>
                                                            <div class="form-row row animated fadeIn mt-delete">
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" class="form-control" id="search_list_rapportassistance"
                                                                        ng-model="search_list_rapportassistance"
                                                                        placeholder="Rechercher par libelle..."
                                                                        ng-model-options="{ debounce: 500 }"
                                                                        ng-change="pageChanged('rapportassistance')">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 form-group justify-content-center d-inline-flex">
                                                                <span cok_radioBtnStatus_rapportassistancelass="me-3 align-self-center text-muted fw-bold">Etat : &nbsp; </span>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="input-group">
                                                                        <div class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="ok_radioBtnStatus_list_rapportassistance" name="status"
                                                                                data-value=2 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="ok_radioBtnStatus_list_rapportassistance">Cloturé</label>
                                                                        </div>
                                                                        <div
                                                                            class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="en_attente_radioBtnStatus_list_rapportassistance" name="status"
                                                                                data-value=1 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="en_attente_radioBtnStatus_list_rapportassistance">En attente</label>
                                                                        </div>
                                                                        <div
                                                                            class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="en_cours_radioBtnStatus_list_rapportassistance" name="status"
                                                                                data-value=0 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="en_cours_radioBtnStatus_list_rapportassistance">En cours</label>
                                                                        </div>

                                                                        <div class="d-inline-block custom-control custom-radio">
                                                                            <input type="radio"
                                                                                id="all_radioBtnStatus_list_rapportassistance" name="status"
                                                                                data-value=""
                                                                                class="custom-control-input me-2 true"
                                                                                checked=""><label
                                                                                class="custom-control-label"
                                                                                for="all_radioBtnStatus_list_rapportassistance">Tout</label>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('rapportassistance', {justWriteUrl : 'rapportassistances-pdf'})">
                                                                <span class="d-md-block d-none pe-2 ps-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('rapportassistance', {justWriteUrl : 'rapportassistances-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}L</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>

                                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('rapportassistance', true)">
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
                                                    <!-- <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center"> -->
                                                    <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                        <thead>
                                                            <tr class="rounded-4 bg-primary text-white">
                                                                <!-- <th style="min-width: 120px"></th> -->
                                                                <th style="min-width: 120px">{{ __('customlang.date') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.libelle') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.projet') }}</th>
                                                                <!-- <th  style="min-width: 120px">{{ __('customlang.status') }}</th> -->
                                                                @if(auth()->user()->can('suppression-rapportassistance') || auth()->user()->can('modification-rapportassistance') || auth()->user()->can('creation-rapportassistance'))
                                                                <th style="min-width: 100px">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg')) !!}
                                                                </th>
                                                                @endif
                                                            </tr>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['rapportassistances']">
                                                                <!-- <td>
                                                                <input type="checkbox" value="item.id" name="rapportassistances[]" />
                                                            </td> -->
                                                                <td>
                                                                    <span class="text-muted ">@{{item.date_fr}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted ">@{{item.libelle}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-pill badge-light-primary" ng-repeat="projet in dataPage['projets']" ng-if="projet.id == item.projet_id">@{{projet.display_text}}</span>
                                                                </td>
                                                                <!-- <td>
                                                                <span class="border border-2 border-warning text-nowrap text-warning rounded fw-bold" ng-if="item.status == 0">NON</span>
                                                                <span class="border border-2 border-success text-nowrap text-success rounded fw-bold" ng-if="item.status == 2">OUI</span>
                                                            </td> -->
                                                                @if(auth()->user()->can('suppression-rapportassistance') || auth()->user()->can('modification-rapportassistance') || auth()->user()->can('creation-rapportassistance'))
                                                                <td class="pr-0 text-right">
                                                                    <div class="menu-leftToRight d-flex align-items-center bg-grey justify-content-center">
                                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                                            <span class="hamburger bg-dark hamburger-1"></span>
                                                                            <span class="hamburger bg-dark hamburger-2"></span>
                                                                            <span class="hamburger bg-dark hamburger-3"></span>
                                                                        </label>
                                                                        @if(auth()->user()->can('suppression-rapportassistance'))
                                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('rapportassistance', item.id)" title="{{__('customlang.supprimer')}}">
                                                                            <i class="flaticon2-trash"></i>
                                                                        </button>
                                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('rapportassistance', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                            <i class="flaticon2-edit"></i>
                                                                        </button>
                                                                        @endif
                                                                        @if(auth()->user()->can('creation-rapportassistance'))
                                                                        <!-- <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalDetails('rapportassistance',item.id)" title="{{ __('customlang.envoie') }}">
                                                                            <i class="fas fa-exclamation-circle"></i>
                                                                        </button> -->
                                                                        <a target="_blank" class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" href="generate-rapportassistances-pdf/@{{item.id}}" title=“PDF”>
                                                                            <i class="fa fa-file-pdf"></i>
                                                                        </a>
                                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('envoiemail', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                            <i class="fa fa-envelope"></i>
                                                                        </button>
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
                                        <div class="container d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex align-items-center me-3">
                                                <span class="text-muted me-3 d-none d-md-inline">Affichage par</span>
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                    style="width: 75px;" ng-model="paginations['rapportassistance'].entryLimit"
                                                    ng-change="pageChanged('rapportassistance')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-end justify-content-center mt-1" uib-pagination
                                                        total-items="paginations['rapportassistance'].totalItems"
                                                        ng-model="paginations['rapportassistance'].currentPage"
                                                        max-size="paginations['rapportassistance'].maxSize"
                                                        items-per-page="paginations['rapportassistance'].entryLimit"
                                                        ng-change="pageChanged('rapportassistance')" previous-text="‹" next-text="›" first-text="«"
                                                        last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-rapportassistance.svg')) !!}
                                            </span>
                                        </span>
                                        <h3 class="card-label align-self-center mb-0 ms-2">
                                            Emails rapport &nbsp;
                                        </h3>
                                        <span class="badge badge-primary p-3"> @{{paginations['rapportemail'].totalItems | currency:"":0 | convertMontant}}</span>
                                    </div>
                                </div>
                                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" ng-click="showModalAdd('envoiemail')" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                    @if(auth()->user()->can('creation-rapportassistance') || auth()->user()->can('modification-rapportassistance'))
                                    <a href="" class="menu-link bg-primary px-6 py-4 rounded-3" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
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
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xxl-12">
                                    <div class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                                        <div class="card rounded-1">
                                            <div class="card-header p-5">
                                                <div class="card-label w-100 d-flex justify-content-between align-items-center cursor-pointer"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#filtres" aria-expanded="false"
                                                    aria-controls="filtresdossier">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="card-title">
                                                            <div class="card-label h3">
                                                                <span class="svg-icon ">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                                </span>
                                                                Filtres
                                                            </div>
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
                                                    <form ng-submit="pageChanged('rapportemail')">
                                                        <div class="form-row row justify-content-center animated fadeIn mt-4">
                                                            <div class="col-md-6 form-group">
                                                                <select class="form-control select2 search_projet"
                                                                    id="projet_list_rapportemail" placeholder="Projet">
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <select class="form-control select2 search_client"
                                                                    id="client_list_rapportemail" placeholder="Destinataire">
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 form-group">
                                                                <input class="form-control" id="objet_list_rapportemail" type="text" placeholder="Objet" />
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('rapportassistance', {justWriteUrl : 'rapportassistances-pdf'})">
                                                                <span class="d-md-block d-none pe-2 ps-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('rapportassistance', {justWriteUrl : 'rapportassistances-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}L</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>

                                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('rapportassistance', true)">
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
                                                    <!-- <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center"> -->
                                                    <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                        <thead>
                                                            <tr class="rounded-4 bg-primary text-white">
                                                                <!-- <th style="min-width: 120px"></th> -->
                                                                <th style="min-width: 120px">{{ __('customlang.date_fr') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.client') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.objet') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.file') }}</th>
                                                                <!-- <th  style="min-width: 120px">{{ __('customlang.status') }}</th> -->
                                                                @if(auth()->user()->can('suppression-rapportassistance') || auth()->user()->can('modification-rapportassistance') || auth()->user()->can('creation-rapportassistance'))
                                                                <th style="min-width: 100px">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg')) !!}
                                                                </th>
                                                                @endif
                                                            </tr>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['rapportemails']">
                                                                <!-- <td>
                                                                <input type="checkbox" value="item.id" name="rapportassistances[]" />
                                                            </td> -->
                                                                <td>
                                                                    <span class="text-muted ">@{{item.date_fr}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted ">@{{item.client.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted ">@{{item.objet}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted ">@{{item.file}}</span>
                                                                </td>
                                                                @if(auth()->user()->can('suppression-rapportassistance') || auth()->user()->can('modification-rapportassistance') || auth()->user()->can('creation-rapportassistance'))
                                                                <td class="pr-0 text-right">
                                                                    <div class="menu-leftToRight d-flex align-items-center bg-grey justify-content-center">
                                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                                            <span class="hamburger bg-dark hamburger-1"></span>
                                                                            <span class="hamburger bg-dark hamburger-2"></span>
                                                                            <span class="hamburger bg-dark hamburger-3"></span>
                                                                        </label>
                                                                        @if(auth()->user()->can('suppression-rapportassistance'))
                                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('rapportassistance', item.id)" title="{{__('customlang.supprimer')}}">
                                                                            <i class="flaticon2-trash"></i>
                                                                        </button>
                                                                        @endif
                                                                        @if(auth()->user()->can('creation-rapportassistance'))
                                                                        <!-- <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalDetails('rapportassistance',item.id)" title="{{ __('customlang.envoie') }}">
                                                                            <i class="fas fa-exclamation-circle"></i>
                                                                        </button> -->
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
                                        <div class="container d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex align-items-center me-3">
                                                <span class="text-muted me-3 d-none d-md-inline">Affichage par</span>
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                    style="width: 75px;" ng-model="paginations['rapportassistance'].entryLimit"
                                                    ng-change="pageChanged('rapportassistance')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-end justify-content-center mt-1" uib-pagination
                                                        total-items="paginations['rapportassistance'].totalItems"
                                                        ng-model="paginations['rapportassistance'].currentPage"
                                                        max-size="paginations['rapportassistance'].maxSize"
                                                        items-per-page="paginations['rapportassistance'].entryLimit"
                                                        ng-change="pageChanged('rapportassistance')" previous-text="‹" next-text="›" first-text="«"
                                                        last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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
    </div>
</div>