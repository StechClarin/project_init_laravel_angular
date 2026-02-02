<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('liste-devise') || auth()->user()->can('creation-devise') || auth()->user()->can('suppression-devise') || auth()->user()->can('modification-devise'))
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#page-devise-0" target="_self" ng-click="pageChanged('devise')">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-devise.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">
                                {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#page-devise-1" target="_self" ng-click="pageChanged('coursdevise')">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-historiquecours.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">Historique Des Cours Par Devise</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="">
        <div class="tab-content">
            {{-- Liste des devises --}}
            <div class="tab-pane fade show active" id="page-devise-0" role="tabpanel" aria-labelledby="page-devise-0">
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
                
                                                        <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtres" aria-expanded="false" aria-controls="filtresdossier">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="m-auto d-inline-flex page-head-title">
                                                    <h4 class="card-label align-self-center m-auto position-relative">
                                                        {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                                                        <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['devise'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                                    </h4>
                                                </div>
                                                <div class="card-toolbar">
                                                    <div ng-click="showModalAdd('devise')" class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                        @if(auth()->user()->can('creation-devise') || auth()->user()->can('modification-devise'))
                                                            <a href="" class="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                                <span class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                                </span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="filtres" class="card collapse">
                                                <div class="card-body">
                                                    <form ng-submit="pageChanged('devise')">
                                                        <div class="form-row animated fadeIn mt-4">
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" class="form-control" id="search_list_devise" ng-model="search_list_devise" placeholder="{{ __('customlang.rechercher_par_nom_signe_taux_change') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('devise')">
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('devise', {justWriteUrl : 'devises-pdf'})">
                                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('devise', {justWriteUrl : 'devises-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>
                
                                                            <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('devise', true)">
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
                                                                <th style="min-width: 120px">{{ __('customlang.signe') }}</th>
                                                                <th style="min-width: 120px">Cours</th>
                                                                <th style="min-width: 120px">Unité</th>
                                                                <th style="min-width: 120px">Précision</th>
                                                                <th style="min-width: 120px">{{__('customlang.devise_base')}}</th>
                                                                @if(auth()->user()->can('suppression-devise') || auth()->user()->can('modification-devise') || auth()->user()->can('creation-devise'))
                                                                    <th style="min-width: 100px">
                                                                        <i class="flaticon2-settings"></i>
                                                                    </th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['devises']">
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.code}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.signe}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.cours}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.unite}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.precision}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-pill badge-success" ng-if ="item.devise_base">{{__('customlang.oui')}}</span>
                                                                    <span class="badge badge-pill badge-danger" ng-if ="!item.devise_base">{{__('customlang.non')}}</span>
                                                                </td>
                                                                @if(auth()->user()->can('suppression-devise') || auth()->user()->can('modification-devise') || auth()->user()->can('creation-devise'))
                                                                    <td class="pr-0 text-right">
                                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                            </label>
                                                                            @if(auth()->user()->can('suppression-devise'))
                                                                                <button ng-if="!item.devise_base" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm"  ng-if="!item.desactiver" ng-click="deleteElement('devise', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                    <i class="flaticon2-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('modification-devise'))
                                                                                <button ng-if="!item.devise_base" class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm"  ng-click="showModalUpdate('devise', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                    <i class="flaticon2-edit"></i>
                                                                                </button>
                                                                                <button ng-if="!item.devise_base" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event, 'devise', 1, item, {mode:2, title: '{{__('customlang.definir_comme_devise_base')}}'})">
                                                                                    <i class="fa fa-thumbs-up"></i>
                                                                                </button>
                                                                                <button ng-if="item.devise_base" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event, 'devise', 0, item, {mode:2, title: '{{__('customlang.retirer_devise_base')}}'})">
                                                                                    <i class="fa fa-thumbs-down"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('creation-devise'))
                                                                                <button ng-if="!item.devise_base" class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('devise',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['devise'].entryLimit" ng-change="pageChanged('devise')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['devise'].totalItems" ng-model="paginations['devise'].currentPage" max-size="paginations['devise'].maxSize" items-per-page="paginations['devise'].entryLimit" ng-change="pageChanged('devise')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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

            {{-- Historique Cours Devise --}}
            <div class="tab-pane fade" id="page-devise-1" role="tabpanel" aria-labelledby="page-devise-1">
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
                
                                                        <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtres1" aria-expanded="false" aria-controls="filtresdossier">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="m-auto d-inline-flex page-head-title">
                                                    <h4 class="card-label align-self-center m-auto position-relative">
                                                        Historique Des Cours Par Devise
                                                        <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['coursdevise'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                                    </h4>
                                                </div>
                                            </div>
                                            <div id="filtres1" class="card collapse">
                                                <div class="card-body">
                                                    <form ng-submit="pageChanged('coursdevise')">
                                                        <div class="form-row animated fadeIn mt-4">
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" class="form-control" id="search_list_devise" ng-model="search_list_devise" placeholder="{{ __('customlang.rechercher_par_nom_signe_taux_change') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('coursdevise')">
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('coursdevise', {justWriteUrl : 'devises-pdf'})">
                                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('coursdevise', {justWriteUrl : 'devises-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>
                
                                                            <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('coursdevise', true)">
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
                                                                <th style="min-width: 120px">{{ __('customlang.date') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.code') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                                <th style="min-width: 120px">Cours</th>
                                                                <th style="min-width: 120px">{{ __('customlang.signe') }}</th>
                                                                <th style="min-width: 120px">Unité</th>
                                                                <th style="min-width: 120px">Précision</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['coursdevises']">
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.created_at_fr}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.devise.code}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.devise.nom}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.cours}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted text-capitalize fw-bold">@{{item.devise.signe}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.devise.unite}}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.devise.precision}}</span>
                                                                </td>
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
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['coursdevise'].entryLimit" ng-change="pageChanged('coursdevise')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['coursdevise'].totalItems" ng-model="paginations['coursdevise'].currentPage" max-size="paginations['coursdevise'].maxSize" items-per-page="paginations['coursdevise'].entryLimit" ng-change="pageChanged('coursdevise')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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