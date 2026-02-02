<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    {{-- Ordre de transit --}}
    <div class="container py-3 pt-lg-8 px-12">
        <fieldset class="row fieldset-title border border-primary p-0 rounded-1">
            <div class="d-flex flex-column-fluid p-0">
                <div class="w-100">
                    <div class="row">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-custom @{{is_collapse_table_ordretransit ? '' : 'mb-2'}} accordion accordion-solid accordion-panel accordion-svg-toggle">
                                <div class="card rounded-1">
                                    <div class="card-header p-5">
                                        <div class="card-title">
                                            <div class="card-label h3">
                                                <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                </span>

                                                {{__('customlang.filtres')}}

                                                <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtres" aria-expanded="false" aria-controls="filtres">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="m-auto d-inline-flex page-head-title">
                                            <h4 class="card-label align-self-center m-auto position-relative">
                                                {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                                                <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['ordretransit'].totalItems | currency:"":0 | convertMontant}}</span>                                                
                                            </h4>

                                            <div class="row" style="width: 231px; margin-left: 25px">
                                                <div class="col-md-6 d-flex align-items-center">
                                                    <span>Complet</span>
                                                    <div class="bg-dark ms-2" style="width: 30px;height: 4px"></div>
                                                </div>
                                                <div class="col-md-6 d-flex align-items-center">
                                                    <span>En attente</span>
                                                    <div class="bg-warning ms-2" style="width: 30px;height: 4px"></div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="card-toolbar">
                                            <span id="toggle-text" class="bg-light-primary rounded-1 p-1 text-primary cursor-pointer me-10" ng-click="updateText('table_ordretransit', 'filtres')" data-bs-toggle="collapse" data-bs-target="#table_ordretransit" aria-expanded="false" aria-controls="filtres">
                                               @{{is_collapse_table_ordretransit ? 'Afficher' : 'Réduire'}}
                                                <i ng-if="!is_collapse_table_ordretransit" class="text-primary la la-angle-up"></i>
                                                <i ng-if="is_collapse_table_ordretransit" class="text-primary la la-angle-down"></i>
                                            </span>
                                            <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                                @if(auth()->user()->can('creation-navire') || auth()->user()->can('modification-navire'))
                                                    <a href="" ng-click="showModalAdd('ordretransit')" class="" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
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
                                            <form ng-submit="pageChanged('ordretransit')">
                                                <div class="form-row row animated fadeIn mt-4 ">
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" class="form-control" id="search_list_ordretransit" ng-model="search_list_ordretransit" placeholder="{{ __('customlang.rechercher_par_code') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('ordretransit')">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <div class="input-group">
                                                            <select class="select2 form-control search_client filter" id="client_list_ordretransit" placeholder="Client">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="select2 form-control filter" id="type_importation_list_ordretransit" style="width: 100%">
                                                                <option value="">Type d'importation</option>
                                                                <option ng-repeat="item in dataPage['typeimportations']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="select2 form-control filter" id="type_dossier_list_ordretransit" style="width: 100%">
                                                                <option value="">Type de dossier</option>
                                                                <option ng-repeat="item in dataPage['typedossiers']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="date_start_list_ordretransit" class="form-control datedropper" placeholder="Date debut">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="date_end_list_ordretransit" class="form-control datedropper" placeholder="Date fin">
                                                    </div>
                                                    <div class="d-none col-md-12 form-group d-flex justify-content-center">
                                                        <span class="me-3 fw-bolder">{{__('customlang.valider')}} ?</span>
                                                        <div class="form-group mb-2 d-flex align-items-center" id="status">
                                                            <div class="input-group ">
                                                                <div class="d-inline-block custom-control custom-radio me-2 ">
                                                                    <input type="radio" name="status" id="enabled_option_status_list_ordretransit" data-value="true" class="custom-control-input" ng-click="onRadioClickStatus($event, 'true')"><label class="custom-control-label ms-1" for="enabled_option_status_list_ordretransit">{{ __('customlang.oui') }}</label>
                                                                </div>
                                                                <div class="d-inline-block custom-control custom-radio me-2">
                                                                    <input type="radio" name="status" id="disabled_option_status_list_ordretransit" data-value="false" class="custom-control-input" ng-click="onRadioClickStatus($event, 'false')"><label class="custom-control-label ms-1" for="disabled_option_status_list_ordretransit">{{ __('customlang.non') }}</label>
                                                                </div>
                                                                <div class="d-inline-block custom-control custom-radio">
                                                                    <input type="radio" name="status" id="all_option_status_list_ordretransit" data-value="" class="custom-control-input true" checked="" ng-click="onRadioClickStatus($event, '')"><label class="custom-control-label ms-1" for="all_option_status_list_ordretransit">{{ __('customlang.tout') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 form-group d-flex justify-content-center">
                                                        <span class="me-3 fw-bolder">Complet ?</span>
                                                        <div class="form-group mb-2 d-flex align-items-center" id="status">
                                                            <div class="input-group ">
                                                                <div class="d-inline-block custom-control custom-radio me-2 ">
                                                                    <input type="radio" name="is_complet" id="enabled_option_status_list_ordretransit" data-value="true" class="custom-control-input" ng-click="onRadioClickStatus($event, 'true')"><label class="custom-control-label ms-1" for="enabled_option_status_list_ordretransit">{{ __('customlang.oui') }}</label>
                                                                </div>
                                                                <div class="d-inline-block custom-control custom-radio me-2">
                                                                    <input type="radio" name="is_complet" id="disabled_option_status_list_ordretransit" data-value="false" class="custom-control-input" ng-click="onRadioClickStatus($event, 'false')"><label class="custom-control-label ms-1" for="disabled_option_status_list_ordretransit">{{ __('customlang.non') }}</label>
                                                                </div>
                                                                <div class="d-inline-block custom-control custom-radio">
                                                                    <input type="radio" name="is_complet" id="all_option_status_list_ordretransit" data-value="" class="custom-control-input true" checked="" ng-click="onRadioClickStatus($event, '')"><label class="custom-control-label ms-1" for="all_option_status_list_ordretransit">{{ __('customlang.tout') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-100 text-center pb-4">
                                                    <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('ordretransit', {justWriteUrl : 'ordretransits-pdf'})">
                                                        <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                        <i class="fa fa-file-pdf"></i>
                                                    </button>
                                                    <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('ordretransit', {justWriteUrl : 'ordretransits-excel'})">
                                                        <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                        <i class="fa fa-file-excel"></i>
                                                    </button>

                                                    <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                        <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('ordretransit', true)">
                                                        <i class="fa fa-times"></i>
                                                        <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="table_ordretransit" class="card card-custom gutter-b rounded-1 collapse show">
                                <div class="card-body p-5 animated fadeIn">
                                    <div class="tab-content">
                                        <div class="table-responsive">
                                            <table class="m-auto table table-head-custom table-vertical-center table-head-bg table-borderless table-striped table-report text-center">
                                                <thead>
                                                    <tr>
                                                        <th style="min-width: 120px">{{__('customlang.code')}}</th>
                                                        @if(!isset(Auth::user()->client))
                                                            <th style="min-width: 120px">{{__('customlang.client')}}</th>
                                                        @endif
                                                        <th style="min-width: 120px">{{__('customlang.date')}}</th>
                                                        <th style="min-width: 120px">Imp</th>
                                                        <!-- <th style="min-width: 120px">Status</th> -->
                                                        @if(auth()->user()->can('suppression-ordretransit') || auth()->user()->can('modification-ordretransit') || auth()->user()->can('creation-ordretransit'))
                                                            <th style="min-width: 100px">
                                                                <i class="flaticon2-settings"></i>
                                                            </th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- <td>
                                                        <div style="width: 10px; height: 10px; border-radius: 50%;" ng-class="{'bg-dark': item.is_complet === true, 'bg-warning': item.is_complet !== true}"></div>
                                                    </td> --}}
                                                    <tr class="withMenuContextuel" style="border: 3px solid; border-left:none; border-right:none; border-top:none" ng-class="{'border-dark': item.is_complet === true, 'border-warning': item.is_complet !== true}" ng-repeat="item in dataPage['ordretransits']">
                                                        <td class="p-0">
                                                            <span class="text-muted fw-bold text-capitalize">
                                                                <span ng-if="item.type_marchandise_id === 2 && item.type_dossier.nbre_type_dossier === 0" ng-include="'pages/sections.svg-typevehicule'"></span>
                                                                <span ng-if="item.type_marchandise_id === 1 && item.type_dossier.nbre_type_dossier === 0" ng-include="'pages/sections.svg-typemarchandise'"></span>

                                                                {{-- Pour mixte --}}
                                                                <span ng-if="item.type_marchandise_id === 1 && item.type_dossier.nbre_type_dossier > 0" ng-include="'pages/sections.svg-typemarchandisemixte'"></span>
                                                                <span ng-if="item.type_marchandise_id === 2 && item.type_dossier.nbre_type_dossier > 0" ng-include="'pages/sections.svg-typevehiculemixte'"></span>
                                                                @{{item.code}}
                                                            </span>
                                                            <span class="text-muted fw-bold text-capitalize badge badge-danger" ng-if="item.niveau_habilite">@{{item.niveau_habilite.nom}}</span>
                                                        </td>
                                                        @if(!isset(Auth::user()->client))
                                                            <td>
                                                                <span class="text-muted fw-bold text-capitalize">@{{item.client.display_text}}</span>
                                                            </td>
                                                        @endif
                                                        <td>
                                                            <span class="text-muted fw-bold text-capitalize">@{{item.date_fr}}</span>
                                                        </td>
                                                        <td>
                                                            @{{item.type_importation.description}}
                                                        </td>
                                                        @if(auth()->user()->can('suppression-ordretransit') || auth()->user()->can('modification-ordretransit') || auth()->user()->can('creation-ordretransit'))
                                                            <td class="pr-0 text-right">
                                                                <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                    <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                                    <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                        <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                        <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                        <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                    </label>
                                                                    @if(auth()->user()->can('suppression-ordretransit'))
                                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('ordretransit', item.id)" title="{{ __('customlang.supprimer') }}">
                                                                            <i class="flaticon2-trash"></i>
                                                                        </button>
                                                                    @endif
                                                                    @if(auth()->user()->can('modification-ordretransit'))
                                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit', item.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                                            <i class="flaticon2-edit"></i>
                                                                        </button>
                                                                        <button class="menu-btn-item btn btn-sm btn-light-info btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit',item.id,{forceChangeForm: false, isClone:false, transformToType:'detailordretransit'}, 'null')" title="{{ __('customlang.detail') }}">
                                                                            <i class="flaticon2-information"></i>
                                                                        </button>
                                                                       {{--  <button ng-if="!item.status && item.is_complet" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event,'ordretransit', 1, item, {mode:2, title: 'Transformer l\'ordre de transit en dossier'})">
                                                                            <i class="fa fa-thumbs-up"></i>
                                                                        </button> --}}
                                                                    @endif
                                                                    @if(auth()->user()->can('detail-ordretransit'))
                                                                        <a target="_blank" type="button" href="generate-documentordretransits-pdf?id:@{{item.id}}" title="Générer OT" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm">
                                                                            <span class="menu-icon" data-kt-element="icon">
                                                                                <span class="svg-icon svg-icon-3">
                                                                                    <i class="fa fa-file-pdf"></i>
                                                                                </span>
                                                                            </span>
                                                                        </a>
                                                                    @endif
                                                                    @if(auth()->user()->can('creation-ordretransit'))
                                                                        <button class="d-none menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit', item.id, {forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
        </fieldset>
    </div>

    {{-- Dossier --}}
    <div class="container py-2 py-lg-4 px-12">
        <fieldset class="row fieldset-title border border-primary py-0 rounded-1">
            <div class="d-flex flex-column-fluid p-0">
                <div class="w-100">
                    <div class="row">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-custom @{{is_collapse_table_dossier ? '' : 'mb-3'}} accordion accordion-solid accordion-panel accordion-svg-toggle">
                                <div class="card rounded-1">
                                    <div class="card-header p-5">
                                        <div class="card-title">
                                            <div class="card-label h3">
                                                <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                </span>

                                                {{__('customlang.filtres')}}

                                                <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtresdossier" aria-expanded="false" aria-controls="filtresdossier">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="m-auto d-inline-flex page-head-title">
                                            <h4 class="card-label align-self-center m-auto position-relative">
                                                En traitement
                                                {{-- <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{paginations['dossier'].totalItems | currency:"":0 | convertMontant}}</span>                                                 --}}
                                                <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{getTotalElements('dossiers', 'step_traitement') | currency:"":0 | convertMontant}}</span>                                                
                                            </h4>
                                        </div>
                                        <div class="card-toolbar">
                                            <span id="toggle-text" class="bg-light-primary rounded-1 p-1 text-primary cursor-pointer" ng-click="updateText('table_dossier', 'filtresdossier')" data-bs-toggle="collapse" data-bs-target="#table_dossier" aria-expanded="false" aria-controls="filtres">
                                                @{{is_collapse_table_dossier ? 'Afficher' : 'Réduire'}}
                                                 <i ng-if="!is_collapse_table_dossier" class="text-primary la la-angle-up"></i>
                                                 <i ng-if="is_collapse_table_dossier" class="text-primary la la-angle-down"></i>
                                             </span>
                                        </div>
                                    </div>
                                    <div id="filtresdossier" class="card collapse">
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
                            <div ng-include="'pages/sections.table-dossier?table_id=table_dossier&section_id=1&dataPage=dossiers&column=step_traitement'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="container py-2 py-lg-4 px-12">
        <fieldset class="row fieldset-title border border-primary py-0 rounded-1">
            <div class="d-flex flex-column-fluid p-0">
                <div class="w-100">
                    <div class="row">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-custom @{{is_collapse_table_declaration ? '' : 'mb-3'}} accordion accordion-solid accordion-panel accordion-svg-toggle">
                                <div class="card rounded-1">
                                    <div class="card-header p-5">
                                        <div class="card-title">
                                            <div class="card-label h3">
                                                <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                </span>

                                                {{__('customlang.filtres')}}

                                                <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtresdeclaration" aria-expanded="false" aria-controls="filtresdossier">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="m-auto d-inline-flex page-head-title">
                                            <h4 class="card-label align-self-center m-auto position-relative">
                                                Déclaration
                                                <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{getTotalElements('dossiers', 'step_declaration') | currency:"":0 | convertMontant}}</span>                                                
                                            </h4>
                                        </div>
                                        <div class="card-toolbar">
                                            <span id="toggle-text" class="bg-light-primary rounded-1 p-1 text-primary cursor-pointer" ng-click="updateText('table_declaration', 'filtresdeclaration')" data-bs-toggle="collapse" data-bs-target="#table_declaration" aria-expanded="false" aria-controls="table_declaration">
                                                @{{is_collapse_table_declaration ? 'Afficher' : 'Réduire'}}
                                                 <i ng-if="!is_collapse_table_declaration" class="text-primary la la-angle-up"></i>
                                                 <i ng-if="is_collapse_table_declaration" class="text-primary la la-angle-down"></i>
                                             </span>
                                        </div>
                                    </div>
                                    <div id="filtresdeclaration" class="card collapse">
                                        <div class="card-body">
                                            <form ng-submit="">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-include="'pages/sections.table-dossier?table_id=table_declaration&section_id=2&dataPage=dossiers&column=step_declaration'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="container py-2 py-lg-4 px-12">
        <fieldset class="row fieldset-title border border-primary py-0 rounded-1">
            <div class="d-flex flex-column-fluid p-0">
                <div class="w-100">
                    <div class="row">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-custom @{{is_collapse_table_attente_bae ? '' : 'mb-3'}} accordion accordion-solid accordion-panel accordion-svg-toggle">
                                <div class="card rounded-1">
                                    <div class="card-header p-5">
                                        <div class="card-title">
                                            <div class="card-label h3">
                                                <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                </span>

                                                {{__('customlang.filtres')}}

                                                <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtresbae" aria-expanded="false" aria-controls="filtresdossier">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="m-auto d-inline-flex page-head-title">
                                            <h4 class="card-label align-self-center m-auto position-relative">
                                                En attente de BAE
                                                <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{getTotalElements('dossiers', 'step_attente_bae') | currency:"":0 | convertMontant}}</span>                                                
                                            </h4>
                                        </div>
                                        <div class="card-toolbar">
                                            <span id="toggle-text" class="bg-light-primary rounded-1 p-1 text-primary cursor-pointer" ng-click="updateText('table_attente_bae', 'filtresbae')" data-bs-toggle="collapse" data-bs-target="#table_attente_bae" aria-expanded="false" aria-controls="table_attente_bae">
                                                @{{is_collapse_table_attente_bae ? 'Afficher' : 'Réduire'}}
                                                 <i ng-if="!is_collapse_table_attente_bae" class="text-primary la la-angle-up"></i>
                                                 <i ng-if="is_collapse_table_attente_bae" class="text-primary la la-angle-down"></i>
                                             </span>
                                        </div>
                                    </div>
                                    <div id="filtresbae" class="card collapse">
                                        <div class="card-body">
                                            <form ng-submit="">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-include="'pages/sections.table-dossier?table_id=table_attente_bae&section_id=3&dataPage=dossiers&column=step_attente_bae'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="container py-2 py-lg-4 px-12">
        <fieldset class="row fieldset-title border border-primary py-0 rounded-1">
            <div class="d-flex flex-column-fluid p-0">
                <div class="w-100">
                    <div class="row">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-custom @{{is_collapse_table_livraison ? '' : 'mb-3'}} accordion accordion-solid accordion-panel accordion-svg-toggle">
                                <div class="card rounded-1">
                                    <div class="card-header p-5">
                                        <div class="card-title">
                                            <div class="card-label h3">
                                                <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                </span>

                                                {{__('customlang.filtres')}}

                                                <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtreslivraison" aria-expanded="false" aria-controls="filtresdossier">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="m-auto d-inline-flex page-head-title">
                                            <h4 class="card-label align-self-center m-auto position-relative">
                                                Livraison
                                                <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{getTotalElements('dossiers', 'step_livraison') | currency:"":0 | convertMontant}}</span>                                                
                                            </h4>
                                        </div>
                                        <div class="card-toolbar">
                                            <span id="toggle-text" class="bg-light-primary rounded-1 p-1 text-primary cursor-pointer" ng-click="updateText('table_livraison', 'filtreslivraison')" data-bs-toggle="collapse" data-bs-target="#table_livraison" aria-expanded="false" aria-controls="table_livraison">
                                                @{{is_collapse_table_livraison ? 'Afficher' : 'Réduire'}}
                                                 <i ng-if="!is_collapse_table_livraison" class="text-primary la la-angle-up"></i>
                                                 <i ng-if="is_collapse_table_livraison" class="text-primary la la-angle-down"></i>
                                             </span>
                                        </div>

                                    </div>
                                    <div id="filtreslivraison" class="card collapse">
                                        <div class="card-body">
                                            <form ng-submit="">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div ng-include="'pages/sections.table-dossier?table_id=table_livraison&section_id=4&dataPage=dossiers&column=step_livraison'"></div>

                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="container py-2 py-lg-4 px-12">
        <fieldset class="row fieldset-title border border-primary py-0 rounded-1">
            <div class="d-flex flex-column-fluid p-0">
                <div class="w-100">
                    <div class="row">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-custom accordion accordion-solid accordion-panel accordion-svg-toggle">
                                <div class="card rounded-1">
                                    <div class="card-header p-5">
                                        <div class="card-title">
                                            <div class="card-label h3">
                                                <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                </span>

                                                {{__('customlang.filtres')}}

                                                <span class="svg-icon svg-no-rotate bg-primary cursor-pointer" style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse" data-bs-target="#filtresfacturation" aria-expanded="false" aria-controls="filtresdossier">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="m-auto d-inline-flex page-head-title">
                                            <h4 class="card-label align-self-center m-auto position-relative">
                                                Facturation
                                                <span class="badge badge-light-primary position-absolute" style="top: -5px ; margin-left: 5px">@{{0 | currency:"":0 | convertMontant}}</span>                                                
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="filtresfacturation" class="card collapse">
                                        <div class="card-body">
                                            <form ng-submit="">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
