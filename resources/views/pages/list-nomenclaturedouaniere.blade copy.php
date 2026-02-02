<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
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
                                {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                            </h3>
                        </div>
                    </h2>
                    <span class="badge badge-light-primary">@{{paginations['nomenclaturedouaniere'].totalItems | currency:"":0 | convertMontant}}</span>
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
                            @if(auth()->user()->can('creation-nomenclaturedouaniere') || auth()->user()->can('modification-nomenclaturedouaniere'))
                                <div class="menu-item px-3 my-0" ng-click="showModalAdd('nomenclaturedouaniere', {is_file_excel:true, title: '{{ __('customlang.nomenclaturedouaniere') }}'})">
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
                            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#filtres" aria-expanded="false" aria-controls="filtres">
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
                            <div id="filtres" class="card collapse">
                                <div class="card-body">
                                    <form ng-submit="pageChanged('nomenclaturedouaniere')">
                                        <div class="form-row animated fadeIn mt-4">
                                            <div class="col-md-12 form-group">
                                                <input type="text" class="form-control" id="search_list_nomenclaturedouaniere" ng-model="search_list_nomenclaturedouaniere" placeholder="{{ __('customlang.rechercher_par_nom_code') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('nomenclaturedouaniere')">
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
                    <div class="card card-custom  gutter-b">
                        <div class="card-body bg-dark-o-5 pt-10 pb-3">
                            <div class="tab-content">
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px">{{ __('customlang.code') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.unite_de_mesure') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.valeur_mercurial') }}</th>
                                                <th style="min-width: 120px">Origine FR</th>
                                                <th style="min-width: 120px">Export</th>
                                                <th style="min-width: 120px">Remise</th>
                                                <th style="min-width: 120px">{{ __('customlang.ajustement') }}</th>
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
                                                    <span class="badge badge-pill badge-success" ng-if ="item.ajustement">{{__('customlang.oui')}}</span>
                                                    <span class="badge badge-pill badge-danger" ng-if ="!item.ajustement">{{__('customlang.non')}}</span>
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer py-4 d-flex flex-lg-column bg-body" id="kt_footer">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
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
