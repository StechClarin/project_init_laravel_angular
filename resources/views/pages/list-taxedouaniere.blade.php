<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('liste-taxedouaniere') || auth()->user()->can('creation-taxedouaniere') || auth()->user()->can('suppression-taxedouaniere') || auth()->user()->can('modification-taxedouaniere'))
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#page-taxedouaniere-0" target="_self" ng-click="pageChanged('taxedouaniere')">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-taxedouaniere.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">
                                {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#page-taxedouaniere-1" target="_self" ng-click="pageChanged('familletaxedouaniere')">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-familletaxedouaniere.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">Familles des taxes douanières</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="">
        <div class="tab-content">
            {{-- Liste des taxes douanières --}}
            <div class="tab-pane fade show active" id="page-taxedouaniere-0" role="tabpanel" aria-labelledby="page-taxedouaniere-0">
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
                                                        <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['taxedouaniere'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                                    </h4>
                                                </div>
                                                <div class="card-toolbar">
                                                    <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                        @if(auth()->user()->can('creation-taxedouaniere') || auth()->user()->can('modification-taxedouaniere'))
                                                            <a href="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                                <span class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                                </span>
                                                            </a>
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                                @if(auth()->user()->can('creation-taxedouaniere'))
                                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('taxedouaniere')">
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
                                                                @if(auth()->user()->can('creation-taxedouaniere') || auth()->user()->can('modification-taxedouaniere'))
                                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('taxedouaniere', {is_file_excel:true, title: 'Taxes douanières'})">
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
                                                                        <a href="taxedouaniere.feuille" class="menu-link px-3 py-2">
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
                                            <div id="filtres-p0" class="card collapse">
                                                <div class="card-body">
                                                    <form ng-submit="pageChanged('taxedouaniere')">
                                                        <div class="form-row animated fadeIn mt-4">
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" class="form-control" id="search_list_taxedouaniere" ng-model="search_list_taxedouaniere" placeholder="{{ __('customlang.rechercher_par_nom_code') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('taxedouaniere')">
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('taxedouaniere', {justWriteUrl : 'taxedouanieres-pdf'})">
                                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('taxedouaniere', {justWriteUrl : 'taxedouanieres-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>
    
                                                            <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('taxedouaniere', true)">
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
                                                                @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                    <th style="width: 50px">
                                                                        <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid" for="taxedouaniere_all_selected">
                                                                            <input class="form-check-input mycheck_all_taxedouaniere" type="checkbox" id="taxedouaniere_all_selected" name="taxedouaniere_all" ng-click="checkAllOruncheckAll('#taxedouaniere_all_selected', null, null, 'mychecktaxedouaniere', {tagInput: 'taxedouaniere_selected', scopeName: 'itemIds', attrName: 'data-item-id', className: 'mychecktaxedouaniere', btnAllId: 'taxedouaniere_all_selected'})">
                                                                            <span class="form-check-label text-muted"></span>
                                                                        </label>
                                                                    </th>
                                                                @endif
                                                                <th style="min-width: 120px">{{ __('customlang.code') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.taux') }} (%)</th>
                                                                <th style="min-width: 120px">Famille taxe douanière</th>
                                                                <th style="min-width: 120px">{{ __('customlang.taxes_douanieres') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.comptant') }}</th>
                                                                @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                    <th style="min-width: 100px" class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                                        <i class="flaticon2-settings" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"></i>
                                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                                            @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                                <div class="menu-item px-3 my-0" ng-click="deleteElement('taxedouaniere', itemIds)" title="{{__('customlang.supprimer')}}">
                                                                                    <a href="" class="menu-link px-3 py-2">
                                                                                        <span class="menu-icon" data-kt-element="icon">
                                                                                        <i class="flaticon2-trash"></i>
                                                                                        </span>
                                                                                        <span class="menu-title">SUPPRIMER</span>
                                                                                    </a>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['taxedouanieres']">
                                                                @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                    <td class="align-middle text-capitalize">
                                                                        <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid" for="taxedouaniere_all_selected">
                                                                            <input class="form-check-input mychecktaxedouaniere" type="checkbox" id="taxedouaniere_selected_@{{$index}}" data-item-id="@{{item.id}}" ng-click="addToRole($event, item.id, {tagInput: 'taxedouaniere_selected', scopeName: 'itemIds', attrName: 'data-item-id', className: 'mychecktaxedouaniere', btnAllId: 'taxedouaniere_all_selected'})" ng-checked="isInArrayData($event, item.id, null, 'taxedouaniere', 'itemIds')">
                                                                            <span class="form-check-label text-muted"></span>
                                                                        </label>
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.code}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize">@{{item.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize">@{{item.taux}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.famille_taxe_douaniere.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold text-uppercase" ng-repeat="ssitem in item.details">
                                                                        <span class="badge badge-pill badge-light-primary">@{{ssitem.nom}}</span>
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-pill badge-success" ng-if ="item.comptant">{{__('customlang.oui')}}</span>
                                                                    <span class="badge badge-pill badge-danger" ng-if ="!item.comptant">{{__('customlang.non')}}</span>
                                                                </td>
                                                                @if(auth()->user()->can('suppression-taxedouaniere') || auth()->user()->can('modification-taxedouaniere') || auth()->user()->can('creation-taxedouaniere'))
                                                                    <td class="pr-0 text-right">
                                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                            </label>
                                                                            @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm"  ng-if="!item.desactiver" ng-click="deleteElement('taxedouaniere', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                    <i class="flaticon2-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('modification-taxedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm"  ng-click="showModalUpdate('taxedouaniere', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                    <i class="flaticon2-edit"></i>
                                                                                </button>
                                                                                <button ng-if="!item.comptant" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event, 'taxedouaniere', 1, item, {mode:2, title: 'Activer la notion \'Comptant\' ?'})">
                                                                                    <i class="fa fa-thumbs-up"></i>
                                                                                </button>
                                                                                <button ng-if="item.comptant" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event, 'taxedouaniere', 0, item, {mode:2, title: 'Désactiver la notion \'Comptant\' ?'})">
                                                                                    <i class="fa fa-thumbs-down"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('creation-taxedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('taxedouaniere',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['taxedouaniere'].entryLimit" ng-change="pageChanged('taxedouaniere')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['taxedouaniere'].totalItems" ng-model="paginations['taxedouaniere'].currentPage" max-size="paginations['taxedouaniere'].maxSize" items-per-page="paginations['taxedouaniere'].entryLimit" ng-change="pageChanged('taxedouaniere')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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
            <div class="tab-pane fade" id="page-taxedouaniere-1" role="tabpanel" aria-labelledby="page-taxedouaniere-1">
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
                                                        Familles des taxes douanières
                                                        <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['familletaxedouaniere'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                                    </h4>
                                                </div>
                                                <div class="card-toolbar">
                                                    <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                        @if(auth()->user()->can('creation-taxedouaniere') || auth()->user()->can('modification-taxedouaniere'))
                                                            <a href="" class="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                                <span class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                                </span>
                                                            </a>
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                                @if(auth()->user()->can('creation-taxedouaniere'))
                                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('familletaxedouaniere')">
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
                                                                @if(auth()->user()->can('creation-taxedouaniere') || auth()->user()->can('modification-taxedouaniere'))
                                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('familletaxedouaniere', {is_file_excel:true, title: 'Famille des taxes douanières'})">
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
                                                                        <a href="familletaxedouaniere.feuille" class="menu-link px-3 py-2">
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
                                                    <form ng-submit="pageChanged('familletaxedouaniere')">
                                                        <div class="form-row animated fadeIn mt-4">
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" class="form-control" id="search_list_familletaxedouaniere" ng-model="search_list_familletaxedouaniere" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('familletaxedouaniere')">
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('familletaxedouaniere', {justWriteUrl : 'familletaxedouanieres-pdf'})">
                                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('familletaxedouaniere', {justWriteUrl : 'familletaxedouanieres-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>
    
                                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('familletaxedouaniere', true)">
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
                                                                @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                    <th style="max-width: 100px">
                                                                        <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid" for="familletaxedouaniere_all_selected">
                                                                            <input class="form-check-input mycheck_all_familletaxedouaniere" type="checkbox" id="familletaxedouaniere_all_selected" name="familletaxedouaniere_all" ng-click="checkAllOruncheckAll('#familletaxedouaniere_all_selected', null, null, 'mycheckfamilletaxedouaniere', {tagInput: 'familletaxedouaniere_selected', scopeName: 'itemIds2', attrName: 'data-item-id', className: 'mycheckfamilletaxedouaniere', btnAllId: 'familletaxedouaniere_all_selected'})">
                                                                            <span class="form-check-label text-muted"></span>
                                                                        </label>
                                                                    </th>
                                                                @endif
                                                                <th style="min-width: 120px">{{ __('customlang.code') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                                <th style="min-width: 120px">Nbre de taxe douaniere</th>
                                                                @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                    <th style="min-width: 100px" class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                                        <i class="flaticon2-settings" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"></i>
                                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                                            @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                                <div class="menu-item px-3 my-0" ng-click="deleteElement('familletaxedouaniere', itemIds2)" title="{{__('customlang.supprimer')}}">
                                                                                    <a href="" class="menu-link px-3 py-2">
                                                                                        <span class="menu-icon" data-kt-element="icon">
                                                                                        <i class="flaticon2-trash"></i>
                                                                                        </span>
                                                                                        <span class="menu-title">SUPPRIMER</span>
                                                                                    </a>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['familletaxedouanieres']">
                                                                @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                    <td class="align-middle text-capitalize">
                                                                        <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid" for="familletaxedouaniere_all_selected">
                                                                            <input class="form-check-input mycheckfamilletaxedouaniere" type="checkbox" id="familletaxedouaniere_selected_@{{$index}}" data-item-id="@{{item.id}}" ng-click="addToRole($event, item.id, {tagInput: 'familletaxedouaniere_selected', scopeName: 'itemIds2', attrName: 'data-item-id', className: 'mycheckfamilletaxedouaniere', btnAllId: 'familletaxedouaniere_all_selected'})" ng-checked="isInArrayData($event, item.id, null, 'familletaxedouaniere', 'itemIds2')">
                                                                            <span class="form-check-label text-muted"></span>
                                                                        </label>
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.code}}</span><br>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.nbre_familletaxedouaniere}}</span>
                                                                </td>
                                                                @if(auth()->user()->can('suppression-taxedouaniere') || auth()->user()->can('modification-taxedouaniere') || auth()->user()->can('creation-taxedouaniere'))
                                                                    <td class="pr-0 text-right">
                                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                            </label>
                                                                            @if(auth()->user()->can('suppression-taxedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('familletaxedouaniere', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                    <i class="flaticon2-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('modification-taxedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('familletaxedouaniere', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                    <i class="flaticon2-edit"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('creation-taxedouaniere'))
                                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('familletaxedouaniere',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['familletaxedouaniere'].entryLimit" ng-change="pageChanged('familletaxedouaniere')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['familletaxedouaniere'].totalItems" ng-model="paginations['familletaxedouaniere'].currentPage" max-size="paginations['familletaxedouaniere'].maxSize" items-per-page="paginations['familletaxedouaniere'].entryLimit" ng-change="pageChanged('familletaxedouaniere')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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