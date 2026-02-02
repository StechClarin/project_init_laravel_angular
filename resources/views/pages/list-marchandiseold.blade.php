<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
            @if(auth()->user()->can('liste-inventaire') || auth()->user()->can('creation-inventaire') || auth()->user()->can('suppression-inventaire') || auth()->user()->can('modification-inventaire'))
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-0" target="_self" ng-click="pageChanged('marchandise')">
                        <span class="nav-icon">
                            <span class="svg-icon">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-marchandise.svg')) !!}
                            </span>
                        </span>
                        <span class="nav-text">{{ __('customlang.marchandise')(s) }}</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->can('liste-inventaire') || auth()->user()->can('creation-inventaire') || auth()->user()->can('suppression-inventaire') || auth()->user()->can('modification-inventaire'))
                <li class="nav-item">
                    <a class="nav-link @if(!(auth()->user()->can('liste-inventaire') || auth()->user()->can('creation-inventaire') || auth()->user()->can('suppression-inventaire') || auth()->user()->can('modification-inventaire'))) active @endif" data-bs-toggle="tab" href="#page-tab-1" target="_self" ng-click="pageChanged('vehicule')">
                        <span class="nav-icon">
                            <span class="svg-icon">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-vehicule.svg')) !!}
                            </span>
                        </span>
                        <span class="nav-text">{{ __('customlang.vehicules') }}</span>
                    </a>
                </li>
            @endif
            </ul>
        </div>
    </div>
    <div class="">
        <div class="tab-content mt-5">
            {{--Marchandises--}}
            <div class="tab-pane fade show active" id="page-tab-0" role="tabpanel" aria-labelledby="page-tab-0">
                <div class="pb-5">
                    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                        <div class="d-flex align-items-center me-1">
                            <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                                <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                                    <div class="card-title d-flex align-self-center mb-0 me-3">
                                        <span class="card-icon align-self-center">
                                            <span class="svg-icon svg-icon-primary">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-nomenclaturedouaniere.svg')) !!}
                                            </span>
                                        </span>
                                        <h3 class="card-label align-self-center mb-0 ms-3">
                                            {{ __('customlang.marchandise')(s) }}
                                        </h3>
                                    </div>
                                </h2>
                                <span class="badge badge-light-primary">@{{paginations['marchandise'].totalItems | currency:"":0 | convertMontant}}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                @if(auth()->user()->can('creation-marchandise') || auth()->user()->can('modification-inventaire'))
                                    <a href="" class="btn btn-primary btn-fixed-height fw-bold px-2 px-lg-5 me-2" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-lg">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                        </span>
                                        <span class="d-none d-md-inline">{{ __('customlang.ajouter') }}</span>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        @if(auth()->user()->can('creation-inventaire'))
                                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('marchandise')">
                                                <a href="" class="menu-link px-3 py-2">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                        @if(auth()->user()->can('creation-inventaire') || auth()->user()->can('modification-inventaire'))
                                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('marchandise', {is_file_excel:true, title: '{{ __('customlang.marchandise')(s) }}'})">
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
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-xxl-12">
                                <div class="card card-custom mb-10 accordion accordion-solid accordion-panel accordion-svg-toggle cursor-pointer">
                                    <div class="card">
                                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#filtres-p0" aria-expanded="false" aria-controls="filtres-p0">
                                            <div class="card-title">
                                                <div class="card-label h3">
                                                    <span class="svg-icon">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                    </span>
                                                    {{__('customlang.filtres')}}
                                                </div>
                                            </div>
                                            <div class="card-toolbar">
                                                <span class="svg-icon">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div id="filtres-p0" class="card collapse">
                                            <div class="card-body">
                                                <form ng-submit="pageChanged('marchandise')">
                                                    <div class="form-row row animated fadeIn mt-4 ">
                                                        <div class="col-md-12 form-group">
                                                            <input type="text" class="form-control" id="search_list_marchandise" ng-model="search_list_marchandise" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('marchandise')">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="select2 form-control filter" id="type_marchandise_list_marchandise" style="width: 100%">
                                                                    <option value="">{{ __('customlang.type_de_marchandise') }}</option>
                                                                    <option ng-repeat="item in dataPage['typemarchandises']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="select2 form-control filter" id="nomenclature_douaniere_list_marchandise" style="width: 100%">
                                                                    <option value="">{{ __('customlang.nomenclatures_douanieres') }}</option>
                                                                    <option ng-repeat="item in dataPage['nomenclaturedouanieres']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-100 text-center pb-4">
                                                        <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('marchandise', {justWriteUrl : 'marchandises-pdf'})">
                                                            <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                            <i class="fa fa-file-pdf"></i>
                                                        </button>
                                                        <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('marchandise', {justWriteUrl : 'marchandises-excel'})">
                                                            <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                            <i class="fa fa-file-excel"></i>
                                                        </button>

                                                        <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                            <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                        <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('marchandise', true)">
                                                            <i class="fa fa-times"></i>
                                                            <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom gutter-b">
                                    <div class="card-body bg-dark-o-5 pt-10 pb-3">
                                        <div class="tab-content">
                                            <div class="table-responsive">
                                                <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                            <th style="min-width: 120px">{{__('customlang.reference')}}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.nomenclatures_douanieres') }}</th>
                                                            <th style="min-width: 120px">{{__('customlang.type_de_marchandise')}}</th>
                                                            @if(auth()->user()->can('suppression-inventaire') || auth()->user()->can('modification-inventaire') || auth()->user()->can('creation-inventaire'))
                                                                <th style="min-width: 100px">
                                                                    <i class="flaticon2-settings"></i>
                                                                </th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="" ng-repeat="item in dataPage['marchandises']">
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.reference}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.nomenclature_douaniere.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.type_marchandise.nom}}</span>
                                                            </td>

                                                            @if(auth()->user()->can('suppression-inventaire') || auth()->user()->can('modification-inventaire') || auth()->user()->can('creation-inventaire'))
                                                                <td class="pr-0 text-right">
                                                                    <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                            <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                            <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                            <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                        </label>
                                                                        @if(auth()->user()->can('suppression-inventaire'))
                                                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('marchandise', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                <i class="flaticon2-trash"></i>
                                                                            </button>
                                                                        @endif
                                                                        @if(auth()->user()->can('modification-inventaire'))
                                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('marchandise', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                <i class="flaticon2-edit"></i>
                                                                            </button>
                                                                        @endif
                                                                        @if(auth()->user()->can('creation-inventaire'))
                                                                            <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('marchandise',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
                                                                                <i class="fa fa-clone"></i>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer py-4 d-flex flex-lg-column bg-body">
                    <div class="container d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center me-3">
                            <span class="text-muted me-3 d-none d-md-inline">{{__('customlang.affichage_par')}}</span>
                            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['marchandise'].entryLimit" ng-change="pageChanged('marchandise')">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="d-flex flex-wrap">
                            <nav aria-label="...">
                                <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['marchandise'].totalItems" ng-model="paginations['marchandise'].currentPage" max-size="paginations['marchandise'].maxSize" items-per-page="paginations['marchandise'].entryLimit" ng-change="pageChanged('marchandise')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            {{--Vehicule--}}
            <div class="tab-pane fade" id="page-tab-1" role="tabpanel" aria-labelledby="page-tab-1">
                <div class="pb-5">
                    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                        <div class="d-flex align-items-center me-1">
                            <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                                <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                                    <div class="card-title d-flex align-self-center mb-0 me-3">
                                        <span class="card-icon align-self-center">
                                            <span class="svg-icon svg-icon-primary">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-vehicule.svg')) !!}
                                            </span>
                                        </span>
                                        <h3 class="card-label align-self-center mb-0 ms-3">
                                            {{ __('customlang.vehicules') }}
                                        </h3>
                                    </div>
                                    <span class="badge badge-light-primary">@{{paginations['vehicule'].totalItems | currency:"":0 | convertMontant}}</span>
                                </h2>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                @if(auth()->user()->can('creation-inventaire') || auth()->user()->can('modification-inventaire'))
                                    <a href="" class="btn btn-primary btn-fixed-height fw-bold px-2 px-lg-5 me-2" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-lg">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                        </span>
                                        <span class="d-none d-md-inline">{{ __('customlang.ajouter') }}</span>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        @if(auth()->user()->can('creation-inventaire'))
                                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('vehicule')">
                                                <a href="" class="menu-link px-3 py-2">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                        @if(auth()->user()->can('creation-inventaire') || auth()->user()->can('modification-inventaire'))
                                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('vehicule', {is_file_excel:true, title: '{{__('customlang.vehicules')}}'})">
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
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-xxl-12">
                                <div class="card card-custom mb-10 accordion accordion-solid accordion-panel accordion-svg-toggle cursor-pointer">
                                    <div class="card">
                                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#filtres-p2" aria-expanded="false" aria-controls="filtres-p2">
                                            <div class="card-title">
                                                <div class="card-label h3">
                                                    <span class="svg-icon me-2 ps-2">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                    </span>
                                                    {{__('customlang.filtres')}}
                                                </div>
                                            </div>
                                            <div class="card-toolbar">
                                                <span class="svg-icon">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div id="filtres-p2" class="card collapse">
                                            <div class="card-body">
                                                <form ng-submit="pageChanged('vehicule')">
                                                    <div class="form-row row animated fadeIn mt-4 ">
                                                        <div class="col-md-12 form-group">
                                                            <input type="text" class="form-control" id="search_list_vehicule" ng-model="search_list_vehicule" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('vehicule')">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="select2 form-control filter" id="marque_list_vehicule" style="width: 100%">
                                                                    <option value="">{{ __('customlang.marque') }}</option>
                                                                    <option ng-repeat="item in dataPage['marques']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="select2 form-control filter" id="nomenclature_douaniere_list_vehicule" style="width: 100%">
                                                                    <option value="">{{ __('customlang.nomenclatures_douanieres') }}</option>
                                                                    <option ng-repeat="item in dataPage['nomenclaturedouanieres']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="select2 form-control filter" id="energie_list_vehicule" style="width: 100%">
                                                                    <option value="">{{ __('customlang.energie') }}</option>
                                                                    <option ng-repeat="item in dataPage['energies']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="select2 form-control filter" id="modele_list_vehicule" style="width: 100%">
                                                                    <option value="">{{ __('customlang.modele') }}</option>
                                                                    <option ng-repeat="item in dataPage['modeles']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-100 text-center pb-4">
                                                        <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('vehicule', {justWriteUrl : 'vehicules-pdf'})">
                                                            <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                            <i class="fa fa-file-pdf"></i>
                                                        </button>
                                                        <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('vehicule', {justWriteUrl : 'vehicules-excel'})">
                                                            <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                            <i class="fa fa-file-excel"></i>
                                                        </button>

                                                        <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                            <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                        <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('vehicule', true)">
                                                            <i class="fa fa-times"></i>
                                                            <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom gutter-b">
                                    <div class="card-body bg-dark-o-5 pt-10 pb-3">
                                        <div class="tab-content">
                                            <div class="table-responsive">
                                                <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                            <th style="min-width: 120px">Imatriculation</th>
                                                            <th style="min-width: 120px">{{ __('customlang.marque') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.modele') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.energie') }}</th>
                                                            {{-- <th style="min-width: 120px">{{ __('customlang.type_de_marchandise') }}</th> --}}
                                                            <th style="min-width: 120px">{{ __('customlang.nomenclatures_douanieres') }}</th>
                                                            @if(auth()->user()->can('suppression-inventaire') || auth()->user()->can('modification-inventaire') || auth()->user()->can('creation-inventaire'))
                                                                <th style="min-width: 100px">
                                                                    <i class="flaticon2-settings"></i>
                                                                </th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="" ng-repeat="item in dataPage['vehicules']">
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.immatriculation}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.marque.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.modele.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.energie.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fw-bold">@{{item.nomenclature_douaniere.nom}}</span>
                                                            </td>
                                                            {{-- <td>
                                                                <span class="text-muted fw-bold">@{{item.nbre_marchandise}}</span>
                                                            </td> --}}
                                                            @if(auth()->user()->can('suppression-inventaire') || auth()->user()->can('modification-inventaire') || auth()->user()->can('creation-inventaire'))
                                                                <td class="pr-0 text-right">
                                                                    <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-d@{{ item.id }}">
                                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-d@{{ item.id }}">
                                                                            <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                            <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                            <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                        </label>
                                                                        @if(auth()->user()->can('suppression-inventaire'))
                                                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('vehicule', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                <i class="flaticon2-trash"></i>
                                                                            </button>
                                                                        @endif
                                                                        @if(auth()->user()->can('modification-inventaire'))
                                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('vehicule', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                <i class="flaticon2-edit"></i>
                                                                            </button>
                                                                        @endif
                                                                        @if(auth()->user()->can('creation-inventaire'))
                                                                            <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('vehicule',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
                                                                                <i class="fa fa-clone"></i>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer py-4 d-flex flex-lg-column bg-body">
                    <div class="container d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center me-3">
                            <span class="text-muted me-3 d-none d-md-inline">{{__('customlang.affichage_par')}}</span>
                            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['vehicule'].entryLimit" ng-change="pageChanged('vehicule')">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="d-flex flex-wrap">
                            <nav aria-label="...">
                                <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['vehicule'].totalItems" ng-model="paginations['vehicule'].currentPage" max-size="paginations['vehicule'].maxSize" items-per-page="paginations['vehicule'].entryLimit" ng-change="pageChanged('vehicule')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
