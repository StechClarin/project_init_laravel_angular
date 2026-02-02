<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-tabs-line-2x mt-4">
                @if(auth()->user()->can('canal') || auth()->user()->can('canalslack') || auth()->user()->can('creation-canal') || auth()->user()->can('creation-canalslack') || auth()->user()->can('suppression-canal') || auth()->user()->can('supression-canalslack') || auth()->user()->can('modification-canal') || auth()->user()->can('modification-canalslack'))
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#page-tab-0" ng-click="pageChanged('canal')">
                        <span class="svg-icon">{!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-pointage.svg')) !!}</span>
                        <span class="nav-text">Performance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#page-tab-1" ng-click="manageTab(0); pageChanged('canalslack')">
                        <span class="svg-icon">{!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-sav.svg')) !!}</span>
                        <span class="nav-text"></span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="tab-content">
        {{-- Onglet Performance --}}
        <div class="tab-pane fade show active" id="page-tab-0">
            <div class="container">
                {{-- Bloc Pointages --}}
                <div class="card-title d-flex align-items-center">
                    <span class="svg-icon svg-icon-primary">{!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-pointage.svg')) !!}</span>
                    <h3 class="card-label ms-2">Pointages</h3>
                </div>

                <div class="card card-custom gutter-b mb-4">
                    <div class="card-body p-5">
                        <form>
                            <div class="form-row row animated fadeIn ">
                                <div class="col-md-5 form-group">
                                    <input type="date" class="form-control" name="date_debut" id="date_start_list_pointage"
                                        placeholder="Rechercher par nom, priorité ...">
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="date" class="form-control" name="date_fin" id="date_end_list_pointage">
                                </div>
                                <div class="col-md-2 form-group ">
                                    <button
                                        type="button" ng-click="pageChanged('pointage', {justWriteUrl : 'detailspointages-pdf'})"
                                        class=" btn shadow btn-transition btn-danger ">
                                        <i class="fa fa-file-pdf"></i>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- Bloc Efficience --}}
                <div class="card-title d-flex align-items-center">
                    <span class="svg-icon svg-icon-primary">{!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-tache.svg')) !!}</span>
                    <h3 class="card-label ms-2">Efficience</h3>
                </div>

                <div class="card card-custom gutter-b mb-4">
                    <div class="card-body p-5">
                        <form class="row animated fadeIn">
                            <div class="col-md-5 form-group">
                                <input type="date" class="form-control" id="date_start_list_tacheprojet" name="date_debut">
                            </div>
                            <div class="col-md-5 form-group">
                                <input type="date" class="form-control" id="date_end_list_tacheprojet" name="date_fin">
                            </div>
                            <div class="col-md-2 form-group">
                                <button type="button" class="btn btn-danger shadow" ng-click="pageChanged('tacheprojet', {justWriteUrl : 'tacheprojets-pdf'})">
                                    <i class="fa fa-file-pdf"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>