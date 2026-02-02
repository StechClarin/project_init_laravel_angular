<style>
    .subheader-fixed.subheader-enabled .wrapper {
        padding-top: 20px !important;
    }

    .wd-85 {
        width: 85%;
    }
    .wd-70 {
        width: 70%;
    }
</style>


@if(!isset(Auth::user()->client))
    <div class="content d-flex flex-column flex-column-fluid accueil p-0" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="wd-85 mx-auto align-self-center">
                <div class="item-back">
                    <div class="item-home-border position-relative">
                        <div class="item-home">
                            <div class="animated fadeInDown w-100">
                                <div class="row">
                                    <div class="col-md-6 bg-primary br-rad-shadow-10">

                                        <div class="item-card-home bg-body">
                                            <div class="d-inline-flex w-100 p-4">
                                                <div class="align-self-center">
                                                    <div class="item-home-img-0 br-2">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-client.svg')) !!}
                                                    </div>
                                                </div>
                                                <div class="align-self-center item-titre text-dark">
                                                    {{ __('customlang.CLIENTS') }}
                                                </div>
                                                <div class="align-self-center ms-auto">
                                                    <div class="item-home-number br-2">
                                                        @{{dataPage['indexs'][0].nbre_clients}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item-card-home bg-body">
                                            <div class="d-inline-flex w-100 p-4">
                                                <div class="align-self-center">
                                                    <div class="item-home-img-0 br-2">
                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/icon-projet.svg')) !!}
                                                    </div>
                                                </div>
                                                <div class="align-self-center item-titre text-dark">
                                                    {{ __('customlang.projets') }}
                                                </div>
                                                <div class="align-self-center ms-auto">
                                                    <div class="item-home-number br-2">
                                                        @{{dataPage['indexs'][0].nbre_projets}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 text-center img-accueil">
                                        <div class="h-100 bg-body align-self-center d-block br-rad-shadow-10">
                                            <img class="h-100px" src="{{ ('assets/media/logos/logo.svg') }}" alt="Logo">
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
@else
    <div class="content d-flex flex-column flex-column-fluid unauthorized p-0" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="wd-70 mx-auto align-self-center">
                <div class="">
                    <div class="item-home-border position-relative">
                        <div class="item-home bg-body">
                            <div class="animated fadeInDown w-100">
                                <img class="w-100" src="{{ ('assets/media/logos/logo.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
