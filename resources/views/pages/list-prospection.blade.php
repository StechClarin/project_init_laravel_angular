<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('prospection')|| auth()->user()->can('creation-prospection') ||  auth()->user()->can('modification-prospection') )
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-0" target="_self" ng-click="pageChanged('projetprospect')">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-sav.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">
                               Propections noyaux
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#page-tab-1" target="_self" ng-click="manageTab(0);pageChanged('surmesure');">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-mesure.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">Propections Sur Mesure</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="page-tab-0" role="tabpanel" aria-labelledby="page-tab-0">
                <div class="">
                    <div class="container tab-content" id="myTabContent">
                        <div class="w-100">
                            <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                                <div class="titre-ch-p">
                                    <span class="svg-icon-tt" >
                                        {!!
                                            file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-sav.svg'))
                                        !!}
                                    </span>
                                    <span class="fs-3 title-bold-kapp">Propections noyaux</span>
                                    <a class="icon-number px-3 text-white cursor-default">
                                       <span class="bg-primary rounded p-3"> @{{paginations['projetprospect'].totalItems | currency:"":0 | convertMontant}}
                                        </span>
                                    </a>
                                </div>
                                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                    @if(auth()->user()->can('creation-prospection') || auth()->user()->can('modification-prospection'))
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
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 overtop-filterbar menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
                                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        @if(auth()->user()->can('creation-prospection'))
                                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('projetprospect')">
                                            <a href="" class="menu-link px-3 py-2">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                    </span>
                                                </span>
                                                <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('projetprospect', {is_file_excel:true, title: 'projetprospect'})">
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
                                        @if(auth()->user()->can('creation-prospection') || auth()->user()->can('modification-prospection'))
                                        <div class="menu-item px-3 my-0" title="Télécharger un fichier excel modèle">
                                            <a href="rapportassistance.feuille" class="menu-link px-3 py-2">
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
                            <div class="row">
                                <div class="col-lg-12 col-xxl-12">
                                    <div style="z-index: 3;" class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                                        <div class="card rounded-1">
                                            <div class="card-header p-5">
                                                <div class="card-label w-100 d-flex justify-content-between align-items-center cursor-pointer"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#filtres" aria-expanded="false"
                                                    aria-controls="filtresdossier">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="card-title">
                                                            <div class="card-label h3">
                                                                <span class="svg-icon ">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                                </span>
                                                                Filtres
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="svg-icon svg-no-rotate bg-primary cursor-pointer"
                                                        style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse"
                                                        data-bs-target="#filtres" aria-expanded="false"
                                                        aria-controls="filtresdossier">
                                                        {!!
                                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg'))
                                                        !!}
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="filtres" class="card collapse">
                                                <div class="card-body">
                                                    <form ng-submit="pageChanged('projetprospect')">
                                                        <div class="form-row row justify-content-center animated fadeIn mt-4">
                                                            <div class="col-md-6 form_group">
                                                                <select id="noyaux_interne_list_projetprospect" placeholder="Noyaux"
                                                                    class="form-control form-control-solid select2 modalselect2 required"
                                                                    name="noyaux_interne_id" style="width: 100% !important;">
                                                                    <option value=""></option>
                                                                    <option value="@{{ item.id }}"
                                                                        ng-repeat="item in dataPage['noyauxinternes']">
                                                                        @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                           
                                                         
                                                            <div class="col-md-6 form-group">
                                                                <input class="form-control form-control-solid datedropper ignore-elt" id="date_start_list_projetprospect" type="text" placeholder="Entre le "/>
                                                            </div>
                                                             <div class="col-md-6 form_group">
                                                                <select id="client_list_projetprospect" placeholder="Propects"
                                                                    class="form-control form-control-solid select2 modalselect2 required"
                                                                    name="client_id" style="width: 100% !important;">
                                                                    <option value=""></option>
                                                                    <option value="@{{ item.id }}"
                                                                        ng-repeat="item in dataPage['clients']">
                                                                        @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <input class="form-control form-control-solid datedropper ignore-elt" id="date_end_list_projetprospect" type="text" placeholder="Au"/>
                                                            </div>
                                                            <div class="col-md-12 form-group justify-content-center d-inline-flex">
                                                                <span id="ok_radioBtnStatus_projetprospect" class="me-3 align-self-center text-muted fw-bold">Status : &nbsp; </span>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="input-group">

                                                                        <div
                                                                            class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="valide_radioBtnStatus_list_projetprospect" name="status"
                                                                                data-value=2 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="valide_radioBtnStatus_list_projetprospect">Validé</label>
                                                                        </div>

                                                                        <div
                                                                            class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="en_attente_radioBtnStatus_list_projetprospect" name="status"
                                                                                data-value=0 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="en_attente_radioBtnStatus_list_projetprospect">En attente</label>
                                                                        </div>

                                                                        <div
                                                                            class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="non_valide_radioBtnStatus_list_projetprospect" name="status"
                                                                                data-value=1 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="non_valide_radioBtnStatus_list_projetprospect">Non validé</label>
                                                                        </div>
                                                                        
                                                                        <div class="d-inline-block custom-control custom-radio">
                                                                            <input type="radio"
                                                                                id="all_radioBtnStatus_list_projetprospect" name="status"
                                                                                data-value=""
                                                                                class="custom-control-input me-2 true"
                                                                                checked=""><label
                                                                                class="custom-control-label"
                                                                                for="all_radioBtnStatus_list_projetprospect">Tout</label>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('projetprospect', {justWriteUrl : 'projetprospects-pdf'})">
                                                                <span class="d-md-block d-none pe-2 ps-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('projetprospect', {justWriteUrl : 'projetprospects-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}L</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>

                                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('projetprospect', true)">
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
                                                <!-- <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center"> -->
                                                <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                    <thead >
                                                        <tr class="rounded-4 bg-primary text-white">
                                                            <!-- <th style="min-width: 120px"></th> -->
                                                            <th style="min-width: 120px">{{ __('customlang.date_fr') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.prospect') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.projet') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.noyau') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.commentaire') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.status') }}</th>
                                                            <!-- <th  style="min-width: 120px">{{ __('customlang.status') }}</th> -->
                                                            @if(auth()->user()->can('suppression-projetprospect') || auth()->user()->can('modification-prospection') || auth()->user()->can('creation-prospection'))
                                                                <th style="min-width: 100px">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg')) !!}
                                                                </th>
                                                            @endif
                                                        </tr>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr class="" ng-repeat="item in dataPage['projetprospects']">
                                                            <!-- <td>
                                                                <input type="checkbox" value="item.id" name="rapportassistances[]" />
                                                            </td> -->
                                                            <td>
                                                                <span class="text-muted ">@{{item.date_fr}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted ">@{{item.client.display_text}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted " style="text-transform: uppercase;">@{{item.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted ">@{{item.noyaux_interne.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted ">@{{item.commentaires}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="border border-2 border-warning text-nowrap text-warning rounded fw-bold p-2" ng-if="item.status == 0">En attente</span>
                                                                <span class="border border-2 border-success text-nowrap text-success rounded fw-boldp  p-2" ng-if="item.status == 2">Validé</span>
                                                                <span class="border border-2 border-danger text-nowrap text-danger rounded fw-bold p-2" ng-if="item.status == 1">Non validé</span>
                                                            </td>
                                                            @if(auth()->user()->can('suppression-prospection') || auth()->user()->can('modification-prospection') || auth()->user()->can('creation-prospection'))
                                                                <td class="pr-0 text-right">
                                                                    <div class="menu-leftToRight d-flex align-items-center bg-grey justify-content-center">
                                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                                            <span class="hamburger bg-dark hamburger-1"></span>
                                                                            <span class="hamburger bg-dark hamburger-2"></span>
                                                                            <span class="hamburger bg-dark hamburger-3"></span>
                                                                        </label>
                                                                        @if(auth()->user()->can('suppression-prospection'))
                                                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('projetprospect', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                <i class="flaticon2-trash"></i>
                                                                            </button>
                                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('projetprospect', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                <i class="flaticon2-edit"></i>
                                                                            </button>
                                                                            <!-- <button ng-if="item.status !== 2" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.valide')}}" ng-click="showModalStatutNotif($event, 'projetprospect', 1, item, {mode:2, title: 'validé'})">
                                                                                <i class="fa fa-thumbs-up"></i>
                                                                            </button> -->
                                                                            <button ng-if="item.status !== 1" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.nonvalide')}}" ng-click="showModalStatutNotif($event, 'projetprospect', 1, item, {mode:2, title: 'Non validé'})">
                                                                                <i class="fa fa-thumbs-down"></i>
                                                                            </button>
                                                                            <!-- <button ng-if="item.status !== 2  && item.status !== 1" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.valide')}}" ng-click="showModalStatutNotif($event, 'projetprospect', 2, item, {mode:2, title: 'Demande validée'})">
                                                                                <i class="fa fa-check"></i>
                                                                            </button> -->
                                                                            <button ng-if="item.status !== 2 " class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm"  title="{{ __('customlang.cloture') }}" ng-click="showModalUpdate('projet', item.id, {forceChangeForm: false, isClone:true, queryType:'projetprospects', title: '{{ __('customlang.cloture') }}'}, 'null');">
                                                                                <i  class="fa fa-check" style="font-size:20px; color:primary"></i>
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
                                    <div class="container d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="d-flex align-items-center me-3">
                                            <span class="text-muted me-3 d-none d-md-inline">Affichage par</span>
                                            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                style="width: 75px;" ng-model="paginations['projetprospect'].entryLimit"
                                                ng-change="pageChanged('projetprospect')">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            <nav aria-label="...">
                                                <ul class="pagination float-end justify-content-center mt-1" uib-pagination
                                                    total-items="paginations['projetprospect'].totalItems"
                                                    ng-model="paginations['projetprospect'].currentPage"
                                                    max-size="paginations['projetprospect'].maxSize"
                                                    items-per-page="paginations['projetprospect'].entryLimit"
                                                    ng-change="pageChanged('projetprospect')" previous-text="‹" next-text="›" first-text="«"
                                                    last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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

            <div class="tab-pane fade" id="page-tab-1" role="tabpanel" aria-labelledby="page-tab-1">
                <div class="">
                    <div class="container tab-content" id="myTabContent">
                        <div class="w-100">
                            <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                                <div class="titre-ch-p">
                                    <span class="svg-icon-tt">
                                        {!!
                                            file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-sav.svg'))
                                        !!}
                                    </span>
                                    <span class="fs-3 title-bold-kapp">Propection sur mesure</span>
                                    <a class="icon-number px-3 text-white cursor-default">
                                        <span class="bg-primary rounded p-3">
                                            @{{paginations['surmesure'].totalItems | currency:"":0 | convertMontant}}
                                        </span>
                                    </a>
                                </div>
                                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" ng-click="showModalAdd('surmesure')" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                    @if(auth()->user()->can('creation-prospection') || auth()->user()->can('modification-prospection'))
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
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xxl-12">
                                    <div style="z-index: 3;" class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                                        <div class="card rounded-1">
                                            <div class="card-header p-5">
                                                <div class="card-label w-100 d-flex justify-content-between align-items-center cursor-pointer"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#filtres" aria-expanded="false"
                                                    aria-controls="filtresdossier">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="card-title">
                                                            <div class="card-label h3">
                                                                <span class="svg-icon ">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                                </span>
                                                                Filtres
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="svg-icon svg-no-rotate bg-primary cursor-pointer"
                                                        style="padding: 2px 5px 2px 5px" data-bs-toggle="collapse"
                                                        data-bs-target="#filtres" aria-expanded="false"
                                                        aria-controls="filtresdossier">
                                                        {!!
                                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg'))
                                                        !!}
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="filtres" class="card collapse">
                                                <div class="card-body">
                                                    <!-- <form ng-submit="pageChanged('projetprospect',{queries: ['noyaux_interne_id: null']})"> -->
                                                    <form ng-submit="pageChanged('surmesure')">
                                                        <div class="form-row row justify-content-center animated fadeIn mt-4">
                                                            <div class="col-md-4 form_group">
                                                                <select id="noyaux_interne_list_surmesure"  placeholder="Noyaux"
                                                                    class="form-control form-control-solid select2 modalselect2 required"
                                                                    name="noyaux_interne_id" style="width: 100% !important;">
                                                                    <option value=""></option>
                                                                    <option value="@{{ item.id }}"
                                                                        ng-repeat="item in dataPage['noyauxinternes']">
                                                                        @{{ item.nom }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                
                                                                <input class="form-control form-control-solid datedropper ignore-elt"  id="date_start_list_surmesure" type="text" placeholder="Entre le"/>
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                <input class="form-control form-control-solid datedropper ignore-elt" id="date_end_list_surmesure" type="text" placeholder="Au"/>
                                                            </div>
                                                            <div class="col-md-12 form-group justify-content-center d-inline-flex">
                                                                <span id="ok_radioBtnStatus_surmesure" class="me-3 align-self-center text-muted fw-bold">Status : &nbsp; </span>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="input-group">
                                                                        <div
                                                                            class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="valide_radioBtnStatus_list_surmesure" name="status"
                                                                                data-value=1 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="valide_radioBtnStatus_list_surmesure">Validé</label>
                                                                        </div>
                                                                        <div
                                                                            class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="en_attente_radioBtnStatus_list_surmesure" name="status"
                                                                                data-value=0 class="custom-control-input me-2"><label
                                                                                class="custom-control-label"
                                                                                for="en_attente_radioBtnStatus_list_surmesure">En attente</label>
                                                                        </div>
                                                                        <div class="d-inline-block custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                id="non_validé_radioBtnStatus_list_surmesure" name="status"
                                                                                data-value=1 class="custom-control-input me-2""><label
                                                                                class="custom-control-label"
                                                                                for="non_validé_radioBtnStatus_list_surmesure">Non Validé</label>
                                                                        </div>
                                                                        <div class="d-inline-block custom-control custom-radio">
                                                                            <input type="radio"
                                                                                id="all_radioBtnStatus_list_surmesure" name="status"
                                                                                data-value=""
                                                                                class="custom-control-input me-2 true"
                                                                                checked=""><label
                                                                                class="custom-control-label"
                                                                                for="all_radioBtnStatus_list_surmesure">Tout</label>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('surmesure', {justWriteUrl : 'projetprospects-pdf')">
                                                                <span class="d-md-block d-none pe-2 ps-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('surmesure', {justWriteUrl : 'projetprospects-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}L</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>

                                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('surmesure', true)">
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
                                                <!-- <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center"> -->
                                                <table class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                    <thead >
                                                        <tr class="rounded-4 bg-primary text-white">
                                                            <!-- <th style="min-width: 120px"></th> -->
                                                            <th style="min-width: 120px">{{ __('customlang.date_fr') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.prospect') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.projet') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.commentaire') }}</th>
                                                            <th style="min-width: 120px">{{ __('customlang.status') }}</th>
                                                            <!-- <th  style="min-width: 120px">{{ __('customlang.status') }}</th> -->
                                                            @if(auth()->user()->can('suppression-prospection') || auth()->user()->can('modification-prospection') || auth()->user()->can('creation-prospection'))
                                                                <th style="min-width: 100px">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg')) !!}
                                                                </th>
                                                            @endif
                                                        </tr>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr class="" ng-repeat="item in dataPage['surmesures']">
                                                            <!-- <td>
                                                                <input type="checkbox" value="item.id" name="rapportassistances[]" />
                                                            </td> -->
                                                            <td>
                                                                <span class="text-muted ">@{{item.date_fr}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted ">@{{item.client.display_text}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted " style="text-transform: uppercase;">@{{item.nom}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted ">@{{item.commentaires}}</span>
                                                            </td>
                                                            <td>
                                                                <span class="border border-2 border-warning text-nowrap text-warning rounded fw-bold p-2" ng-if="item.status == 0">En attente</span>
                                                                <span class="border border-2 border-success text-nowrap text-success rounded fw-boldp  p-2" ng-if="item.status == 2">Validé</span>
                                                                <span class="border border-2 border-danger text-nowrap text-danger rounded fw-bold p-2" ng-if="item.status == 1">Non validé</span>
                                                            </td>
                                                            @if(auth()->user()->can('suppression-prospection') || auth()->user()->can('modification-prospection') || auth()->user()->can('creation-prospection'))
                                                                <td class="pr-0 text-right">
                                                                    <div class="menu-leftToRight d-flex align-items-center bg-grey justify-content-center">
                                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayonb@{{ item.id }}">
                                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayonb@{{ item.id }}">
                                                                            <span class="hamburger bg-dark hamburger-1"></span>
                                                                            <span class="hamburger bg-dark hamburger-2"></span>
                                                                            <span class="hamburger bg-dark hamburger-3"></span>
                                                                        </label>
                                                                        @if(auth()->user()->can('suppression-prospection'))
                                                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('surmesure', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                <i class="flaticon2-trash"></i>
                                                                            </button>
                                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('surmesure', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                <i class="flaticon2-edit"></i>
                                                                            </button>
                                                                            <!-- <button ng-if="item.status !== 2" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.valide')}}" ng-click="showModalStatutNotif($event, 'surmesure', 1, item, {mode:2, title: 'validé'})">
                                                                                <i class="fa fa-thumbs-up"></i>
                                                                            </button> -->
                                                                            <button ng-if="item.status !== 1" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.rejeter')}}" ng-click="showModalStatutNotif($event, 'surmesure', 1, item, {mode:2, title: 'Rejeter projet'})">
                                                                                <i class="fa fa-thumbs-down"></i>
                                                                            </button>
                                                                            <!-- <button ng-if="item.status !== 2  && item.status !== 1" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.valide')}}" ng-click="showModalStatutNotif($event, 'surmesure', 2, item, {mode:2, title: 'Demande validée'})">
                                                                                <i class="fa fa-check"></i>
                                                                            </button> -->
                                                                            <button ng-if="item.status !== 2 " class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm"  title="{{ __('customlang.valide') }}" ng-click="showModalUpdate('projet', item.id, {forceChangeForm: false, isClone:true, queryType:'surmesures', title: '{{ __('customlang.valide') }}'}, 'null');">
                                                                                <i  class="fa fa-check" style="font-size:20px; color:primary"></i>
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
                                    <div class="container d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="d-flex align-items-center me-3">
                                            <span class="text-muted me-3 d-none d-md-inline">Affichage par</span>
                                            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                style="width: 75px;" ng-model="paginations['surmesure'].entryLimit"
                                                ng-change="pageChanged('surmesure')">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            <nav aria-label="...">
                                                <ul class="pagination float-end justify-content-center mt-1" uib-pagination
                                                    total-items="paginations['surmesure'].totalItems"
                                                    ng-model="paginations['surmesure'].currentPage"
                                                    max-size="paginations['surmesure'].maxSize"
                                                    items-per-page="paginations['surmesure'].entryLimit"
                                                    ng-change="pageChanged('surmesure')" previous-text="‹" next-text="›" first-text="«"
                                                    last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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
