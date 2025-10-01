<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--favicon-->
    @php
        $faviconPath = \App\Models\Setting::get('general', 'favicon');
    @endphp
    <link rel="icon" href="{{ $faviconPath ? safe_asset('storage/' . $faviconPath, 'assets/images/favicon-32x32.png') : asset('assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
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
        body {
            background-color: #f5f5f5;
        }
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            flex-direction: column;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-container img {
            max-height: 80px;
            /* box-shadow: 0 4px 8px rgba(0,0,0,0.1); */
            border-radius: 8px;
        }
        .input-group .form-control {
            border-right: 0;
        }
        .input-group .btn {
            border-left: 0;
        }
        .login-form-container {
            width: 100%;
            max-width: 800px;
        }
    </style>
</head>
 
<body>
    <!-- Only the login form, no header, sidebar or footer -->
    <div class="login-container">
        @php
            $logoPath = \App\Models\Setting::get('general', 'logo');
        @endphp
        
        @if($logoPath)
            <div class="logo-container">
                <img src="{{ safe_asset('storage/' . $logoPath, 'assets/images/logo-img.png') }}" alt="Logo">
            </div>
        @endif
        
        <div class="login-form-container">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    @yield('scripts')
</body>

</html>