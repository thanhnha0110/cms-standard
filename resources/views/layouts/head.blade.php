<head>
    <meta charset="utf-8" />
    <title> {{ $title }} | {{ setting('admin_title', 'Admin') }} </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <!--end::Global Theme Styles -->

    <!--end::Page Vendors Styles -->
    <link rel="shortcut icon" href="{{ setting('favicon', asset('assets/demo/default/media/img/logo/favicon.ico')) }}" />

    <!--begin::Tags Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">    
    <!--end::Tags Styles -->

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="{{ asset('js/script.js?v1.0.0') }}" type="text/javascript"></script>
    <link href="{{ asset('css/style.css?v1.0.0') }}" rel="stylesheet" type="text/css" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')
</head>