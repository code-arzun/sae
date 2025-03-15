<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CV. SAE GROUP | Sistem Informasi Manajemen</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}">

    <!-- Custom page-specific styles -->
    @yield('specificpagestyles')
</head>
<body>
    <!-- Loader Start -->
    <div id="loading">
        <div id="loading-center"></div>
    </div>
    <!-- Loader End -->

    <!-- Wrapper Start -->
    <div class="wrapper">
        @include('layout.partials.sidebar') <!-- Sidebar -->
        @include('layout.partials.navbar') <!-- Navbar -->

        <div class="content-page">
            @yield('container') <!-- Main content -->
        </div>
    </div>
    <!-- Wrapper End -->

    @include('layout.partials.footer') <!-- Footer -->

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/574a2abf75.js" crossorigin="anonymous"></script>

    <!-- Main JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page-specific scripts -->
    @yield('specificpagestyles')
</body>
</html>

