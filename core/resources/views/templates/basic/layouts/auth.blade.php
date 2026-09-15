<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $general->sitename($page_title) }}</title>
    <link rel="shortcut icon" href="{{ asset(imagePath()['logoIcon']['path'] . '/favicon.png') }}" />
    @include($activeTemplate . 'partials.premium-css')
    @include('partials.seo')
    @stack('style-lib')
    @stack('style')
</head>
<body class="site-body">
    @yield('content')
    @include('admin.partials.notify')
    @include('partials.plugins')
    <script src="{{ asset($activeTemplateTrue . 'app/vendors/js/vendor.bundle.base.js') }}"></script>
    @stack('script')
</body>
</html>
