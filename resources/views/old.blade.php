<div id="modal_adddossier_old" class="modal fade" tabindex="-1" role="dialog" style="z-index: 3200">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content h-100">
            <form id="form_adddossierold" class="form h-100" accept-charset="UTF-8" ng-submit="addElement($event,'dossierold')">
                @csrf
                <input type="hidden" id="id_dossier" name="id">

                <div class="card card-custom h-100">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-gestiondossier.svg')) !!}
                                </span>
                            </span>
                            <h3 class="card-label">
                                Dossier
                                <small></small>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-adddossier-0" target="_self">
                                        <span class="nav-icon">
                                            <i class="flaticon2-information"></i>
                                        </span>
                                        <span class="nav-text">{{__('customlang.infos_generales')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab-adddossier-2" target="_self">
                                        <span class="nav-icon">
                                            <i class="fa fa-book-open"></i>
                                        </span>
                                        <span class="nav-text">Details </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mt-5">
                            <div class="tab-pane fade show active" id="tab-adddossier-0" role="tabpanel" aria-labelledby="tab-adddossier-0">
                                <div class="row d-none">
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label for="ordre_transit_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Ordre de transit</span>
                                            </label>
                                            <div class="input-group">
                                                <select id="ordre_transit_dossier" class=" form-control-solid form-control select2 modalselect2 search_ordretransit text-capitalize required" name="ordre_transit_id" placeholder="Ordre de transit">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label for="date_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">{{__('customlang.date')}}</span>
                                            </label>
                                            <input type="text" id="date_dossier" name="date" class="form-control form-control-solid required datedropper date-today"  placeholder="Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label for="niveau_habilite_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2" >
                                                <span>Niveau d'habilitation</span>
                                            </label>
                                            <select class="form-control form-control-solid select2 modalselect2 "  id="niveau_habilite_dossier" name="niveau_habilite_id" style="width: 100% !important;">
                                                <option value="">--</option>
                                                <option ng-repeat="item in dataPage['niveauhabilites']" value="@{{item.id}}">@{{item.nom}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 d-none">
                                    <div class="fv-row mb-10">
                                        <label class="fs-6 fw-semibold mb-2">Type de dossier
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Selectionner le type de dossier correspondant"></i></label>
                                        <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                            <div class="col-4" ng-repeat="item in dataPage['typedossiers'] track by $index">
                                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6" data-kt-button="true">
                                                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                        <input class="form-check-input" type="radio" id="type_dossier_@{{item.id}}_dossier" name="type_dossier_id" value="@{{item.id}}" />
                                                    </span>
                                                    <span class="ms-5">
                                                        <span class="fs-4 fw-bold text-gray-800 text-uppercase d-block">@{{item.nom}}</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(!isset(Auth::user()->client))
                                        <div class="col-md-12 d-none">
                                            <div class="d-flex flex-stack mb-8">
                                                <div class="me-5">
                                                    <label class="fs-6 fw-semibold">Exonérer
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="la tva facturé"></i>
                                                    </label>
                                                    <div class="fs-7 fw-semibold text-muted">Si c'est Exoneration, coché OUI, sinon l'inverse</div>
                                                </div>
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"  id="exo_tva_dossier" name="exo_tva" />
                                                    <span class="form-check-label fw-semibold text-muted"></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12 d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
                                        <ul class="nav nav-pills nav-pills-custom mb-3" role="tablist">
                                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4 active" data-bs-toggle="pill" href="#tab-adddossier-0-0" aria-selected="false" role="tab" tabindex="-1">
                                                    <div class="nav-icon nav-icon-primary">
                                                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-douane-color.svg')}}" class="">
                                                    </div>
                                                    <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Douane</span>
                                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                </a>
                                            </li>
                                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-adddossier-0-1" aria-selected="false" role="tab" tabindex="-1">
                                                    <div class="nav-icon">
                                                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-debours_livraison-color.svg')}}" class="">
                                                    </div>
                                                    <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Debours & livraison</span>
                                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                </a>
                                            </li>
                                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-adddossier-0-2" aria-selected="false" role="tab" tabindex="-1">
                                                    <div class="nav-icon">
                                                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-facture-color.svg')}}" class="">
                                                    </div>
                                                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Facture</span>
                                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 card card-body shadow rounded border-primary border border-dashed">
                                        <div class="tab-content mt-5">
                                            <div class="tab-pane fade show active" id="tab-adddossier-0-0" role="tabpanel" aria-labelledby="tab-adddossier-0-0">
                                                <div class="row">
                                                    <ul class="nav nav-pills nav-pills-custom mb-3 d-flex align-items-center justify-content-center" role="tablist">
                                                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4 active" data-bs-toggle="pill" href="#tab-adddossier-0-0-0" aria-selected="false" role="tab" tabindex="-1">
                                                                <div class="nav-icon nav-icon-primary">
                                                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-manifeste-color.svg')}}" class="">
                                                                </div>
                                                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Manifeste(s)</span>
                                                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-adddossier-0-0-1" aria-selected="false" role="tab" tabindex="-1">
                                                                <div class="nav-icon">
                                                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-note-detail-color.svg')}}" class="">
                                                                </div>
                                                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Note de détail</span>
                                                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-adddossier-0-0-2" aria-selected="false" role="tab" tabindex="-1">
                                                                <div class="nav-icon">
                                                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-declaration-color.svg')}}" class="">
                                                                </div>
                                                                <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Déclaration</span>
                                                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-adddossier-0-0-3" aria-selected="true" role="tab">
                                                                <div class="nav-icon">
                                                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-bae-color.svg')}}" class="nav-icon">
                                                                </div>
                                                                <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">BAE</span>
                                                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-adddossier-0-0-4" aria-selected="true" role="tab">
                                                                <div class="nav-icon">
                                                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-rattachement-color.svg')}}" class="nav-icon">
                                                                </div>
                                                                <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Rattachement</span>
                                                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="tab-adddossier-0-0-0" role="tabpanel">
                                                            <div class="row animated fadeIn">
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="ordre_transit_bl_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Connaissement</span>
                                                                        </label>
                                                                        <select id="ordre_transit_bl_manifestes_dossier" class="form-control form-control-solid select2 modalselect2" name="ordre_transit_bl" style="width: 100% !important;">
                                                                            <option value="">--</option>
                                                                            <option value="@{{item.id}}" ng-repeat="item in dataPage['ordretransitbls']">@{{item.numero}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="numero_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">N°</span>
                                                                        </label>
                                                                        <input type="text" id="numero_manifestes_dossier" class="form-control form-control-solid required" placeholder="N° du manifeste *" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="aa_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">AA</span>
                                                                        </label>
                                                                        <input id="aa_manifestes_dossier" type="number" class="form-control form-control-solid" placeholder="AA" name="aa" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="bureau_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Bureau</span>
                                                                        </label>
                                                                        <select id="bureau_manifestes_dossier" class="form-control form-control-solid select2 modalselect2" name="bureau" style="width: 100% !important;">
                                                                            <option value="">--</option>
                                                                            <option value="@{{item.id}}" ng-repeat="item in dataPage['bureaus']">@{{item.nom}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="num_article_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Article n°</span>
                                                                        </label>
                                                                        <input type="text" id="num_article_manifestes_dossier" name="num_article" class="form-control form-control-solid" placeholder="Article n°">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="date_article_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Date Article</span>
                                                                        </label>
                                                                        <input id="date_article_manifestes_dossier" type="text" class="form-control form-control-solid datedropper" placeholder="Date Article" name="date_article" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="quantite_article_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Quantité Article</span>
                                                                        </label>
                                                                        <input id="quantite_article_manifestes_dossier" type="number" class="form-control form-control-solid" placeholder="Quantité Article" name="quantite_article" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="poids_article_manifestes_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Poids total Article</span>
                                                                        </label>
                                                                        <input id="poids_article_manifestes_dossier" type="number" class="form-control form-control-solid" placeholder="Poids total Article" name="poids_article" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group mt-8 text-end">
                                                                        <button type="button" class="btn btn-light-warning" title="{{__('customlang.ajouter_un_element_au_tableau')}}" ng-click="actionSurTabPaneTagData('add','manifestes_dossier')">
                                                                            <i class="flaticon2-add pe-0"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mt-2">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 5%">#</th>
                                                                                    <th style="width: 20%">Connaissement</th>
                                                                                    <th style="width: 35%">N° - AA - Bureau</th>
                                                                                    <th style="width: 15%">Article n°</th>
                                                                                    <th style="width: 15%">Date Article</th>
                                                                                    <th style="width: 20%">Qté - Poids</th>
                                                                                    <th style="width: 20%">Fichier</th>
                                                                                    <th style="width: 5%">
                                                                                        <i class="flaticon2-settings"></i>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="animated fadeIn" ng-repeat="item in dataInTabPane['manifestes_dossier']['data']">
                                                                                    <td>
                                                                                        <div>@{{($index+1)}}</div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                                                            <select id="ordre_transit_bl_manifestes_dossier_@{{$index}}" ng-model="dataInTabPane['manifestes_dossier']['data'][$index].ordre_transit_bl_id" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                                                                                <option value="">--</option>
                                                                                                <option value="@{{item.id}}" ng-repeat="item in dataPage['ordretransitbls']">@{{item.numero}}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <input type="text" string-to-number ng-model="dataInTabPane['manifestes_dossier']['data'][$index].numero" class="form-control form-control-solid text-center" placeholder="N° *" autocomplete="off">
                                                                                            <input type="text" string-to-number ng-model="dataInTabPane['manifestes_dossier']['data'][$index].aa" class="form-control form-control-solid text-center mt-2" placeholder="N° *" autocomplete="off">
                                                                                            <select id="bureau_manifestes_dossier_@{{$index}}" ng-model="dataInTabPane['manifestes_dossier']['data'][$index].bureau_id" class="form-control form-control-solid select2 modalselect2 text-center mt-2" style="width: 100% !important;">
                                                                                                <option value="">--</option>
                                                                                                <option value="@{{item.id}}" ng-repeat="item in dataPage['bureaus']">@{{item.nom}}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <input type="text" string-to-number ng-model="dataInTabPane['manifestes_dossier']['data'][$index].num_article" class="form-control form-control-solid text-center" placeholder="N° *" autocomplete="off">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <input type="text" string-to-number ng-model="dataInTabPane['manifestes_dossier']['data'][$index].date_article" class="form-control form-control-solid text-center datedropper" placeholder="N° *" autocomplete="off">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <input type="text" string-to-number ng-model="dataInTabPane['manifestes_dossier']['data'][$index].quantite_article" class="form-control form-control-solid text-center" placeholder="N° *" autocomplete="off">
                                                                                            <input type="text" string-to-number ng-model="dataInTabPane['manifestes_dossier']['data'][$index].poids_article" class="form-control form-control-solid text-center mt-2" placeholder="N° *" autocomplete="off">
                                                                                        </div>
                                                                                    </td>

                                                                                    <td lass="align-middle">
                                                                                        <div ng-repeat="sitem in dataInTabPane['manifestes_dossier']['data'][$index].files">
                                                                                            <div>
                                                                                                <label for="@{{sitem.name}}" class="cursor-pointer">
                                                                                                    <div class="text-center box-shadow-2 image-hover-0" style="width: 80px !important;height: 60px !important;line-height: 70px !important;">
                                                                                                        <img alt="..." class="rounded w-150px image-hover border-primary" id="@{{'aff' + sitem.name}}" src="{{ asset('assets/media/svg/icons/sidebar/icon-file-upload.svg')}}" style="width: 80px !important;height: 80px !important;">
                                                                                                    </div>
                                                                                                    <div style="display: none;">
                                                                                                        <!-- les attrs data-property & data-idFile ne sont pas utilisés -->
                                                                                                        <input type="file" id="@{{sitem.name}}" data-tabpane="manifestes_dossier" data-property="numero" data-idFile="@{{index}}" name="@{{sitem.name}}" value=@{{sitem.url}} onchange="Chargerphoto('imgdossiertmanifestes_dossier', this.id, 'pdf')" class="required">
                                                                                                        <input type="hidden" id="@{{'erase_erase_' + sitem.name}}" name="@{{'erase' + 'aff' + sitem.name}}" value="">
                                                                                                    </div>
                                                                                                </label>
                                                                                            </div>
                                                                                            <button class="btn btn-sm  btn-icon btn-transition btn-shadow btn-light-danger" type="button" ng-click="eraseFile(sitem.name, $parent.$index)" style="top:-3px !important;">
                                                                                                <i class="flaticon2-trash"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <div class="d-flex align-items-center justify-content-center">
                                                                                            <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="actionSurTabPaneTagData('delete', 'bls_ordretransit', $index)" title="{{__('customlang.supprimer')}}">
                                                                                                <i class="flaticon2-trash"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tab-adddossier-0-0-1" role="tabpanel">
                                                            <div class="row animated fadeIn">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="fichier_ff_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">{{__('customlang.fichier')}}</span>
                                                                        </label>
                                                                        <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" id="fichier_ff_dossier" name="fichier_ff" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tab-adddossier-0-0-2" role="tabpanel">
                                                            <div class="row animated fadeIn">
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="num_transit_declaration_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">N° Transit</span>
                                                                        </label>
                                                                        <input id="num_transit_declaration_dossier" type="text" class="form-control form-control-solid" placeholder="N° Transit" name="num_transit_declaration" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="aa_declaration_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">AA</span>
                                                                        </label>
                                                                        <input id="aa_declaration_dossier" type="number" class="form-control form-control-solid" placeholder="AA" name="aa_transit_declaration" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="bureau_declaration_id_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Bureau</span>
                                                                        </label>
                                                                        <select id="bureau_declaration_id_dossier" class="form-control form-control-solid select2 modalselect2" name="bureau_declaration_id" style="width: 100% !important;">
                                                                            <option value="">--</option>
                                                                            <option value="@{{item.id}}" ng-repeat="item in dataPage['bureaus']">@{{item.nom}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="numero_declaration_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">N° DÉCLARATION</span>
                                                                        </label>
                                                                        <input id="numero_declaration_dossier" type="number" class="form-control form-control-solid" placeholder="N° DÉCLARATION" name="numero_declaration" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="date_declaration_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Du</span>
                                                                        </label>
                                                                        <input type="text" id="date_declaration_dossier" name="date_rattachement" class="form-control form-control-solid datedropper" placeholder="Date">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="regime_declaration_id_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">Régime</span>
                                                                        </label>
                                                                        <select id="regime_declaration_id_dossier" class="form-control form-control-solid select2 modalselect2" name="regime_declaration_id" style="width: 100% !important;">
                                                                            <option value="">--</option>
                                                                            <option value="@{{item.id}}" ng-repeat="item in dataPage['regimes']">@{{item.nom}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tab-adddossier-0-0-3" role="tabpanel">
                                                            <div class="row animated fadeIn">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="date_bae_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">{{__('customlang.date')}}</span>
                                                                        </label>
                                                                        <input type="text" id="date_bae_dossier" name="date_bae" class="form-control form-control-solid datedropper" placeholder="Date BAE">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tab-adddossier-0-0-4" role="tabpanel">
                                                            <div class="row animated fadeIn">
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="date_rattachement_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">{{__('customlang.date')}}</span>
                                                                        </label>
                                                                        <input type="text" id="date_rattachement_dossier" name="date_rattachement" class="form-control form-control-solid datedropper" placeholder="Date Rattachement">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                                        <label for="num_orbus_rattachement_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                            <span class="required">N° ORBUS</span>
                                                                        </label>
                                                                        <input type="text" id="num_orbus_rattachement_dossier" name="num_orbus_rattachement" class="form-control form-control-solid" placeholder="N° ORBUS">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="tab-adddossier-0-1" role="tabpanel" aria-labelledby="tab-adddossier-0-1">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <label for="famille_debour_debours_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span class="required">Famille</span>
                                                            </label>
                                                            <select id="famille_debour_debours_dossier" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                                                <option value="">--</option>
                                                                <option value="@{{item.id}}" ng-repeat="item in dataPage['familledebours']">@{{item.nom}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <label for="article_facturation_debours_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span class="required">Article</span>
                                                            </label>
                                                            <select id="article_facturation_debours_dossier" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                                                <option value="">--</option>
                                                                <option value="@{{item.id}}" ng-repeat="item in dataPage['articlefacturations2']">@{{item.nom}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <label for="fournisseur_debours_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span class="required">Fournisseur</span>
                                                            </label>
                                                            <select id="fournisseur_debours_dossier" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                                                <option value="">--</option>
                                                                <option value="@{{item.id}}" ng-repeat="item in dataPage['fournisseurs2']">@{{item.nom}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <label for="montant_debours_dossier" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span class="required">Montant</span>
                                                            </label>
                                                            <input type="number" id="montant_debours_dossier" class="form-control form-control-solid required" placeholder="Montant *" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group mt-8 text-end">
                                                            <button type="button" class="btn btn-light-warning" title="{{__('customlang.ajouter_un_element_au_tableau')}}" ng-click="actionSurTabPaneTagData('add','debours_dossier')">
                                                                <i class="flaticon2-add pe-0"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <div class="table-responsive">
                                                            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn p-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 5%">#</th>
                                                                        <th style="width: 10%">Article</th>
                                                                        <th style="width: 10%">Compagnie</th>
                                                                        <th style="width: 30%">Montant</th>
                                                                        <th style="width: 5%">
                                                                            <i class="flaticon2-settings"></i>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="animated fadeIn" ng-repeat="item in dataInTabPane['debours_dossier']['data']">
                                                                        <td class="p-1">
                                                                            <div>@{{($index+1)}}</div>
                                                                            @{{item.famille_debour.nom}}
                                                                        </td>
                                                                        <td class="p-1">
                                                                            <div>
                                                                                <select data-tabpane="debours_dossier" id="article_facturation_debours_dossier_@{{$index}}" ng-model="dataInTabPane['debours_dossier']['data'][$index].article_facturation_id" class="form-control form-control-solid select2 modalselect2 text-center" style="width: 100% !important;">
                                                                                    <option value="">--</option>
                                                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['familledebours']">@{{item.nom}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="p-1">
                                                                            <div>
                                                                                <select data-tabpane="debours_dossier" id="fournisseur_debours_dossier_@{{$index}}" ng-model="dataInTabPane['debours_dossier']['data'][$index].fournisseur_id" class="form-control form-control-solid select2 modalselect2 text-center" style="width: 100% !important;">
                                                                                    <option value="">--</option>
                                                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['articlefacturations']">@{{item.nom}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="p-1">
                                                                            <div>
                                                                                <input type="number" string-to-number ng-model="dataInTabPane['debours_dossier']['data'][$index].montant" class="form-control form-control-solid text-center" placeholder="Poids *" autocomplete="off">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="d-flex align-items-center justify-content-center">
                                                                                <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="actionSurTabPaneTagData('delete', 'debours_dossier', $index)" title="{{__('customlang.supprimer')}}">
                                                                                    <i class="flaticon2-trash"></i>
                                                                                </button>
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

                            <div class="tab-pane fade show" id="tab-adddossier-2" role="tabpanel" aria-labelledby="tab-adddossier-2">
                                <div class="row">

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer d-block text-end border-0">
                        <button type="button" class="btn btn-light-dark fw-bold" data-bs-dismiss="modal">{{__('customlang.annuler')}}</button>
                        <button type="submit" class="btn btn-light-primary fw-bold">{{__('customlang.valider')}}</button>
                    </div>
                </div>

                <!--Sticky modal client-->
                <ul class="sticky-modal bg-body nav flex-column pe-2 py-2">
                    <li class="nav-item mb-2" ng-if="getElementsNeeds.length > 0">
                        <a title="{{__('customlang.actualiser')}}" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-light-success" ng-click="refreshElementsNeeds()">
                            <i class="flaticon2-refresh"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a title="{{__('customlang.sauvegarder')}}" class="btn btn-sm btn-icon btn-bg-light btn-icon-primary btn-light-primary" ng-click="saveElementInCookies($event)">
                            <i class="flaticon2-circle-vol-2"></i>
                        </a>
                    </li>
                </ul>
                <!--/Sticky Toolbar-->
            </form>
        </div>
    </div>
</div>

<div class="tab-pane fade d-none" id="tab-addgestiondossier-0-2" role="tabpanel" aria-labelledby="tab-addgestiondossier-0-2">
    <div class="row">
        <ul class="nav nav-pills nav-pills-custom mb-3 d-flex align-items-center justify-content-center" role="tablist">
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4 active" data-bs-toggle="pill" href="#tab-gestiondossier-0-2-0" aria-selected="false" role="tab" tabindex="-1">
                    <div class="nav-icon nav-icon-primary">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-connaissement-color.svg')}}" class="">
                    </div>
                    <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Connaissement</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                    <div style="position: absolute; margin-left:114px; margin-top:-10px">
                        <img ng-if="bls_ordretransit_iscorrect !== true" width="20" alt="" src="{{asset('assets/media/icons/ic_alert.svg')}}" class="">
                    </div>
                    <input type="hidden" id="bls_ordretransit_iscorrect_ordretransit" ng-model="bls_ordretransit_iscorrect" name="bls_ordretransit_iscorrect" value=@{{bls_ordretransit_iscorrect}}>
                </a>
                
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addgestiondossier-0-2-1" aria-selected="false" role="tab" tabindex="-1">
                    <div class="nav-icon">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-facturefournisseur-color.svg')}}" class="">
                    </div>
                    <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Facture fournisseur</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                    <div style="position: absolute; margin-left:178px; margin-top:-10px">
                       {{--  <i ng-if="ff_ordretransit_iscorrect === true" class="flaticon-star fsize-16" style="color:green !important"></i>
                        <i ng-if="ff_ordretransit_iscorrect !== true" class="fa fa-exclamation-circle fsize-16" style="color:red !important"></i> --}}

                        <img ng-if="ff_ordretransit_iscorrect !== true" width="20" alt="" src="{{asset('assets/media/icons/ic_alert.svg')}}" class="">

                    </div>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addgestiondossier-0-2-2" aria-selected="false" role="tab" tabindex="-1">
                    <div class="nav-icon">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-facturefret-color.svg')}}" class="">
                    </div>
                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Facture Fret</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                    <div style="position: absolute; margin-left:113px; margin-top:-10px">
                        <i ng-if="fft_ordretransit_iscorrect === true" class="flaticon-star fsize-16" style="color:green !important"></i>
                        <i ng-if="fft_ordretransit_iscorrect !== true" class="fa fa-exclamation-circle fsize-16" style="color:red !important"></i>
                    </div>
                    <input type="hidden" id="fft_ordretransit_iscorrect_ordretransit" ng-model="fft_ordretransit_iscorrect" name="fft_ordretransit_iscorrect" value=@{{fft_ordretransit_iscorrect}}>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addgestiondossier-0-2-3" aria-selected="true" role="tab">
                    <div class="nav-icon">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-assurance-color.svg')}}" class="nav-icon">
                    </div>
                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Assurance</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                    <div style="position: absolute; margin-left:95px; margin-top:-10px">
                        <i ng-if="asre_ordretransit_iscorrect === true" class="flaticon-star fsize-16" style="color:green !important"></i>
                        <i ng-if="asre_ordretransit_iscorrect !== true" class="fa fa-exclamation-circle fsize-16" style="color:red !important"></i>
                    </div>
                    <input type="hidden" id="asre_ordretransit_iscorrect_ordretransit" ng-model="asre_ordretransit_iscorrect" name="asre_ordretransit_iscorrect" value=@{{asre_ordretransit_iscorrect}}>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="p-10 nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addgestiondossier-0-2-4" aria-selected="true" role="tab">
                    <div class="nav-icon">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-dpi-color.svg')}}" class="nav-icon">
                    </div>
                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">DPI</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                    <div style="position: absolute; margin-left:76px; margin-top:-10px">
                        <i ng-if="dpi_ordretransit_iscorrect === true" class="flaticon-star fsize-16" style="color:green !important"></i>
                        <i ng-if="dpi_ordretransit_iscorrect !== true" class="fa fa-exclamation-circle fsize-16" style="color:red !important"></i>
                    </div>
                    <input type="hidden" id="dpi_ordretransit_iscorrect_ordretransit" ng-model="dpi_ordretransit_iscorrect" name="dpi_ordretransit_iscorrect" value=@{{dpi_ordretransit_iscorrect}}>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="p-10 nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addgestiondossier-0-2-5" aria-selected="true" role="tab">
                    <div class="nav-icon">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-bsc-color.svg')}}" class="nav-icon">
                    </div>
                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">BSC</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                    <div style="position: absolute; margin-left:75px; margin-top:-10px">
                        <i ng-if="bsc_ordretransit_iscorrect === true" class="flaticon-star fsize-16" style="color:green !important"></i>
                        <i ng-if="bsc_ordretransit_iscorrect !== true" class="fa fa-exclamation-circle fsize-16" style="color:red !important"></i>
                    </div>
                    <input type="hidden" id="bsc_ordretransit_iscorrect_ordretransit" ng-model="bsc_ordretransit_iscorrect" name="bsc_ordretransit_iscorrect" value=@{{bsc_ordretransit_iscorrect}}>
                </a>
            </li>
            <li class="nav-item mb-3" role="presentation">
                <a class="nav-link shadow d-flex flex-center overflow-hidden w-80px h-85px" data-bs-toggle="pill" href="#tab-addgestiondossier-0-2-6" aria-selected="true" role="tab">
                    <div class="nav-icon">
                        <span class="svg-icon svg-icon-2hx svg-icon-gray-400">
                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-etc.svg')) !!}
                        </span>
                    </div>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                    {{-- <div style="position: absolute; margin-left:58px; margin-top:-54px">
                        <i ng-if="documents_ordretransit_iscorrect === true" class="flaticon-star fsize-16" style="color:green !important"></i>
                        <i ng-if="documents_ordretransit_iscorrect !== true" class="fa fa-exclamation-circle fsize-16" style="color:red !important"></i>
                    </div> --}}
                </a>
            </li>
        </ul>
        
        <div class="tab-content">
            {{-- Tab Pane Connaissement --}}
            <div class="tab-pane fade show active" id="tab-gestiondossier-0-2-0" role="tabpanel">
                <div class="row animated fadeIn">
                    <div class="col-md-12 mt-2">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 40%">N°</th>
                                        <th style="width: 25%">Type</th>
                                        <th style="width: 25%">Fichier</th>
                                        <th style="width: 5%">
                                            <i class="flaticon2-settings me-10"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="animated fadeIn" ng-repeat="item in updateItem.ordre_transit.bls">
                                        <td>
                                            <div>@{{($index+1)}}</div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" ng-readonly="item.id && item.enableEdit !== true" ng-model="dataInTabPane['bls_ordretransit']['data'][$index].numero" class="form-control form-control-solid text-center" placeholder="N° *" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column mb-8 fv-row">
                                                <label for="type_bls_ordretransit_@{{$index}}" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">Type</span>
                                                </label>
                                                <select id="type_bls_ordretransit_@{{$index}}" ng-disabled="item.id && item.enableEdit !== true" ng-model="dataInTabPane['bls_ordretransit']['data'][$index].type_id" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                                    <option value="">--</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in typebls">@{{item.nom}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div ng-repeat="sitem in dataInTabPane['bls_ordretransit']['data'][$index].files">
                                                <div>
                                                    <label for="@{{sitem.name}}" class="cursor-pointer">
                                                        <div class="text-center box-shadow-2 image-hover-0" style="width: 80px !important;height: 60px !important;line-height: 70px !important;">
                                                            <img alt="..." class="rounded w-150px image-hover border-primary" id="@{{'aff' + sitem.name}}" src="{{ asset('assets/media/svg/icons/sidebar/icon-file-upload.svg')}}" style="width: 80px !important;height: 80px !important;">
                                                        </div>
                                                        <div style="display: none;">
                                                            <!-- les attrs data-property & data-idFile ne sont pas utilisés -->
                                                            <input ng-disabled="item.id && item.enableEdit !== true" type="file" id="@{{sitem.name}}" data-tabpane="bls_ordretransit" data-property="numero" data-idFile="@{{index}}" name="@{{sitem.name}}" value=@{{sitem.url}} onchange="Chargerphoto('imgordretransitbls_ordretransit', this.id, 'pdf')" class="required">
                                                            <input type="hidden" id="@{{'erase_erase_' + sitem.name}}" name="@{{'erase' + 'aff' + sitem.name}}" value="">
                                                        </div>
                                                    </label>
                                                </div>
                                                <button ng-disabled="item.id && item.enableEdit !== true" class="btn btn-sm  btn-icon btn-transition btn-shadow btn-light-danger" type="button" ng-click="eraseFile(sitem.name, $parent.$index)" style="top:-3px !important;">
                                                    <i class="flaticon2-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button ng-if="item.id" type="button" class="menu-btn-item btn btn-sm btn-@{{item.id && item.enableEdit !== true ? 'warning' : 'success'}} btn-icon font-size-sm me-20" ng-click="allowEditOnTabPane(item,'ordretransit',$index)" title="{{__('customlang.modifier')}}">
                                                    <i class="flaticon-@{{item.id && item.enableEdit !== true ? 'lock' : 'edit'}}"></i>
                                                </button>
                                                <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm ms-2" ng-click="actionSurTabPaneTagData('delete', 'bls_ordretransit', $index)" title="{{__('customlang.supprimer')}}">
                                                    <i class="flaticon2-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Pane Facture Fournisseur --}}
            <div class="tab-pane fade" id="tab-addgestiondossier-0-2-1" role="tabpanel">
                <div class="row animated fadeIn">
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">N° facture fournisseur</span>
                            </label>
                            <input type="text" class="form-control form-control-solid required" placeholder="N°" name="num_ff" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Montant</span>
                            </label>
                            <input ng-model=""  type="number" class="form-control form-control-solid required" placeholder="Montant" name="montant_ff" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Devise</span>
                            </label>
                            <select data-id-iscorrect="ff_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="devise_ff_id" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in dataPage['devises']">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label  class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">{{__('customlang.fichier')}} facture fournisseur</span>
                            </label>
                            <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open"  ng-model="fichier_ff_ordretransit" onchange="angular.element(this).scope().checkIfDocsCorrect('ff_ordretransit', false)" name="fichier_ff" >
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Pane Facture Fret--}}
            <div class="tab-pane fade" id="tab-addgestiondossier-0-2-2" role="tabpanel">
                <div class="row animated fadeIn">
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="num_fft_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">N° facture fret</span>
                            </label>
                            <input ng-model="num_fft_ordretransit" type="text" class="form-control form-control-solid required" placeholder="N°" name="num_fft" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="montant_fft_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Montant</span>
                            </label>
                            <input ng-model="montant_fft_ordretransit" type="number" class="form-control form-control-solid required" placeholder="Montant" name="montant_fft" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="devise_fft_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Devise</span>
                            </label>
                            <select data-id-iscorrect="fft_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="devise_fft_id" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in dataPage['devises']">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="fichier_fft_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">{{__('customlang.fichier')}} facture fret</span>
                            </label>
                            <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open"  name="fichier_fft" >
                        </div>
                    </div>
                </div>
            </div>

             {{-- Tab Pane Assurance--}}
            <div class="tab-pane fade" id="tab-addgestiondossier-0-2-3" role="tabpanel">
                <div class="row animated fadeIn">
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Type</span>
                            </label>
                            <select data-id-iscorrect="asre_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="type_asre" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in typeasres">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="fichier_asre_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">{{__('customlang.fichier')}} assurance</span>
                            </label>
                            <input type="file" onchange="angular.element(this).scope().checkIfDocsCorrect('asre_ordretransit', false)" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Pane DPI --}}
            <div class="tab-pane fade" id="tab-addgestiondossier-0-2-4" role="tabpanel">
                <div class="row animated fadeIn">
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Type</span>
                            </label>
                            <select data-id-iscorrect="dpi_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="type_dpi" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in typedpis">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">{{__('customlang.fichier')}} DPI</span>
                            </label>
                            <input type="file" onchange="angular.element(this).scope().checkIfDocsCorrect('dpi_ordretransit', false)" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" >
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Pane BSC --}}
            <div class="tab-pane fade" id="tab-addgestiondossier-0-2-5" role="tabpanel">
                <div class="row animated fadeIn">
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Type</span>
                            </label>
                            <select data-id-iscorrect="bsc_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="type_bsc" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in typebscs">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="fichier_bsc_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">{{__('customlang.fichier')}} BSC</span>
                            </label>
                            <input type="file" onchange="angular.element(this).scope().checkIfDocsCorrect('bsc_ordretransit', false)" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Pane Others --}}
            <div class="tab-pane fade" id="tab-addgestiondossier-0-2-6" role="tabpanel">
                <div class="row animated fadeIn">
                    <div class="col-md-12 mt-2">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 40%">Nom du document</th>
                                        <th style="width: 25%">N°</th>
                                        <th style="width: 25%">Fichier</th>
                                        <th style="width: 5%">
                                            <i class="flaticon2-settings me-10"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="animated fadeIn" ng-repeat="item in dataInTabPane['documents_ordretransit']['data']">
                                        <td>
                                            <div>@{{($index+1)}}</div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" ng-readonly="item.id && item.enableEdit !== true" ng-model="dataInTabPane['documents_ordretransit']['data'][$index].nom" class="form-control form-control-solid text-center" placeholder="Nom Document" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" ng-readonly="item.id && item.enableEdit !== true" ng-model="dataInTabPane['documents_ordretransit']['data'][$index].numero" class="form-control form-control-solid text-center" placeholder="Numéro Docuement" autocomplete="off">
                                            </div>
                                        </td>
                                        <td lass="align-middle">
                                            <div ng-repeat="sitem in dataInTabPane['documents_ordretransit']['data'][$index].files">
                                                <div>
                                                    <label for="@{{sitem.name}}" class="cursor-pointer">
                                                        <div class="text-center box-shadow-2 image-hover-0" style="width: 80px !important;height: 60px !important;line-height: 70px !important;">
                                                            <img alt="..." class="rounded w-150px image-hover border-primary" id="@{{'aff' + sitem.name}}" src="{{ asset('assets/media/svg/icons/sidebar/icon-file-upload.svg')}}" style="width: 80px !important;height: 80px !important;">
                                                        </div>
                                                        <div style="display: none;">
                                                            <!-- les attrs data-property & data-idFile ne sont pas utilisés -->
                                                            <input type="file" ng-disabled="item.id && item.enableEdit !== true" id="@{{sitem.name}}" data-tabpane="documents_ordretransit" data-property="numero" data-idFile="@{{index}}" name="@{{sitem.name}}" value=@{{sitem.url}} onchange="Chargerphoto('imgordretransitdocuments_ordretransit', this.id, 'pdf')" class="required">
                                                            <input type="hidden" id="@{{'erase_erase_' + sitem.name}}" name="@{{'erase' + 'aff' + sitem.name}}" value="">
                                                        </div>
                                                    </label>
                                                </div>
                                                <button  ng-disabled="item.id && item.enableEdit !== true" class="btn btn-sm  btn-icon btn-transition btn-shadow btn-light-danger" type="button" ng-click="eraseFile(sitem.name, $parent.$index)" style="top:-3px !important;">
                                                    <i class="flaticon2-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button ng-if="item.id" type="button" class="menu-btn-item btn btn-sm btn-@{{item.id && item.enableEdit !== true ? 'warning' : 'success'}} btn-icon font-size-sm me-20" ng-click="allowEditOnTabPane(item,'ordretransit',$index)" title="{{__('customlang.modifier')}}">
                                                    <i class="flaticon-@{{item.id && item.enableEdit !== true ? 'lock' : 'edit'}}"></i>
                                                </button>
                                                <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm ms-2" ng-click="actionSurTabPaneTagData('delete', 'documents_ordretransit', $index)" title="{{__('customlang.supprimer')}}">
                                                    <i class="flaticon2-trash"></i>
                                                </button>
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





<div class="w-100 d-none">
    <div class="fv-row mb-10">
        <label class="fs-6 fw-semibold mb-2">Type d'importation
        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Selectionner le type d'importation correspondant"></i></label>
        <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
            <div class="col-4" ng-repeat="item in dataPage['typeimportations'] track by $index">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6" data-kt-button="true">
                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                        <input class="form-check-input" type="radio" id="type_importation_@{{item.id}}_ordretransit" name="type_importation_id" value="@{{item.id}}" />
                    </span>
                    <span class="ms-5">
                        <span class="fs-4 fw-bold text-gray-800 text-uppercase d-block">@{{item.nom}}</span>
                    </span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row d-none">
    @if(!isset(Auth::user()->client))
        <div class="col-md-12">
            <div class="d-flex flex-column mb-8 fv-row">
                <label for="niveau_habilite_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2" >
                    <span>Niveau d'habilitation</span>
                </label>
                <select class="form-control form-control-solid select2 modalselect2" id="niveau_habilite_ordretransit" name="niveau_habilite_id" style="width: 100% !important;">
                    <option value="">--</option>
                    <option ng-repeat="item in dataPage['niveauhabilites']" value="@{{item.id}}">@{{item.nom}}</option>
                </select>
            </div>
        </div>
    @endif
    <div class="@if(!isset(Auth::user()->client_id) || Auth::user()->client->type_marchandises()->count()!=1) col-md-6 @else col-md-12 @endif">
        <div class="d-flex flex-column mb-8 fv-row">
            <label for="date_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                <span class="required">{{__('customlang.date')}}</span>
            </label>
            <input type="text" id="date_ordretransit" name="date" class="form-control form-control-solid required datedropper date-today"  placeholder="Date">
        </div>
    </div>
    @if(!isset(Auth::user()->client_id) || Auth::user()->client->type_marchandises()->count()!=1)
        <div class="col-md-6">
            <div class="d-flex flex-column mb-8 fv-row">
                <label for="type_marchandise_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2" >
                    <span class="required">Type de marchandise</span>
                </label>
                <select class="form-control form-control-solid select2 modalselect2 required" id="type_marchandise_ordretransit" name="type_marchandise_id" style="width: 100% !important;">
                    <option value="">--</option>
                    <option ng-repeat="item in dataPage['typemarchandises']" value="@{{item.id}}">@{{item.nom}}</option>
                </select>
            </div>
        </div>
    @endif
    @if(!isset(Auth::user()->client_id))
        <div class="col-md-12">
            <div class="d-flex flex-column mb-8 fv-row">
                <label for="client_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                    <span class="required">Client</span>
                </label>
                <div class="input-group">
                    <select id="client_ordretransit" class=" form-control-solid form-control select2 modalselect2 search_client text-capitalize required" name="client_id" placeholder="Client">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="d-flex flex-stack mb-8">
                <div class="me-5">
                    <label class="fs-6 fw-semibold">Exonérer
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="la tva facturé"></i>
                    </label>
                    <div class="fs-7 fw-semibold text-muted">Si c'est Exoneration, coché OUI, sinon l'inverse</div>
                </div>
                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox"  id="exo_tva_ordretransit" name="exo_tva" />
                    <span class="form-check-label fw-semibold text-muted"></span>
                </label>
            </div>
        </div>
    @endif
    <div class="col-md-4">
        <div class="d-flex flex-column mb-8 fv-row">
            <label for="navire_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                <span class="">Navire</span>
            </label>
            <select id="navire_ordretransit" class="form-control form-control-solid select2 modalselect2" name="navire_id" style="width: 100% !important;">
                <option value="">--</option>
                <option value="@{{item.id}}" ng-repeat="item in dataPage['navires']">@{{item.nom}}</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex flex-column mb-8 fv-row">
            <label for="date_depart_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                <span class="">Départ</span>
            </label>
            <input type="text" id="date_depart_ordretransit" name="date_depart" class="form-control form-control-solid datedropper date-today" placeholder="Date de départ">
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex flex-column mb-8 fv-row">
            <label for="date_arrivee_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                <span class="">Arrivée prévue</span>
            </label>
            <input type="text" id="date_arrivee_ordretransit" name="date_arrivee" class="form-control form-control-solid datedropper date-today" placeholder="Date d'arrivée">
        </div>
    </div>

    <div class="col-md-12 d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
        <ul class="nav nav-pills nav-pills-custom mb-3" role="tablist">
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addordretransit-0-0" aria-selected="false" role="tab" tabindex="-1">
                    <div class="nav-icon nav-icon-primary">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-conteneur-color.svg')}}" class="">
                    </div>
                    <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Conteneur(s)</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addordretransit-0-1" aria-selected="false" role="tab" tabindex="-1">
                    <div class="nav-icon">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-marchandise-color.svg')}}" class="">
                    </div>
                    <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Marchandise(s)</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4 active" data-bs-toggle="pill" href="#tab-addordretransit-0-2" aria-selected="false" role="tab" tabindex="-1">
                    <div class="nav-icon">
                        <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-document-color.svg')}}" class="">
                    </div>
                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Document(s)</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-12 card card-body shadow rounded border-primary border border-dashed">
        <div class="tab-content mt-5">
            <div class="tab-pane fade" id="tab-addordretransit-0-0" role="tabpanel" aria-labelledby="tab-addordretransit-0-0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="quantite_conteneurs_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Quantité</span>
                            </label>
                            <input type="number" id="quantite_conteneurs_ordretransit" class="form-control form-control-solid required" placeholder="Quantité *" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="type_conteneur_conteneurs_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Type de conteneur</span>
                            </label>
                            <select id="type_conteneur_conteneurs_ordretransit" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in dataPage['typeconteneurs']">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-11">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="numero_conteneurs_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">N°(s)</span>
                            </label>
                            <input type="text" id="numero_conteneurs_ordretransit" class="form-control form-control-solid required" placeholder="Numéro(s)" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group mt-8 text-end">
                            <button type="button" class="btn btn-light-warning" title="{{__('customlang.ajouter_un_element_au_tableau')}}" ng-click="actionSurTabPaneTagData('add','conteneurs_ordretransit')">
                                <i class="flaticon2-add pe-0"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 25%">Quantité</th>
                                        <th style="width: 25%">Type de conteneur</th>
                                        <th style="width: 40%">N°</th>
                                        <th style="width: 5%">
                                            <i class="flaticon2-settings"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="animated fadeIn" ng-repeat="item in dataInTabPane['conteneurs_ordretransit']['data']">
                                        <td>
                                            <div>@{{($index+1)}}</div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="number" string-to-number ng-model="dataInTabPane['conteneurs_ordretransit']['data'][$index].quantite" class="form-control form-control-solid text-center" placeholder="Quantité *" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <select data-tabpane="conteneurs_ordretransit" id="type_conteneur_conteneurs_ordretransit_@{{$index}}" ng-model="dataInTabPane['conteneurs_ordretransit']['data'][$index].type_conteneur_id" class="form-control form-control-solid select2 modalselect2 text-center" style="width: 100% !important;">
                                                    <option value="">--</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['typeconteneurs']">@{{item.nom}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" ng-model="dataInTabPane['conteneurs_ordretransit']['data'][$index].numero" class="form-control form-control-solid text-center" placeholder="Numéro(s) *" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="actionSurTabPaneTagData('delete', 'conteneurs_ordretransit', $index)" title="{{__('customlang.supprimer')}}">
                                                    <i class="flaticon2-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-addordretransit-0-1" role="tabpanel" aria-labelledby="tab-addordretransit-0-1">
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="quantite_marchandises_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Quantité</span>
                            </label>
                            <input type="number" id="quantite_marchandises_ordretransit" class="form-control form-control-solid required" placeholder="Quantité *" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="poids_marchandises_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Poids</span>
                            </label>
                            <input type="number" id="poids_marchandises_ordretransit" class="form-control form-control-solid required" placeholder="Poids *" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="marchandise_marchandises_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Marchandise</span>
                            </label>
                            <select id="marchandise_marchandises_ordretransit" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in dataPage['marchandises']">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="nom_marchandises_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Désignation</span>
                            </label>
                            <input type="text" id="nom_marchandises_ordretransit" class="form-control form-control-solid required" placeholder="Désignation" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="unite_mesure_marchandises_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Unité de mesure</span>
                            </label>
                            <select id="unite_mesure_marchandises_ordretransit" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in dataPage['unitemesures']">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="nomenclature_douaniere_marchandises_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Nomenclature</span>
                            </label>
                            <select id="nomenclature_douaniere_marchandises_ordretransit" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="-1">Selon DPI</option>
                                <option value="-2">Selon Facture Fournisseur</option>
                                <option value="@{{item.id}}" ng-repeat="item in dataPage['nomenclaturedouanieres']">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="type_dossier_marchandises_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Type de Déclaration</span>
                            </label>
                            <select id="type_dossier_marchandises_ordretransit" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                <option value="">--</option>
                                <option value="@{{item.id}}" ng-repeat="item in dataPage['typedossiers']">@{{item.nom}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group mt-8 text-end">
                            <button type="button" class="btn btn-light-warning" title="{{__('customlang.ajouter_un_element_au_tableau')}}" ng-click="actionSurTabPaneTagData('add','marchandises_ordretransit')">
                                <i class="flaticon2-add pe-0"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn p-0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%">Quantité</th>
                                        <th style="width: 10%">Poids</th>
                                        <th style="width: 30%">Marchandise</th>
                                        <th style="width: 10%">Unité de mesure</th>
                                        <th style="width: 15%">Nomenclature</th>
                                        <th style="width: 10%">
                                            <div>
                                                <select data-tabpane="marchandises_ordretransit" id="all_type_dossier_marchandises_ordretransit" class="form-control form-control-solid select2 modalselect2 text-center" style="width: 100% !important;">
                                                    <option value="">--</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['typedossiers']">@{{item.nom}}</option>
                                                </select>
                                            </div>
                                        </th>
                                        <th style="width: 5%">
                                            <i class="flaticon2-settings"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="animated fadeIn" ng-repeat="item in dataInTabPane['marchandises_ordretransit']['data']">
                                        <td class="p-1">
                                            <div>@{{($index+1)}}</div>
                                        </td>
                                        <td class="p-1">
                                            <div>
                                                <input type="number" string-to-number ng-model="dataInTabPane['marchandises_ordretransit']['data'][$index].quantite" class="form-control form-control-solid text-center" placeholder="Quantité *" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="p-1">
                                            <div>
                                                <input type="number" string-to-number ng-model="dataInTabPane['marchandises_ordretransit']['data'][$index].poids" class="form-control form-control-solid text-center" placeholder="Poids *" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="p-1">
                                            <div>
                                                <select data-tabpane="marchandises_ordretransit" id="marchandise_marchandises_ordretransit_@{{$index}}" ng-model="dataInTabPane['marchandises_ordretransit']['data'][$index].marchandise_id" class="form-control form-control-solid select2 modalselect2 text-center" style="width: 100% !important;">
                                                    <option value="">--</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['marchandises']">@{{item.nom}}</option>
                                                </select>
                                                <input type="text" id="nom_marchandises_ordretransit_@{{$index}}" ng-model="dataInTabPane['marchandises_ordretransit']['data'][$index].nom" class="form-control form-control-solid text-center mt-2" placeholder="Désignation *" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="p-1">
                                            <div>
                                                <select data-tabpane="marchandises_ordretransit" id="unite_mesure_marchandises_ordretransit_@{{$index}}" ng-model="dataInTabPane['marchandises_ordretransit']['data'][$index].unite_mesure_id" class="form-control form-control-solid select2 modalselect2 text-center" style="width: 100% !important;">
                                                    <option value="">--</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['unitemesures']">@{{item.nom}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="p-1">
                                            <div>
                                                <select data-tabpane="marchandises_ordretransit" id="nomenclature_douaniere_marchandises_ordretransit_@{{$index}}" ng-model="dataInTabPane['marchandises_ordretransit']['data'][$index].nomenclature_douaniere_id" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                                    <option value="">--</option>
                                                    <option value="-1">Selon DPI</option>
                                                    <option value="-2">Selon Facture Fournisseur</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['nomenclaturedouanieres']">@{{item.nom}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="p-1">
                                            <div>
                                                <select data-tabpane="marchandises_ordretransit" id="type_dossier_marchandises_ordretransit_@{{$index}}" ng-model="dataInTabPane['marchandises_ordretransit']['data'][$index].type_dossier_id" class="form-control form-control-solid select2 modalselect2 text-center" style="width: 100% !important;">
                                                    <option value="">--</option>
                                                    <option value="@{{item.id}}" ng-repeat="item in dataPage['typedossiers']">@{{item.nom}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="actionSurTabPaneTagData('delete', 'marchandises_ordretransit', $index)" title="{{__('customlang.supprimer')}}">
                                                    <i class="flaticon2-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="tab-addordretransit-0-2" role="tabpanel" aria-labelledby="tab-addordretransit-0-2">
                <div class="row">
                    <ul class="nav nav-pills nav-pills-custom mb-3 d-flex align-items-center justify-content-center" role="tablist">
                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4 active" data-bs-toggle="pill" href="#tab-addordretransit-0-2-0" aria-selected="false" role="tab" tabindex="-1">
                                <div class="nav-icon nav-icon-primary">
                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-connaissement-color.svg')}}" class="">
                                </div>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Connaissement</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addordretransit-0-2-1" aria-selected="false" role="tab" tabindex="-1">
                                <div class="nav-icon">
                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-facturefournisseur-color.svg')}}" class="">
                                </div>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1 text-uppercase">Facture fournisseur</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addordretransit-0-2-2" aria-selected="false" role="tab" tabindex="-1">
                                <div class="nav-icon">
                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-facturefret-color.svg')}}" class="">
                                </div>
                                <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Facture Fret</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addordretransit-0-2-3" aria-selected="true" role="tab">
                                <div class="nav-icon">
                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-assurance-color.svg')}}" class="nav-icon">
                                </div>
                                <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">Assurance</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addordretransit-0-2-4" aria-selected="true" role="tab">
                                <div class="nav-icon">
                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-dpi-color.svg')}}" class="nav-icon">
                                </div>
                                <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">DPI</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                            <a class="nav-link nav-link-custom shadow d-flex justify-content-between flex-column flex-center overflow-hidden w-120px h-85px py-4" data-bs-toggle="pill" href="#tab-addordretransit-0-2-5" aria-selected="true" role="tab">
                                <div class="nav-icon">
                                    <img alt="" src="{{asset('assets/media/svg/icons/sidebar/icon-bsc-color.svg')}}" class="nav-icon">
                                </div>
                                <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-uppercase">BSC</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3" role="presentation">
                            <a class="nav-link shadow d-flex flex-center overflow-hidden w-80px h-85px" data-bs-toggle="pill" href="#tab-addordretransit-0-2-6" aria-selected="true" role="tab">
                                <div class="nav-icon">
                                    <span class="svg-icon svg-icon-2hx svg-icon-gray-400">
                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-etc.svg')) !!}
                                    </span>
                                </div>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-addordretransit-0-2-0" role="tabpanel">

                            <!-- <div class="row animated fadeIn d-none">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="num_bl_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">N° connaissement</span>
                                        </label>
                                        <input id="num_bl_ordretransit" type="text" class="form-control form-control-solid required" placeholder="N° " name="num_bl" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="type_bl_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Type</span>
                                        </label>
                                        <select id="type_bl_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="type_bl" style="width: 100% !important;">
                                            <option value="">--</option>
                                            <option value="@{{item.id}}" ng-repeat="item in typebls">@{{item.nom}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="fichier_bl_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">{{__('customlang.fichier')}} Connaissement</span>
                                        </label>
                                        <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" id="fichier_bl_ordretransit" name="fichier_bl" >
                                    </div>
                                </div>
                            </div> -->

                            <div class="row animated fadeIn">
                                <div class="col-md-5">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="numero_bls_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">N°</span>
                                        </label>
                                        <input type="text" id="numero_bls_ordretransit" class="form-control form-control-solid required" placeholder="N° du connaissement *" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="type_bls_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Type</span>
                                        </label>
                                        <select id="type_bls_ordretransit" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                            <option value="">--</option>
                                            <option value="@{{item.id}}" ng-repeat="item in typebls">@{{item.nom}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group mt-8 text-end">
                                        <button type="button" class="btn btn-light-warning" title="{{__('customlang.ajouter_un_element_au_tableau')}}" ng-click="actionSurTabPaneTagData('add','bls_ordretransit')">
                                            <i class="flaticon2-add pe-0"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="table-responsive">
                                        <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th style="width: 40%">N°</th>
                                                    <th style="width: 25%">Type</th>
                                                    <th style="width: 25%">Fichier</th>
                                                    <th style="width: 5%">
                                                        <i class="flaticon2-settings"></i>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="animated fadeIn" ng-repeat="item in dataInTabPane['bls_ordretransit']['data']">
                                                    <td>
                                                        <div>@{{($index+1)}}</div>
                                                        <!-- @{{dataInTabPane['bls_ordretransit']['data'][$index]}} -->
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input type="text" string-to-number ng-model="dataInTabPane['bls_ordretransit']['data'][$index].numero" class="form-control form-control-solid text-center" placeholder="N° *" autocomplete="off">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <label for="type_bls_ordretransit_@{{$index}}" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span class="required">Type</span>
                                                            </label>
                                                            <select id="type_bls_ordretransit_@{{$index}}" ng-model="dataInTabPane['bls_ordretransit']['data'][$index].type_id" class="form-control form-control-solid select2 modalselect2 required" style="width: 100% !important;">
                                                                <option value="">--</option>
                                                                <option value="@{{item.id}}" ng-repeat="item in typebls">@{{item.nom}}</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div ng-repeat="sitem in dataInTabPane['bls_ordretransit']['data'][$index].files">
                                                            <div>
                                                                <label for="@{{sitem.name}}" class="cursor-pointer">
                                                                    <div class="text-center box-shadow-2 image-hover-0" style="width: 80px !important;height: 60px !important;line-height: 70px !important;">
                                                                        <img alt="..." class="rounded w-150px image-hover border-primary" id="@{{'aff' + sitem.name}}" src="{{ asset('assets/media/svg/icons/sidebar/icon-file-upload.svg')}}" style="width: 80px !important;height: 80px !important;">
                                                                    </div>
                                                                    <div style="display: none;">
                                                                        <!-- les attrs data-property & data-idFile ne sont pas utilisés -->
                                                                        <input type="file" id="@{{sitem.name}}" data-tabpane="bls_ordretransit" data-property="numero" data-idFile="@{{index}}" name="@{{sitem.name}}" value=@{{sitem.url}} onchange="Chargerphoto('imgordretransitbls_ordretransit', this.id, 'pdf')" class="required">
                                                                        <input type="hidden" id="@{{'erase_erase_' + sitem.name}}" name="@{{'erase' + 'aff' + sitem.name}}" value="">
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <button class="btn btn-sm  btn-icon btn-transition btn-shadow btn-light-danger" type="button" ng-click="eraseFile(sitem.name, $parent.$index)" style="top:-3px !important;">
                                                                <i class="flaticon2-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="actionSurTabPaneTagData('delete', 'bls_ordretransit', $index)" title="{{__('customlang.supprimer')}}">
                                                                <i class="flaticon2-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-addordretransit-0-2-1" role="tabpanel">
                            <div class="row animated fadeIn">
                                <div class="col-md-4">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="num_ff_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">N° facture fournisseur</span>
                                        </label>
                                        <input id="num_ff_ordretransit" type="text" class="form-control form-control-solid required" placeholder="N°" name="num_ff" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="montant_ff_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Montant</span>
                                        </label>
                                        <input id="montant_ff_ordretransit" type="number" class="form-control form-control-solid required" placeholder="Montant" name="montant_ff" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="devise_ff_id_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Devise</span>
                                        </label>
                                        <select id="devise_ff_id_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="devise_ff_id" style="width: 100% !important;">
                                            <option value="">--</option>
                                            <option value="@{{item.id}}" ng-repeat="item in dataPage['devises']">@{{item.nom}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="fichier_ff_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">{{__('customlang.fichier')}} facture fournisseur</span>
                                        </label>
                                        <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" id="fichier_ff_ordretransit" name="fichier_ff" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-addordretransit-0-2-2" role="tabpanel">
                            <div class="row animated fadeIn">
                                <div class="col-md-4">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="num_fft_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">N° facture fret</span>
                                        </label>
                                        <input id="num_fft_ordretransit" type="text" class="form-control form-control-solid required" placeholder="N°" name="num_fft" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="montant_fft_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Montant</span>
                                        </label>
                                        <input id="montant_fft_ordretransit" type="number" class="form-control form-control-solid required" placeholder="Montant" name="montant_fft" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="devise_fft_id_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Devise</span>
                                        </label>
                                        <select id="devise_fft_id_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="devise_fft_id" style="width: 100% !important;">
                                            <option value="">--</option>
                                            <option value="@{{item.id}}" ng-repeat="item in dataPage['devises']">@{{item.nom}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="fichier_fft_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">{{__('customlang.fichier')}} facture fret</span>
                                        </label>
                                        <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" id="fichier_fft_ordretransit" name="fichier_fft" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-addordretransit-0-2-3" role="tabpanel">
                            <div class="row animated fadeIn">
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="type_asre_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Type</span>
                                        </label>
                                        <select id="type_asre_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="type_asre" style="width: 100% !important;">
                                            <option value="">--</option>
                                            <option value="@{{item.id}}" ng-repeat="item in typeasres">@{{item.nom}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="fichier_asre_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">{{__('customlang.fichier')}} assurance</span>
                                        </label>
                                        <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" id="fichier_asre_ordretransit" name="fichier_asre" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-addordretransit-0-2-4" role="tabpanel">
                            <div class="row animated fadeIn">
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="type_dpi_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Type</span>
                                        </label>
                                        <select id="type_dpi_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="type_dpi" style="width: 100% !important;">
                                            <option value="">--</option>
                                            <option value="@{{item.id}}" ng-repeat="item in typedpis">@{{item.nom}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="fichier_dpi_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">{{__('customlang.fichier')}} DPI</span>
                                        </label>
                                        <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" id="fichier_dpi_ordretransit" name="fichier_dpi" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-addordretransit-0-2-5" role="tabpanel">
                            <div class="row animated fadeIn">
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="type_bsc_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Type</span>
                                        </label>
                                        <select id="type_bsc_ordretransit" class="form-control form-control-solid select2 modalselect2 required" name="type_bsc" style="width: 100% !important;">
                                            <option value="">--</option>
                                            <option value="@{{item.id}}" ng-repeat="item in typebscs">@{{item.nom}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="fichier_bsc_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">{{__('customlang.fichier')}} BSC</span>
                                        </label>
                                        <input type="file" class="form-control filestyle required" data-buttonName="shadow-sm btn-transition btn-light-primary" data-buttonText="{{__('customlang.choisir_un_fichier')}}" data-placeholder="{{__('customlang.aucun_fichier_choisi')}}" data-iconName="fa fa-folder-open" id="fichier_bsc_ordretransit" name="fichier_bsc" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-addordretransit-0-2-6" role="tabpanel">
                            <div class="row animated fadeIn">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="nom_documents_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Nom du document</span>
                                        </label>
                                        <input type="text" id="nom_documents_ordretransit" class="form-control form-control-solid required" placeholder="Nom du document *" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label for="numero_documents_ordretransit" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">N° du document</span>
                                        </label>
                                        <input type="text" id="numero_documents_ordretransit" class="form-control form-control-solid required" placeholder="Numéro *" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group mt-8 text-end">
                                        <button type="button" class="btn btn-light-warning" title="{{__('customlang.ajouter_un_element_au_tableau')}}" ng-click="actionSurTabPaneTagData('add','documents_ordretransit')">
                                            <i class="flaticon2-add pe-0"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="table-responsive">
                                        <table class="table table-head-custom table-vertical-center table-head-bg table-borderless table-report text-center animated fadeIn">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th style="width: 40%">Nom du document</th>
                                                    <th style="width: 25%">N°</th>
                                                    <th style="width: 25%">Fichier</th>
                                                    <th style="width: 5%">
                                                        <i class="flaticon2-settings"></i>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="animated fadeIn" ng-repeat="item in dataInTabPane['documents_ordretransit']['data']">
                                                    <td>
                                                        <div>@{{($index+1)}}</div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input type="text" string-to-number ng-model="dataInTabPane['documents_ordretransit']['data'][$index].nom" class="form-control form-control-solid text-center" placeholder="Quantité *" autocomplete="off">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input type="text" string-to-number ng-model="dataInTabPane['documents_ordretransit']['data'][$index].numero" class="form-control form-control-solid text-center" placeholder="Quantité *" autocomplete="off">
                                                        </div>
                                                    </td>
                                                    <td lass="align-middle">
                                                        <div ng-repeat="sitem in dataInTabPane['documents_ordretransit']['data'][$index].files">
                                                            <div>
                                                                <label for="@{{sitem.name}}" class="cursor-pointer">
                                                                    <div class="text-center box-shadow-2 image-hover-0" style="width: 80px !important;height: 60px !important;line-height: 70px !important;">
                                                                        <img alt="..." class="rounded w-150px image-hover border-primary" id="@{{'aff' + sitem.name}}" src="{{ asset('assets/media/svg/icons/sidebar/icon-file-upload.svg')}}" style="width: 80px !important;height: 80px !important;">
                                                                    </div>
                                                                    <div style="display: none;">
                                                                        <!-- les attrs data-property & data-idFile ne sont pas utilisés -->
                                                                        <input type="file" id="@{{sitem.name}}" data-tabpane="documents_ordretransit" data-property="numero" data-idFile="@{{index}}" name="@{{sitem.name}}" value=@{{sitem.url}} onchange="Chargerphoto('imgordretransitdocuments_ordretransit', this.id, 'pdf')" class="required">
                                                                        <input type="hidden" id="@{{'erase_erase_' + sitem.name}}" name="@{{'erase' + 'aff' + sitem.name}}" value="">
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <button class="btn btn-sm  btn-icon btn-transition btn-shadow btn-light-danger" type="button" ng-click="eraseFile(sitem.name, $parent.$index)" style="top:-3px !important;">
                                                                <i class="flaticon2-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <button type="button" class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="actionSurTabPaneTagData('delete', 'documents_ordretransit', $index)" title="{{__('customlang.supprimer')}}">
                                                                <i class="flaticon2-trash"></i>
                                                            </button>
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

</div>
