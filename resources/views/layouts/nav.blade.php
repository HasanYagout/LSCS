@php use Illuminate\Support\Facades\Auth; @endphp
<div
    class="main-header py-10 px-30  bg-secondary-color d-flex justify-content-between align-items-center" style="background: url("{{asset('public/frontend/images/community-bg.png')}}")" data-background="{{asset('public/frontend/images/community-bg.png')}}">

<div class="d-flex align-items-center cg-15" >
    <!-- Mobile Menu Button -->
    <div class="mobileMenu">
        <button
            class="bd-one bd-c-ededed bd-ra-12 w-30 h-30 d-flex justify-content-center align-items-center text-707070 p-0 bg-transparent">
            <i class="fa-solid fa-bars"></i></button>
    </div>
    @if(Auth::check() && Auth::user()->role_id == USER_ROLE_ADMIN)
        <a href="{{ route('admin.alumni.list') }}" class="d-none  d-sm-inline-block fs-15 fw-500 lh-25 text-white  py-10 px-26 bg-primary-color bd-ra-12 hover-bg-#002a5c">{{
            __('Find an Alumni') }}</a>
    @endif
</div>
<!-- Right -->
<div class="right d-flex justify-content-end align-items-center cg-15">
    <!-- Message - Notify - User -->
    <div class="d-flex align-items-center cg-17">

        <div class="dropdown headerUserDropdown">
            @php
                $authenticatedUser = Auth::user();
                if ($authenticatedUser) {
            switch ($authenticatedUser->role_id) {
        case 1:
            $userInfo = $authenticatedUser->admin;
            $role = 'admin';
            break;
        case 2:
            $userInfo = $authenticatedUser->alumni;
            $role = 'alumni';
            break;
        case 3:
            $userInfo = $authenticatedUser->company;
            $role = 'company';
            break;
    }
}
            @endphp

            <button class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                @if ($authenticatedUser)
                    <div class="w-42 h-42 rounded-circle overflow-hidden bd-one bd-c-primary-color">
                        <img class="h-100 object-fit-cover ratio" onerror="this.src='{{ asset('public/assets/images/no-image.jpg') }}'"
                             src="{{ asset('public/storage') . '/' . $role . '/'.'image'.'/' . $userInfo->image }}"
                             alt="{{ $userInfo->first_name . ' ' . $userInfo->last_name }}" />
                    </div>
                    <div class="text-start d-none d-sm-block">
                        <p class="fs-12 fw-400 lh-15 text-707070">{{ __('Welcome') }}</p>
                        <h4 class="fs-15 fw-500 lh-18 text-1b1c17">
                            @if ($role == 'company')
                                {{ $userInfo->name }}
                            @else
                                {{ $userInfo->first_name }}
                            @endif
                        </h4>
                    </div>
                @endif
            </button>

            <ul class="dropdown-menu dropdownItem-one">
                @if ($authenticatedUser)
                    <li>
                        <a class="d-flex align-items-center cg-8" href="{{ route($role . '.profile.index') }}">
                            <div class="d-flex">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7274 20.4471C19.2716 19.1713 18.2672 18.0439 16.8701 17.2399C15.4729 16.4358 13.7611 16 12 16C10.2389 16 8.52706 16.4358 7.12991 17.2399C5.73276 18.0439 4.72839 19.1713 4.27259 20.4471" stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"></path>
                                    <circle cx="12" cy="8" r="4" stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"></circle>
                                </svg>
                            </div>
                            <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Profile') }}</p>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center cg-8" href="{{ route('auth.logout') }}">
                            <div class="d-flex">
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.49935 17.8333C7.28921 17.8333 5.1696 16.9553 3.60679 15.3925C2.04399 13.8297 1.16602 11.7101 1.16602 9.49996C1.16602 7.28982 2.04399 5.17021 3.60679 3.6074C5.1696 2.0446 7.28921 1.16663 9.49935 1.16663" stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7.41602 9.5H17.8327M17.8327 9.5L14.7077 6.375M17.8327 9.5L14.7077 12.625" stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Logout') }}</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>


        @if (request()->route()->getName() == 'admin.home')
            <!-- Home Right side for Mobile view -->
            <button
                class="d-md-none bd-one bd-c-ededed bd-ra-12 w-30 h-30 d-flex justify-content-center align-items-center text-707070 p-0 bg-transparent"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#homeRightSideView"
                aria-controls="homeRightSideView">
                <img src="{{ asset('public/assets/images/icon/nav-right-menu.svg') }}" alt="" />
            </button>
        @endif
    </div>
</div>
</div>
