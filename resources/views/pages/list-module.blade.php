<div class="row page-module">
    <div class="col-md-10 col-10">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
                <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <div class="d-flex align-items-center me-1">
                        <div class="d-flex align-items-baseline flex-wrap me-5 nav-text">
                            <h2 class="d-flex align-items-center text-dark fw-bold my-1">
                                <div class="card-title d-flex align-self-center mb-0 me-3">
                                    <span class="card-icon align-self-center">
                                        <span class="svg-icon svg-icon-primary">
                                            {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-module.svg')) !!}
                                        </span>
                                    </span>
                                    <h3 class="card-label align-self-center mb-0 ms-3">
                                        {{ app()->getLocale() == 'en' ? $page->title_en : $page->title}}
                                    </h3>
                                </div>
                            </h2>
                            <span class="badge badge-light-primary">@{{paginations['module'].totalItems | currency:"":0 | convertMontant}}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-wrap">
                        <div class="dropdown dropdown-inline" data-toggle="tooltip" title="{{ __('customlang.ajouter') }}" data-placement="left">
                            <button class="btn btn-primary btn-fixed-height fw-bold px-2 px-lg-5 me-2" ng-click="showModalAdd('module')">
                                <span class="svg-icon svg-icon-lg">
                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg')) !!}
                                </span>
                                <span class="d-none d-md-inline">{{ __('customlang.ajouter') }}</span>
                            </button>
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
                                        </div>
                                        <div class="card-toolbar">
                                            <span class="svg-icon">
                                                {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-filtrederoulant.svg')) !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div id="filtres" class="card collapse">
                                        <div class="card-body">
                                            <form ng-submit="pageChanged('module')">
                                                <div class="form-row animated fadeIn mt-4">
                                                    <div class="col-md-12 form-group">
                                                        <input type="text" class="form-control" id="search_list_module" ng-model="search_list_module" placeholder="{{ __('customlang.rechercher_par_nom') }}" ng-model-options="{ debounce: 500 }" ng-change="pageChanged('module')">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <select class="select2 form-control filter" id="mode_link_list_module" style="width: 100%">
                                                            <option value="">Mode link</option>
                                                            <option ng-repeat="item in dataPage['modelinks']" value="@{{ item.id }}"> @{{ item.nom }}</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="w-100 text-center pb-4">
                                                    <button type="submit" class="btn shadow-sm btn-transition btn-light-primary float-end">
                                                        <span class="d-md-block d-none">{{__('customlang.filter')}}</span>
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    <button type="reset" class="me-2 btn shadow-sm btn-transition btn-light-dark float-end" ng-click="emptyForm('module', true)">
                                                        <i class="fa fa-times"></i>
                                                        <span class="d-md-block d-none">{{__('customlang.annuler')}}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-custom  gutter-b item-card-module">
                                <div class="card-body bg-dark-o-5 pt-5 pb-5">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card card-custom  gutter-b bg-gray-200 item-card-module">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-custom gutter-b bg-gray-200 item-card-module">
                                                            <div class="card-body bg-dark-o-5 pt-10 pb-3 dragon" id="div@{{item.id}}" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                                <div class="row mb-5">
                                                                    <div class="col-lg-2 col-md-2 col-2 px-1 align-self-center">
                                                                        <img alt="Logo" src="uploads/icons/icon-devise.svg" class="max-h-30px w-30" style="margin-top: -15px !important;padding: 5px;border-radius: 0px;width: 30px;" />
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-7 col-7 px-2 align-items-center">
                                                                       <span class="ms-2 text-truncate" style="margin-top: -10px !important;">
                                                                            Module 1
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-3 col-3 pl-0">
                                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                            <input type="checkbox" href="#" class="menu-open max-h-15px w-15" name="menu-open" id="menu-m-open-@{{ item.title }}">
                                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-m-open-@{{ item.title }}">
                                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                            </label>
                                                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('module', item.id)" title="{{ __('customlang.supprimer') }}">
                                                                                <i class="flaticon2-trash"></i>
                                                                            </button>
                                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('module', item.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                                                <i class="flaticon2-edit"></i>
                                                                            </button>
                                                                            <button class="menu-btn-item btn btn-sm btn-info btn-icon font-size-sm" ng-click="showModalUpdate('module', item.id,{isClone: true}, 'null')" title="{{ __('customlang.cloner') }}">
                                                                                <i class="flaticon2-copy"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="h-450px overflow-auto">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="card card-custom  gutter-b" id="drag@{{page.id}}" src="img_logo.gif" draggable="true" ondragstart="drag(event)">
                                                                                <div class="card-body bg-dark-o-5 pb-3 item-module">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2 col-md-2 col-2 px-1">
                                                                                            <div class="d-flex justify-content-center">
                                                                                                <img alt="Logo" src="uploads/icons/icon-devise.svg" class="max-h-30px w-30 badge-icon-module" />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-8 col-md-7 col-7 px-2">
                                                                                            <div class="d-flex align-items-center">
                                                                                                <span class="text-truncate" style="margin-top: -10px !important;">
                                                                                                    Sous Module 2
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-3 col-3">
                                                                                            <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ page.id }}">
                                                                                                <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ page.id }}">
                                                                                                    <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                                    <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                                    <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                                                </label>
                                                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('page',page.id)" title="{{ __('customlang.supprimer') }}">
                                                                                                    <i class="flaticon2-trash"></i>
                                                                                                </button>

                                                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('page',page.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                                                                    <i class="flaticon2-edit"></i>
                                                                                                </button>

                                                                                                <button class="menu-btn-item btn btn-sm btn-info btn-icon font-size-sm" ng-click="showModalUpdate('page',page.id, 'null', 'null')" title="{{ __('customlang.cloner') }}">
                                                                                                    <i class="flaticon2-copy"></i>
                                                                                                </button>

                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-12">
                                                                            <a class="nav-link active" data-toggle="tab" href="#tab-addpage-0" target="_self">
                                                                                <span class="nav-icon mt-7">
                                                                                    <i class="flaticon2-add"></i>
                                                                                </span>
                                                                                <span class="nav-text">Déplacer une page pour ajouter</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card card-custom gutter-b bg-gray-200 item-card-module">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-custom gutter-b bg-gray-200">
                                                            <div class="card-body bg-dark-o-5 pt-10 pb-3 dragon" id="div@{{item.id}}" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                                <div class="row mb-5">
                                                                    <div class="col-lg-2 col-md-2 col-2 px-1 align-self-center">
                                                                        <img alt="Logo" src="uploads/icons/icon-devise.svg" class="max-h-30px w-30" style="margin-top: -15px !important;padding: 5px;border-radius: 0px;width: 30px;" />
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-7 col-7 px-2 align-items-center">
                                                                       <span class="ms-2 text-truncate" style="margin-top: -10px !important;">
                                                                            Module 1
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-3 col-3 pl-0">
                                                                        <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                            <input type="checkbox" href="#" class="menu-open max-h-15px w-15" name="menu-open" id="menu-m-open-@{{ item.title }}">
                                                                            <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-m-open-@{{ item.title }}">
                                                                                <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                            </label>
                                                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('module', item.id)" title="{{ __('customlang.supprimer') }}">
                                                                                <i class="flaticon2-trash"></i>
                                                                            </button>
                                                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('module', item.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                                                <i class="flaticon2-edit"></i>
                                                                            </button>
                                                                            <button class="menu-btn-item btn btn-sm btn-info btn-icon font-size-sm" ng-click="showModalUpdate('module', item.id,{isClone: true}, 'null')" title="{{ __('customlang.cloner') }}">
                                                                                <i class="flaticon2-copy"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="h-450px overflow-auto">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="card card-custom  gutter-b" id="drag@{{page.id}}" src="img_logo.gif" draggable="true" ondragstart="drag(event)">
                                                                                <div class="card-body bg-dark-o-5 pb-3 item-module">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2 col-md-2 col-2 px-1">
                                                                                            <div class="d-flex justify-content-center">
                                                                                                <img alt="Logo" src="uploads/icons/icon-devise.svg" class="max-h-30px w-30 badge-icon-module" />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-8 col-md-7 col-7 px-2">
                                                                                            <div class="d-flex align-items-center">
                                                                                                <span class="text-truncate" style="margin-top: -10px !important;">
                                                                                                    Sous Module 2
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-3 col-3">
                                                                                            <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                                                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-@{{ page.id }}">
                                                                                                <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-@{{ page.id }}">
                                                                                                    <span class="hamburger bg-template-1 hamburger-1"></span>
                                                                                                    <span class="hamburger bg-template-1 hamburger-2"></span>
                                                                                                    <span class="hamburger bg-template-1 hamburger-3"></span>
                                                                                                </label>
                                                                                                <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('page',page.id)" title="{{ __('customlang.supprimer') }}">
                                                                                                    <i class="flaticon2-trash"></i>
                                                                                                </button>

                                                                                                <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('page',page.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                                                                    <i class="flaticon2-edit"></i>
                                                                                                </button>

                                                                                                <button class="menu-btn-item btn btn-sm btn-info btn-icon font-size-sm" ng-click="showModalUpdate('page',page.id, 'null', 'null')" title="{{ __('customlang.cloner') }}">
                                                                                                    <i class="flaticon2-copy"></i>
                                                                                                </button>

                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-12">
                                                                            <a class="nav-link active" data-toggle="tab" href="#tab-addpage-0" target="_self">
                                                                                <span class="nav-icon mt-7">
                                                                                    <i class="flaticon2-add"></i>
                                                                                </span>
                                                                                <span class="nav-text">Déplacer une page pour ajouter</span>
                                                                            </a>
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
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 col-2" style="margin-top: -25px">
        <input type="text" style="border: none;color: white;background-color: transparent" id="id_drag" ng-model="id_drag">

        <div class="py-4 d-flex flex-lg-column bg-body align-self-end" style="height: 2000px !important;width: 300px !important;">
            <div class="container flex-wrap">
                <div class="offcanvas-content">
                    <div class="navi navi-icon-circle navi-spacer-x-0">
                        <div class="row dragonleft" id="vi1" ondrop="drop(event)" ondragover="allowDrop(event)" style="overflow:auto;">
                            <div class="col-md-12 p-0">
                                <div class="card card-custom bg-dark-o-5 gutter-b drag" id="drag@{{page.id}}" draggable="true" ondragstart="drag(event)">
                                    <div class="card-body bg-dark-o-5 pb-3 pt-3">
                                        <div class="row">
                                            <div class="col-md-2 col-2 px-1 item-module">
                                                <img alt="Logo" src="{{ asset('uploads/icons/icon-devise.svg') }}" class="max-h-30px w-30 badge-icon-module-2"/>
                                            </div>
                                            <div class="col-md-10 col-10 px-2 align-self-center">
                                                <span class="text-truncate" style="margin-top: -15px !important;">
                                                    Module 3
                                                </span>
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




<script>
    function allowDrop(ev) {
        // console.log('le allowDrop déclenché dans le JS', $(ev.target));
        ev.preventDefault();
    }

    function drag(ev)
    {
        // console.log('le drag déclenché dans le JS', $(ev.target));
        ev.dataTransfer.setData("text", ev.target.id);
        $("#id_drag").val(ev.target.id);
    }

    function drop(ev)
    {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        console.log('le drop déclenché dans le JS', $('#' + data), $('#' + data).prevALL('[id^=drag]')[0]);

        ev.target.appendChild(document.getElementById(data));
    }
</script>

<div class="footer py-4 d-flex flex-lg-column bg-body">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center me-3">
            <span class="text-muted me-3 d-none d-md-inline">{{__('customlang.affichage_par')}}</span>
            <select class="form-control form-control-sm text-primary fw-bold me-4 border-0 bg-light-primary" style="width: 75px;" ng-model="paginations['permission'].entryLimit" ng-change="pageChanged('permission')">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
           </div>
        <div class="d-flex flex-wrap">
            <nav aria-label="...">
                <ul class="pagination float-md-end justify-content-end mt-1" uib-pagination total-items="paginations['module'].totalItems" ng-model="paginations['module'].currentPage" max-size="paginations['module'].maxSize" items-per-page="paginations['module'].entryLimit" ng-change="pageChanged('module')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
            </nav>
        </div>
    </div>
</div>
