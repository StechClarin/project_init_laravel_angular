<div class="container d-flex justify-content-center align-items-center py-3">
    <div class="container">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body pt-3 pb-2">
                <h5 class="text-center mb-3 fw-semibold">Humeurs des utilisateurs</h5>
                <div class="row justify-content-center gap-2">
                    <div class="col-md-2 col-4 card-container-dash" ng-repeat="item in dataPage['users']">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                                <div class="icon-object mb-1">
                                    <span class="fs-1">
                                        @{{ item.moods.emoji || '❓' }}
                                    </span>
                                </div>
                                <small class="text-muted mt-1">
                                    @{{ item.moods.designation || '' }}
                                </small>
                            </div>
                            <div class="bg-primary rounded-bottom text-center py-1">
                                <span class="fw-semibold text-white small">@{{ item.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container d-flex justify-content-center align-items-center py-3">
    <div class="container">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body pt-3 pb-2">
                <h5 class="text-center mb-3 fw-semibold">Les assistances</h5>
                <div class="row justify-content-center gap-2">
                    <div class="col-md-2 col-4 card-container-dash" ng-repeat="statut in [0,1,2]">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                                <div class="icon-object mb-1">
                                    <span class="fs-1">
                                        @{{ (dataPage['assistances'] | filter:{status: statut}).length }}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-primary rounded-bottom text-center py-1">
                                <span class="fw-semibold text-white small">
                                    @{{ statut == 1 ? 'en attente' : (statut == 0 ? 'clôturées' : 'en cours') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>