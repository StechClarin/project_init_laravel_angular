@extends('layouts.app')

@section('content')
    <body id="kt_body" class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-body" id="kt_login">
                <div class="content order-2 order-lg-1 d-flex w-100 pb-0 h-100 p-0" style="background-image: url({{asset('assets/media/svg/illustrations/login-bg.svg')}});background-repeat: no-repeat;background-position: center">
                    <div class="d-flex justify-content-center w-100 align-items-center mx-auto text-center px-lg-0 px-7">

                    </div>
                </div>
                <div class="login-aside order-1 order-lg-2 d-flex flex-row-auto position-relative overflow-hidden">
                    <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                        <div class="d-flex flex-column-fluid flex-column flex-center">
                            <div class="login-form py-11">
                                <form class="form" method="POST" action="{{ route('login.post') }}">
                                    @csrf
                                    <div class="text-center pb-8">
                                        <a href="" class="text-center pt-2">
                                            <img src="{{asset('assets/media/logos/logo.svg')}}" class="h-100px" alt="" />
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-size-h6 fw-bolder text-dark mb-2" for="email">Adresse Email</label>
                                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Entrez votre adresse email" required autocomplete="off" autofocus/>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-5 mb-0">
                                        <div class="d-flex justify-content-between mt-n5">
                                            <label class="font-size-h6 fw-bolder text-dark pt-5 mb-2">{{ __('Mot de passe') }}</label>
                                        </div>

                                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" id="password" name="password" placeholder="*******" required autocomplete="current-password" autofocus />

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
                                                <input type="checkbox" id="check" dataIdParent="password" dataIdShow="fa-eye" dataIdHide="fa-eye-slash" class="custom-control-input hideshownew"><label class="custom-control-label" for="mdp"></label>
                                            </div>
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                            <div></div>
                                            <a href="{{ route('password.request') }}" class="link-primary">Mot de passe oublié ?</a>
                                        </div>
                                    @endif

                                    @if(Session::has('msg'))
                                        <div class="alert alert-danger text-center mb-4 mt-4">
                                            {{Session::get('msg')}}
                                        </div>
                                    @endif

                                    <div style="font-size: 14px;margin: 12px 0 12px;display: none">
                                        <div class="input-group">
                                            <div class="d-inline-block custom-control custom-checkbox me-2">
                                                <input type="checkbox" id="mdp" class="custom-control-inpu hideshow"><label class="custom-control-label" for="mdp">Afficher mot de passe</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pt-5 mt-lg-5 mt-4">
                                        <button class="btn btn-primary fw-bolder font-size-h6 px-8 py-4 my-3">Connexion</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="https://guindytechnology.com/" target="_blank" class="btn btn-light-primary fw-bolder px-8 py-4 my-3 font-size-h6">
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
