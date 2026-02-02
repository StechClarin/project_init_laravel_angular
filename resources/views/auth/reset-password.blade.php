@extends('layouts.app')

@section('content')

    <body id="kt_body"
        class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-body" id="kt_login">
                <div class="content order-2 order-lg-1 d-flex flex-column w-100 pb-0 bg-white">
                    <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="true">
                        <div class="carousel-inner h-100">
                            <div class="carousel-item h-100 active text-center" style="display:flex;align-items:center;" data-bs-interval="3000">
                                <img  style="width: 85%;object-fit:cover;margin: auto" src="{{asset('assets/media/svg/illustrations/slide-1.svg')}}" class="d-block" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="login-aside order-1 order-lg-2 d-flex flex-row-auto position-relative overflow-hidden shadow-sm">
                    <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                        <div class="d-flex flex-column-fluid flex-column flex-center">
                            <div class="login-form py-11">
                                <form class="form" method="POST" action="{{ route('password.email.post') }}">
                                    @csrf
                                    <div class="text-center pb-8">
                                        <a href="" target="_self" class="text-center pt-2">
                                            <img src="{{asset('assets/media/logos/logo.svg')}}" class="h-200px" alt="" />
                                        </a>
                                    </div>

                                    <div class="text-center pb-8">
                                        <h2 class="fw-bolder text-dark font-size-h2 font-size-h1-lg">Réinitialiser votre mot
                                            de passe </h2>
                                    </div>

                                    <input type="hidden" name="email" id="email" value="{{ $email }}">

                                    <input type="hidden" name="token" id="token" value="{{ $token }}">

                                    <div class="form-group mt-5 mb-0">
                                        <div class="d-flex justify-content-between mt-n5">
                                            <label
                                                class="font-size-h6 fw-bolder text-dark pt-5 mb-2">{{ __('Mot de passe') }}</label>
                                        </div>

                                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                            type="password" id="password" name="password"
                                            placeholder="Nouveau mot de passe" required autocomplete="current-password"
                                            autofocus />

                                        @error('password')
                                            <span class="invalid-feedback mt-4" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end mb-3">
                                        <label for="check" class="pointer-hover btn-eye">
                                            <!--<img class="wdpx-22" src="{{ asset('assets/media/icon-eye.svg') }}" alt="">-->
                                            <span id="fa-eye" class="fa fa-eye" style="font-size: 24px;color: #2BA3A3"></span>
                                            <span id="fa-eye-slash" class="fa fa-eye-slash" style="font-size: 24px;color: #2BA3A3;display:none;"></span>
                                            <div class="custom-control custom-checkbox me-2 d-none">
                                                <input type="checkbox" id="check" dataIdParent="password"
                                                    dataIdShow="fa-eye" dataIdHide="fa-eye-slash"
                                                    class="custom-control-input hideshownew"><label
                                                    class="custom-control-label" for="mdp"></label>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-group mt-5 mb-0">
                                        <div class="d-flex justify-content-between mt-n5">
                                            <label class="font-size-h6 fw-bolder text-dark pt-5 mb-2">Confirmation Du
                                                {{ __('Mot de passe') }}</label>
                                        </div>

                                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                            type="password" id="password_confirmation" name="password_confirmation"
                                            placeholder="Confirmation du mot de passe" required autocomplete="new-password"
                                            autofocus />

                                        @error('password')
                                            <span class="invalid-feedback mt-4" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end mb-3">
                                        <label for="check-confirm" class="pointer-hover btn-eye">
                                            <!--<img class="wdpx-22" src="{{ asset('assets/media/icon-eye.svg') }}" alt="">-->
                                            <span id="fa-eye-confirm" class="fa fa-eye" style="font-size: 24px;color: #2BA3A3"></span>
                                            <span id="fa-eye-slash-confirm" class="fa fa-eye-slash" style="font-size: 24px;color: #2BA3A3;display:none;"></span>
                                            <div class="custom-control custom-checkbox me-2 d-none">
                                                <input type="checkbox" id="check-confirm"
                                                    dataIdParent="password_confirmation" dataIdShow="fa-eye-confirm"
                                                    dataIdHide="fa-eye-slash-confirm"
                                                    class="custom-control-input hideshownew"><label
                                                    class="custom-control-label" for="mdp"></label>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-md-12 mt-5">
                                        @if (Session::has('error'))
                                            <div class="alert alert-danger text-center mb-4">
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
                                        @if (Session::has('success'))
                                            <div class="alert alert-success text-center mb-4">
                                                {{ Session::get('success') }}
                                            </div>
                                        @endif
                                    </div>


                                    <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                        <button
                                            class="btn btn-primary fw-bolder font-size-h6 px-8 py-4 my-3 mx-4">Envoyer</button>
                                        <a href="{{ route('login') }}"
                                            class="btn bg-light-primary fw-bolder font-size-h6 px-8 py-4 my-3 mx-4">Retour
                                            à la connexion</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="https://guindytechnology.com/" target="_blank"
                                class="btn btn-light-primary fw-bolder px-8 py-4 my-3 font-size-h6">
                                <span class="svg-icon svg-icon-md">
                                    {!! file_get_contents(public_path('assets/media/logos/logo-guindy.svg')) !!}
                                </span>
                                Guindy Technology
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
