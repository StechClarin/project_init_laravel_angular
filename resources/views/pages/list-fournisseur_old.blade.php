<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center me-1">
                <div class="d-flex align-items-baseline flex-wrap me-5">
                    <h2 class="d-flex align-items-center text-dark fw-bold my-1 me-3">{{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}</h2>
                    <span class="badge badge-light-primary">@{{paginations['fournisseur'].totalItems | currency:"":0 | convertMontant}}</span>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="dropdown dropdown-inline" data-toggle="tooltip" title="{{ __('customlang.ajouter') }}" data-placement="left">
                    <a href="" class="btn btn-primary btn-fixed-height fw-bold px-2 px-lg-5 me-2" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <span class="svg-icon svg-icon-lg">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                            </span>
                        <span class="d-none d-md-inline">{{ __('customlang.ajouter') }}</span>
                    </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <ul class="navi navi navi-hover text-center">
                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('fournisseur')">
                                <a href="" class="menu-link px-3 py-2">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-item.svg')) !!}
                                            </span>
                                        </span>
                                        <span class="menu-title">{{ __('customlang.ajouter') }}</span>
                                    </a>
                            </li>
                            <div class="menu-item px-3 my-0" ng-click="showModalAdd('fournisseur', {is_file_excel:true, title: 'Fournisseur'})">
                                <a href="" class="menu-link px-3 py-2">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-excel.svg')) !!}
                                            </span>
                                        </span>
                                        <span class="menu-title">{{ __('customlang.fichier_excel') }}</span>
                                    </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
                                    <span class="svg-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero" />
                                                <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div id="filtres" class="card collapse">
                                <div class="card-body">
                                    <form ng-submit="pageChanged('fournisseur')">
                                        <div class="form-row animated fadeIn mt-4">
                                            <div class="col-md-12 form-group">
                                                <input type="text" class="form-control" id="nom_fournisseur_list_fournisseur" ng-model="nom_fournisseur_list_fournisseur" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('fournisseur')">
                                            </div>
                                            <div class="col-md-12 form-group">

                                                <select id="type_fournisseur_list_fournisseur" ng-model="type_fournisseur_list_fournisseur" class="form-control">
                                                        <option value="">Type de fournisseur</option>
                                                        <option value="@{{item.id}}" ng-repeat="item in dataPage['typefournisseurs']">@{{item.libelle}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">

                                                <select id="pays_list_fournisseur" ng-model="pays_list_fournisseur" class="form-control select2">
                                                    <option value="">Pays</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['pays']">@{{item.libelle}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">

                                                <select id="devise_list_fournisseur" ng-model="devise_list_fournisseur" class="form-control select2">
                                                    <option value="">Devise</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['devises']">@{{item.libelle}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="w-100 text-center pb-4">
                                            <button type="button" class="me-2 btn shadow-sm btn-transition btn-danger float-start" ng-click="pageChanged('fournisseur', {justWriteUrl : 'fournisseurs-pdf'})">
                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                <i class="fa fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn shadow-sm btn-transition btn-success float-start" ng-click="pageChanged('fournisseur', {justWriteUrl : 'fournisseurs-excel'})">
                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                <i class="fa fa-file-excel"></i>
                                            </button>

                                            <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('fournisseur', true)">
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
                                                <th style="min-width: 120px">Code</th>
                                                <th style="min-width: 120px">Nom</th>
                                                <th style="min-width: 120px">Type</th>
                                                <th style="min-width: 120px">Email</th>
                                                <th style="min-width: 120px">Téléphone</th>
                                                <th style="min-width: 120px">Devise</th>
                                                <th style="min-width: 100px">
                                                    <i class="flaticon2-settings"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['fournisseurs']">
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.code}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.nom_fournisseur}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.typeFournisseur.libelle}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.email}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.mobile}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold">@{{item.devise.signe}}</span>
                                                </td>
                                                <td class="pr-0 text-right">
                                                    <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                            <span class="hamburger bg-template-1 hamburger-1"></span>
                                                            <span class="hamburger bg-template-1 hamburger-2"></span>
                                                            <span class="hamburger bg-template-1 hamburger-3"></span>
                                                        </label>
                                                        <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('fournisseur', item.id)" title="{{ __('customlang.supprimer') }}">
                                                            <i class="flaticon2-trash"></i>
                                                        </button>
                                                        <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('fournisseur', item.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                            <i class="flaticon2-edit"></i>
                                                        </button>
                                                        <a href="#!/detail-fournisseur/@{{item.id}}"  class="menu-btn-item btn btn-sm btn-primary btn-icon font-size-sm" target="_self" title="Voir les détails">
                                                            <i class="flaticon2-information"></i>
                                                        </a>
                                                    </div>
                                                </td>
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
            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['fournisseur'].entryLimit" ng-change="pageChanged('fournisseur')">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="d-flex flex-wrap">
            <nav aria-label="...">
                <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['fournisseur'].totalItems" ng-model="paginations['fournisseur'].currentPage" max-size="paginations['fournisseur'].maxSize" items-per-page="paginations['fournisseur'].entryLimit" ng-change="pageChanged('fournisseur')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
            </nav>
        </div>
    </div>
</div>

