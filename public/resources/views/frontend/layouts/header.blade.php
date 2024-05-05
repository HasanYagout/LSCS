<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>{{ getOption('app_name') }} - @stack('title' ?? '')</title>

    @hasSection('meta')
        @stack('meta')
    @else
        @php
            $metaData = getMeta('home');
        @endphp

        <meta name="description" content="{{ __($metaData['meta_description']) ?? getOption('app_name') }}">
        <meta name="keywords" content="{{ __($metaData['meta_keyword']) }}">

        <!-- Open Graph meta tags for social sharing -->
        <meta property="og:type" content="{{ __('Alumni') }}">
        <meta property="og:title" content="{{ __($metaData['meta_title']) ?? getOption('app_name') }}">
        <meta property="og:description" content="{{ __($metaData['meta_description']) ?? getOption('app_name') }}">
        <meta property="og:image" content="{{ __($metaData['og_image']) ?? getSettingImage('app_logo') }}">
        <meta property="og:url" content="{{ url()->current() }}">

        <meta property="og:site_name" content="{{ __(getOption('app_name')) }}">

        <!-- Twitter Card meta tags for Twitter sharing -->
        <meta name="twitter:card" content="{{ __('Alumni') }}">
        <meta name="twitter:title" content="{{ __($metaData['meta_title']) ?? getOption('app_name') }}">
        <meta name="twitter:description" content="{{ __($metaData['meta_description']) ?? getOption('app_name') }}">
        <meta name="twitter:image" content="{{ __($metaData['og_image']) ?? getSettingImage('app_logo') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @endif

    <!-- Place favicon.ico in the root directory -->
    <link rel="icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/png" sizes="16x16">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}">
    <!-- fonts file -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900;1000&display=swap"
        rel="stylesheet"/>
    <!-- css file  -->
    <link rel="stylesheet" href="{{ asset('public/frontend/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/frontend/css/plugins.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/frontend/scss/style.css') }}"/>
    @stack('style')

    @if(getOption('google_analytics_status', 0))
        <!-- Google tag (gtag.js) -->
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ getOption('google_analytics_tracking_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', "{{ getOption('google_analytics_tracking_id') }}");
        </script>
    @endif

</head>
