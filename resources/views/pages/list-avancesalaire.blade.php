<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class=" ard-header p-5 d-flex align-items-center me-1 " >
                <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                    <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                        <div class="card-title d-flex align-self-center mb-0 me-3">
                            <span class="card-icon align-self-center">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-avancesalaire.svg')) !!}
                                </span>
                            </span>
                            <h3 class="card-label align-self-center mb-0 ms-2">
                                Avance sur salaire
                            </h3>
                        </div>
                        <span class="badge badge-primary p-3">@{{paginations['avancesalaire'].totalItems | currency:"":0 | convertMontant}}</span>
                    </h2>
                </div>
            </div>
            <div class="card-toolbar">
                @if(auth()->user()->can('creation-avancesalaire') || auth()->user()->can('modification_avancesalaire'))
                    <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                        @if(auth()->user()->can('creation-avancesalaire') || auth()->user()->can('modification-avancesalaire'))
                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('avancesalaire')">
                                <a href="" class="menu-link bg-primary px-6 py-4 rounded-3" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                        data-kt-menu-placement="bottom-end">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                {!!
                                                file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg'))
                                                !!}
                                            </span>
                                        </span>
                                    <span class="menu-title text-white text-uppercase fw-bold">Ajouter</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xxl-12">
                        <div class="card card-custom gutter-b accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                            <div class="card">
                                <div class="card-header" data-bs-toggle="collapse" data-bs-target="#filtres"
                                    aria-expanded="false" aria-controls="filtres">
                                    <div class="card-title">
                                        <div class="card-label h3">
                                            <span class="svg-icon">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                            </span>
                                            Filtres
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <span class="svg-icon bg-primary" >
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                        </span>
                                    </div>
                                </div>
                                <div id="filtres" class="card collapse">
                                    <div class="card-body">
                                        <form ng-submit="pageChanged('avancesalaire')">
                                            <div class="form-row row justify-content-center animated fadeIn mt-4">

                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input id="date_start_list_avancesalaire" type="text" class="form-control form-control-solid datedropper ignore-elt" placeholder="{{__('customlang.date_entre')}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input id="date_end_list_avancesalaire" type="text" class="form-control form-control-solid datedropper ignore-elt" placeholder="{{__('customlang.date_a')}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <select class="form-control select2 search_personnel"
                                                        id="employe_list_avancesalaire" placeholder="Employe">
                                                    </select>
                                                </div>
                                                
              

                                                <div class="col-md-12 form-group justify-content-center d-inline-flex">
                                                    <span cok_radioBtnStatus_avancesalairelass="me-3 align-self-center text-muted fw-bold">Status : &nbsp; </span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group">
                                                            <div class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="ok_radioBtnStatus_list_avancesalaire" name="status"
                                                                    data-value=0 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="ok_radioBtnStatus_list_avancesalaire">En attente</label>
                                                            </div>
                                                            <div
                                                                class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="en_attente_radioBtnStatus_list_avancesalaire" name="status"
                                                                    data-value=2 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="en_attente_radioBtnStatus_list_avancesalaire">Validé</label>
                                                            </div>
                                                            <div
                                                                class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="en_cours_radioBtnStatus_list_avancesalaire" name="status"
                                                                    data-value=1 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="en_cours_radioBtnStatus_list_avancesalaire">Non Validé</label>
                                                            </div>
                                                            
                                                            <div class="d-inline-block custom-control custom-radio">
                                                                <input type="radio"
                                                                    id="all_radioBtnStatus_list_avancesalaire" name="status"
                                                                    data-value=""
                                                                    class="custom-control-input me-2 true"
                                                                    checked=""><label
                                                                    class="custom-control-label"
                                                                    for="all_radioBtnStatus_list_avancesalaire">Tout</label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 form-group justify-content-center d-inline-flex">
                                                    <span cok_radioBtnEtat_avancesalairelass="me-3 align-self-center text-muted fw-bold">Etat : &nbsp; </span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group">
                                                            <div class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="non_radioBtnEtat_list_avancesalaire" name="etat"
                                                                    data-value=0 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="non_radioBtnEtat_list_avancesalaire">Non remboursé</label>
                                                            </div>
                                                            <div
                                                                class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="partiel_radioBtnEtat_list_avancesalaire" name="etat"
                                                                    data-value=1 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="partiel_radioBtnEtat_list_avancesalaire">Particiellement Remboursé</label>
                                                            </div>
                                                            <div
                                                                class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="ok_radioBtnEtat_list_avancesalaire" name="etat"
                                                                    data-value=2 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="ok_radioBtnEtat_list_avancesalaire">Remboursé</label>
                                                            </div>
                                                            
                                                            <div class="d-inline-block custom-control custom-radio">
                                                                <input type="radio"
                                                                    id="all_radioBtnETat_list_avancesalaire" name="etat"
                                                                    data-value=""
                                                                    class="custom-control-input me-2 true"
                                                                    checked=""><label
                                                                    class="custom-control-label"
                                                                    for="all_radioBtnETat_list_avancesalaire">Tout</label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-100 text-center pb-4">
                                                <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('avancesalaire', {justWriteUrl : 'avancesalaires-pdf'})">
                                                    <span class="d-md-block d-none pe-2 ps-2">{{__('customlang.pdf')}}</span>
                                                    <i class="fa fa-file-pdf"></i>
                                                </button>
                                                <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('avancesalaire', {justWriteUrl : 'avancesalaires-excel'})">
                                                    <span class="d-md-block d-none">{{__('customlang.excel')}}L</span>
                                                    <i class="fa fa-file-excel"></i>
                                                </button>

                                                <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                    <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                    <i class="fa fa-search"></i>
                                                </button>
                                                <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('avancesalaire', true)">
                                                    <i class="fa fa-times"></i>
                                                    <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-custom gutter-b mb-2 rounded-1">
                        <div class="card-body p-5">
                            <div class="tab-content">
                                <div class="table-responsive">
                                    <!-- <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center"> -->
                                    <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                        <thead >
                                            <tr class="rounded-4 bg-primary  table table-head-custom text-white">
                                                <th style="min-width: 120px" class="text-nowrap" style="color:white">{{ __('customlang.date') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap" style="color:white">{{ __('customlang.employe') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap" style="color:white">{{ __('customlang.montant') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap" style="color:white">{{ __('customlang.restant') }}</th>
                                                <!-- <th style="min-width: 120px" class="text-nowrap" ng-repeat="item in dataPage['avancesalaires']" ng-if="item.status == 2" >{{ __('customlang.restant') }}</th> -->
                                                <th style="min-width: 120px" class="text-nowrap" style="color:white">{{ __('customlang.statut') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap" style="color:white" >{{ __('customlang.etat') }}</th>
                                                @if(auth()->user()->can('suppression-avancesalaire') || auth()->user()->can('modification-avancesalaire') || auth()->user()->can('creation-avancesalaire'))
                                                    <th style="min-width: 100px">
                                                        <!-- <i class="flaticon2-settings"></i> -->
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg')) !!}
                                                    </th>
                                                @endif
                                            </tr>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['avancesalaires']">
                                                
                                                <td >
                                                    <span  class="text-dark">@{{item.date_fr}}</span>
                                                </td> 
                                                <td>
                                                    <span class="text-muted text-nowrap" ng-repeat="employe in dataPage['personnels']"  ng-if="employe.id === item.employe_id">
                                                        @{{ employe.nom }}  @{{ employe.prenom }} 
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="w-25 ">@{{item.montant_fr | convertMontant}}</span>
                                                </td>
                                                <td>
                                                    <span class="w-25 ">@{{item.restant_fr || 0 |convertMontant }}</span>
                                                </td>
                                                <!-- <td ng-if="item.status == 2">
                                                    <span class="badge badge-pill badge-dark">@{{item.restant}} XOF</span>
                                                </td> -->
                                                
                                                <td>
                                                    <span class="border border-2 border-warning text-nowrap text-warning rounded fw-bold" ng-if="item.status == 0"><span class="p-4">En attente</span></span>
                                                    <span class="border border-2 border-danger text-nowrap text-danger rounded fw-bold" ng-if="item.status == 1"><span class="p-2">Non validée</span></span>
                                                    <span class="border border-2 border-success text-primary rounded fw-bold" ng-if="item.status == 2"><span class="p-5">Validée</span></span>
                                                </td>
                                                <td ng-if="item.status == 2">
                                                    <span class="badge badge-pill badge-danger" ng-if="item.etat == 0">Non remboursé</span>
                                                    <span class="badge badge-pill badge-warning" ng-if="item.etat == 1">Partiellement remboursé</span>
                                                    <span class="badge badge-pill badge-dark" ng-if="item.etat == 2">Remboursé</span>
                                                </td>
                                                <td ng-if="item.status != 2">
                                                    <span class="badge badge-pill badge-dark"> </span>
                                                </td>

                                                @if(auth()->user()->can('suppression-avancesalaire') || auth()->user()->can('modification-avancesalaire') || auth()->user()->can('creation-avancesalaire'))
                                                    <td class="pr-0 text-right">
                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                                <span class="hamburger bg-dark hamburger-1"></span>
                                                                <span class="hamburger bg-dark hamburger-2"></span>
                                                                <span class="hamburger bg-dark hamburger-3"></span>
                                                            </label>
                                                            @if(auth()->user()->can('suppression-avancesalaire'))
                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('avancesalaire', item.id)" title="{{__('customlang.supprimer')}}">
                                                                    <i class="flaticon2-trash"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('modification-avancesalaire'))
                                                                <button ng-if="item.status == 0"  class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('avancesalaire', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                    <i class="flaticon2-edit"></i>
                                                                </button>
                                                                <button ng-if="!item.status && item.status !== 2" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.non_valide')}}" ng-click="showModalStatutNotif($event, 'avancesalaire', 1, item, {mode:2, title: 'Avance non validée'})">
                                                                    <i class="fa fa-thumbs-down"></i>
                                                                </button>
                                                                <button ng-if="item.status !== 2  && item.status !== 1" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.valide')}}" ng-click="showModalStatutNotif($event, 'avancesalaire', 2, item, {mode:2, title: 'Demande validée'})">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                                <button ng-if="item.status == 2 && item.etat !== 2" class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm"  title="{{ __('customlang.Remboursement') }}" ng-click="showModalUpdate('remboursement', item.id, {queryType:'avancesalaires', title: '{{ __('customlang.remboursement') }}'}, 'null');">
                                                                    <i class="fas fa-money-bill-alt" style="font-size:20px; color:black"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('creation-avancesalaire'))

                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('avancesalaire',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                    <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['personnel'].entryLimit" ng-change="pageChanged('personnel')">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <nav aria-label="...">
                                        <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['avancesalaire'].totalItems" ng-model="paginations['personnel'].currentPage" max-size="paginations['personnel'].maxSize" items-per-page="paginations['personnel'].entryLimit" ng-change="pageChanged('personnel')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div> 
</div>