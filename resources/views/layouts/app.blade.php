<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header')

<body>

    <div class="overflow-x-hidden">
        <!-- Main Content -->
        <div class="zMain-wrap">
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- Main Content -->
            <div class="zMainContent">
                <!-- Header -->
                @include('layouts.nav')
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
    @include('layouts.script')
    {!! Toastr::message() !!}
</body>

</html>
