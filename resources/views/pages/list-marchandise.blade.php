<div class="container py-3 py-lg-8">
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

                                        <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtres" aria-expanded="false" aria-controls="filtresdossier">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                        </span>
                                    </div>
                                </div>
                                <div class="m-auto d-inline-flex page-head-title">
                                    <h4 class="card-label align-self-center m-auto position-relative">
                                        {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                                        <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['marchandise'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                    </h4>
                                </div>
                                <div class="card-toolbar">
                                    <div ng-click="showModalAdd('marchandise')" class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                        @if(auth()->user()->can('creation-article') || auth()->user()->can('modification-article'))
                                            <a href="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                <span class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                </span>
                                            </a>
                                            <div class="d-none menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                @if(auth()->user()->can('creation-article'))
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
                                                @if(auth()->user()->can('creation-article') || auth()->user()->can('modification-article'))
                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('marchandise', {is_file_excel:true, title: '{{ __('customlang.marchandise') }}'})">
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
                            <div id="filtres" class="card collapse">
                                <div class="card-body">
                                    <form ng-submit="pageChanged('marchandise')">
                                        <div class="form-row row animated fadeIn mt-4 ">
                                            <div class="col-md-6 form-group">
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
                                                        <option ng-repeat="item in dataPage['nomenclaturedouanieres2']" value="@{{ item.id }}"> @{{ item.code }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="select2 form-control filter" id="marque_list_marchandise" style="width: 100%">
                                                        <option value="">{{ __('customlang.marque') }}</option>
                                                        <option ng-repeat="item in dataPage['marques']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="select2 form-control filter" id="energie_list_marchandise" style="width: 100%">
                                                        <option value="">{{ __('customlang.energie') }}</option>
                                                        <option ng-repeat="item in dataPage['energies']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="select2 form-control filter" id="modele_list_marchandise" style="width: 100%">
                                                        <option value="">{{ __('customlang.modele') }}</option>
                                                        <option ng-repeat="item in dataPage['modeles']" value="@{{ item.id }}"> @{{ item.nom }}</option>
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

                    <div class="card card-custom gutter-b mb-2 rounded-1">
                        <div class="card-body p-5">
                            <div class="tab-content">
                                <div class="table-responsive">
                                    <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px">{{__('customlang.type_de_marchandise')}}</th>
                                                <th style="min-width: 120px">{{ __('customlang.client') }}(s)</th>
                                                <th style="min-width: 120px">{{ __('customlang.nomenclatures_douanieres') }}</th>
                                                <th style="min-width: 200px">{{ __('customlang.nom') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.marque') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.modele') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.energie') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.poids') }}</th>
                                                <th style="min-width: 120px">{{__('customlang.reference')}}</th>
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
                                                    <span class="text-muted font-weight-bold text-uppercase">@{{item.type_marchandise.nom}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold text-uppercase" ng-repeat="ssitem in item.clients">
                                                        <span class="badge badge-pill badge-light-warning">@{{ssitem.display_text}}</i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.nomenclature_douaniere.code}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.nom}}</span>
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
                                                    <span class="text-muted fw-bold">@{{item.poids}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.reference}}</span>
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

                    <div class="card p-5 rounded-1">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
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
            </div>
        </div>
    </div>
</div>