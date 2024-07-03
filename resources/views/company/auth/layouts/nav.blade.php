
<div class="">
    <div class="col-lg-6">
        <div class="d-flex justify-content-center justify-content-lg-end align-items-center g-11">
            <!-- Language switcher -->
            @if (!empty(getOption('show_language_switcher')) && getOption('show_language_switcher') == STATUS_ACTIVE)
                <div class="dropdown headerUserDropdown lanDropdown">
                    <button
                        class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div
                            class="flex-shrink-0 w-42 h-42 rounded-circle overflow-hidden bd-one bd-c-black-5 bg-fafafa d-flex justify-content-center align-items-center">
                            <img class="h-100 object-fit-cover w-100" src="{{ asset(selectedLanguage()?->flag) }}"
                                 alt="" />
                        </div>
                        <div class="text-start d-none d-md-block">
                            <h4 class="fs-15 fw-500 lh-18 text-1b1c17">{{ selectedLanguage()?->language }}
                            </h4>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdownItem-one">
                        @foreach (appLanguages() as $app_lang)
                            <li>
                                <a class="d-flex align-items-center cg-8"
                                   href="{{ url('/local/' . $app_lang->iso_code) }}">
                                    <div class="d-flex">
                                        <img src="{{ asset($app_lang->flag) }}" alt=""
                                             class="max-w-26" />
                                    </div>
                                    <p class="fs-14 fw-500 lh-16 text-707070">{{ $app_lang->language }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
<!-- Main Header -->
<div class="pt-16 pb-17 bg-primary-color">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <img style="height: 100px" height="100" src="{{asset('public/frontend/images/liu-logo.png')}}" alt="">
            </div>
            <!-- Middle / Menu -->
            <div class="col-lg-6 col-6">
                <nav class="navbar navbar-expand-lg p-0">
                    <button class="navbar-toggler menu-navbar-toggler bd-c-black-color ms-auto" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse menu-navbar-collapse offcanvas offcanvas-start" tabindex="-1"
                         id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <button type="button"
                                class="d-lg-none w-30 h-30 p-0 rounded-circle bg-white border-0 position-absolute top-10 right-10"
                                data-bs-dismiss="offcanvas" aria-label="Close"><i
                                class="fa-solid fa-times"></i></button>
                        <ul class="navbar-nav justify-content-around menu-navbar-nav justify-content-center flex-wrap cg-42 rg-10 w-100">
                            <li class="nav-item">
                                <a class="nav-link fs-18 fw-500 lh-28 text-white p-0 active"
                                   aria-current="page" href="{{ route('index') }}">{{ __('Home') }}</a>
                            </li>

                            <li class="nav-item"><a class="nav-link fs-18 fw-500 lh-28 text-white p-0"
                                                    href="{{ route('all.alumni') }}">{{ __('Alumni') }}</a></li>
                            <li class="nav-item"><a class="nav-link fs-18 fw-500 lh-28 text-white p-0"
                                                    href="{{ route('all.event') }}">{{ __('Events') }}</a></li>
                            <li class="nav-item"><a class="nav-link fs-18 fw-500 lh-28 text-white p-0"
                                                    href="{{ route('our.news') }}">{{ __('News') }}</a></li>
                            <li class="nav-item"><a class="nav-link fs-18 fw-500 lh-28 text-white p-0"
                                                    href="{{ route('our.notice') }}">{{ __('Notice') }}</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link fs-18 fw-500 lh-28 text-white p-0 dropdown-toggle menu-dropdown-toggle"
                                   href="#" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">{{ __('Company') }}</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('company.auth.register') }}">
                                            {{ __('Sign up') }}
                                            <span><i class="fa-solid fa-long-arrow-right"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('company.auth.login') }}">
                                            {{ __('Login') }}
                                            <span><i class="fa-solid fa-long-arrow-right"></i></span>
                                        </a>

                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="pt-20 w-100 d-lg-none">
                            <div
                                class="d-flex justify-content-start align-items-center flex-wrap cg-23 rg-10 pb-30">
                                <a href="mailto:{{ getOption('app_email') }}"
                                   class="d-flex align-items-center cg-7 fs-18 fw-600 lh-28 text-white">
                                    <div class="d-flex flex-shrink-0"><img
                                            src="{{ asset('public/frontend/images/icon/envelope.svg') }}"
                                            alt="" /></div>
                                    <p><span class="d-none d-lg-block">{{ __('Email') }} :</span> <span
                                            class="fw-500">{{ getOption('app_email') }}</span></p>
                                </a>
                                <a href="tel:(880) 2566 3245"
                                   class="d-flex align-items-center cg-7 fs-18 fw-600 lh-28 text-black-color">
                                    <div class="d-flex flex-shrink-0"><img
                                            src="{{ asset('public/frontend/images/icon/phone.svg') }}" alt="" />
                                    </div>
                                    <p><span class="d-none d-lg-block">{{ __('Hotline') }} :</span> <span
                                            class="fw-500">{{ getOption('app_contact_number') }}</span></p>
                                </a>
                            </div>
                            <!-- Language switcher -->
                            @if (!empty(getOption('show_language_switcher')) && getOption('show_language_switcher') == STATUS_ACTIVE)
                                <div class="dropdown headerUserDropdown lanDropdown">
                                    <button
                                        class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div
                                            class="flex-shrink-0 w-42 h-42 rounded-circle overflow-hidden bd-one bd-c-black-5 bg-fafafa d-flex justify-content-center align-items-center">
                                            <img class="max-w-26" src="{{ asset(selectedLanguage()?->flag) }}"
                                                 alt="" />
                                        </div>
                                        <div class="text-start d-none d-md-block">
                                            <h4 class="fs-15 fw-500 lh-18 text-1b1c17">
                                                {{ selectedLanguage()?->language }}
                                            </h4>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu dropdownItem-one">
                                        @foreach (appLanguages() as $app_lang)
                                            <li>
                                                <a class="d-flex align-items-center cg-8"
                                                   href="{{ url('/local/' . $app_lang->iso_code) }}">
                                                    <div class="d-flex">
                                                        <img src="{{ asset($app_lang->flag) }}" alt=""
                                                             class="max-w-26" />
                                                    </div>
                                                    <p class="fs-14 fw-500 lh-16 text-707070">
                                                        {{ $app_lang->language }}</p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="d-flex justify-content-start align-items-center flex-wrap g-11 pt-16">
                                {{--                                    @auth()--}}
                                {{--                                        <a href="{{ route('login') }}"--}}
                                {{--                                            class="d-flex py-6 px-24 bg-transparent bd-one bd-ra-8 fs-18 fw-500 lh-28 text-black-color">{{ __('Go To Community') }}</a>--}}
                                {{--                                    @else--}}
                                {{--                                        <a href="{{ route('login') }}"--}}
                                {{--                                            class="d-flex py-6 px-24 bg-black-color bd-ra-8 fs-18 fw-500 lh-28 text-white">{{ __('Login') }}</a>--}}
                                {{--                                        @if (!getOption('disable_registration'))--}}
                                {{--                                            <a href="{{ route('register') }}"--}}
                                {{--                                                class="d-flex py-6 px-24 bg-transparent bd-one bd-ra-8 fs-18 fw-500 lh-28 text-black-color">{{ __('Sign Up') }}</a>--}}
                                {{--                                        @endif--}}
                                {{--                                    @endauth--}}
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <!-- Right -->
            <div class="col-lg-4 d-none d-lg-flex">
                @auth()
                    <a href="{{ route('alumni.auth.login') }}"
                       class="d-flex py-6 px-24 bg-white bd-one bd-ra-8 fs-18 fw-500 lh-28 text-black-color hover-bg-color-primary hover-border-color-primary">{{ __('Go To Community') }}</a>
                @else
                    <a href="{{ route('alumni.auth.login') }}"
                       class="align-content-center bg-secondary-color mx-3 text-white btn btn-sm d-flex fw-500 h-100 px-20 py-2">{{ __('Alumni Login') }}</a>
                    @if (!getOption('disable_registration'))
                        <a href="{{ route('admin.auth.login') }}"
                           class="align-content-center bg-secondary-color text-white btn btn-sm d-flex fw-500 h-100 px-20 py-2">{{ __('Admin Login') }}</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
</div>
<!-- End Header -->