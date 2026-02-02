<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('liste-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-0" target="_self" ng-click="pageChanged('nomenclaturedouaniere');getElements('chapitrenomenclaturedouanieres');getElements('souschapitrenomenclaturedouanieres');">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-nomenclaturedouaniere.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">
                                {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#page-tab-1" target="_self" ng-click="getElements('maxdepths');manageTab(0);pageChanged('chapitrenomenclaturedouaniere');">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-chapitrenomenclaturedouaniere.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">Chapitres</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="">
        <div class="tab-content">
            {{-- Liste des taxes douanières --}}
            <div class="tab-pane fade show active" id="page-tab-0" role="tabpanel" aria-labelledby="page-tab-0">
                <div class="container">
                    <div class="d-flex flex-column-fluid p-0">
                        <div class="w-100">
                            <div class="row">
                                <div class="col-lg-12 col-xxl-12">
                                    <div class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle">
                                        <div class="card rounded-1">
                                            <div class="card-header p-5">
                                                <div class="card-title">
                                                    <div class="card-label h3">
                                                        <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                        </span>
                
                                                        {{__('customlang.filtres')}}
                
                                                        <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtres-p0" aria-expanded="false" aria-controls="filtres-p0">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="m-auto d-inline-flex page-head-title">
                                                    <h4 class="card-label align-self-center m-auto position-relative">
                                                        {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                                                        <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['nomenclaturedouaniere'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                                    </h4>
                                                </div>
                                                <div class="card-toolbar">
                                                    <div class="dropdown dropdown-inline" ng-click="showModalAdd('nomenclaturedouaniere')" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                        @if(auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                                                            <a href="" class="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                                <span class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                                </span>
                                                            </a>
                                                            <div class="d-none menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                                @if(auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('nomenclaturedouaniere')">
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
                                                                {{-- @if(auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('nomenclaturedouaniere', {is_file_excel:true, title: '{{ __('customlang.nomenclatures_client') }}'})">
                                                                        <a href="" class="menu-link px-3 py-2">
                                                                            <span class="menu-icon" data-kt-element="icon">
                                                                                <span class="svg-icon svg-icon-3">
                                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-excel.svg')) !!}
                                                                                </span>
                                                                            </span>
                                                                            <span class="menu-title">{{ __('customlang.fichier_excel') }}</span>
                                                                        </a>
                                                                    </div>
                                                                @endif --}}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="filtres-p0" class="card collapse">
                                                <div class="card-body">
                                                    <form ng-submit="pageChanged('nomenclaturedouaniere')">
                                                        <div class="row  form-row animated fadeIn mt-4">
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" class="form-control" id="search_list_nomenclaturedouaniere" ng-model="search_list_nomenclaturedouaniere" placeholder="{{ __('customlang.rechercher_par_nom_code') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('nomenclaturedouaniere')">
                                                            </div>
                                                            <div class="col-md-6 d-none">
                                                                <div class="form-group">
                                                                    <select class="form-control select2 filter" id="chapitre_nomenclature_douaniere_list_nomenclaturedouaniere">
                                                                        <option value="">Chapitre</option>
                                                                        <option ng-repeat="item in dataPage['chapitrenomenclaturedouanieres']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <select class="form-control select2 filter" id="sous_chapitre_nomenclature_douaniere_list_nomenclaturedouaniere">
                                                                        <option value="">Chapitre(s)</option>
                                                                        {{-- <option ng-repeat="item in dataPage['souschapitrenomenclaturedouanieres']" value="@{{ item.id }}"> @{{ item.nom }}</option> --}}
                                                                        <option ng-repeat="item in dataPage['chapitrenomenclaturedouanieres2']" value="@{{ item.id }}"> @{{ item.all_name_parent }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('nomenclaturedouaniere', {justWriteUrl : 'nomenclaturedouanieres-pdf'})">
                                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('nomenclaturedouaniere', {justWriteUrl : 'nomenclaturedouanieres-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>
    
                                                            <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('nomenclaturedouaniere', true)">
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
                                                    <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-redevise text-center">
                                                        <thead>
                                                            <tr>
                                                                <th style="min-width: 100px">{{ __('customlang.code') }}</th>
                                                                <th style="min-width: 300px">{{ __('customlang.nom') }}</th>
                                                                <th style="min-width: 400px">Chapitre(s)</th>
                                                                <th style="min-width: 120px">{{ __('customlang.unite_de_mesure') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.valeur_mercurial') }}</th>
                                                                <th style="min-width: 120px">Origine FR</th>
                                                                <th style="min-width: 120px">Export</th>
                                                                <th style="min-width: 120px">Remise</th>
                                                                <th style="min-width: 120px">{{ __('customlang.qte_complementaire') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.taxes_douanieres') }}</th>
                                                                @if(auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                    <th style="min-width: 100px">
                                                                        <i class="flaticon2-settings"></i>
                                                                    </th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['nomenclaturedouanieres']">
                                                                <td>
                                                                    <span class="text-muted fw-bold badge" style="background: @{{item.couleur}}">@{{item.code}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="text-muted fw-bold text-uppercase" ng-repeat="ssitem in item.chapitres_reverse">
                                                                        <span style="display:normal !important ;flex-wrap: wrap;width:400px" class="fsize-10 bg-light-primary text-primary p-1 rounded-1">@{{ssitem.nom}}</span>
                                                                        <span ng-if="($index + 1) !== item.chapitres.length">
                                                                            <br><i class="fa fa-arrow-down"></i>
                                                                            <br>
                                                                        </span> 
                                                                    </div>
                                                                </td>
                                                                {{-- <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.chapitre_nomenclature_douaniere.nom}}</span>
                                                                </td> --}}
                                                                <td>
                                                                    <span class="text-muted fw-bold text-capitalize badge badge-pill badge-warning">@{{item.unite_mesure.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.valeur_mercurial}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.originefr}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.export}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.remise}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-pill badge-success" ng-if ="item.qte_complementaire">{{__('customlang.oui')}}</span>
                                                                    <span class="badge badge-pill badge-danger" ng-if ="!item.qte_complementaire">{{__('customlang.non')}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold text-uppercase" ng-repeat="ssitem in item.details">
                                                                        <span class="badge badge-pill badge-light-primary">@{{ssitem.nom}}</i>
                                                                    </span>
                                                                </td>
                                                                @if(auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                    <td class="pr-0 text-right">
                                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                            </label>
                                                                            @if(auth()->user()->can('suppression-nomenclaturedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm"  ng-if="!item.desactiver" ng-click="deleteElement('nomenclaturedouaniere', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                    <i class="flaticon2-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('modification-nomenclaturedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm"  ng-click="showModalUpdate('nomenclaturedouaniere', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                    <i class="flaticon2-edit"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('nomenclaturedouaniere',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                    <div class="card p-5 rounded-1">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex align-items-center me-3">
                                                <span class="text-muted me-3 d-none d-md-inline">{{__('customlang.affichage_par')}}</span>
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['nomenclaturedouaniere'].entryLimit" ng-change="pageChanged('nomenclaturedouaniere')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['nomenclaturedouaniere'].totalItems" ng-model="paginations['nomenclaturedouaniere'].currentPage" max-size="paginations['nomenclaturedouaniere'].maxSize" items-per-page="paginations['nomenclaturedouaniere'].entryLimit" ng-change="pageChanged('nomenclaturedouaniere')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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

            {{-- Liste des familles des taxes douanieres --}}
            <div class="tab-pane fade" id="page-tab-1" role="tabpanel" aria-labelledby="page-tab-1">
                <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
                    <input type="hidden" id="depth_list_chapitrenomenclaturedouaniere">
                    <ul class="nav nav-tabs nav-tabs-line-2x mt-4" ng-repeat="item in maxDepths">
                        @if(auth()->user()->can('liste-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                            <li class="nav-item">
                                <a class="nav-link" ng-class="{'active' : item === maxDepths[0] }" data-bs-toggle="tab" id="onglet-chapitre-@{{$index}}" href="#page-tab-1-0-@{{$index}}" target="_self" depth=@{{item}} maxdepth=@{{maxDepths.length}} ng-click="manageTab($index);pageChanged('chapitrenomenclaturedouaniere');">
                                    <span class="nav-icon">
                                        <span class="svg-icon">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-chapitrenomenclaturedouaniere.svg')) !!}
                                        </span>
                                    </span>
                                    <span class="nav-text">
                                        Chapitres <span class="badge badge-pill badge-light-primary">@{{item}}</span> 
                                    </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <ul class="nav nav-tabs nav-tabs-line-2x mt-4 d-none">
                        @if(auth()->user()->can('liste-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-1-0" target="_self" ng-click="pageChanged('chapitrenomenclaturedouaniere');">
                                    <span class="nav-icon">
                                        <span class="svg-icon">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-chapitrenomenclaturedouaniere.svg')) !!}
                                        </span>
                                    </span>
                                    <span class="nav-text">
                                        Chapitres
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#page-tab-1-1" target="_self" ng-click="pageChanged('souschapitrenomenclaturedouaniere');getElements('chapitrenomenclaturedouanieres');">
                                    <span class="nav-icon">
                                        <span class="svg-icon">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-souschapitrenomenclaturedouaniere.svg')) !!}
                                        </span>
                                    </span>
                                    <span class="nav-text">Sous-chapitres</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="tab-content mt-5">
                    <div class="tab-pane fade show active" id="page-tab-1-0-@{{$index}}" role="tabpanel" aria-labelledby="page-tab-1-0">
                        <div class="container">
                            <div class="d-flex flex-column-fluid p-0">
                                <div class="w-100">
                                    <div class="row">
                                        <div class="col-lg-12 col-xxl-12">
                                            <div class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle">
                                                <div class="card rounded-1">
                                                    <div class="card-header p-5">
                                                        <div class="card-title">
                                                            <div class="card-label h3">
                                                                <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                                </span>
                        
                                                                {{__('customlang.filtres')}}
                        
                                                                <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtres-p2" aria-expanded="false" aria-controls="filtres-p2">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="m-auto d-inline-flex page-head-title">
                                                            <h4 class="card-label align-self-center m-auto position-relative">
                                                                Chapitres
                                                                <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['chapitrenomenclaturedouaniere'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                                            </h4>
                                                        </div>
                                                        <div class="card-toolbar">
                                                            <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                                @if(auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                                                                    <a href="" class="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                                        <span class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                                        </span>
                                                                    </a>
                                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                                        @if(auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('chapitrenomenclaturedouaniere')">
                                                                                <a href="" class="menu-link px-3 py-2">
                                                                                    <span class="menu-icon" data-kt-element="icon">
                                                                                        <span class="svg-icon svg-icon-3">
                                                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                                                        </span>
                                                                                    </span>
                                                                                </a>
                                                                            </div>
                                                                        @endif
                                                                        @if(auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                                                                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('chapitrenomenclaturedouaniere', {is_file_excel:true, title: 'Chapitres nomenclatures douanières'})">
                                                                                <a href="" class="menu-link px-3 py-2">
                                                                                    <span class="menu-icon" data-kt-element="icon">
                                                                                        <span class="svg-icon svg-icon-3">
                                                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-excel.svg')) !!}
                                                                                        </span>
                                                                                    </span>
                                                                                    <span class="menu-title">{{ __('customlang.fichier_excel') }}</span>
                                                                                </a>
                                                                            </div>
                                                                            <div class="menu-item px-3 my-0" title="Télécharger un fichier excel modèle">
                                                                                <a href="chapitrenomenclaturedouaniere.feuille" class="menu-link px-3 py-2">
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
                                                    </div>
                                                    <div id="filtres-p2" class="card collapse">
                                                        <div class="card-body">
                                                            <form ng-submit="pageChanged('chapitrenomenclaturedouaniere')">
                                                                <div class="form-row animated fadeIn mt-4">
                                                                    <div class="col-md-12 form-group">
                                                                        <input type="text" class="form-control" id="search_list_chapitrenomenclaturedouaniere" ng-model="search_list_chapitrenomenclaturedouaniere" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('chapitrenomenclaturedouaniere')">
                                                                    </div>
                                                                </div>
                                                                <div class="w-100 text-center pb-4">
                                                                    <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('chapitrenomenclaturedouaniere', {justWriteUrl : 'chapitrenomenclaturedouanieres-pdf'})">
                                                                        <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                        <i class="fa fa-file-pdf"></i>
                                                                    </button>
                                                                    <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('chapitrenomenclaturedouaniere', {justWriteUrl : 'chapitrenomenclaturedouanieres-excel'})">
                                                                        <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                        <i class="fa fa-file-excel"></i>
                                                                    </button>
    
                                                                    <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                        <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                    <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('chapitrenomenclaturedouaniere', false); manageTab(currentTab); pageChanged('chapitrenomenclaturedouaniere');">
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
                                                            <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-redevise text-center">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="min-width: 120px">{{ __('customlang.code') }}</th>
                                                                        <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                                        <th style="min-width: 120px">Nbre de nomenclature douaniere</th>
                                                                        @if(auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                            <th style="min-width: 100px">
                                                                                <i class="flaticon2-settings"></i>
                                                                            </th>
                                                                        @endif
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="" ng-repeat="item in dataPage['chapitrenomenclaturedouanieres']">
                                                                        <td>
                                                                            <span class="text-muted fw-bold">@{{item.code}}</span><br>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-muted fw-bold text-uppercase" ng-repeat="ssitem in item.parents_reverse">
                                                                                <span style="display:normal !important ;flex-wrap: wrap;width:400px" class="fsize-10 bg-light-primary text-primary p-1 rounded-1">@{{ssitem.nom}}</span>
                                                                                <span ng-if="($index + 1) !== item.parents_reverse.length">
                                                                                    <br><i class="fa fa-arrow-down"></i>
                                                                                    <br>
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-muted fw-bold">@{{item.nbre_nomenclaturedouaniere}}</span>
                                                                        </td>
                                                                        @if(auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                            <td class="pr-0 text-right">
                                                                                <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                                    <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-chapitrenomenclaturedouaniere@{{ item.id }}">
                                                                                    <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-chapitrenomenclaturedouaniere@{{ item.id }}">
                                                                                        <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                        <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                        <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                                    </label>
                                                                                    @if(auth()->user()->can('suppression-nomenclaturedouaniere'))
                                                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('chapitrenomenclaturedouaniere', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                            <i class="flaticon2-trash"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                    @if(auth()->user()->can('modification-nomenclaturedouaniere'))
                                                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('chapitrenomenclaturedouaniere', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                            <i class="flaticon2-edit"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                    @if(auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                                        <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('chapitrenomenclaturedouaniere',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                            <div class="card p-5 rounded-1">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="d-flex align-items-center me-3">
                                                        <span class="text-muted me-3 d-none d-md-inline">{{__('customlang.affichage_par')}}</span>
                                                        <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['chapitrenomenclaturedouaniere'].entryLimit" ng-change="pageChanged('chapitrenomenclaturedouaniere')">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <nav aria-label="...">
                                                            <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['chapitrenomenclaturedouaniere'].totalItems" ng-model="paginations['chapitrenomenclaturedouaniere'].currentPage" max-size="paginations['chapitrenomenclaturedouaniere'].maxSize" items-per-page="paginations['chapitrenomenclaturedouaniere'].entryLimit" ng-change="pageChanged('chapitrenomenclaturedouaniere')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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
                    <div class="tab-pane fade" id="page-tab-1-1" role="tabpanel" aria-labelledby="page-tab-1-1">
                        <div class="pb-5">
                            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                <div class="d-flex align-items-center me-1">
                                    <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                                        <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                                            <div class="card-title d-flex align-self-center mb-0 me-3">
                                                <span class="card-icon align-self-center">
                                                    <span class="svg-icon svg-icon-primary">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-souschapitrenomenclaturedouaniere.svg')) !!}
                                                    </span>
                                                </span>
                                                <h3 class="card-label align-self-center mb-0 ms-3">
                                                    Sous-Chapitres
                                                </h3>
                                            </div>
                                            <span class="badge badge-light-primary">@{{paginations['souschapitrenomenclaturedouaniere'].totalItems | currency:"":0 | convertMontant}}</span>
                                        </h2>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                        @if(auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                                            <a href="" class="btn btn-primary btn-fixed-height fw-bold px-2 px-lg-5 me-2" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                <span class="svg-icon svg-icon-lg">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                </span>
                                                <span class="d-none d-md-inline">{{ __('customlang.ajouter') }}</span>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                @if(auth()->user()->can('creation-nomenclaturedouaniere'))
                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('souschapitrenomenclaturedouaniere')">
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
                                                @if(auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('souschapitrenomenclaturedouaniere', {is_file_excel:true, title: 'Sous-chapitres nomenclatures douanières'})">
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
                                                <div class="card-header" data-bs-toggle="collapse" data-bs-target="#filtres-p3" aria-expanded="false" aria-controls="filtres-p3">
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
                                                <div id="filtres-p3" class="card collapse">
                                                    <div class="card-body">
                                                        <form ng-submit="pageChanged('souschapitrenomenclaturedouaniere')">
                                                            <div class="form-row row animated fadeIn mt-4">
                                                                <div class="col-md-6 form-group">
                                                                    <input type="text" class="form-control" id="search_list_souschapitrenomenclaturedouaniere" ng-model="search_list_souschapitrenomenclaturedouaniere" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('souschapitrenomenclaturedouaniere')">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <select class="form-control select2 filter" id="chapitre_nomenclature_douaniere_list_souschapitrenomenclaturedouaniere">
                                                                            <option value="">Chapitre</option>
                                                                            <option ng-repeat="item in dataPage['chapitrenomenclaturedouanieres']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="w-100 text-center pb-4">
                                                                <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('souschapitrenomenclaturedouaniere', {justWriteUrl : 'souschapitrenomenclaturedouanieres-pdf'})">
                                                                    <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                    <i class="fa fa-file-pdf"></i>
                                                                </button>
                                                                <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('souschapitrenomenclaturedouaniere', {justWriteUrl : 'souschapitrenomenclaturedouanieres-excel'})">
                                                                    <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                    <i class="fa fa-file-excel"></i>
                                                                </button>

                                                                <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                    <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                                <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('souschapitrenomenclaturedouaniere', true)">
                                                                    <i class="fa fa-times"></i>
                                                                    <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-custom gutter-b" style="margin-bottom:7rem !important">
                                            <div class="card-body bg-dark-o-5 pt-10 pb-3">
                                                <div class="tab-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 120px">{{ __('customlang.code') }}</th>
                                                                    <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                                    <th style="min-width: 120px">Nbre de nomenclature douaniere</th>
                                                                    <th style="min-width: 120px">Chapitre</th>
                                                                    @if(auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                        <th style="min-width: 100px">
                                                                            <i class="flaticon2-settings"></i>
                                                                        </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="" ng-repeat="item in dataPage['souschapitrenomenclaturedouanieres']">
                                                                    <td>
                                                                        <span class="text-muted fw-bold">@{{item.code}}</span><br>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-muted fw-bold">@{{item.nom}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-muted fw-bold">@{{item.nbre_nomenclaturedouaniere}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-muted fw-bold">@{{item.chapitre_nomenclature_douaniere.nom}}</span>
                                                                    </td>
                                                                    @if(auth()->user()->can('suppression-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere') || auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                        <td class="pr-0 text-right">
                                                                            <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-souschapitrenomenclaturedouaniere@{{ item.id }}">
                                                                                <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-souschapitrenomenclaturedouaniere@{{ item.id }}">
                                                                                    <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                    <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                    <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                                </label>
                                                                                @if(auth()->user()->can('suppression-nomenclaturedouaniere'))
                                                                                    <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('souschapitrenomenclaturedouaniere', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                        <i class="flaticon2-trash"></i>
                                                                                    </button>
                                                                                @endif
                                                                                @if(auth()->user()->can('modification-nomenclaturedouaniere'))
                                                                                    <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('souschapitrenomenclaturedouaniere', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                        <i class="flaticon2-edit"></i>
                                                                                    </button>
                                                                                @endif
                                                                                @if(auth()->user()->can('creation-nomenclaturedouaniere'))
                                                                                    <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('souschapitrenomenclaturedouaniere',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                    <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['souschapitrenomenclaturedouaniere'].entryLimit" ng-change="pageChanged('souschapitrenomenclaturedouaniere')">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <nav aria-label="...">
                                        <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['souschapitrenomenclaturedouaniere'].totalItems" ng-model="paginations['souschapitrenomenclaturedouaniere'].currentPage" max-size="paginations['souschapitrenomenclaturedouaniere'].maxSize" items-per-page="paginations['souschapitrenomenclaturedouaniere'].entryLimit" ng-change="pageChanged('souschapitrenomenclaturedouaniere')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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
