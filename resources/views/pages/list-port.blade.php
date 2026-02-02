<div class="container py-3 py-lg-8">
    <div class="d-flex flex-column-fluid p-0">
        <div class="w-100">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">

                    <div class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle cursor-pointer">
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
                                        <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['port'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                    </h4>
                                </div>
                                <div class="card-toolbar">
                                    <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                        @if(auth()->user()->can('creation-port') || auth()->user()->can('modification-port'))
                                            <a href="" class="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                <span class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                </span>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                @if(auth()->user()->can('creation-port'))
                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('port')">
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
                                                @if(auth()->user()->can('creation-port') || auth()->user()->can('modification-port'))
                                                    <div class="menu-item px-3 my-0" ng-click="showModalAdd('port', {is_file_excel:true, title: '{{ __('customlang.port') }}'})">
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
                                                        <a href="port.feuille" class="menu-link px-3 py-2">
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
                            <div id="filtres" class="card collapse">
                                <div class="card-body">
                                    <form ng-submit="pageChanged('port')">
                                        <div class="form-row animated fadeIn mt-4">
                                            <div class="col-md-12 form-group">
                                                <input type="text" class="form-control" id="nom_list_port" ng-model="nom_list_port" placeholder="{{__('customlang.rechercher_par_nom')}}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('port')">
                                            </div>
                                        </div>
                                        <div class="w-100 text-center pb-4">
                                            <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('port', {justWriteUrl : 'ports-pdf'})">
                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                <i class="fa fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('port', {justWriteUrl : 'ports-excel'})">
                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                <i class="fa fa-file-excel"></i>
                                            </button>

                                            <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('port', true)">
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
                                                <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.description') }}</th>
                                                @if(auth()->user()->can('suppression-port') || auth()->user()->can('modification-port') || auth()->user()->can('creation-port'))
                                                    <th style="min-width: 100px">
                                                        <i class="flaticon2-settings"></i>
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['ports']">
                                                <td>
                                                    <span class="text-muted text-capitalize fw-bold">@{{item.nom}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted text-capitalize fw-bold" >@{{item.description}}</span>
                                                </td>
                                                @if(auth()->user()->can('suppression-port') || auth()->user()->can('modification-port') || auth()->user()->can('creation-port'))
                                                    <td class="pr-0 text-right">
                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                            </label>
                                                            @if(auth()->user()->can('suppression-port'))
                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('port', item.id)" title="{{__('customlang.supprimer')}}">
                                                                    <i class="flaticon2-trash"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('modification-port'))
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm"  ng-click="showModalUpdate('port', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                    <i class="flaticon2-edit"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('creation-port'))
                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('port',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{__('customlang.cloner')}}">
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
                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['port'].entryLimit" ng-change="pageChanged('port')">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="d-flex flex-wrap">
                                <nav aria-label="...">
                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['port'].totalItems" ng-model="paginations['port'].currentPage" max-size="paginations['port'].maxSize" items-per-page="paginations['port'].entryLimit" ng-change="pageChanged('port')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>