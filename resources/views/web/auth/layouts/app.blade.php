<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.auth.layouts.header')
{{--{!! RecaptchaV3::initJs() !!}--}}

<body>
@include('web.auth.layouts.nav')


    <div id="preloader">
        <div id="preloader_status">
            <img src="{{ asset('public/frontend/images/liu-logo.png') }}" alt="{{ getOption('app_name') }}" />
        </div>
    </div>


    @yield('content')
    @if (!empty(getOption('cookie_status')) && getOption('cookie_status') == STATUS_ACTIVE)
    <div class="cookie-consent-wrap shadow-lg">
        @include('cookie-consent::index')
    </div>
    @endif

    @include('web.auth.layouts.script')

    @stack('script')
</body>

</html>
