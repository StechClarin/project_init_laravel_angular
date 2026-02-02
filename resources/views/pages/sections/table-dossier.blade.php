<div id="{{$table_id}}" class="card card-custom gutter-b rounded-1 collapse show">
    <div class="card-body p-5">
        <div class="tab-content">
            <div class="table-responsive">
                <table class="m-auto table table-head-custom table-vertical-center table-head-bg table-borderless table-striped table-report text-center">
                    <thead>
                        <tr>
                            <th style="min-width: 120px">{{__('customlang.code')}}</th>
                            @if(!isset(Auth::user()->client))
                                <th style="min-width: 120px">{{__('customlang.client')}}</th>
                            @endif
                            <th style="min-width: 120px">{{__('customlang.date')}}</th>
                            <th style="min-width: 120px">Imp</th>
                            @if(auth()->user()->can('suppression-dossier') || auth()->user()->can('modification-ordretransit') || auth()->user()->can('creation-ordretransit'))
                                <th style="min-width: 100px">
                                    <i class="flaticon2-settings"></i>
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="withMenuContextuel" ng-repeat="item in dataPage['{{$dataPage}}']" ng-if="item['{{$column}}']">
                            <td class="p-0">
                                <span ng-if="item.ordre_transit.type_marchandise_id === 2" ng-include="'pages/sections.svg-typevehicule'"></span>
                                <span ng-if="item.ordre_transit.type_marchandise_id === 1" ng-include="'pages/sections.svg-typemarchandise'"></span>
                                <span class="text-muted fw-bold text-capitalize">@{{item.ordre_transit.code}}</span>
                            </td>
                            @if(!isset(Auth::user()->client))
                                <td>
                                    <span class="text-muted fw-bold text-capitalize">@{{item.client.display_text}}</span>
                                </td>
                            @endif
                            <td>
                                <span class="text-muted fw-bold text-capitalize">@{{item.ordre_transit.date_fr}}</span>
                            </td>
                            <td>
                                @{{item.ordre_transit.type_importation.description}}
                            </td>
                            @if(auth()->user()->can('suppression-dossier') || auth()->user()->can('modification-dossier') || auth()->user()->can('creation-dossier'))
                                <td class="pr-0 text-right">
                                    <div class="menu-leftToRight d-flex align-items-center justify-content-center">
                                        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open-dossier-@{{item.id}}-{{$section_id}}">
                                        <label class="menu-open-button m-0 border-0 btn btn-sm btn-icon bg-gray-100" for="menu-open-dossier-@{{item.id}}-{{$section_id}}">
                                            <span class="hamburger bg-template-1 hamburger-1"></span>
                                            <span class="hamburger bg-template-1 hamburger-2"></span>
                                            <span class="hamburger bg-template-1 hamburger-3"></span>
                                        </label>
                                        @if(auth()->user()->can('suppression-dossier'))
                                            <button class="menu-btn-item btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteElement('dossier', item.id)" title="{{ __('customlang.supprimer') }}">
                                                <i class="flaticon2-trash"></i>
                                            </button>
                                        @endif
                                        @if(auth()->user()->can('modification-dossier'))
                                            <button class="menu-btn-item btn btn-sm btn-warning btn-icon font-size-sm" ng-click="showModalUpdate('dossier', item.id, 'null', 'null')" title="{{ __('customlang.modifier') }}">
                                                <i class="flaticon2-edit"></i>
                                            </button>
                                            <button ng-if="item.status" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event,'dossier', 1, item, {mode:2, title: 'Revenir vers OT'})">
                                                <i class="fa fa-thumbs-down"></i>
                                            </button>
                                            <button ng-if="item.apurement" class="menu-btn-item btn btn-sm btn-secondary btn-icon font-size-sm" title="Consultation" ng-click="openConsultationDossier('dossiers', item.id)">
                                                <i class="flaticon2-file"></i>
                                            </button>
                                        {{--  <button ng-if="!item.status" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm" title="{{__('customlang.activation')}}" ng-click="showModalStatutNotif($event,'dossier', 1, item, {mode:2, title: '{{__('customlang.activer_dossier')}}'})">
                                                <i class="fa fa-thumbs-up"></i>
                                            </button>
                                            <button ng-if="item.status" class="menu-btn-item btn btn-sm btn-light-danger btn-icon font-size-sm" title="{{__('customlang.desactivation')}}" ng-click="showModalStatutNotif($event,'dossier', 0, item, {mode:2, title: '{{__('customlang.desactiver_dossier')}}'})">
                                                <i class="fa fa-thumbs-down"></i>
                                            </button> --}}
                                        @endif
                                        @if(auth()->user()->can('detail-ordretransit'))
                                            <a target="_blank" type="button" href="generate-documentordretransits-pdf?id:@{{item.ordre_transit_id}},skip_dossier:true" title="Générer OT" class="menu-btn-item btn btn-sm btn-light-success btn-icon font-size-sm">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        <i class="fa fa-file-pdf"></i>
                                                    </span>
                                                </span>
                                            </a>
                                        @endif
                                        @if(auth()->user()->can('creation-dossier'))
                                            {{-- <button class="menu-btn-item btn btn-sm btn-light-primary btn-icon font-size-sm" ng-click="showModalUpdate('dossier',item.id,{forceChangeForm: false, isClone:true}, 'null')" title="{{ __('customlang.cloner') }}">
                                                <i class="fa fa-clone"></i>
                                            </button> --}}
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