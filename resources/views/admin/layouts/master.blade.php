<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->siteName($pageTitle ?? '') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ getImage(getFilePath('logoIcon') . '/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/viser_admin/css/vendor/bootstrap-toggle.min.css') }}">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">

    @include('partials.notify')
    @stack('style-lib')

    <link rel="stylesheet" href="{{ asset('assets/viser_admin/css/vendor/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/viser_admin/css/vendor/jquery-jvectormap-2.0.5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/vendor/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/viser_admin/css/vendor/jquery-timepicky.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/viser_admin/css/vendor/bootstrap-clockpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/viser_admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/viser_admin/css/custom.css') }}">

    @stack('style')
</head>

<body>
    @yield('content')

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/viser_admin/js/vendor/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/viser_admin/js/vendor/jquery.slimscroll.min.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset('assets/viser_admin/js/nicEdit.js') }}"></script>

    <script src="{{ asset('assets/viser_admin/js/vendor/select2.min.js') }}"></script>
    <script src="{{ asset('assets/viser_admin/js/app.js') }}"></script>

    {{-- LOAD NIC EDIT --}}
    <script>
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

        (function($) {
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });
        })(jQuery);

    </script>

    @stack('script')
</body>

</html>
