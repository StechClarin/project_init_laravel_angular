@if (auth()->user()->can('liste-role') ||
        auth()->user()->can('creation-role') ||
        auth()->user()->can('modification-role') ||
        auth()->user()->can('suppression-role'))

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
                <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#page-profil-0" target="_self"
                            ng-click="pageChanged('role');getElements('permissions')">
                            <span class="nav-icon">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-profil.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">{{ __('customlang.profils') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#page-profil-1" target="_self"
                            ng-click="pageChanged('permission')">
                            <span class="nav-icon">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-profil.svg')) !!}
                                </span>
                            </span>
                            <span class="nav-text">{{ __('customlang.permissions') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="">
            <div class="tab-content">
                {{-- Liste profils --}}
                <div class="tab-pane fade show active" id="page-profil-0" role="tabpanel"
                    aria-labelledby="page-profil-0">
                    <div class="container">
                        {{-- <div class="d-flex flex-column-fluid p-0">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-lg-12 col-xxl-12">
                                        <div
                                            class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle">
                                            <div class="card rounded-1">
                                                <div class="card-header p-5">
                                                    <div class="card-title">
                                                        <div class="card-label h3">
                                                            <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                            </span>

                                                            {{ __('customlang.filtres') }}

                                                            <span
                                                                class="svg-icon svg-no-rotate bg-primary cursor-pointer"
                                                                style="padding: 2px 5px 2px 5px"
                                                                data-bs-toggle="collapse" data-bs-target="#filtres-p0"
                                                                aria-expanded="false" aria-controls="filtres-p0">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m-auto d-inline-flex page-head-title">
                                                        <h4
                                                            class="card-label align-self-center m-auto position-relative">
                                                            {{ __('customlang.profils') }}
                                                            <span class="badge badge-light-primary position-absolute"
                                                                style="top: -5px ; margin-left: 5px">
                                                                @{{ paginations['role'].totalItems | currency: "": 0 | convertMontant }}
                                                            </span>
                                                        </h4>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        @if (auth()->user()->can('creation-role'))
                                                            <div class="d-flex align-items-center flex-wrap">
                                                                <div class=""
                                                                    title="{{ __('customlang.ajouter') }}">
                                                                    <a target="_self" href=""
                                                                        ng-click="showModalAdd('role')">
                                                                        <span
                                                                            class="svg-icon svg-icon-lg bg-primary cursor-pointer p-3">
                                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="filtres-p0" class="card collapse">
                                                    <div class="card-body">
                                                        <form ng-submit="pageChanged('role')">
                                                            <div class="form-row animated fadeIn mt-4">
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" class="form-control"
                                                                        id="search_list_role"
                                                                        ng-model="search_list_role"
                                                                        placeholder="{{ __('customlang.rechercher_par_nom') }}"
                                                                        ng-model-options="{ debounce: 500 }"
                                                                        ng-change="pageChanged('role')">
                                                                </div>
                                                            </div>
                                                            <div class="w-100 text-center pb-4">
                                                                <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('role', {justWriteUrl : 'roles-pdf'})">
                                                                    <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                    <i class="fa fa-file-pdf"></i>
                                                                </button>
                                                                <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('role', {justWriteUrl : 'roles-excel'})">
                                                                    <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                    <i class="fa fa-file-excel"></i>
                                                                </button>

                                                                <button type="submit"
                                                                    class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                                    <span
                                                                        class="d-md-block d-none">{{ __('customlang.filter') }}</span>
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                                <button type="reset"
                                                                    class="me-2 btn shadow-sm btn-transition btn-light-dark float-end"
                                                                    ng-click="emptyForm('role', true)">
                                                                    <i class="fa fa-times"></i>
                                                                    <span
                                                                        class="d-md-block d-none">{{ __('customlang.annuler') }}</span>
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
                                                        <table
                                                            class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 100px">
                                                                        {{ __('customlang.nom') }}</th>
                                                                    <th style="min-width: 100px">
                                                                        {{ __('customlang.nbre_de_permissions') }}</th>
                                                                    @if (auth()->user()->can('suppression-role') || auth()->user()->can('modification-role') || auth()->user()->can('creation-role'))
                                                                        <th style="min-width: 100px">
                                                                            <i class="flaticon2-settings"></i>
                                                                        </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class=""
                                                                    ng-repeat="item in dataPage['roles']">
                                                                    <td class="text-capitalize fw-bold"><span
                                                                            class="text-muted fw-bold">@{{ item.name }}</span>
                                                                    </td>
                                                                    <td><span
                                                                            class="text-muted fw-bold">@{{ item.permissions.length }}</span>
                                                                    </td>
                                                                    @if (auth()->user()->can('suppression-role') || auth()->user()->can('modification-role') || auth()->user()->can('creation-role'))
                                                                        <td class="pr-0 text-right">
                                                                            <div
                                                                                class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                                <input type="checkbox" href="#"
                                                                                    class="menu-open" name="menu-open"
                                                                                    id="menu-open-@{{ item.id }}">
                                                                                <label
                                                                                    class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100"
                                                                                    for="menu-open-@{{ item.id }}">
                                                                                    <span
                                                                                        class="hamburger bg-template-1 hamburger-1"></span>
                                                                                    <span
                                                                                        class="hamburger bg-template-1 hamburger-2"></span>
                                                                                    <span
                                                                                        class="hamburger bg-template-1 hamburger-3"></span>
                                                                                </label>
                                                                                @if (auth()->user()->can('suppression-role'))
                                                                                    <button ng-if="item.id>1"
                                                                                        class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm"
                                                                                        ng-click="deleteElement('role', item.id)"
                                                                                        title="{{ __('customlang.supprimer') }}">
                                                                                        <i class="flaticon2-trash"></i>
                                                                                    </button>
                                                                                @endif
                                                                                @if (auth()->user()->can('modification-role'))
                                                                                    <button ng-if="item.id>1"
                                                                                        type="button"
                                                                                        class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm"
                                                                                        ng-click="showModalUpdate('role', item.id, 'null', 'null')"
                                                                                        title="{{ __('customlang.modifier') }}">
                                                                                        <i class="flaticon2-edit"></i>
                                                                                    </button>
                                                                                @endif
                                                                                @if (auth()->user()->can('creation-role'))
                                                                                    <button
                                                                                        class="menu-btn-item btn btn-sm btn-primary btn-icon font-size-sm"
                                                                                        ng-click="showModalUpdate('role',item.id,{forceChangeForm: false, isClone:true}, 'null')"
                                                                                        title="Cloner">
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
                                                    <span
                                                        class="text-muted me-3 d-none d-md-inline">{{ __('customlang.affichage_par') }}</span>
                                                    <select
                                                        class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                        style="width: 75px;" ng-model="paginations['role'].entryLimit"
                                                        ng-change="pageChanged('role')">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <nav aria-label="...">
                                                        <ul class="pagination float-md-end justify-content-center mt-1"
                                                            uib-pagination total-items="paginations['role'].totalItems"
                                                            ng-model="paginations['role'].currentPage"
                                                            max-size="paginations['role'].maxSize"
                                                            items-per-page="paginations['role'].entryLimit"
                                                            ng-change="pageChanged('role')" previous-text="‹"
                                                            next-text="›" first-text="«" last-text="»"
                                                            boundary-link-numbers="true" rotate="false"></ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                        <div class="">
                            <div class="container tab-content" id="myTabContent">
                                <div class="w-100">
                                    <div
                                        class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                                        <div class="titre-ch-p">
                                            <span class="nav-icon">
                                                <span class="svg-icon svg-icon-primary">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-profil.svg')) !!}
                                                </span>
                                            </span>
                                            <span class="fs-3 title-bold-kapp">Profils</span>
                                            <a class="icon-number px-3 text-white cursor-default">
                                                @{{ paginations['role'].totalItems | currency: "": 0 | convertMontant }}
                                                
                                            </a>
                                        </div>
                                        <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click"
                                            data-bs-trigger="hover">
                                            @if (auth()->user()->can('creation-role'))
                                            <a href="" class="menu-link bg-primary px-6 py-4 rounded-3"
                                                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                                                    data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                        </span>
                                                    </span>
                                                    <span
                                                        class="menu-title text-white text-uppercase fw-bold">Ajouter</span>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 overtop-filterbar menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
                                                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                    @if (auth()->user()->can('creation-role'))                                                    <div class="menu-item px-3 my-0"
                                                            ng-click="showModalAdd('role')">
                                                            <a href="" class="menu-link px-3 py-2">
                                                                <span class="menu-icon" data-kt-element="icon">
                                                                    <span class="svg-icon svg-icon-3">
                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                                    </span>
                                                                </span>
                                                                <span
                                                                    class="menu-title">{{ __('customlang.ajouter') }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item px-3 my-0"
                                                            ng-click="showModalAdd('profil', {is_file_excel:true, title: 'Type d\'activités'})">
                                                            <a href="" class="menu-link px-3 py-2">
                                                                <span class="menu-icon" data-kt-element="icon">
                                                                    <span class="svg-icon svg-icon-3">
                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-excel.svg')) !!}
                                                                    </span>
                                                                </span>
                                                                <span
                                                                    class="menu-title">{{ __('customlang.fichier_excel') }}</span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if (auth()->user()->can('creation-profil') || auth()->user()->can('modification-profil'))
                                                        <div class="menu-item px-3 my-0"
                                                            title="Télécharger un fichier excel modèle">
                                                            <a href="profil.feuille" class="menu-link px-3 py-2">
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
                                                            data-bs-toggle="collapse" data-bs-target="#filtres"
                                                            aria-expanded="false" aria-controls="filtresdossier">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <span class="svg-icon-tt">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                                </span>

                                                                {{-- {{__('customlang.filtres')}} --}}

                                                                <span class="fs-5 text-uppercase">Filtres</span>
                                                            </div>
                                                            <span
                                                                class="svg-icon svg-no-rotate bg-primary cursor-pointer"
                                                                style="padding: 2px 5px 2px 5px"
                                                                data-bs-toggle="collapse" data-bs-target="#filtres"
                                                                aria-expanded="false" aria-controls="filtresdossier">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div id="filtres" class="card collapse">
                                                        <div class="card-body">
                                                            <form ng-submit="pageChanged('profil')">
                                                                <div class="form-row row animated fadeIn mt-delete">
                                                                    <div class="col-md-12 form-group">
                                                                        <input type="text" class="form-control"
                                                                            id="search_list_profil"
                                                                            ng-model="search_list_profil"
                                                                            placeholder="Rechercher par nom, priorité ..."
                                                                            ng-model-options="{ debounce: 500 }"
                                                                            ng-change="pageChanged('profil')">
                                                                    </div>
                                                                </div>
                                                                <div class="w-100 text-center pb-4">
                                                                    <button type="button"
                                                                        class="me-2 btn shadow btn-transition btn-danger float-start"
                                                                        ng-click="pageChanged('profil', {justWriteUrl : 'profils-pdf'})">
                                                                        <span
                                                                            class="d-md-block d-none pr-2 pl-2">{{ __('customlang.pdf') }}</span>
                                                                        <i class="fa fa-file-pdf"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn shadow btn-transition btn-success float-start"
                                                                        ng-click="pageChanged('profil', {justWriteUrl : 'profils-excel'})">
                                                                        <span
                                                                            class="d-md-block d-none">{{ __('customlang.excel') }}</span>
                                                                        <i class="fa fa-file-excel"></i>
                                                                    </button>

                                                                    <button type="submit"
                                                                        class="btn shadow btn-transition btn-outline-primary float-end">
                                                                        <span
                                                                            class="d-md-block d-none">{{ __('customlang.filter') }}</span>
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                    <button type="reset"
                                                                        class="me-2 btn shadow-sm btn-transition btn-light-dark float-end"
                                                                        ng-click="emptyForm('profil', true)">
                                                                        <i class="fa fa-times"></i>
                                                                        <span
                                                                            class="d-md-block d-none">{{ __('customlang.annuler') }}</span>
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
                                                            <table
                                                                class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="min-width: 100px">
                                                                            {{ __('customlang.nom') }}</th>
                                                                        <th style="min-width: 100px">
                                                                            {{ __('customlang.nbre_de_permissions') }}
                                                                        </th>
                                                                        @if (auth()->user()->can('suppression-role') ||
                                                                                auth()->user()->can('modification-role') ||
                                                                                auth()->user()->can('creation-role'))
                                                                            <th style="min-width: 100px">
                                                                                <i class="flaticon2-settings"></i>
                                                                            </th>
                                                                        @endif
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class=""
                                                                        ng-repeat="item in dataPage['roles']">
                                                                        <td class="text-capitalize fw-bold"><span
                                                                                class="text-muted fw-bold">@{{ item.name }}</span>
                                                                        </td>
                                                                        <td><span
                                                                                class="text-muted fw-bold">@{{ item.permissions.length }}</span>
                                                                        </td>
                                                                        @if (auth()->user()->can('suppression-role') ||
                                                                                auth()->user()->can('modification-role') ||
                                                                                auth()->user()->can('creation-role'))
                                                                            <td class="pr-0 text-right">
                                                                                <div
                                                                                    class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                                    <input type="checkbox"
                                                                                        href="#"
                                                                                        class="menu-open"
                                                                                        name="menu-open"
                                                                                        id="menu-open-@{{ item.id }}">
                                                                                    <label
                                                                                        class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100"
                                                                                        for="menu-open-@{{ item.id }}">
                                                                                        <span
                                                                                            class="hamburger bg-template-1 hamburger-1"></span>
                                                                                        <span
                                                                                            class="hamburger bg-template-1 hamburger-2"></span>
                                                                                        <span
                                                                                            class="hamburger bg-template-1 hamburger-3"></span>
                                                                                    </label>
                                                                                    @if (auth()->user()->can('suppression-role'))
                                                                                        <button ng-if="item.id>1"
                                                                                            class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm"
                                                                                            ng-click="deleteElement('role', item.id)"
                                                                                            title="{{ __('customlang.supprimer') }}">
                                                                                            <i
                                                                                                class="flaticon2-trash"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                    @if (auth()->user()->can('modification-role'))
                                                                                        <button ng-if="item.id>1"
                                                                                            type="button"
                                                                                            class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm"
                                                                                            ng-click="showModalUpdate('role', item.id, 'null', 'null')"
                                                                                            title="{{ __('customlang.modifier') }}">
                                                                                            <i
                                                                                                class="flaticon2-edit"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                    @if (auth()->user()->can('creation-role'))
                                                                                        <button
                                                                                            class="menu-btn-item btn btn-sm btn-primary btn-icon font-size-sm"
                                                                                            ng-click="showModalUpdate('role',item.id,{forceChangeForm: false, isClone:true}, 'null')"
                                                                                            title="Cloner">
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
                                                <div
                                                    class="d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="d-flex align-items-center me-3">
                                                        <span
                                                            class="text-muted me-3 d-none d-md-inline">{{ __('customlang.affichage_par') }}</span>
                                                        <select
                                                            class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                            style="width: 75px;"
                                                            ng-model="paginations['role'].entryLimit"
                                                            ng-change="pageChanged('role')">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <nav aria-label="...">
                                                            <ul class="pagination float-md-end justify-content-center mt-1"
                                                                uib-pagination
                                                                total-items="paginations['role'].totalItems"
                                                                ng-model="paginations['role'].currentPage"
                                                                max-size="paginations['role'].maxSize"
                                                                items-per-page="paginations['role'].entryLimit"
                                                                ng-change="pageChanged('role')" previous-text="‹"
                                                                next-text="›" first-text="«" last-text="»"
                                                                boundary-link-numbers="true" rotate="false"></ul>
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

                {{-- Liste permission --}}
                <div class="tab-pane fade" id="page-profil-1" role="tabpanel" aria-labelledby="page-profil-1">
                    <div class="container">
                        {{-- <div class="d-flex flex-column-fluid p-0">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-lg-12 col-xxl-12">
                                        <div
                                            class="card card-custom mb-2 accordion accordion-solid accordion-panel accordion-svg-toggle">
                                            <div class="card rounded-1">
                                                <div class="card-header p-5">
                                                    <div class="card-title">
                                                        <div class="card-label h3">
                                                            <span class="svg-icon me-2 ps-2 svg-no-rotate">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                            </span>

                                                            {{ __('customlang.filtres') }}

                                                            <span
                                                                class="svg-icon svg-no-rotate bg-primary cursor-pointer"
                                                                style="padding: 2px 5px 2px 5px"
                                                                data-bs-toggle="collapse" data-bs-target="#filtres-p2"
                                                                aria-expanded="false" aria-controls="filtres-p2">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m-auto d-inline-flex page-head-title">
                                                        <h4
                                                            class="card-label align-self-center m-auto position-relative">
                                                            {{ __('customlang.permissions') }}
                                                            <span class="badge badge-light-primary position-absolute"
                                                                style="top: -5px ; margin-left: 5px">@{{ paginations['permission'].totalItems | currency: "": 0 | convertMontant }}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div id="filtres-p2" class="card collapse">
                                                    <div class="card-body">
                                                        <form ng-submit="pageChanged('permission')">
                                                            <div class="form-row animated fadeIn mt-4">
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" class="form-control"
                                                                        id="search_list_permission"
                                                                        ng-model="search_list_permission"
                                                                        placeholder="{{ __('customlang.rechercher_par_nom') }}"
                                                                        ng-model-options="{ debounce: 500 }"
                                                                        ng-change="pageChanged('permission')">
                                                                </div>
                                                            </div>
                                                            <div class="w-100 text-center pb-4">
                                                                <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('permission', {justWriteUrl : 'permissions-pdf'})">
                                                                    <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                                    <i class="fa fa-file-pdf"></i>
                                                                </button>
                                                                <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('permission', {justWriteUrl : 'permissions-excel'})">
                                                                    <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                                    <i class="fa fa-file-excel"></i>
                                                                </button>

                                                                <button type="submit"
                                                                    class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                                    <span
                                                                        class="d-md-block d-none">{{ __('customlang.filter') }}</span>
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                                <button type="reset"
                                                                    class="me-2 btn shadow-sm btn-transition btn-light-dark float-end"
                                                                    ng-click="emptyForm('permission', true)">
                                                                    <i class="fa fa-times"></i>
                                                                    <span
                                                                        class="d-md-block d-none">{{ __('customlang.annuler') }}</span>
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
                                                        <table
                                                            class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 250px">
                                                                        {{ __('customlang.appellation') }}</th>
                                                                    <th style="min-width: 100px">
                                                                        {{ __('customlang.description') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class=""
                                                                    ng-repeat="item in dataPage['permissions']">
                                                                    <td class="text-capitalize fw-bold">
                                                                        <span
                                                                            class="text-muted fw-bold">@{{ item.name }}</span>
                                                                        <i class="fa fa-arrow-right text-warning"></i>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-muted fw-bold">@{{ item.display_name }}</span>
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
                                                    <span
                                                        class="text-muted me-3 d-none d-md-inline">{{ __('customlang.affichage_par') }}</span>
                                                    <select
                                                        class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                        style="width: 75px;"
                                                        ng-model="paginations['permission'].entryLimit"
                                                        ng-change="pageChanged('permission')">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <nav aria-label="...">
                                                        <ul class="pagination float-md-end justify-content-center mt-1"
                                                            uib-pagination
                                                            total-items="paginations['permission'].totalItems"
                                                            ng-model="paginations['permission'].currentPage"
                                                            max-size="paginations['permission'].maxSize"
                                                            items-per-page="paginations['permission'].entryLimit"
                                                            ng-change="pageChanged('permission')" previous-text="‹"
                                                            next-text="›" first-text="«" last-text="»"
                                                            boundary-link-numbers="true" rotate="false"></ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="">
                            <div class="container tab-content" id="myTabContent">
                                <div class="w-100">
                                    <div
                                        class="d-inline-flex align-items-center justify-content-between gap-2 w-100 p-10 px-0">
                                        <div class="titre-ch-p">
                                            <span class="nav-icon">
                                                <span class="svg-icon svg-icon-primary">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-permission.svg')) !!}
                                                </span>
                                            </span>
                                            <span class="fs-3 title-bold-kapp">Permissions</span>
                                            <a class="icon-number px-3 text-white cursor-default">
                                                @{{ paginations['permission'].totalItems | currency: "": 0 | convertMontant }}
                                                </span>
                                            </a>
                                        </div>
                                        <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click"
                                            data-bs-trigger="hover">
                                            @if (auth()->user()->can('creation-permission') || auth()->user()->can('modification-permission'))
                                                <a href="" class="menu-link bg-primary px-6 py-4 rounded-3"
                                                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                                                    data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                                        </span>
                                                    </span>
                                                    <span
                                                        class="menu-title text-white text-uppercase fw-bold">Ajouter</span>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 overtop-filterbar menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
                                                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                    @if (auth()->user()->can('creation-permission'))
                                                        <div class="menu-item px-3 my-0"
                                                            ng-click="showModalAdd('permission')">
                                                            <a href="" class="menu-link px-3 py-2">
                                                                <span class="menu-icon" data-kt-element="icon">
                                                                    <span class="svg-icon svg-icon-3">
                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                                                    </span>
                                                                </span>
                                                                <span
                                                                    class="menu-title">{{ __('customlang.ajouter') }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item px-3 my-0"
                                                            ng-click="showModalAdd('permission', {is_file_excel:true, title: 'Type d\'activités'})">
                                                            <a href="" class="menu-link px-3 py-2">
                                                                <span class="menu-icon" data-kt-element="icon">
                                                                    <span class="svg-icon svg-icon-3">
                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-excel.svg')) !!}
                                                                    </span>
                                                                </span>
                                                                <span
                                                                    class="menu-title">{{ __('customlang.fichier_excel') }}</span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if (auth()->user()->can('creation-permission') || auth()->user()->can('modification-permission'))
                                                        <div class="menu-item px-3 my-0"
                                                            title="Télécharger un fichier excel modèle">
                                                            <a href="permission.feuille" class="menu-link px-3 py-2">
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
                                                            data-bs-toggle="collapse" data-bs-target="#filtres"
                                                            aria-expanded="false" aria-controls="filtresdossier">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <span class="svg-icon-tt">
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtre.svg')) !!}
                                                                </span>

                                                                {{-- {{__('customlang.filtres')}} --}}

                                                                <span class="fs-5 text-uppercase">Filtres</span>
                                                            </div>
                                                            <span
                                                                class="svg-icon svg-no-rotate bg-primary cursor-pointer"
                                                                style="padding: 2px 5px 2px 5px"
                                                                data-bs-toggle="collapse" data-bs-target="#filtres"
                                                                aria-expanded="false" aria-controls="filtresdossier">
                                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div id="filtres" class="card collapse">
                                                        <div class="card-body">
                                                            <form ng-submit="pageChanged('permission')">
                                                                <div class="form-row row animated fadeIn mt-delete">
                                                                    <div class="col-md-12 form-group">
                                                                        <input type="text" class="form-control"
                                                                            id="search_list_permission"
                                                                            ng-model="search_list_permission"
                                                                            placeholder="Rechercher par nom, priorité ..."
                                                                            ng-model-options="{ debounce: 500 }"
                                                                            ng-change="pageChanged('permission')">
                                                                    </div>
                                                                </div>
                                                                <div class="w-100 text-center pb-4">
                                                                    <button type="button"
                                                                        class="me-2 btn shadow btn-transition btn-danger float-start"
                                                                        ng-click="pageChanged('permission', {justWriteUrl : 'permissions-pdf'})">
                                                                        <span
                                                                            class="d-md-block d-none pr-2 pl-2">{{ __('customlang.pdf') }}</span>
                                                                        <i class="fa fa-file-pdf"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn shadow btn-transition btn-success float-start"
                                                                        ng-click="pageChanged('permission', {justWriteUrl : 'permissions-excel'})">
                                                                        <span
                                                                            class="d-md-block d-none">{{ __('customlang.excel') }}</span>
                                                                        <i class="fa fa-file-excel"></i>
                                                                    </button>

                                                                    <button type="submit"
                                                                        class="btn shadow btn-transition btn-outline-primary float-end">
                                                                        <span
                                                                            class="d-md-block d-none">{{ __('customlang.filter') }}</span>
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                    <button type="reset"
                                                                        class="me-2 btn shadow-sm btn-transition btn-light-dark float-end"
                                                                        ng-click="emptyForm('permission', true)">
                                                                        <i class="fa fa-times"></i>
                                                                        <span
                                                                            class="d-md-block d-none">{{ __('customlang.annuler') }}</span>
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
                                                            <table
                                                                class="m-auto table-striped table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="min-width: 250px">
                                                                            {{ __('customlang.appellation') }}</th>
                                                                        <th style="min-width: 100px">
                                                                            {{ __('customlang.description') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class=""
                                                                        ng-repeat="item in dataPage['permissions']">
                                                                        <td class="text-capitalize fw-bold">
                                                                            <span
                                                                                class="text-muted fw-bold">@{{ item.name }}</span>
                                                                            <i
                                                                                class="fa fa-arrow-right text-warning"></i>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="text-muted fw-bold">@{{ item.display_name }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card p-5 rounded-1">
                                                <div
                                                    class="d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="d-flex align-items-center me-3">
                                                        <span
                                                            class="text-muted me-3 d-none d-md-inline">{{ __('customlang.affichage_par') }}</span>
                                                        <select
                                                            class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary"
                                                            style="width: 75px;"
                                                            ng-model="paginations['permission'].entryLimit"
                                                            ng-change="pageChanged('permission')">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <nav aria-label="...">
                                                            <ul class="pagination float-md-end justify-content-center mt-1"
                                                                uib-pagination
                                                                total-items="paginations['permission'].totalItems"
                                                                ng-model="paginations['permission'].currentPage"
                                                                max-size="paginations['permission'].maxSize"
                                                                items-per-page="paginations['permission'].entryLimit"
                                                                ng-change="pageChanged('permission')"
                                                                previous-text="‹" next-text="›" first-text="«"
                                                                last-text="»" boundary-link-numbers="true"
                                                                rotate="false"></ul>
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
@endif
