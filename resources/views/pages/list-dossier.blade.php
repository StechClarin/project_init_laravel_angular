<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center me-1">
                <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                    <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                        <div class="card-title d-flex align-self-center mb-0 me-3">
                            <span class="card-icon align-self-center">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-gestiondossier.svg')) !!}
                                </span>
                            </span>
                            <h3 class="card-label align-self-center mb-0 ms-3">
                                {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                            </h3>
                        </div>
                    </h2>
                    <span class="badge badge-light-primary">@{{paginations['dossier'].totalItems | currency:"":0 | convertMontant}}</span>
                </div>
            </div>
            @if(auth()->user()->can('creation-dossier'))
                <div class="d-none d-flex align-items-center flex-wrap">
                    <div class="" title="{{ __('customlang.ajouter') }}">
                        <a target="_self" href="" class="btn btn-primary btn-fixed-height fw-bold px-2 px-lg-5 me-2" ng-click="showModalAdd('dossier')">
                            <span class="svg-icon svg-icon-lg">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                </span>
                            <span class="d-none d-md-inline">{{ __('customlang.ajouter') }}</span>
                        </a>
                    </div>
                </div>
            @endif
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
                                    <form ng-submit="pageChanged('dossier')">
                                        <div class="form-row row animated fadeIn mt-4 ">
                                            <div class="col-md-6 form-group">
                                                <input type="text" class="form-control" id="nom_list_dossier" ng-model="nom_list_dossier" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('dossier')">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="select2 form-control filter" id="type_dossier_list_dossier" style="width: 100%">
                                                        <option value=""> {{__('customlang.typedossier')}}</option>
                                                        <option ng-repeat="item in dataPage['typedossiers']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="select2 form-control filter" id="modalite_paiement_list_dossier" style="width: 100%">
                                                        <option value="">{{__('customlang.modalite_de_paiement')}}</option>
                                                        <option ng-repeat="item in dataPage['modalitepaiements']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="select2 form-control filter" id="nomenclature_dossier_list_dossier" style="width: 100%">
                                                        <option value="">{{__('customlang.nomenclature')}}</option>
                                                        <option ng-repeat="item in dataPage['nomenclaturedossiers']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="date_start_list_bl" class="form-control datedropper" placeholder="Date debut">
                                            </div>
                                            <div class="col-md-12 form-group d-flex justify-content-center">
                                                <span class="me-3 fw-bolder">{{__('customlang.activer')}} ?</span>
                                                <div class="form-group mb-2 d-flex align-items-center" id="status">
                                                    <div class="input-group ">
                                                        <div class="d-inline-block custom-control custom-radio me-2 ">
                                                            <input type="radio" name="status" id="enabled_option_status_list_dossier" data-value="true" class="custom-control-input" ng-click="onRadioClickStatus($event, 'true')"><label class="custom-control-label ms-1" for="enabled_option_status_list_dossier">{{ __('customlang.oui') }}</label>
                                                        </div>
                                                        <div class="d-inline-block custom-control custom-radio me-2">
                                                            <input type="radio" name="status" id="disabled_option_status_list_dossier" data-value="false" class="custom-control-input" ng-click="onRadioClickStatus($event, 'false')"><label class="custom-control-label ms-1" for="disabled_option_status_list_dossier">{{ __('customlang.non') }}</label>
                                                        </div>
                                                        <div class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" name="status" id="all_option_status_list_dossier" data-value="" class="custom-control-input true" checked="" ng-click="onRadioClickStatus($event, '')"><label class="custom-control-label ms-1" for="all_option_status_list_dossier">{{ __('customlang.tout') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-100 text-center pb-4">
                                            <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('dossier', {justWriteUrl : 'dossiers-pdf'})">
                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                <i class="fa fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('dossier', {justWriteUrl : 'dossiers-excel'})">
                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                <i class="fa fa-file-excel"></i>
                                            </button>

                                            <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('dossier', true)">
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
                                                <th style="min-width: 120px">{{__('customlang.code')}}</th>
                                                <th style="min-width: 120px">{{__('customlang.niveau_habilite')}}</th>
                                                <th style="min-width: 120px">{{__('customlang.date')}}</th>
                                                <th style="min-width: 120px">{{__('customlang.typedossier')}}</th>
                                                <th style="min-width: 120px">{{__('customlang.client')}}</th>
                                                <th style="min-width: 120px">{{__('customlang.status')}}</th>

                                                <!-- <th style="min-width: 120px">Status</th> -->
                                                @if(auth()->user()->can('suppression-dossier') || auth()->user()->can('modification-dossier') || auth()->user()->can('creation-dossier'))
                                                    <th style="min-width: 100px">
                                                        <i class="flaticon2-settings"></i>
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['dossiers']">
                                                <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.code}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.niveau_habilite.nom}}</span>
                                                </td>
                                                 <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.date_fr}}</span>
                                                </td>
                                                 <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.type_dossier.nom}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.client.display_text}}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-@{{item.color_status}}">@{{item.status_fr}}</span>
                                                </td>
                                                @if(auth()->user()->can('suppression-dossier') || auth()->user()->can('modification-dossier') || auth()->user()->can('creation-dossier'))
                                                    <td class="pr-0 text-right">
                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                            </label>
                                                            @if(auth()->user()->can('suppression-dossier'))
                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('dossier', item.id)" title="{{ __('customlang.supprimer') }}">
                                                                    <i class="flaticon2-trash"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('modification-dossier'))
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('dossier', item.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                                    <i class="flaticon2-edit"></i>
                                                                </button>
                                                                <button ng-if="!item.status" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event,'dossier', 1, item, {mode:2, title: '{{__('customlang.activer_dossier')}}'})">
                                                                    <i class="fa fa-thumbs-up"></i>
                                                                </button>
                                                                <button ng-if="item.status" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event,'dossier', 0, item, {mode:2, title: '{{__('customlang.desactiver_dossier')}}'})">
                                                                    <i class="fa fa-thumbs-down"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('creation-dossier'))
                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('dossier',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['dossier'].entryLimit" ng-change="pageChanged('dossier')">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="d-flex flex-wrap">
            <nav aria-label="...">
                <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['dossier'].totalItems" ng-model="paginations['dossier'].currentPage" max-size="paginations['dossier'].maxSize" items-per-page="paginations['dossier'].entryLimit" ng-change="pageChanged('dossier')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
            </nav>
        </div>
    </div>
</div>
