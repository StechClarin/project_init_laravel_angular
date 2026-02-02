<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class=" ard-header p-5 d-flex align-items-center me-1 ">
                <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                    <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                        <div class="card-title d-flex align-self-center mb-0 me-3">
                            <span class="card-icon align-self-center">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-demandeabsence.svg')) !!}
                                </span>
                            </span>
                            <h3 class="card-label align-self-center mb-0 ms-2">
                                Demandes d'absence
                            </h3>
                        </div>
                        <span class="badge badge-primary p-3">@{{paginations['demandeabsence'].totalItems | currency:"":0 | convertMontant}}</span>
                    </h2>
                </div>
            </div>
            <div class="card-toolbar">
                @if(auth()->user()->can('creation-demandeabsence') || auth()->user()->can('modification_demandeabsence'))
                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    @if(auth()->user()->can('creation-demandeabsence') || auth()->user()->can('modification-demandeabsence'))
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
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        @if(auth()->user()->can('creation-demandeabsence'))
                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('demandeabsence')">
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
                        @if(auth()->user()->can('creation-demandeabsence') || auth()->user()->can('modification-demandeabsence'))
                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('demandeabsence', {is_file_excel:true, title: '{{ __('customlang.demandeabsence') }}'})">
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
                            <a href="demandeabsence.feuille" class="menu-link px-3 py-2">
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
                                        <span class="svg-icon bg-primary">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                        </span>
                                    </div>
                                </div>
                                <div id="filtres" class="card collapse">
                                    <div class="card-body">
                                        <form ng-submit="pageChanged('demandeabsence')">
                                            <div class="form-row row justify-content-center animated fadeIn mt-4">
                                                <div class="col-md-6 form-group">
                                                    <select class="form-control select2 search_personnel"
                                                        id="employe_list_demandeabsence" placeholder="Employe">
                                                    </select>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <input class="form-control" id="motif_list_demandeabsence" type="text" placeholder="Motif" />
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input
                                                            id="date_start_list_demandeabsence"
                                                            type="text"
                                                            class="form-control form-control-solid datedropper ignore-elt"
                                                            placeholder="{{ __('customlang.date_entre') }}"
                                                            autocomplete="off"
                                                            ng-model="dateStart">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input
                                                            id="date_end_list_demandeabsence"
                                                            type="text"
                                                            class="form-control form-control-solid datedropper ignore-elt"
                                                            placeholder="{{ __('customlang.date_a') }}"
                                                            autocomplete="off"
                                                            ng-model="dateEnd">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group justify-content-center d-inline-flex" ng-if="dateStart && dateEnd">
                                                    <span class="me-3 align-self-center text-muted fw-bold">Quand? : &nbsp; </span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group">

                                                            <!-- Option: Au début -->
                                                            <div class="d-inline-block custom-control custom-radio me-4">
                                                                <input
                                                                    type="radio"
                                                                    id="debut_radioBtnStatus_list_demandeabsence"
                                                                    name="date_mode"
                                                                    class="custom-control-input me-2"
                                                                    ng-model="dateMode"
                                                                    ng-value="'debut'">
                                                                <label
                                                                    class="custom-control-label"
                                                                    for="debut_radioBtnStatus_list_demandeabsence">
                                                                    Au début
                                                                </label>
                                                            </div>
                                                            <!-- Option: À la création -->
                                                            <div class="d-inline-block custom-control custom-radio me-4">
                                                                <input
                                                                    type="radio"
                                                                    id="fin_radioBtnStatus_list_demandeabsence"
                                                                    name="date_mode"
                                                                    class="custom-control-input me-2"
                                                                    ng-model="dateMode"
                                                                    ng-value="'creation'">
                                                                <label
                                                                    class="custom-control-label"
                                                                    for="fin_radioBtnStatus_list_demandeabsence">
                                                                    À la création
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input id="date_debut_list_demandeabsence" type="text" class="form-control form-control-solid datedropper ignore-elt" placeholder="{{__('customlang.date_debut')}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input id="date_fin_list_demandeabsence" type="text" class="form-control form-control-solid datedropper ignore-elt" placeholder="{{__('customlang.date_fin')}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input id="heure_debut_list_demandeabsence" type="text" class="form-control form-control-solid timedropper ignore-elt" placeholder="{{__('customlang.heure_a_partir')}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <input id="heure_fin_list_demandeabsence" type="text" class="form-control form-control-solid timedropper ignore-elt" placeholder="{{__('customlang.heure_a')}}" autocomplete="off">
                                                    </div>
                                                </div>




                                                <div class="col-md-12 form-group justify-content-center d-inline-flex">
                                                    <span cok_radioBtnStatus_demandeabsencelass="me-3 align-self-center text-muted fw-bold">Status : &nbsp; </span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group">
                                                            <div class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="ok_radioBtnStatus_list_demandeabsence" name="status"
                                                                    data-value=0 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="ok_radioBtnStatus_list_demandeabsence">En attente</label>
                                                            </div>
                                                            <div
                                                                class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="en_attente_Status_list_demandeabsence" name="status"
                                                                    data-value=2 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="en_attente_radioBtnStatus_list_demandeabsence">Validée</label>
                                                            </div>
                                                            <div
                                                                class="d-inline-block custom-control custom-radio me-4">
                                                                <input type="radio"
                                                                    id="en_cours_radioBtnStatus_list_demandeabsence" name="status"
                                                                    data-value=1 class="custom-control-input me-2"><label
                                                                    class="custom-control-label"
                                                                    for="en_cours_radioBtnStatus_list_demandeabsence">Non Validée</label>
                                                            </div>

                                                            <div class="d-inline-block custom-control custom-radio">
                                                                <input type="radio"
                                                                    id="all_Status_list_demandeabsence" name="status"
                                                                    data-value=""
                                                                    class="custom-control-input me-2 true"
                                                                    checked=""><label
                                                                    class="custom-control-label"
                                                                    for="all_radioBtnStatus_list_demandeabsence">Tout</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-100 text-center pb-4">
                                                <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('demandeabsence', {justWriteUrl : 'demandeabsences-pdf'})">
                                                    <span class="d-md-block d-none pe-2 ps-2">{{__('customlang.pdf')}}</span>
                                                    <i class="fa fa-file-pdf"></i>
                                                </button>
                                                <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('demandeabsence', {justWriteUrl : 'demandeabsences-excel'})">
                                                    <span class="d-md-block d-none">{{__('customlang.excel')}}L</span>
                                                    <i class="fa fa-file-excel"></i>
                                                </button>

                                                <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                    <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                    <i class="fa fa-search"></i>
                                                </button>
                                                <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('demandeabsence', true)">
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
                                        <thead>
                                            <tr class="rounded-4 bg-primary text-white">
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.date') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.employe') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.date_debut') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.date_fin') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.heure_debut') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.heure_fin') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.motif') }}</th>
                                                <th style="min-width: 120px" class="text-nowrap">{{ __('customlang.status') }}</th>
                                                @if(auth()->user()->can('suppression-demandeabsence') || auth()->user()->can('modification-demandeabsence') || auth()->user()->can('creation-demandeabsence'))
                                                <th style="min-width: 100px">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg')) !!}
                                                </th>
                                                @endif
                                            </tr>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['demandeabsences']">

                                                <td>
                                                    <span class="text-muted ">@{{item.date_fr}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted text-nowrap" ng-repeat="employe in dataPage['personnels']" ng-if="employe.id === item.employe_id">
                                                        @{{ employe.nom + ' ' + employe.prenom }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-light-primary">@{{item.date_debut_fr}}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-light-primary">@{{item.date_fin_fr}}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-light-primary" ng-if="item.heure_debut == null">@{{ ' ' }}</span>
                                                    <span class="badge badge-pill badge-light-primary" ng-if="item.heure_debut != null">@{{ item.heure_debut}}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-light-primary" ng-if="item.heure_fin == null">@{{ ' ' }}</span>
                                                    <span class="badge badge-pill badge-light-primary" ng-if="item.heure_fin != null">@{{item.heure_fin}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">@{{item.motif}}</span>
                                                </td>

                                                <td>
                                                    <span class="border border-2 border-warning text-nowrap text-warning rounded fw-bold" ng-if="item.status == 0">
                                                        <span class="p-4">En attente</span>
                                                    </span>
                                                    <span class="border border-2 border-danger text-nowrap text-danger rounded fw-bold" ng-if="item.status == 1">
                                                        <span class="p-4">Non validée</span>
                                                    </span>
                                                    <span class="border border-2 border-success text-nowrap text-success rounded fw-bold" ng-if="item.status == 2">
                                                        <span class="p-6">Validée</span>
                                                    </span>
                                                </td>

                                                @if(auth()->user()->can('suppression-demandeabsence') || auth()->user()->can('modification-demandeabsence') || auth()->user()->can('creation-demandeabsence'))
                                                <td class="pr-0 text-right">
                                                    <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                            <span class="hamburger bg-dark hamburger-1"></span>
                                                            <span class="hamburger bg-dark hamburger-2"></span>
                                                            <span class="hamburger bg-dark hamburger-3"></span>
                                                        </label>
                                                        @if(auth()->user()->can('suppression-demandeabsence'))
                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('demandeabsence', item.id)" title="{{__('customlang.supprimer')}}">
                                                            <i class="flaticon2-trash"></i>
                                                        </button>
                                                        @endif
                                                        @if(auth()->user()->can('modification-demandeabsence'))
                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('demandeabsence', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                            <i class="flaticon2-edit"></i>
                                                        </button>
                                                        <button ng-if="!item.status && item.status !== 2" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.non_valide')}}" ng-click="showModalStatutNotif($event, 'demandeabsence', 1, item, {mode:2, title: 'Demande non validée'})">
                                                            <i class="fa fa-thumbs-down"></i>
                                                        </button>
                                                        <button ng-if="item.status" class="menu-btn-item btn btn-sm btn-light-warning btn-icon font-size-sm" title="{{__('customlang.en_attente')}}" ng-click="showModalStatutNotif($event, 'demandeabsence', 0, item, {mode:2, title: 'Demande en cours '})">
                                                            <i class="fa fa-thumbs-up"></i>
                                                        </button>
                                                        <button ng-if="item.status !== 2" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.valide')}}" ng-click="showModalStatutNotif($event, 'demandeabsence', 2, item, {mode:2, title: 'Demande validée'})">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        <button class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.pdf')}}" ng-click="pageChanged('demandeabsence', {justWriteUrl : 'demandeabsences-pdf'})">
                                                            <i class="fa fa-file-pdf"></i>
                                                        </button>
                                                        @endif
                                                        @if(auth()->user()->can('creation-demandeabsence'))
                                                        <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('demandeabsence',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['demandeabsence'].entryLimit" ng-change="pageChanged('personnel')">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="d-flex flex-wrap">
                                <nav aria-label="...">
                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['demandeabsence'].totalItems" ng-model="paginations['personnel'].currentPage" max-size="paginations['personnel'].maxSize" items-per-page="paginations['personnel'].entryLimit" ng-change="pageChanged('personnel')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>