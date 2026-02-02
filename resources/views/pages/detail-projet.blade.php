

<style>  
    .project-card {  
        border-radius: 15px;  
        background: linear-gradient(55deg,rgb(218, 213, 213),rgb(255, 255, 255));  
        color: white;  
        padding: 1rem;  
        margin: 0.8rem;  
        position: relative;  
        overflow: hidden;  
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  
    }  

    .card-title {  
        font-size: 1.5rem;  
        font-weight: bold;  
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);  
        margin-bottom: 1rem;  
    }  

    .card-subtitle {  
        font-size: 1.1rem;  
        color: #4ecdc4;  
        margin-bottom: 1rem;  
    }  

    .progress {  
        height: 8px;
        border-radius: 4px;  
        background-color: rgba(255, 255, 255, 0.2);  
    }  

    .progress .progress-bar {  
        background-color: #4ecdc4;  
        border-radius: 4px;  
    }  

    .progress-text {  
        display: flex;  
        justify-content: space-between;  
        margin-bottom: 1rem;  
        font-size: 1rem;  
    }  
</style>  
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
<script>  
    window.onload = function() {  
        setTimeout(function() {  
            //document.querySelector('.progress-bar').style.width = '80%';  
        }, 3000);  
    };  
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
                        <h3 class="card-label align-self-center mb-0 ms-2" style="color:gray">
                            <a ng-href="#!/list-gestionprojet">{{ __('customlang.gestionprojet') }}</a> &nbsp;|
                        </h3>@php $i = 0; @endphp
                        <span class="badge badge-primary p-3"></span>
                        <h3 class="card-label align-self-center text-muted mb-0 ms-2">
                            @{{ projetView.nom }} &nbsp;
                        </h3>
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
                                                    placeholder="Rechercher par code, nom, type, client ..."
                                                    ng-model-options="{ debounce: 500 }"
                                                    ng-change="pageChanged('projet')">
                                            </div>
                                        </div>
                                        <div class="form-row row animated fadeIn mt-delete">
                                            <div class="col-md-6 form-group">
                                                <div class="d-flex flex-column mb-8 fv-row">
                                                    <label for="type_projet_projet"
                                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                        <span >Type de projet</span>
                                                    </label>
                                                    <select id="type_projet_list_projet"
                                                        class="form-control form-control-solid select2 modalselect2"
                                                        style="width: 100% !important;">
                                                        <option value="">--</option>
                                                        <option value="@{{ item.id }}"
                                                            ng-repeat="item in dataPage['typeprojets']">
                                                            @{{ item.nom }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <div class="d-flex flex-column mb-8 fv-row">
                                                    <label for="client_projet"
                                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                        <span >client</span>
                                                    </label>
                                                    <select id="client_list_projet"
                                                        class="form-control form-control-solid select2 modalselect2"
                                                        style="width: 100% !important;">
                                                        <option value="">--</option>
                                                        <option value="@{{ item.id }}"
                                                            ng-repeat="item in dataPage['clients']">
                                                            @{{ item.nom }}</option>
                                                    </select>
                                                </div>
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
                </div>
                <!-- <div class="container">   -->
                <div class="row">  
                    <div class="col-md-3" ng-repeat="item in dataPage['projetdepartements']"  ng-if="projetView.id === item.projet_id"> 
                        <a class="text-decoration-none" ng-href="#!/detail-departement/@{{item.departement_id}}">
                            <div> 
                                <div class="card project-card">  
                                    <div class="card-body" style="padding: 0.35rem">  
                                        <div class="tab-content">
                                            <img class="border-1 rounded-1" src="@{{item.departement.image}}" width="100%" height="200px" class="">
                                        </div><br>
                                        <p class="fw-bold card-subtitle text-uppercase text-center">@{{item.departement.nom}}</p>  
                                        <div class="progress-text"  style='color:black'>  
                                            <span><i class='fas fa-tasks' style='color:black'></i> &nbsp; Progression</span> 
                                            <span>@{{ item.nombre_tache_close }} / @{{ item.nombre_tache }}</span>  
                                        </div>  
                                        <div style="display:flex; align-items: center;">
                                            <div class="progress border border-primary rounded-1" style="width: 100%; height: 8px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning border border-warning" role="progressbar" style="width: @{{item.progression}}%"   
                                                    aria-valuenow="@{{item.progression}}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div> 
                                            <span class="text-primary ms-2">@{{item.progression}}%</span>  
                                        </div>
                                    </div>  
                                </div>  
                            </div>
                        </a> 
                    </div> 
                </div>  
                <!-- </div>   -->

                <!-- </div> -->
            </div>
        </div>
    </div>
</div>