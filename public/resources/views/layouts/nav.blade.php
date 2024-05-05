<div
    class="main-header pt-28 pb-27 px-30 bd-one bd-c-ebedf0 bg-white d-flex justify-content-between align-items-center">
    <!-- Left -->
    <div class="d-flex align-items-center cg-15">
        <!-- Mobile Menu Button -->
        <div class="mobileMenu">
            <button
                class="bd-one bd-c-ededed bd-ra-12 w-30 h-30 d-flex justify-content-center align-items-center text-707070 p-0 bg-transparent">
                <i class="fa-solid fa-bars"></i></button>
        </div>
        <!-- Alumni link -->
        <a href="{{ route('alumni.list-search-with-filter') }}"
            class="d-none d-sm-inline-block fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{
            __('Find
            an Alumni') }}</a>
    </div>
    <!-- Right -->
    <div class="right d-flex justify-content-end align-items-center cg-15">
        <!--language-->
        @if (!empty(getOption('show_language_switcher')) && getOption('show_language_switcher') == STATUS_ACTIVE)
        <div class="dropdown headerUserDropdown lanDropdown">
            <button class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div
                    class="flex-shrink-0 w-42 h-42 rounded-circle overflow-hidden bd-one bd-c-black-5 bg-fafafa d-flex justify-content-center align-items-center">
                    <img class="h-100 object-fit-cover w-100" src="{{ asset(selectedLanguage()?->flag) }}" alt="" />
                </div>
                <div class="text-start d-none d-md-block">
                    <h4 class="fs-15 fw-500 lh-18 text-1b1c17">{{ selectedLanguage()?->language }}</h4>
                </div>
            </button>
            <ul class="dropdown-menu dropdownItem-one">
                @foreach (appLanguages() as $app_lang)
                <li>
                    <a class="d-flex align-items-center cg-8" href="{{ url('/local/' . $app_lang->iso_code) }}">
                        <div class="d-flex">
                            <img src="{{ asset($app_lang->flag) }}" alt="" class="max-w-26" />
                        </div>
                        <p class="fs-14 fw-500 lh-16 text-707070">{{ $app_lang->language }}</p>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- Message - Notify - User -->
        <div class="d-flex align-items-center cg-17">
            <div class="d-flex align-items-center cg-5">
                <!-- Message -->
                <a href="{{ route('chats.index') }}" class="item-one">
                    <img src="{{ asset('assets/images/icon/chat-one.svg') }}" alt="" />
                    <span class="notify_no" id="unseen-user-message">{{ userMessageUnseen() }}</span>
                </a>
                <!-- Notify -->
                <div class="dropdown notifyDropdown">
                    <button class="item-one dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('assets/images/icon/bell.svg') }}" alt="" />
                        <span class="notify_no">{{ count(userNotification('unseen')) }}</span>
                    </button>
                    <div class="dropdown-menu">
                        <div
                            class="d-flex justify-content-between align-items-center {{ count(userNotification('unseen')) > 0 ? 'bd-b-one' : '' }}  bd-c-ededed pb-3">
                            <h4 class="fs-15 fw-600 lh-32 text-black">
                                @if (count(userNotification('unseen')) > 0)
                                {{ __('Today') }}
                                @else
                                {{ __('Notification Not Found!') }}
                                @endif
                            </h4>
                            @if (count(userNotification('unseen')) > 0)
                            <a href="{{ route('notification.notification-mark-all-as-read') }}"
                                class="fs-12 fw-600 lh-20 text-1b1c17 text-decoration-underline border-0 p-0 bg-transparent hover-color-one">{{
                                __('Mark
                                all as read') }}</a>
                            @endif
                        </div>

                        <ul class="notify-list">
                            @foreach (userNotification('unseen') as $key => $item)
                                <li class="d-flex align-items-start cg-15">
                                    <div class="flex-grow-0 flex-shrink-0 w-32 h-32 rounded-circle d-flex justify-content-center align-items-center bg-71e3ba">
                                        <img src="{{ asset('assets/images/icon/bell-white.svg') }}" alt="" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="{{ route('notification.notification-mark-as-read',$item->id) }}">
                                            <div class="d-flex justify-content-between align-items-center pb-8">
                                                <p class="fs-13 fw-500 lh-20 text-1b1c17">{{ $item->title }}</p>
                                                <p class="fs-10 fw-400 lh-20 text-707070">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            <p class="fs-12 fw-400 lh-17 text-707070 max-w-220">
                                                {{ $item->body }}
                                                @if(!empty($item->link))
                                                <span class="text-1b1c17 text-decoration-underline hover-color-one">{{ __('View') }}</span>
                                                @endif
                                            </p>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- User -->
            <div class="dropdown headerUserDropdown">
                <button class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="w-42 h-42 rounded-circle overflow-hidden bd-one bd-c-cdef84"><img
                            src="{{ asset(getFileUrl(auth()->user()->image)) }}" alt="{{ auth()->user()->name }}" />
                    </div>
                    <div class="text-start d-none d-sm-block">
                        <p class="fs-12 fw-400 lh-15 text-707070">{{ __('Welcome') }}</p>
                        <h4 class="fs-15 fw-500 lh-18 text-1b1c17">{{ auth()->user()->name }}</h4>
                    </div>
                </button>
                <ul class="dropdown-menu dropdownItem-one">
                    <li>
                        <a class="d-flex align-items-center cg-8" href="{{ route('profile') }}">
                            <div class="d-flex">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.7274 20.4471C19.2716 19.1713 18.2672 18.0439 16.8701 17.2399C15.4729 16.4358 13.7611 16 12 16C10.2389 16 8.52706 16.4358 7.12991 17.2399C5.73276 18.0439 4.72839 19.1713 4.27259 20.4471"
                                        stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round">
                                    </path>
                                    <circle cx="12" cy="8" r="4" stroke="#707070" stroke-opacity="0.7"
                                        stroke-width="1.5" stroke-linecap="round"></circle>
                                </svg>
                            </div>
                            <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Profile') }}</p>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center cg-8" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="d-flex">
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.49935 17.8333C7.28921 17.8333 5.1696 16.9553 3.60679 15.3925C2.04399 13.8297 1.16602 11.7101 1.16602 9.49996C1.16602 7.28982 2.04399 5.17021 3.60679 3.6074C5.1696 2.0446 7.28921 1.16663 9.49935 1.16663"
                                        stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                        stroke-linecap="round" />
                                    <path d="M7.41602 9.5H17.8327M17.8327 9.5L14.7077 6.375M17.8327 9.5L14.7077 12.625"
                                        stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Logout') }}</p>
                        </a>
                    </li>
                </ul>
            </div>
            @if (request()->route()->getName() == 'home')
            <!-- Home Right side for Mobile view -->
            <button
                class="d-md-none bd-one bd-c-ededed bd-ra-12 w-30 h-30 d-flex justify-content-center align-items-center text-707070 p-0 bg-transparent"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#homeRightSideView"
                aria-controls="homeRightSideView">
                <img src="{{ asset('assets/images/icon/nav-right-menu.svg') }}" alt="" />
            </button>
            @endif
        </div>
    </div>
</div>
