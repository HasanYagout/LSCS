<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('super_admin.layouts.header')

<body>
<div class="overflow-x-hidden">
    @if (getOption('app_preloader_status', 0) == STATUS_ACTIVE)
        <div id="preloader">
            <div id="preloader_status">
                <img src="{{ getSettingImage('app_preloader') }}" alt="{{ getOption('app_name') }}"/>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="zMain-wrap">
        <!-- Sidebar -->
        @include('super_admin.layouts.sidebar')
        <!-- Main Content -->
        <div class="zMainContent">
            <!-- Header -->
            @include('super_admin.layouts.nav')
            <!-- Content -->
            @yield('content')
        </div>
    </div>
</div>
@if (!empty(getOption('cookie_status')) && getOption('cookie_status') == STATUS_ACTIVE)
    <div class="cookie-consent-wrap shadow-lg">
        @include('cookie-consent::index')
    </div>
@endif
@include('super_admin.layouts.script')
</body>

</html>
