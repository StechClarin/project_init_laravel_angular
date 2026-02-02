




<div class="">
    <div class="container tab-content" id="myTabContent">
        <div class="w-100">
            <div class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                <div class="titre-ch-p">
                    <div class="card-title d-flex align-self-center mb-0 me-3">
                        <span class="card-icon align-self-center">
                            <span class="svg-icon svg-icon-primary">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-pays.svg')) !!}
                            </span>
                        </span>
                        <h3 class="card-label align-self-center mb-0 ms-2">
                            Pays &nbsp;
                        </h3>
                        <span class="badge badge-primary p-3"> @{{paginations['pays'].totalItems | currency:"":0 | convertMontant}}</span>
                    </div>
                </div>
                <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    @if(auth()->user()->can('creation-pay') || auth()->user()->can('modification-pays'))
                    <a  hidden href="" class="menu-link bg-primary px-6 py-4 rounded-3" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
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
                    <div hidden class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 overtop-filterbar menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                        @if(auth()->user()->can('creation-pays'))
                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('pay')">
                            <a href="" class="menu-link px-3 py-2">
                                <span class="menu-icon" data-kt-element="icon">
                                    <span class="svg-icon svg-icon-3">
                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                    </span>
                                </span>
                                <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0" ng-click="showModalAdd('pay', {is_file_excel:true, title: 'Type d\'activités'})">
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
                        @if(auth()->user()->can('creation-pay') || auth()->user()->can('modification-pays'))
                        <div class="menu-item px-3 my-0" title="Télécharger un fichier excel modèle">
                            <a href="pay.feuille" class="menu-link px-3 py-2">
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
                                    <form ng-submit="pageChanged('pay')">
                                        <div class="form-row row animated fadeIn mt-delete">
                                            <div class="col-md-12 form-group">
                                                <input type="text" class="form-control" id="search_list_pay"
                                                    ng-model="search_list_pay"
                                                    placeholder="Rechercher par nom ..."
                                                    ng-model-options="{ debounce: 500 }"
                                                    ng-change="pageChanged('pay')">
                                            </div>
                                        </div>
                                        <div class="w-100 text-center pb-4">
                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('pay', {justWriteUrl : 'pays-pdf'})">
                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                <i class="fa fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('pay', {justWriteUrl : 'pays-excel'})">
                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                <i class="fa fa-file-excel"></i>
                                            </button>

                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('pay', true)">
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
                                                <th style="min-width: 120px">Membre CEDEAO</th>
                                                @if(auth()->user()->can('modification-pays'))
                                                    <th style="min-width: 100px">
                                                        <i class="flaticon2-settings"></i>
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['pays']">
                                                <td>
                                                    <span class="text-muted text-uppercase fw-bold">@{{item.nom}}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-success" ng-if ="item.cedeao">{{__('customlang.oui')}}</span>
                                                    <span class="badge badge-pill badge-danger" ng-if ="!item.cedeao">{{__('customlang.non')}}</span>
                                                </td>
                                                @if(auth()->user()->can('modification-pays'))
                                                    <td class="pr-0 text-right">
                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                            </label>
                                                            @if(auth()->user()->can('modification-pays'))
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm"  ng-click="showModalUpdate('pay', item.id, {queryType : 'pay'}, 'null')" title="{{__('customlang.modifier')}}">
                                                                    <i class="flaticon2-edit"></i>
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
                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['pay'].entryLimit" ng-change="pageChanged('pay', {ignore_char : true})">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="d-flex flex-wrap">
                                <nav aria-label="...">
                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['pay'].totalItems" ng-model="paginations['pay'].currentPage" max-size="paginations['pay'].maxSize" items-per-page="paginations['pay'].entryLimit" ng-change="pageChanged('pay', {ignore_char : true})" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
