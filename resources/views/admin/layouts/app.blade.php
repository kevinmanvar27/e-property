<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <!--favicon-->
    @php
        $faviconPath = \App\Models\Setting::get('general', 'favicon');
    @endphp
    <link rel="icon" href="{{ $faviconPath ? safe_asset('storage/' . $faviconPath, 'assets/images/favicon-32x32.png') : asset('assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    
    <!-- Admin Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-custom.css') }}" />
    
    <!-- Dynamic CSS based on settings -->
    <!-- <link href="{{ route('dynamic-css') }}" rel="stylesheet" type="text/css"> -->
    
    <!-- Set page title with format: Page | title - tagline -->
    @php
        $websiteTitle = \App\Models\Setting::get('general', 'website_title', 'E-Property');
        $tagline = \App\Models\Setting::get('general', 'tagline', 'Find Your property destiny');
        $pageTitle = trim($__env->yieldContent('title'));
        $fullTitle = $pageTitle ? $pageTitle . ' | ' . $websiteTitle . ' - ' . $tagline : $websiteTitle . ' - ' . $tagline;
    @endphp
    <title>{{ $fullTitle }}</title>
    
    @yield('styles')
    <style>
        .user-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-img.bg-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
    
    <!-- Auto Logout Timeout Setting -->
    <script>
        window.autoLogoutTimeout = {{ \App\Models\Setting::get('general', 'auto_logout_timeout', 30) }};
    </script>
    
    <!-- Vite assets -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/auto-logout.js'])
    @endif
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        @include('admin.layouts.sidebar')
        <!--end sidebar wrapper -->

        <!--start header -->
        @include('admin.layouts.header')
        <!--end header -->

        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
        <!--end page wrapper -->

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

        @include('admin.layouts.footer')
    </div>
    <!--end wrapper-->

    <!-- search modal -->
    @include('admin.layouts.search-modal')
    <!-- end search modal -->

    <!-- Add New Modal -->
    @include('admin.layouts.add-new-modal')
    <!-- end Add New Modal -->

    <!--start switcher-->
    @include('admin.layouts.theme-switcher')
    <!--end switcher-->

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/suppress-errors.js') }}"></script>
    
    <!-- Admin Custom JS -->
    <script src="{{ asset('assets/admin/js/admin-custom.js') }}"></script>
    
    @yield('scripts')
</body>

</html>