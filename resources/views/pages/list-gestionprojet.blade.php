




<style>
    /* .progress-container {  
    display: flex;  
    align-items: center;  
    gap: 10px;
    }  

    .progress-value {  
    font-weight: bold;  
    color: #007bff;/  
    }   */
</style>
 
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  -->
<!-- <script>  
    window.onload = function() {  
    setTimeout(function() {  
        document.querySelector('.progress-bar').style.width = '80%';  
    }, 1000);  
    };   -->
</script>

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
                        <h3 class="card-label align-self-center mb-0 ms-2">
                            {{ __('customlang.gestionprojet') }} &nbsp;
                        </h3>
                        <span class="badge badge-primary p-3"> @{{paginations['projet'].totalItems | currency:"":0 | convertMontant}}</span>
                    </div>
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
                                    <form ng-submit="pageChanged('gestionprojet')">
                                       
                                        <div class="form-row row animated fadeIn mt-delete">
                                            <div class="col-md-12 form-group">
                                                <input type="text" class="form-control" id="search_list_projet"
                                                    ng-model="search_list_projet"
                                                    placeholder="Rechercher par nom..."
                                                    ng-model-options="{ debounce: 500 }"
                                                    ng-change="pageChanged('projet')">
                                            </div>
                                        </div>
                                  

                                       
                                        

                                        <div class="w-100 text-center pb-4">
                                            <button type="button" class="me-2 btn shadow btn-transition btn-danger float-start" ng-click="pageChanged('projet', {justWriteUrl : 'projets-pdf'})">
                                                <span class="d-md-block d-none pr-2 pl-2">{{__('customlang.pdf')}}</span>
                                                <i class="fa fa-file-pdf"></i>
                                            </button>
                                            <button type="button" class="btn shadow btn-transition btn-success float-start" ng-click="pageChanged('projet', {justWriteUrl : 'projets-excel'})">
                                                <span class="d-md-block d-none">{{__('customlang.excel')}}</span>
                                                <i class="fa fa-file-excel"></i>
                                            </button>

                                            <button type="submit" class="btn shadow btn-transition btn-outline-primary float-end">
                                                <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('projet', true)">
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
                                            <tr class=" bg-primary text-white">
                                                <th style="min-width: 120px">Nom</th>
                                                <th style="min-width: 120px">{{ __('customlang.date_debut') }}</th>
                                                <th style="min-width: 120px">{{ __('customlang.date_fin') }}</th>
                                                <th style="min-width: 120px">Progression</th>
                                                @if(auth()->user()->can('suppression-gestionprojet') || auth()->user()->can('modification-gestionprojet') || auth()->user()->can('creation-gestionprojet'))
                                                    <th style="min-width: 100px">
                                                        {!!
                                                        file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg'))
                                                        !!}
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="" ng-repeat="item in dataPage['projets']">
                                                <td>
                                                    <a type="button" class=" shadow  float-center rounded p-1" ng-href="#!/detail-projet/@{{item.id}}">
                                                        <span class="badge text-muted fw-bold text-uppercase text-white ">@{{item.nom}}</span>
                                                    </a>
                                                    <!-- <a type="button" class=" shadow  float-center rounded p-1" ng-click="pageChanged('projetdepartement',{queries: ['projet_id: item.id']})">
                                                        <span class="badge text-muted fw-bold text-uppercase text-white ">@{{item.nom}}</span>
                                                    </a> -->
                                                </td>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.date_debut_fr}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold text-capitalize">@{{item.date_cloture_fr}}</span>
                                                </td>
                                                <td> 
                                                    <div class="progress" style="background-color:beige;margin-top:20px" >
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"  
                                                            role="progressbar"  
                                                            aria-valuenow="@{{item.progression}}"  
                                                            aria-valuemin="0"  
                                                            aria-valuemax="100"  
                                                            style="width: @{{item.progression}}%"> 
                                                        </div>   
                                                    </div>  
                                                    <span class="progress-value text-primary fw-bold">@{{item.progression}}%</span>
                                                </td>  
                                                @if(auth()->user()->can('suppression-gestionprojet') || auth()->user()->can('modification-gestionprojet') || auth()->user()->can('creation-gestionprojet'))
                                                    <td class="pr-0 text-right">
                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ item.id }}">
                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ item.id }}">
                                                                <span class="hamburger bg-dark hamburger-1"></span>
                                                                <span class="hamburger bg-dark hamburger-2"></span>
                                                                <span class="hamburger bg-dark hamburger-3"></span>
                                                            </label>
                                                            @if(auth()->user()->can('suppression-gestionprojet'))
                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('projet', item.id)" title="{{ __('customlang.supprimer') }}">
                                                                    <i class="flaticon2-trash"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('modification-gestionprojet'))
                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('projet', item.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                                    <i class="flaticon2-edit"></i>
                                                                </button>
                                                                <button ng-if="!item.status" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event, 'projet', 1, item, {mode:2, title: 'Activer un projet'})">
                                                                    <i class="fa fa-thumbs-up"></i>
                                                                </button>
                                                                <button ng-if="item.status" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event, 'projet', 0, item, {mode:2, title: 'Désactiver  un projet'})">
                                                                    <i class="fa fa-thumbs-down"></i>
                                                                </button>
                                                            @endif
                                                            @if(auth()->user()->can('creation-gestionprojet'))
                                                            <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('projet',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
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
                                <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['projet'].entryLimit" ng-change="pageChanged('projet')">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="d-flex flex-wrap">
                                <nav aria-label="...">
                                    <ul class="pagination float-md-end justify-content-center mt-1" uib-pagination total-items="paginations['projet'].totalItems" ng-model="paginations['projet'].currentPage" max-size="paginations['projet'].maxSize" items-per-page="paginations['projet'].entryLimit" ng-change="pageChanged('projet')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>