<div class="card-body">
    <div class="tab-content mt-5">
        <div class="tab-pane fade show active" id="tab-addtypeprojet-0" role="tabpanel" aria-labelledby="tab-addtypeprojet-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="nom_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">{{__('customlang.nom')}}</span>
                        </label>
                        <input id="nom_projet" type="text" class="form-control form-control-solid required" placeholder="{{__('customlang.nom')}} " name="nom" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="type_projet_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Type de projet</span>
                        </label>
                        <select id="type_projet_projet" class="form-control form-control-solid select2 modalselect2 required" name="type_projet_id" style="width: 100% !important;">
                            <option value="">--</option>
                            <option value="@{{item.id}}" ng-repeat="item in dataPage['typeprojets']">@{{item.nom}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="date_debut_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">Date de début</span>
                        </label>
                        <input id="date_debut_projet" type="text" class="form-control form-control-solid datedropper ignore-elt" placeholder="Date de début" name="date_debut" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="date_cloture_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">Date de clôture</span>
                        </label>
                        <input id="date_cloture_projet" type="text" class="form-control form-control-solid datedropper ignore-elt" placeholder="Date de clôture" name="date_cloture" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="noyauxinterne_projet"
                            class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">Noyaux</span>
                        </label>
                        <select id="noyauxinterne_projet"
                            class="form-control form-control-solid select2 modalselect2"
                            name="noyauxinterne_id" style="width: 100% !important;">
                            <option value=""></option>
                            <option value="@{{ item.id }}"
                                ng-repeat="item in dataPage['noyauxinternes']">
                                @{{ item.nom }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="flex-column mb-8 fv-row">
                        <label for="client_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">{{__('customlang.client')}}</span>
                        </label>
                        <div class="form-group">
                            <!-- <select class="form-control form-control-solid select2 modalselect2 search_client" data-addfilters="status:1" id="client_projet" name="client_id"> -->
                            <select class="form-control form-control-solid select2 modalselect2 search_client" id="client_projet" name="client_id">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    
                    <div class="pt-12 ">
                        <div class="dropdown dropdown-inline" title="{{ __('customlang.ajouter') }}" data-bs-toggle="tooltip"
                            data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                            @if(auth()->user()->can('creation-preference') || auth()->user()->can('modification-preference'))
                            <a href="" class="menu-link bg-primary px-6 py-4 rounded-3"
                                ng-click="showModalAdd('client')"
                                data-kt-menu-placement="bottom-end">
                                <span class="menu-icon" data-kt-element="icon">
                                    <span class="svg-icon svg-icon-3">
                                        {!!
                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg'))
                                        !!}
                                    </span>
                                </span>
                                <span class="menu-title text-white text-uppercase fw-bold">Ajouter client</span>
                            </a>

                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="hebergeur_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.hebergeur')}}</span>
                        </label>
                        <input id="hebergeur_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.hebergeur')}} " name="hebergeur" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="serveur_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.serveur')}}</span>
                        </label>
                        <input id="serveur_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.serveur')}} " name="serveur" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="tarif_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.tarif')}}</span>
                        </label>
                        <input id="tarif_projet" type="number" min=0 class="form-control form-control-solid " placeholder="{{__('customlang.tarif')}} " name="tarif" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="date_debut_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.date_p_renouvellement')}}</span>
                        </label>
                        <input id="date_prochain_renouvellement" type="date" class="form-control form-control-solid datedropper ignore-elt" placeholder="{{__('customlang.date_p_renouvellement')}}" name="date_prochain_renouvellement" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="lien_test_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.lien_test')}}</span>
                        </label>
                        <input id="lien_test_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.lien_test')}} " name="lien_test" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="identifiant_test_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">Identifiant test</span>
                        </label>
                        <input id="identifiant_test_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.identifiant_test')}} " name="identifiant_test" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="mot_de_passe_test_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.mdp_test')}}</span>
                        </label>
                        <input id="mot_de_passe_test_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.mdp_test')}} " name="mot_de_passe_test" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="lien_prod_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.lien_prod')}}</span>
                        </label>
                        <input id="lien_prod_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.lien_prod')}} " name="lien_prod" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="identifiant_prod_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">Identifiant prod</span>
                        </label>
                        <input id="identifiant_prod_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.identifiant_prod')}} " name="identifiant_prod" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="mot_de_passe_prod_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="">{{__('customlang.mdp_prod')}}</span>
                        </label>
                        <input id="mot_de_passe_prod_projet" type="text" class="form-control form-control-solid" placeholder="{{__('customlang.mdp_prod')}} " name="mot_de_passe_prod" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label for="description_projet" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span>{{__('customlang.description')}}</span>
                        </label>
                        <textarea class="form-control form-control-solid" rows="4" cols="4" id="description_projet" name="description" placeholder="{{__('customlang.description')}} ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>