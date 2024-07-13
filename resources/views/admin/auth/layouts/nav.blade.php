<!-- Start Header -->
<div class="">

    <!-- Main Header -->
    <div class="pt-16 pb-17 bg-primary-color">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <!-- Left / Logo -->
                <div class="col-lg-1 col-6">
                    <a href="{{ route('index') }}" class="d-flex justify-content-center align-items-center max-w-146">
                        <img height="100" width="100" src="{{ asset('public/frontend/images/liu-logo.png') }}" alt="LIU Logo" /></a>
                </div>
                <!-- Middle / Menu -->
                <div class="col-lg-6 col-6">
                    <nav class="navbar navbar-expand-lg p-0">
                        <button class="navbar-toggler menu-navbar-toggler bd-c-black-color ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="navbar-collapse menu-navbar-collapse offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <button type="button" class="d-lg-none w-30 h-30 p-0 rounded-circle bg-white border-0 position-absolute top-10 right-10" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                            <ul class="navbar-nav menu-navbar-nav justify-content-center flex-wrap cg-42 rg-10 w-100">
                                <li class="nav-item">
                                    <a class="nav-link fs-18 fw-500 lh-28 text-white p-0 active" aria-current="page" href="{{ route('index') }}">{{ __('Home') }}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link hover-color-secondary fs-18 fw-500 lh-28 text-white p-0" href="{{ route('our.news') }}">{{ __('News') }}</a></li>
                                <li class="nav-item"><a class="nav-link hover-color-secondary fs-18 fw-500 lh-28 text-white p-0" href="{{ route('our.notice') }}">{{ __('Notice') }}</a></li>
                                <li class="nav-item"><a class="nav-link hover-color-secondary fs-18 fw-500 lh-28 text-white p-0" href="{{ route('all.job') }}">{{ __('Jobs') }}</a></li>
                                <li class="nav-item"><a class="nav-link hover-color-secondary fs-18 fw-500 lh-28 text-white p-0" href="{{ route('all.stories') }}">{{ __('Story') }}</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link fs-18 fw-500 lh-28 text-white p-0 dropdown-toggle menu-dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('Company') }}</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item nav-link hover-color-secondary fs-18 fw-500 lh-28  p-0" href="{{ route('company.auth.login') }}">
                                                {{ __('Login') }}
                                                <span><i class="fa-solid fa-long-arrow-right"></i></span>
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="{{ route('company.auth.register') }}">
                                                {{ __('Register') }}
                                                <span><i class="fa-solid fa-long-arrow-right"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                            <div class=" w-100 d-lg-none">

                                <div class="d-flex justify-content-start align-items-center flex-wrap g-11 pt-16">
                                    @auth()
                                        <a href="{{ route('admin.auth.login') }}" class="d-flex py-6 px-24 bg-transparent bd-one bd-ra-8 fs-18 fw-500 lh-28 text-white">{{ __('Go To Community') }}</a>
                                    @else
                                        <a href="{{ route('admin.auth.login') }}" class="align-content-center bg-secondary-color mx-3 text-white btn btn-sm d-flex fw-500 h-100 px-20 py-2">{{ __('Admin Login') }}</a>
                                        @if (!getOption('disable_registration'))
                                            <a href="{{ route('company.auth.register') }}" class="align-content-center bg-secondary-color mx-3 text-white btn btn-sm d-flex fw-500 h-100 px-20 py-2">{{ __('Alumni Login') }}</a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="d-flex justify-content-start align-items-center g-11 pt-16">
                        @auth()
                            <a href="{{ route('admin.auth.login') }}" class="d-flex py-6 px-24 bg-transparent bd-one bd-ra-8 fs-18 fw-500 lh-28 text-white">{{ __('Go To Community') }}</a>
                        @else
                            <a href="{{ route('admin.auth.login') }}" class="align-content-center bg-secondary-color text-white btn btn-sm d-flex fw-500 h-100 px-20 py-2">{{ __('Admin Login') }}</a>

                            <a href="{{ route('company.auth.register') }}" class="align-content-center bg-secondary-color  text-white btn btn-sm d-flex fw-500 h-100 px-20 py-2">{{ __('Alumni Login') }}</a>

                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
