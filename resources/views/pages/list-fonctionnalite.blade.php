<div class="">
    <div class="container tab-content" id="myTabContent">
        <div class="w-100">
            <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                <div class="titre-ch-p">
                    <div class="card-title d-flex align-self-center mb-0 me-3">
                        <span class="card-icon align-self-center">
                            <span class="svg-icon svg-icon-primary">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-fonction.svg')) !!}
                            </span>
                        </span>
                        <h3 class="card-label align-self-center mb-0 ms-2">
                            Fonctionnalités &nbsp;
                        </h3>
                        <span class="badge badge-primary p-3"> @{{paginations['fonctionnalite'].totalItems | currency:"":0 | convertMontant}}</span>
                    </div>
                </div>
                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    @if(auth()->user()->can('creation-fonctionnalite') || auth()->user()->can('modification-fonctionnalite'))
                    <a href="" class="menu-link bg-primary px-6 py-4 rounded-3" ng-click="showModalAdd('fonctionnalite')" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
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
                    <div
                        class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle mb-10">
                        <div class="card rounded-1">
                            <div class="card-header p-5">
                                <div class="card-label w-100 d-flex justify-content-between align-items-center cursor-pointer"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#filtres" aria-expanded="false"
                                    aria-controls="filtresdossier">
                                    <div class="card-title">
                                        <div class="card-label h3">
                                            <span class="svg-icon">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                            </span>
                                            Filtres
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
                                    <form ng-submit="pageChanged('fonctionnalite')">
                                        <div class="w-100 text-center pb-4">
                                            <div class="form-row row animated fadeIn mt-delete">
                                                <div class="col-md-12 form-group">
                                                    <input type="text" class="form-control" id="search_list_fonctionnalite"
                                                        ng-model="search_list_fonctionnalite"
                                                        placeholder="Rechercher par nom, priorité ..."
                                                        ng-model-options="{ debounce: 500 }"
                                                        ng-change="pageChanged('fonctionnalite')">
                                                </div>
                                            </div>
                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('fonctionnalite', {justWriteUrl : 'fonctionnalites-pdf'})">
                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                <i class="fa fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('fonctionnalite', {justWriteUrl : 'fonctionnalites-excel'})">
                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                <i class="fa fa-file-excel"></i>
                                            </button>

                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('fonctionnalite', true)">
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
                                            <tr class="bg-primary text-white">
                                                <th style="min-width: 120px">{{ __('customlang.nom')}}</th>
                                                <th style="min-width: 120px">{{ __('customlang.version')}}</th>
                                                <th style="min-width: 120px">{{ __('customlang.description') }}</th>
                                                @if(auth()->user()->can('suppression-fonctionnalite') || auth()->user()->can('modification-fonctionnalite') || auth()->user()->can('creation-fonctionnalite'))
                                                <th style="min-width: 100px">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg')) !!}
                                                </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="item in dataPage['fonctionnalites']">
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.nom}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-white fw-bold badge badge-dark">@{{item.version}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.description}}</span>
                                                </td>
                                                <!-- <td>
                                                    <span class="border border-2 border-warning text-nowrap text-warning rounded fw-bold p-1" ng-if="item.status == 0"></span>
                                                    <span class="border border-2 border-danger text-nowrap text-danger rounded fw-bold p-1" ng-if="item.status == 1">En attente</span>
                                                    <span class="border border-2 border-success text-nowrap text-success rounded fw-bold p-1" ng-if="item.status == 2">Cloturé</span>
                                                </td> -->
                                                @if(auth()->user()->can('suppression-fonctionnalite') || auth()->user()->can('modification-fonctionnalite') || auth()->user()->can('creation-fonctionnalite'))
                                                <td class="pr-0 text-right">
                                                    <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-rayon@{{ item.id }}">
                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-rayon@{{ item.id }}">
                                                            <span class="hamburger bg-dark hamburger-1"></span>
                                                            <span class="hamburger bg-dark hamburger-2"></span>
                                                            <span class="hamburger bg-dark hamburger-3"></span>
                                                        </label>
                                                        @if(auth()->user()->can('suppression-fonctionnalite'))
                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('fonctionnalite', item.id)" title="{{__('customlang.supprimer')}}">
                                                            <i class="flaticon2-trash"></i>
                                                        </button>
                                                        @endif
                                                        @if(auth()->user()->can('modification-fonctionnalite'))
                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('fonctionnalite', item.id, 'null', 'null')" title="{{__('customlang.modifier')}}">
                                                            <i class="flaticon2-edit"></i>
                                                        </button>
                                                        <button ng-if="item.status == 1" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactiver')}}" ng-click="showModalStatutNotif($event, 'fonctionnalite', 1, item, {mode:2, title: 'Mettre en attente'})">
                                                            <i class="fa fa-thumbs-down"></i>
                                                        </button>
                                                        <button ng-if="item.status==0" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activer')}}" ng-click="showModalStatutNotif($event, 'fonctionnalite', 0, item, {mode:2, title: 'Mettre en cours '})">
                                                            <i class="fa fa-thumbs-up"></i>
                                                        </button>
                                                        <!-- <button ng-if="item.status !== 2" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.cloture')}}" ng-click="showModalStatutNotif($event, 'fonctionnalite', 2, item, {mode:2, title: 'Cloturé'})">
                                                                    <i class="fa fa-check"></i>
                                                                </button> -->
                                                        @endif
                                                        @if(auth()->user()->can('creation-fonctionnalite'))
                                                        <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('fonctionnalite',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['fonctionnalite'].entryLimit" ng-change="pageChanged('fonctionnalite')">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="d-flex flex-wrap">
                                <nav aria-label="...">
                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['fonctionnalite'].totalItems" ng-model="paginations['fonctionnalite'].currentPage" max-size="paginations['fonctionnalite'].maxSize" items-per-page="paginations['fonctionnalite'].entryLimit" ng-change="pageChanged('fonctionnalite')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>