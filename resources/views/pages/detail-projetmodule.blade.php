<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    
    <div class="">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="page-tab-0" role="tabpanel" aria-labelledby="page-tab-0">
                <div class="">
                    <div class="container tab-content" id="myTabContent">
                        <div class="w-100">
                            <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                                <div class="titre-ch-p">
                                    <div class="card-title d-flex align-self-center mb-0 me-3">
                                        <span class="card-icon align-self-center">
                                            <span class="svg-icon svg-icon-primary">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-gestionprojet.svg')) !!}
                                            </span>
                                        </span>
                                        <h3 class="card-label align-self-center mb-0 ms-2 fs-3 text-muted" style="color:gray">
                                            <a ng-href="#!/list-gestionprojet">{{ __('customlang.gestionprojet') }}</a> &nbsp;| 
                                        </h3>
                                        <h3 class="card-label align-self-center text-muted mb-0 ms-2">
                                            <a ng-href="#!/detail-projet/@{{projetmoduleView.projet.id}}">@{{ projetmoduleView.projet.nom}}</a> &nbsp;|
                                                {{-- @{{ projetmoduleView.departement.nom}} --}}
                                        </h3>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12 col-xxl-12">
                                    <div class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                                        <div class="card rounded-5 ">
                                            <div class="card-header p-3 border-dark">
                                                <table class="m-auto table-striped table table-head-custom table-vertical-center table-borderless table-report text-center">
                                                    <thead>
                                                        <tr style="vertical-align: baseline;" ng-repeat="item in dataPage['projetdepartements']" ng-if="item.projet_id == projetmoduleView.projet_id && item.departement_id == projetmoduleView.departement_id">
                                                            {{-- <th style="min-width: 120px">{{ __('customlang.nom') }}</th> --}}
                                                            <td class="" style="min-widtd: 120px">
                                                               
                                                                <span class="rounded fw-bold p-3 pr-4 pl-4 text-danger bg-light-danger fs-3" ng-if="projetmoduleView.status == 0">
                                                                    <span class="rounded-circle fw-bold text-danger bg-danger">&nbsp;&nbsp;&nbsp;</span>
                                                                    En attente
                                                                </span>
                                                                <span class="rounded fw-bold p-3 pr-4 pl-4 text-warning bg-light-warning fs-3"   ng-if="projetmoduleView.status == 1">
                                                                    <span class="rounded-circle fw-bold bg-warning fs-4">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                    En cours
                                                                </span>
                                                                <span class="rounded fw-bold p-3 pr-4 pl-4 text-primary bg-light-primary fs-3" ng-if="projetmoduleView.status == 2">
                                                                    <span class="rounded-circle fw-bold text-primary bg-primary">&nbsp;&nbsp;&nbsp;</span>
                                                                    Terminé
                                                                </span>
                                                            
                                                            </td>
                                                            <td style="min-widtd: 120px;"><span class="bg-dark rounded-1">&nbsp;<span></td>
                                                            <td style="min-widtd: 120px;">
                                                               
                                                                    <span class="symbol-label" style="width: 40px; height: 40px">
                                                                        <img src="{{('assets/media/logos/guindy.png') }}" width="45px" height="45px" class="border border-warning rounded-circle" alt="" />
                                                                    </span></span>
                                                                    
                                                               
                                                            </td>
                                                            <td style="min-widtd: 120px;"><span class="bg-dark rounded-1">&nbsp;</span></td>
                                                            <td style="min-widtd: 120px;"><span class="fs-2">@{{item.projet.date_debut_fr}} - @{{item.projet.date_cloture_fr}}</span></td>
                                                            <td style="min-widtd: 120px;"><span class="badge badge-dark fs-2">@{{ item.departement.nom }}</span></td>
                                                           
                                                        </tr>
                                                    </thead>
                                                    </tr>
                                               </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- @{{projetmoduleView.fonctionnalite_modules}} -->
                                    <div class="card rounded-7 mb-2" ng-repeat="fonction in dataPage['fonctionnalites']">
                                        <div  ng-repeat="item in projetmoduleView.fonctionnalite_modules" >
                                            <div ng-if="item.fonctionnalite_id == fonction.id">
                                                <div class="card-header p-2" >
                                                    <table class="m-auto table-striped table table-head-custom table-vertical-center fw-bold table-borderless text-center">
                                                        <thead>
                                                            <tr class="justify-content-between fs-3 ">
                                                                <td  class="text-start  text-primary justify-content-center pl-4" style="min-widtd: 120px">
                                                                    <span>&nbsp;&nbsp;@{{ fonction.nom }}<sup></sup></span>
                                                                    <span class="border border-warning badge badge-dark" ng-if="fonction.version !=='--'">@{{fonction.version}}</span>
                                                                    <span>&nbsp;</span>
                                                                    @if(auth()->user()->can('creation-tache'))
                                                                        <button class="menu-btn-item btn btn-sm btn-icon font-size-sm" ng-click="showModalUpdate('tachefonctionnalite',item.id,{forceChangeForm: false, isClone:true, queryType:'fonctionnalitemodules'}, 'null')" title="{{ __('customlang.cloner') }}">
                                                                            <i class="flaticon2-add text-primary fs-1 w-50 h-50 d-inline-flex align-items-center justify-content-center" ></i>
                                                                        </button>
                                                                    @endif
                                                                    
                                                                </td>
                                                                <td  class="text-end" style="min-widtd: 120px">
                                                                    <span class="cursor-pointer text-danger" ng-if="item.status == 0">
                                                                        {!!
                                                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-blocked.svg'))
                                                                        !!}
                                                                    </span>
                                                                    <span class="cursor-pointer text-warning" ng-if="item.status == 1">
                                                                        {!!
                                                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-hourglass.svg'))
                                                                        !!}
                                                                    </span>
                                                                    <span class="cursor-pointer text-primary" ng-if="item.status == 2">
                                                                        {!!
                                                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-check.svg'))
                                                                        !!}
                                                                    </span>
                                                                    <span>@{{ item.duree }} heures</span>  
                                                                    <span>&nbsp;</span>
                                                                    <span>&nbsp;</span>
                                                                    <span>&nbsp;</span>
                                                                    <span>&nbsp;</span>
                                                                    <span class="cursor-pointer svg-icon-primary"
                                                                        data-bs-toggle="collapse"
                                                                        style="padding: 0px 5px 0px 5px"
                                                                        data-bs-target="#@{{fonction.str_nom}}" aria-expanded="false">
                                                                        {!!
                                                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-down.svg'))
                                                                        !!}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div  id="@{{fonction.str_nom}}" class="card collapse" >
                                            <div class="card-body">
                                                <form ng-submit="pageChanged('tachefonctionnalites')" >
                                                    <div class="tab-content">
                                                        <div class="table-responsive">
                                                            <table class="m-auto table-striped table table-head-custom table-vertical-center table-borderless table-report text-center"  ng-if="fonction.tache_fonctionnalites.length > 0">
                                                                <thead>
                                                                    <tr>
                                                                        {{-- <th style="min-width: 120px">{{ __('customlang.nom') }}</th> --}}
                                                                        <th style="min-width: 120px"></th>
                                                                        <th class="fw-bold fs-4" style="min-width: 120px">{{ __('customlang.termine') }}</th>
                                                                        <th style="min-width: 120px"></th>
                                                                        <th class="fw-bold fs-4" style="min-width: 120px">{{ __('customlang.visa') }}</th>
                                                                        <th style="min-width: 120px"></th>
                                                                        <th class="fw-bold fs-4" style="min-width: 120px">{{ __('customlang.vsa_cto_cdp') }}</th>
                                                                        <th style="min-width: 120px"></th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody ng-if="fonction.tache_fonctionnalites.length > 0" ng-if="item.fonctionnalite_id == fonction.id">
                                                                    <tr  ng-repeat="tache in fonction.tache_fonctionnalites"ng-if="item.id == tache.fonctionnalite_id" >
                                                                        <td>
                                                                            <span class="fs-4">@{{ tache.tache.nom }}</span>
                                                                        </td>
                                                                        <td>
                                                                            {{-- ng-repeat="vs in tache.visas | limitTo:1" --}}
                                                                            <span class="fw-bold  opacity-25"   ng-if="tache.status == 1 ">
                                                                                {{-- <a class="cursor-pointer"  ng-click="showModalStatutNotif($event, 'visa', 1, item, {mode:1, title: 'Terminé'})"> --}}
                                                                                    <span class="svg-icon-primary text-primary">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-up.svg')) !!}
                                                                                    </span>
                                                                                {{-- </a> --}}
                                                                            </span>
                                                                            <span class="fw-bold" ng-if="tache.status < 1">
                                                                                <a class="cursor-pointer"  ng-click="showModalStatutNotif($event, 'visa', 1, tache, {mode:1, title: 'Terminé',substatut:'visa_dev',action:'visaview'})">
                                                                                    <span class="svg-icon-primary text-primary">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-up.svg')) !!}
                                                                                    </span>
                                                                                </a>
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <div class="border border-2 rounded-3 me-2 p-3" >
                                                                                <div id="visaqualite"   class="row" ng-if="tache.visas.length > 0">
                                                                                    <div class="col-2" ng-repeat="visa in tache.visas" ng-if="visa.tache_fonctionnalite_id == tache.id">
                                                                                        <span  class="badge badge-fill" ng-class="visa.visa === 1 ? 'badge-primary' : 'badge-danger'">&nbsp;</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    
                                                                        <td class="justify-content-between opacity-25"  ng-if="tache.status == 1 || tache.visas.length == 0 ">
                                                                            <span class="fw-bold">
                                                                                {{-- <a class="cursor-pointer" ng-click="showModalStatutNotif($event, 'visachef', 1, item, {mode:1, title: 'Terminé'})> --}}
                                                                                    <span class=" svg-icon-primary">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-up.svg')) !!}
                                                                                    </span>
                                                                                {{-- </a> --}}
                                                                            </span>
                                                                            <span class="text-primary fw-bold  p-0">&nbsp;</span>
                                                                            <span class="fw-bold">
                                                                                {{-- <a class="cursor-pointer" ng-click="showModalAdd('visaqualite')"> --}}
                                                                                    <span class="text-danger">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-down.svg')) !!}
                                                                                    </span>
                                                                                {{-- </a> --}}
                                                                            </span>
                                                                        </td>
                                                                        <td class="justify-content-between" ng-repeat="vs in tache.visas | limitTo:1"  ng-if="tache.status < 1 && tache.visas.length > 0 && vs.last_visa == 1">
                                                                            <span class="fw-bold" >
                                                                                <a class="cursor-pointer"  ng-click="showModalStatutNotif($event, 'visa', 1, tache, {mode:1, title: 'Terminé',substatut:'visa_qualite',action:'visaview'})">
                                                                                    <span class="svg-icon-primary text-primary" >
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-up.svg')) !!}
                                                                                    </span>
                                                                                </a>
                                                                            </span>
                                                                            <span class="text-primary fw-bold  p-0">&nbsp;</span>
                                                                            <span class="fw-bold">
                                                                                <a class="cursor-pointer"  ng-click="showModalStatutNotif($event, 'visa', 0, tache, {mode:1, title: 'Terminé',substatut:'visa_qualite',action:'visaview'})">
                                                                                    <span class="text-danger">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-down.svg')) !!}
                                                                                    </span>
                                                                                </a>
                                                                            </span>
                                                                        </td>

                                                                        <td>
                                                                            <div class="border border-2 rounded-3 me-2 p-3">
                                                                                <div id="visaqualite"   class="row"  ng-if="tache.visa_finals.length > 0">
                                                                                    <div class="col-2"ng-repeat="visafinal in tache.visa_finals" ng-if="visafinal.tache_fonctionnalite_id == tache.id">
                                                                                        <span  class="badge badge-fill" ng-class="visafinal.visa === 1 ? 'badge-primary' : 'badge-danger'">&nbsp;</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    
                                                                        <td class="justify-content-between opacity-25" ng-if="tache.status == 1 || tache.visa_finals.length == 0 || visa.last_visa == 1 && visafinal.last_visa == 1">
                                                                            <span class="fw-bold">
                                                                                {{-- <a class="cursor-pointer" ng-click="showModalStatutNotif($event, 'visachef', 1, item, {mode:1, title: 'Terminé'})"> --}}
                                                                                    <span class=" svg-icon-primary">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-up.svg')) !!}
                                                                                    </span>
                                                                                {{-- </a> --}}
                                                                            </span>
                                                                            <span class="text-primary fw-bold  p-0">&nbsp;</span>
                                                                            <span class="fw-bold">
                                                                                {{-- <a class="cursor-pointer" ng-click="showModalAdd('visachef')"> --}}
                                                                                    <span class="text-danger">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-down.svg')) !!}
                                                                                    </span>
                                                                                {{-- </a> --}}
                                                                            </span>
                                                                        </td>
                                                                        <td class="justify-content-between"  ng-if="tache.status < 1 && tache.visa_finals.length > 0 || tache.last_visa == 0">
                                                                            <span class="fw-bold">
                                                                                <a class="cursor-pointer"  ng-click="showModalStatutNotif($event, 'visa', 1, tache, {mode:1, title: 'Terminé',substatut:'visa_chef',action:'visaview'})">
                                                                                    <span class="svg-icon-primary text-primary">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-up.svg')) !!}
                                                                                    </span>
                                                                                </a>
                                                                            </span>
                                                                            <span class="text-primary fw-bold  p-0">&nbsp;</span>
                                                                            <span class="fw-bold">
                                                                                <a class="cursor-pointer"  ng-click="showModalStatutNotif($event, 'visa', 0, tache, {mode:1, title: 'Terminé',substatut:'visa_chef',action:'visaview'})">
                                                                                    <span class="text-danger">
                                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-thumbs-down.svg')) !!}
                                                                                    </span>
                                                                                </a>
                                                                            </span>
                                                                        </td>

                                                                        <td>
                                                                            <div class="border border-1 rounded-3">
                                                                                <span class="text-primary fw-bold  p-0 fs-2">@{{tache.duree}}h</span>
                                                                            </div>
                                                                        </td>

                                                                        @if(auth()->user()->can('suppression-tache') || auth()->user()->can('modification-tache') || auth()->user()->can('creation-tache'))
                                                                            <td class="pr-0 text-right">
                                                                                <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                                    <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{tache.id}}">
                                                                                    <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{tache.id}}">
                                                                                        <span class="hamburger bg-dark hamburger-1"></span>
                                                                                        <span class="hamburger bg-dark hamburger-2"></span>
                                                                                        <span class="hamburger bg-dark hamburger-3"></span>
                                                                                    </label>
                                                                                    @if(auth()->user()->can('suppression-tache'))
                                                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('tachefonctionnalite', tache.id)" title="{{__('customlang.supprimer')}}">
                                                                                            <i class="flaticon2-trash"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                    @if(auth()->user()->can('modification-tache'))
                                                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('tachefonctionnalite', tache.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                                                            <i class="flaticon2-edit"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                </div>
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="fw-bold text-center" ng-if="fonction.tache_fonctionnalites.length === 0">  
                                                                Aucune tâche créer.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
                                    <span class="fs-3 title-bold-kapp">canalslacks</span>
                                    <a class="icon-number px-3 text-white cursor-default">
                                        @{{paginations['canalslack'].totalItems | currency:"":0 | convertMontant}}
                                    </span>
                                    </a>
                                </div>
                                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                                    @if(auth()->user()->can('creation-canalslack') || auth()->user()->can('modification-canalslack'))
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
                                        @if(auth()->user()->can('creation-canalslack'))
                                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('canalslack')">
                                            <a href="" class="menu-link px-3 py-2">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                    </span>
                                                </span>
                                                <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('canalslack', {is_file_excel:true, title: 'Type d\'activités'})">
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
                                        @if(auth()->user()->can('creation-canalslack') || auth()->user()->can('modification-canalslack'))
                                        <div class="menu-item px-3 my-0" title="Télécharger un fichier excel modèle">
                                            <a href="canalslack.feuille" class="menu-link px-3 py-2">
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
                                    <div
                                        class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                                        <div class="card rounded-1">
                                            <div class="card-header p-5">
                                                <div class="card-label w-100 d-flex justify-content-between align-items-center cursor-pointer"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#filtres" aria-expanded="false"
                                                    aria-controls="filtresdossier">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="svg-icon-tt">
                                                            {!!
                                                            file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg'))
                                                            !!}
                                                        </span>
                
                                                        {{-- {{__('customlang.filtres')}} --}}
                
                                                        <span class="fs-5 text-uppercase">Filtres</span>
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
                                                    <form ng-submit="pageChanged('canalslack')">
                                                        <div class="form-row row animated fadeIn mt-delete">
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" class="form-control" id="search_list_canalslack"
                                                                    ng-model="search_list_canalslack"
                                                                    placeholder="Rechercher par nom, priorité ..."
                                                                    ng-model-options="{ debounce: 500 }"
                                                                    ng-change="pageChanged('canalslack')">
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center pb-4">
                                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('canalslack', {justWriteUrl : 'canalslacks-pdf'})">
                                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('canalslack', {justWriteUrl : 'canalslacks-excel'})">
                                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                <i class="fa fa-file-excel"></i>
                                                            </button>
                
                                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('canalslack', true)">
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
                                                                {{-- <th style="min-width: 120px">{{ __('customlang.nom') }}</th> --}}
                                                                <th style="min-width: 120px">{{ __('customlang.nom') }}</th>
                                                                <th style="min-width: 120px">{{ __('customlang.identifiant') }}</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="" ng-repeat="item in dataPage['canalslacks']">
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.nom}}</span>
                                                                </td>
                                                               
                                                                <td>
                                                                    <span class="text-muted fw-bold">@{{item.slack_id}}</span>
                                                                </td>
                
                                                                @if(auth()->user()->can('suppression-canalslack') || auth()->user()->can('modification-canalslack') || auth()->user()->can('creation-canalslack'))
                                                                    <td class="pr-0 text-right">
                                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                            </label>
                                                                            @if(auth()->user()->can('suppression-canalslack'))
                                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('canalslack', item.id)" title="{{__('customlang.supprimer')}}">
                                                                                    <i class="flaticon2-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('modification-canalslack'))
                                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('canalslack', item.id)" title="{{__('customlang.modifier')}}">
                                                                                    <i class="flaticon2-edit"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if(auth()->user()->can('creation-canalslack'))
                                                                                <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('canalslack',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['canalslack'].entryLimit" ng-change="pageChanged('canalslack')">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <nav aria-label="...">
                                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['canalslack'].totalItems" ng-model="paginations['canalslack'].currentPage" max-size="paginations['canalslack'].maxSize" items-per-page="paginations['canalslack'].entryLimit" ng-change="pageChanged('canalslack')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
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
</div>
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">   --}}
<script> 
</script> 
