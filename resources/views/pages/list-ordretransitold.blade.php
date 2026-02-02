<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center me-1">
                <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                    <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                        <div class="card-title d-flex align-self-center mb-0 me-3">
                            <span class="card-icon align-self-center">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-ordretransit.svg')) !!}
                                </span>
                            </span>
                            <h3 class="card-label align-self-center mb-0 ms-3">
                                {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                            </h3>
                        </div>
                    </h2>
                    <span class="badge badge-light-primary">@{{paginations['ordretransit'].totalItems | currency:"":0 | convertMontant}}</span>
                </div>
            </div>
            @if(auth()->user()->can('creation-ordretransit'))
                <div class="d-flex align-items-center flex-wrap">
                    <div class="" title="{{ __('customlang.ajouter') }}">
                        <a target="_self" href="" class="btn btn-primary btn-fixed-height fw-bold px-2 px-lg-5 me-2" ng-click="showModalAdd('ordretransit')">
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
                    <div class="card card-custom gutter-b" style="margin-bottom:7rem !important">
                        <div class="card-body bg-dark-o-5 pt-10 pb-10">

                            <div class="d-none item-card-consultation">
                                <div class="row justify-content-between">
                                    <!--card-success , card-warning , card-danger-->
                                    <div class="animated fadeIn col-lg-6" ng-repeat="item in dataPage['ordretransits']">
                                        {{-- <div class="item-card-consultation-0 mb-3" ng-class="{'card-success': item.status === true, 'card-danger': item.status !== true}"> --}}
                                        <div class="item-card-consultation-0 mb-3" ng-class="{'card-dark': item.is_complet === true, 'card-warning': item.is_complet !== true}">
                                            <div class="row m-0">
                                                <div class="col-6 align-self-center">
                                                    <div class="d-flex">
                                                        <div class="align-self-center me-2">
                                                            <div class="item-consultation-icon" data-bs-toggle="collapse" data-bs-target="#consultation-@{{item.id}}" aria-expanded="false" aria-controls="consultation-@{{item.id}}">
                                                                <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <g>
                                                                        <path d="M0 7.53112C0.135938 7.23444 0.248438 6.9195 0.553125 6.74606C0.745313 6.63651 0.960938 6.51784 1.17188 6.50415C1.63594 6.46763 2.10469 6.49502 2.59219 6.49502C2.59219 6.86017 2.59219 7.22075 2.59219 7.61784C2.33906 7.61784 2.09063 7.61784 1.84219 7.61784C1.3875 7.62241 1.1625 7.83693 1.1625 8.2751C1.1625 12.2506 1.1625 16.2307 1.1625 20.2062C1.1625 20.6033 1.40625 20.8452 1.80937 20.8589C2.06719 20.868 2.37656 20.9411 2.56875 20.8315C2.75625 20.722 2.83594 20.4253 2.94844 20.2017C4.15313 17.8373 5.35312 15.4685 6.55781 13.1041C6.66094 12.9033 6.79688 12.7116 6.94219 12.5382C7.18594 12.2506 7.50937 12.1411 7.89375 12.1456C11.0156 12.1548 14.1422 12.1502 17.2641 12.1502C17.3578 12.1502 17.4516 12.1502 17.5734 12.1502C17.5734 11.0867 17.5734 10.0324 17.5734 8.97801C18.2203 9.00539 18.7312 9.52116 18.7406 10.1465C18.75 10.7261 18.7453 11.3012 18.7453 11.8809C18.7453 11.9631 18.7453 12.0452 18.7453 12.1456C18.8531 12.1456 18.9375 12.1456 19.0219 12.1456C20.3578 12.1456 21.6937 12.1593 23.0297 12.1411C23.4703 12.1365 23.8031 12.2552 24 12.6523C24 12.7892 24 12.9261 24 13.0631C23.8969 13.2639 23.7984 13.4693 23.6906 13.6701C22.4016 16.0481 21.1031 18.4261 19.8234 20.8133C19.5 21.4112 19.0875 21.8631 18.375 22C12.6891 22 6.99844 22 1.3125 22C1.13437 21.9498 0.946875 21.9178 0.778125 21.8494C0.351562 21.6668 0.140625 21.3154 0 20.9046C0 16.4452 0 11.9905 0 7.53112Z" fill="white"/>
                                                                        <path d="M13.4063 0C13.5892 0.132365 13.8048 0.237344 13.9548 0.392531C14.8313 1.30083 15.6985 2.21826 16.5563 3.14938C16.6735 3.27718 16.7673 3.48714 16.7673 3.65602C16.7813 6.19834 16.7767 8.7361 16.7767 11.2784C16.7767 11.3241 16.772 11.3697 16.7673 11.429C16.4626 11.429 16.1626 11.429 15.8392 11.429C15.8392 11.3332 15.8392 11.2419 15.8392 11.1552C15.8392 8.91867 15.8392 6.68216 15.8392 4.44564C15.8392 4.06224 15.7923 4.0166 15.3938 4.0166C14.7704 4.0166 14.1423 4.0166 13.5188 4.0166C13.1063 4.0166 12.9423 3.85228 12.9423 3.44606C12.9423 2.72946 12.9423 2.01743 12.9423 1.30083C12.9423 0.995021 12.886 0.940249 12.572 0.940249C9.93291 0.940249 7.28916 0.940249 4.65009 0.940249C4.34541 0.940249 4.31728 0.967635 4.31728 1.29627C4.31728 6.07967 4.31728 10.8631 4.31259 15.651C4.31259 15.8017 4.27041 15.966 4.20478 16.1075C4.01728 16.5046 3.80634 16.8971 3.60947 17.2896C3.58603 17.2942 3.56259 17.2988 3.53916 17.2988C3.49228 17.1892 3.43134 17.0797 3.39384 16.9656C3.37041 16.888 3.37978 16.8012 3.37978 16.7145C3.37978 11.5568 3.37978 6.39917 3.37978 1.24149C3.37978 0.63444 3.67041 0.214523 4.18603 0.0684647C4.27509 0.0456432 4.36416 0.0228216 4.45791 0C7.43916 0 10.4204 0 13.4063 0ZM15.2392 3.09917C14.7751 2.61079 14.3438 2.15436 13.8892 1.67054C13.8892 2.17718 13.8892 2.63361 13.8892 3.09917C14.3298 3.09917 14.7563 3.09917 15.2392 3.09917Z" fill="white"/>
                                                                        <path d="M10.0781 4.93402C11.4749 4.93402 12.8718 4.92946 14.2687 4.94315C14.4468 4.94315 14.6484 5.02988 14.789 5.13485C14.9484 5.25353 14.9953 5.45436 14.9249 5.65519C14.8499 5.87427 14.6859 6.00664 14.4562 6.05228C14.3906 6.06598 14.3156 6.06141 14.2453 6.06141C11.4656 6.06141 8.68589 6.06141 5.9062 6.06141C5.68589 6.06141 5.48432 6.02033 5.33901 5.84689C5.20307 5.68257 5.15151 5.49544 5.24057 5.29461C5.3437 5.06639 5.52651 4.93402 5.78432 4.92946C6.19214 4.9249 6.59526 4.92946 7.00307 4.9249C8.03432 4.93402 9.0562 4.93402 10.0781 4.93402Z" fill="white"/>
                                                                        <path d="M10.083 9.3112C8.68613 9.3112 7.28926 9.3112 5.89238 9.3112C5.47988 9.3112 5.20801 9.09212 5.20801 8.75436C5.20801 8.42116 5.47988 8.18382 5.8877 8.18382C8.68145 8.18382 11.4752 8.18382 14.2689 8.18382C14.6252 8.18382 14.8736 8.35726 14.9439 8.63569C15.0049 8.87759 14.8549 9.16058 14.5924 9.261C14.4939 9.29751 14.3814 9.30664 14.2736 9.30664C12.8768 9.3112 11.4799 9.3112 10.083 9.3112Z" fill="white"/>
                                                                        <path d="M7.09735 11.4656C6.75048 11.6436 6.43642 11.8353 6.22548 12.1593C6.17392 12.2369 6.11298 12.31 6.08954 12.3967C6.03329 12.6021 5.88329 12.6158 5.70985 12.5884C5.42392 12.5427 5.19892 12.2917 5.20829 12.0178C5.21298 11.7485 5.44267 11.4838 5.73329 11.4701C6.18798 11.4519 6.64267 11.4656 7.09735 11.4656Z" fill="white"/>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="align-self-center lh-18">
                                                            <div class="item-consultation-titre">
                                                                <div class="text-uppercase text-dark">@{{item.code}}</div>
                                                                <div class="text-uppercase item-consultation-code">@{{item.client.display_text}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 p-lg-0 p-md-1 align-self-center">
                                                    <div class="lh-18 ellipsis-1">
                                                        <div class="item-consultation-titre item-consultation-code fw-bold">Date :  @{{item.date_fr}}</div>
                                                        <div class="item-consultation-desc mt-1">
                                                            <span style="@{{item.type_dossier.bgStyle}}" class="text-uppercase badge badge-pill">@{{item.type_dossier.nom}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2 pl-lg-0 pl-md-1 align-self-center">
                                                    <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-old-@{{ item.id }}">
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
                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit', item.id)" title="{{ __('customlang.modifier') }}">
                                                                <i class="flaticon2-edit"></i>
                                                            </button>
                                                            <button class="menu-btn-item btn btn-sm btn-light-info btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit',item.id,{forceChangeForm: false, isClone:false, transformToType:'detailordretransit'})" title="{{ __('customlang.cloner') }}">
                                                                <i class="flaticon2-information"></i>
                                                            </button>
                                                            <button ng-if="!item.status && item.is_complet" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event,'ordretransit', 1, item, {mode:2, title: 'Transformer l\'ordre de transit en dossier'})">
                                                                <i class="fa fa-thumbs-up"></i>
                                                            </button>
                                                            {{-- <button ng-if="item.status && item.is_complet" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event,'ordretransit', 0, item, {mode:2, title: 'Désactiver l\'ordre de transit'})">
                                                                <i class="fa fa-thumbs-down"></i>
                                                            </button> --}}
                                                        @endif
                                                        @if(auth()->user()->can('creation-ordretransit'))
                                                            <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit',item.id,{forceChangeForm: false, isClone:true})" title="{{ __('customlang.cloner') }}">
                                                                <i class="fa fa-clone"></i>
                                                            </button>
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="collapse mt-2" id="consultation-@{{item.id}}">
                                                <div class="row px-3 pb-2 mt-3">
                                                    <div class="col-6">
                                                        <div class="lh-18">Date Départ - Date d'arrivée</div>
                                                        <div class="item-card-consultation-detail">
                                                            <div class="d-flex">
                                                                <span class="fw-bold badge badge-warning">@{{item.date_depart_fr}}</span>
                                                                <i class="fa fa-minus text-dark ms-2 me-2"></i>
                                                                <span class="fw-bold badge badge-success">@{{item.date_depart_fr}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="lh-18">Type De Marchandise / D'importation</div>
                                                        <div class="item-card-consultation-detail">
                                                            <span class="fw-bold text-uppercase badge badge-primary">@{{item.type_marchandise.nom}}</span> /
                                                            <span class="fw-bold text-uppercase badge badge-warning">@{{item.type_importation.nom}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <div class="lh-18">Marchandises</div>
                                                        <div class="item-card-consultation-detail">
                                                            <span ng-repeat="ssitem in item.marchandises" class="fw-bold text-uppercase">@{{ssitem.marchandise.nom}} / </span>
                                                        </div>
                                                    </div>
                                                   
                                                   
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px">{{__('customlang.code')}}</th>
                                                @if(!isset(Auth::user()->client))
                                                    <th style="min-width: 120px">{{__('customlang.client')}}</th>
                                                @endif
                                                <th style="min-width: 120px">{{__('customlang.date')}}</th>
                                                <th style="min-width: 120px">Type de marchandise / d'importation</th>
                                                <th style="min-width: 120px">Type de dossier</th>
                                                <th style="min-width: 120px">Valider ?</th>
                                                <!-- <th style="min-width: 120px">Status</th> -->
                                                @if(auth()->user()->can('suppression-ordretransit') || auth()->user()->can('modification-ordretransit') || auth()->user()->can('creation-ordretransit'))
                                                    <th style="min-width: 100px">
                                                        <i class="flaticon2-settings"></i>
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['ordretransits']">
                                                <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.code}}</span>
                                                    <span class="text-muted fw-bold text-capitalize badge badge-danger" ng-if="item.niveau_habilite">@{{item.niveau_habilite.nom}}</span>
                                                </td>
                                                @if(!isset(Auth::user()->client))
                                                    <td>
                                                        <span class="text-muted fw-bold text-capitalize">@{{item.client.display_text}}</span>
                                                    </td>
                                                @endif
                                                <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.date_fr}}</span>
                                                    <div class="d-flex">
                                                        <span class="fw-bold badge badge-warning">@{{item.date_depart_fr}}</span>
                                                        <i class="fa fa-minus text-dark ms-2 me-2"></i>
                                                        <span class="fw-bold badge badge-success">@{{item.date_depart_fr}}</span>
                                                    </div>
                                                </td>
                                                 <td>
                                                    <span class="fw-bold text-uppercase badge badge-primary">@{{item.type_marchandise.nom}}</span> /
                                                    <span class="fw-bold text-uppercase badge badge-warning">@{{item.type_importation.nom}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-uppercase badge badge-pill badge-light-primary">@{{item.type_dossier.nom}}</span>
                                                    <span class="text-muted fw-bold text-uppercase d-none" ng-repeat="ssitem in item.type_dossiers">
                                                        <span class="badge badge-pill badge-light-primary">@{{ssitem.nom}}</i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-@{{item.color_status}}">@{{item.status_fr}}</span>
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
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit', item.id)" title="{{ __('customlang.modifier') }}">
                                                                    <i class="flaticon2-edit"></i>
                                                                </button>
                                                                <button ng-if="!item.status" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event,'ordretransit', 1, item, {mode:2, title: '{{__('customlang.activer_ordretransit')}}'})">
                                                                    <i class="fa fa-thumbs-up"></i>
                                                                </button>
                                                                <button ng-if="item.status" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event,'ordretransit', 0, item, {mode:2, title: '{{__('customlang.desactiver_ordretransit')}}'})">
                                                                    <i class="fa fa-thumbs-down"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('creation-ordretransit'))
                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('ordretransit',item.id,{forceChangeForm: false, isClone:true})" title="{{ __('customlang.cloner') }}">
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
            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['ordretransit'].entryLimit" ng-change="pageChanged('ordretransit')">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="d-flex flex-wrap">
            <nav aria-label="...">
                <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['ordretransit'].totalItems" ng-model="paginations['ordretransit'].currentPage" max-size="paginations['ordretransit'].maxSize" items-per-page="paginations['ordretransit'].entryLimit" ng-change="pageChanged('ordretransit')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
            </nav>
        </div>
    </div>
</div>
