<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->sitename($page_title ?? '') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- site favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
    <!-- bootstrap 4  -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap.min.css') }}">
    <!-- bootstrap toggle css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap-toggle.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/all.min.css') }}">
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/line-awesome.min.css') }}">
    @stack('style-lib')
    <!-- custom select box css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/nice-select.css') }}">
    <!-- code preview css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/prism.css') }}">
    <!-- select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/select2.min.css') }}">
    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/datatables.min.css') }}">
    <!-- jvectormap css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/jquery-jvectormap-2.0.5.css') }}">
    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/datepicker.min.css') }}">
    <!-- timepicky for time picker css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/jquery-timepicky.css') }}">
    <!-- bootstrap-clockpicker css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap-clockpicker.min.css') }}">
    <!-- bootstrap-pincode css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap-pincode-input.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <!-- dashdoard main css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/survey-style.css') }}">
    @stack('style')
</head>

<body>
    @yield('content')

    <!-- jQuery library -->
    <script src="{{ asset('assets/admin/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('assets/admin/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <!-- bootstrap-toggle js -->
    <script src="{{ asset('assets/admin/js/vendor/bootstrap-toggle.min.js') }}"></script>

    <!-- slimscroll js for custom scrollbar -->
    <script src="{{ asset('assets/admin/js/vendor/jquery.slimscroll.min.js') }}"></script>
    <!-- custom select box js -->
    <script src="{{ asset('assets/admin/js/vendor/jquery.nice-select.min.js') }}"></script>
    @include('admin.partials.notify')
    @stack('script-lib')

    <script src="{{ asset('assets/admin/js/nicEdit.js') }}"></script>

    <!-- code preview js -->
    <script src="{{ asset('assets/admin/js/vendor/prism.js') }}"></script>
    <!-- seldct 2 js -->
    <script src="{{ asset('assets/admin/js/vendor/select2.min.js') }}"></script>
    <!-- data-table js -->
    {{--  <script src="{{asset('assets/admin/js/vendor/datatables.min.js')}}"></script>  --}}
    <!-- main js -->
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/site-script.js') }}"></script>

    {{-- LOAD NIC EDIT --}}
    <script type="text/javascript">
        (function($, document) {
            "use strict";
            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: true
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });

        })(jQuery, document);

        $(document).on('click', '#clearAds', function() {
            ClearShowedAds();
        });

        function ClearShowedAds() {
            Swal.fire({
                title: 'Sure! To reset all showed records of all Ads?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reset the Ads showed Records!'
            }).then((deleteShowed) => {
                var url = '{{ route('admin.clear-ads-showed') }}';
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                // I hope you are learning
                var data = "Okay_Clear";
                $('.loader').removeClass('d-none');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "Json",
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    success: function(response) {
                        setTimeout(() => {
                            if (response.adsCleared) {
                                $('.loader').addClass('loading-done');
                                Swal.fire(
                                    'Ads Showed Resets!',
                                    'All showed Data has been reset.',
                                    'success'
                                )
                                $('.loader').removeClass('loading-done').addClass('d-none');
                            }
                        }, 3500);

                    }
                });
            });
        }
    </script>
    @stack('script')
</body>

</html>
