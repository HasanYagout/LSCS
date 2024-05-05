<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ getOption('app_name') }} - @stack('title' ?? '')</title>
    @hasSection('meta')
        @stack('meta')
    @else
        @php
            $metaData = getMeta('home');
        @endphp

            <!-- Open Graph meta tags for social sharing -->
        <meta property="og:type" content="{{ __('zaisub') }}">
        <meta property="og:title" content="{{ $metaData['meta_title'] ?? getOption('app_name') }}">
        <meta property="og:description" content="{{ $metaData['meta_description'] ?? getOption('app_name') }}">
        <meta property="og:image" content="{{ $metaData['og_image'] ?? getSettingImageCentral('app_logo') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{getOption('app_name') }}">

        <!-- Twitter Card meta tags for Twitter sharing -->
        <meta name="twitter:card" content="{{ __('zaisub') }}">
        <meta name="twitter:title" content="{{ $metaData['meta_title'] ?? getOption('app_name') }}">
        <meta name="twitter:description" content="{{ $metaData['meta_description'] ?? getOption('app_name') }}">
        <meta name="twitter:image" content="{{ $metaData['og_image'] ?? getSettingImageCentral('app_logo') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
    @endif

    <!-- Place favicon.ico in the root directory -->
    <link rel="icon" href="{{ getSettingImageCentral('app_fav_icon') }}" type="image/png" sizes="16x16">
    <link rel="shortcut icon" href="{{ getSettingImageCentral('app_fav_icon') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ getSettingImageCentral('app_fav_icon') }}">
    <!-- fonts file -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900;1000&display=swap"
        rel="stylesheet" />
    <!-- css file  -->
    <link rel="stylesheet" href="{{ asset('public/super_admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/super_admin/css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/super_admin/css/dataTables.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/super_admin/css/dataTables.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/super_admin/css/dataTables.responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/super_admin/scss/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/super_admin/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/super_admin/css/summernote/summernote-lite.min.css') }}" />
    <script src="{{ asset('public/super_admin/js/modernizr-3.11.2.min.js') }}"></script>
    @stack('style')
</head>
