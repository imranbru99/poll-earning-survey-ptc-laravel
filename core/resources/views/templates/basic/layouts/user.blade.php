<!DOCTYPE html>
<html lang="en">

<head>

<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $general->sitename($page_title) }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicons -->
    <link href="{{ asset(imagePath()['logoIcon']['path'] . '/favicon.png') }}" rel="icon">
    <link href="{{ asset(imagePath()['logoIcon']['path'] . '/favicon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">



    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/app/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/app/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/app/vendors/mdi/css/materialdesignicons.min.css') }}">




    <link rel="stylesheet" href="{{ asset('assets/survey-style.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/css/custom.css') }}">
    <link rel="stylesheet"
        href="{{ asset(asset($activeTemplateTrue) . "/css/color.php?color1=$general->base_color&color2=$general->secondary_color") }}">
    @include($activeTemplate . 'partials.premium-css')


    @include('partials.seo')
    @stack('style-lib')

    @stack('style')
</head>

<body>
    @include('partials.sidebar')

    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright ©
                    {{ $general->sitename }} {{ date('Y') }}</span>
                <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Guaranteed Earning <a
                        href="{{ route('home') }}" target="_blank">{{ config('app.name') }}</a> from
                    {{ $general->sitename }} </span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>


    <!-- plugins:js -->
    <script src="{{ asset($activeTemplateTrue . 'app/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset($activeTemplateTrue . 'app/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'app/js/jquery.cookie.js" type="text/javascript') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset($activeTemplateTrue . 'app/js/off-canvas.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'app/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'app/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset($activeTemplateTrue . 'app/js/dashboard.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'app/js/todolist.js') }}"></script>
    <!-- End custom js for this page -->
    <!-- Template Main JS File -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <!-- lightcase plugin -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/lightcase.js') }}"></script>
    <!-- custom select js -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/jquery.nice-select.min.js') }}"></script>
    <!-- slick slider js -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/slick.min.js') }}"></script>
    <!-- scroll animation -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/wow.min.js') }}"></script>
    <!-- dashboard custom js -->
    <script src="{{ asset($activeTemplateTrue . '/js/app.js') }}"></script>


</body>



@stack('script-lib')


@include('admin.partials.notify')

@include('partials.plugins')

@stack('script')


</html>
