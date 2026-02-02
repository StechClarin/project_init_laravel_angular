@extends('pdfs.layouts.layout-export')

@section('title', " Tags")

@section('content')
<table class="table table-bordered w-100" align="center">
    <tr style="font-size: 1.2em;">
        <th><strong>nom</strong></th>
        <th><strong>description</strong></th>

    </tr>
    <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
            <td>{{ ucfirst( $data[$i]['nom'] ) }}</td>
            <td>{{ ucfirst( $data[$i]['description'] ) }}</td>
            </tr>
            @endfor
    </tbody>
</table>
@endsection





<div id="modal_addpointage" class="modal fade" tabindex="-1" role="dialog" style="z-index: 3200">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="form_addpointage" class="form" accept-charset="UTF-8" ng-submit="addElement($event,'pointage')">
                @csrf
                <input type="hidden" id="id_pointage" name="id">

                <div class="card card-custom">
                    <div class="card-header bg-primary">
                        <div class="card-title">
                            <span class="card-icon">
                                <span class="svg-icon svg-icon-primary">
                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-pointage.svg')) !!}
                                </span>
                            </span>
                            <h3 class="card-label text-white">{{__('customlang.pointage')}}</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- ... TOUS LES CHAMPS QUE TU AS FOURNIS ... (inchangés ici pour compacité) -->
                        <div class="tab-content mt-5">
                            <div class="tab-pane fade show active" id="tab-addpointage-0" role="tabpanel" aria-labelledby="tab-addpointage-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="flex-column mb-8 fv-row">
                                            <label for="personnel_pointage" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">{{__('customlang.personnel')}}</span>
                                            </label>
                                            <div class="form-group">
                                                <select class="form-control form-control-solid select2 modalselect2 search_personnel" id="personnel_pointage" name="personnel_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="flex-column mb-8 fv-row">
                                            <label for="total_temps_au_bureau_pointage" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="">Temps mis au bureau/semaine</span>
                                            </label>
                                            <div class="form-group">
                                                <input type="number"
                                                    class="form-control"
                                                    name="total_temps_au_bureau"
                                                    placeholder=""
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_debut_pointage">{{__('customlang.date_debut')}} </label>
                                            <input type="date"
                                                class="form-control datedropper daterange-pointage required"
                                                ng-model="date_debut_pointage"
                                                ng-change="radioChanged('date_debut_pointage')"
                                                id="date_debut_pointage"
                                                name="date_debut"
                                                placeholder="{{__('customlang.date_debut')}}"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_fin_pointage">{{__('customlang.date_fin')}} </label>
                                            <input type="date"
                                                class="form-control datedropper daterange-pointage required"
                                                ng-model="date_fin_pointage"
                                                ng-change="radioChanged('date_fin_pointage')"
                                                id="date_fin_pointage"
                                                name="date_fin"
                                                placeholder="{{__('customlang.date_fin')}}"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 card bg-primary m-0"
                                    ng-init="selectedDate = new Date(interval_dates[0]?.date)"
                                    ng-if="interval_dates.length > 0">
                                    <ul class="nav nav-tabs nav-top-border nav-justified">
                                        <li class="nav-item ng-scope cursor-pointer"
                                            ng-repeat="item in interval_dates"
                                            ng-click="manageTabDate(item, $index); changeTab(0, 'form_addprogramme-tab'+$index, '', null, item)">
                                            <a class="nav-link text-uppercase myProgrammeTab ng-binding"
                                                ng-class="{'active fw-bold': selectedIndex === $index}"
                                                data-toggle="tab"
                                                id="link@{{$index}}"
                                                target="_self"
                                                aria-expanded="true"
                                                aria-controls="form_addprogramme-tab@{{$index}}">
                                                <span class="svg-icon svg-icon-@{{selectedIndex === $index ? 'primary' : 'white' }}">
                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-calendar.svg')) !!}
                                                </span>
                                                @{{item.initial}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <input class="" type="text" id="day_details_pointage" name="date" hidden />
                                <div class="col-md-12" ng-class="{'d-none': !interval_dates.length}">
                                    <div class="tab-content  px-1 pt-1">
                                        <!-- <div class="row-planning"> -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column mb-8 fv-row ">
                                                    <label for="nom_pointage" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                        <span class="required">{{ __('customlang.heure_arrive') }}</span>
                                                    </label>
                                                    <input
                                                        id="heure_arrive_details_pointage"
                                                        type="time"
                                                        class="form-control form-control-solid required"
                                                        placeholder="{{ __('customlang.heure_arrive') }}"
                                                        name="heure_arrive"
                                                        ng-model="heure_arrive"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column mb-8 fv-row">
                                                    <label for="heure_depart_details_pointage"
                                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                        <span class="required">{{ __('customlang.heure_depart') }}</span>
                                                    </label>
                                                    <input id="heure_depart_details_pointage" type="time"
                                                        class="form-control form-control-solid required"
                                                        placeholder="{{ __('customlang.heure_depart') }} "
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-12 row d-flex">
                                                <!-- Bloc Retard -->
                                                <div class="col-md-4 justify-content-center d-inline-flex">
                                                    <span class="me-3 align-self-center text-muted fw-bold">Retard : &nbsp; </span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group" hidden>
                                                            <div class="form-check form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="radio"
                                                                    id="retard_oui_details_pointage"
                                                                    name="retard"
                                                                    ng-model="retard"
                                                                    value="oui"
                                                                    autocomplete="off" />
                                                                <label class="form-check-label" for="retard_oui_details_pointage">
                                                                    Oui
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="radio"
                                                                    id="retard_non_details_pointage"
                                                                    name="retard"
                                                                    ng-model="retard"
                                                                    value="non"
                                                                    autocomplete="off" />
                                                                <label class="form-check-label" for="retard_non_details_pointage">
                                                                    Non
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                id="retard_details_pointage"
                                                                ng-model="retard"
                                                                ng-true-value="'oui'"
                                                                ng-false-value="'non'"
                                                                ng-checked="heure_arrive > '08:45'"
                                                                ng-disabled="!(heure_arrive > '08:45')"
                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bloc absence-->
                                                <div class="col-md-4 justify-content-center d-inline-flex">
                                                    <span class="me-3 align-self-center text-muted fw-bold">Absence : &nbsp; </span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group" hidden>
                                                            <div class="form-check form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="radio"
                                                                    id="absence_oui_details_pointage"
                                                                    ng-model="absence"
                                                                    value="oui"
                                                                    autocomplete="off" />
                                                                <label class="form-check-label" for="absence_oui_details_pointage">
                                                                    Oui
                                                                </label>
                                                            </div>

                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="radio"
                                                                    id="absence_non_details_pointage"
                                                                    ng-model="absence"
                                                                    value="non"
                                                                    autocomplete="off" />
                                                                <label class="form-check-label" for="absence_non_details_pointage">
                                                                    Non
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                id="absence_details_pointage"
                                                                ng-model="absence"
                                                                ng-true-value="'oui'"
                                                                ng-false-value="'non'"

                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bloc Justificatif -->
                                                <div class="col-md-4 justify-content-center d-inline-flex" ng-class="{'d-block': retard === 'oui' || absence === 'oui','d-none': !(retard === 'oui' || absence === 'oui')}">
                                                    <span class="me-3 align-self-center text-muted fw-bold">justificatif(avec/sans) : &nbsp; </span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group" hidden>
                                                            <div class="form-check form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="radio"
                                                                    id="justificatif_oui_details_pointage"
                                                                    ng-model="justificatif"
                                                                    value="oui"
                                                                    autocomplete="off" />
                                                                <label class="form-check-label" for="justificatif_oui_details_pointage">
                                                                    Oui
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="radio"
                                                                    id="justificatif_non_details_pointage"
                                                                    ng-model="justificatif"
                                                                    value="non"
                                                                    autocomplete="off" />
                                                                <label class="form-check-label" for="justificatif_non_details_pointage">
                                                                    Non
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                                            <input class="form-check-input"
                                                                type="checkbox"
                                                                id="justificatif_details_pointage"
                                                                ng-model="justificatif"
                                                                ng-true-value="'oui'"
                                                                ng-false-value="'non'"
                                                                autocomplete="off">

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bloc Description -->
                                                <div class="col-md-12" ng-if="justificatif === 'oui' && (absence === 'oui' || retard ==='oui')">
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <label for="description_pointage" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                            <span>{{ __('customlang.description') }}</span>
                                                        </label>
                                                        <textarea class="form-control form-control-solid required" rows="4" cols="4" id="description_details_pointage"
                                                            placeholder="{{ __('customlang.description') }} ..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-end  d-block " style="margin-bottom: 20px">
                                                    <button class="btn bg-primary pull-right btnaddemptyprog" type="button" ng-click="actionSurTabPaneTagDataold('add', 'details_pointage')">
                                                        <span class="svg-icon svg-icon-3">
                                                            {!!
                                                            file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-add-item.svg'))
                                                            !!}
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="col-md-12" style="overflow: auto; width: 100%;">
                                                    <table class="table table-hover text-center rounded-3">
                                                        <thead class="bg-template-1-light bg-primary  text-white rounded-3 fw-bold">
                                                            <tr align="center ">
                                                                <th>#</th>
                                                                <th>{{__('customlang.heure_arrive')}}</th>
                                                                <th>{{__('customlang.heure_depart')}}</th>
                                                                <th>{{__('customlang.retard')}}</th>
                                                                <th>{{__('customlang.absence')}}</th>
                                                                <th>{{__('customlang.justificatif')}}</th>
                                                                <th>{{__('customlang.description')}}</th>
                                                                <th style="min-width: 100px"> {!!file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-action.svg'))!!}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="item in dataInTabPane['details_pointage']['data']" align="center" class="animated fadeIn">
                                                                <td>@{{ $index + 1 }}</td>
                                                                <td class="fw-bold">@{{item.heure_arrive}}</td>
                                                                <td class="fw-bold">@{{ item.heure_depart}}</td>
                                                                <td class="fw-bold">@{{ item.retard }}</td>
                                                                <td class="fw-bold">@{{ item.absence}}</td>
                                                                <td class="fw-bold">@{{ item.justificatif}}</td>
                                                                <td class="fw-bold">@{{ item.description }}</td>
                                                                <td class="ps-0 text-end">
                                                                    <div class="d-flex align-items-center justify-content-center">
                                                                        <button type="button" class="btn btn-sm btn-danger btn-icon font-size-sm" ng-click="deleteProgrammeElement('delete', 'details_pointage', $index)" title="{{__('customlang.supprimer')}}">
                                                                            <i class="flaticon2-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold" hidden>@{{ item.day }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end  d-block pb-3 p-t-10 border-0">
                                    <div class="modal-footer" style="border: 0px !important">
                                        <button type="button" class="btn btn-light-dark  shadow btn btn-light-danger  fw-bold" data-bs-dismiss="modal"> Annuler &nbsp;<i class="fa fa-times text-light-danger"></i>
                                        </button>
                                        <button class="btn shadow btn-primary add-btn fw-bold" type="submit" data-original-title="" title="">
                                            Valider &nbsp;<i class="fa fa-check "></i>
                                        </button>
                                    </div>
                                </div>
                                {{-- <div class="card-footer d-block text-end p-b-10 p-t-10 border-0">
                                    <button type="button" class="btn btn-light-dark fw-bold" data-bs-dismiss="modal">{{__('customlang.annuler')}}</button>
                                <button type="submit" class="btn btn-primary fw-bold">{{__('customlang.valider')}}</button>
                            </div> --}}
                        </div>

                    </div>

                    <div class="card-footer text-end pb-3 border-0">
                        <div class="modal-footer" style="border: 0 !important">
                            <button type="button" class="btn btn-light-dark shadow fw-bold" data-bs-dismiss="modal">
                                Annuler &nbsp;<i class="fa fa-times text-light-danger"></i>
                            </button>
                            <button class="btn shadow btn-primary add-btn fw-bold" type="submit">
                                Valider &nbsp;<i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>
                </div> <!-- Fermeture .card -->

                <!-- Sticky Toolbar repositionnée proprement -->
                <ul class="sticky-modal nav flex-column ps-2 pe-2 pt-3 pb-3">
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
            </form>
        </div>
    </div>
</div>