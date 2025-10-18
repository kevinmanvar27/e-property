<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Nexmart - HTML 5 Template Preview</title>

<!-- Fav Icon -->
<link rel="icon" href="{{ asset('user/assets/images/favicon.ico') }}" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<!-- Stylesheets -->
<link href="{{ asset('user/assets/css/font-awesome-all.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/flaticon.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/owl.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/nice-select.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/elpath.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/jquery-ui.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/odometer.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/color.css') }}" id="jssDefault" rel="stylesheet">
<link href="{{ asset('user/assets/css/rtl.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/header.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/page-title.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/contact.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/login.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/shop-sidebar.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/shop-page.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/shop.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/shop-one.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/shop-two.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/account.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/shop-details.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/cta.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/highlights.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/module-css/footer.css') }}" rel="stylesheet">
<link href="{{ asset('user/assets/css/responsive.css') }}" rel="stylesheet">

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<!-- page wrapper -->
<body>

    <div class="boxed_wrapper ltr">

        <!--start header -->
        @include('user.layouts.header')
        <!--end header -->

        <!--start page wrapper -->
            @yield('content')
        <!--end page wrapper -->

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->

        <div class="scroll-to-top">
            <svg class="scroll-top-inner" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>

        @include('user.layouts.footer')
    </div>
    <!--end wrapper-->

        <!-- jequery plugins -->
    <script src="{{ asset('user/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('user/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/owl.js') }}"></script>
    <script src="{{ asset('user/assets/js/wow.js') }}"></script>
    <script src="{{ asset('user/assets/js/validation.js') }}"></script>
    <script src="{{ asset('user/assets/js/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('user/assets/js/appear.js') }}"></script>
    <script src="{{ asset('user/assets/js/isotope.js') }}"></script>
    <script src="{{ asset('user/assets/js/parallax-scroll.js') }}"></script>
    <script src="{{ asset('user/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/scrolltop.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/language.js') }}"></script>
    <script src="{{ asset('user/assets/js/countdown.js') }}"></script>
    <script src="{{ asset('user/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('user/assets/js/odometer.js') }}"></script>
    <script src="{{ asset('user/assets/js/product-filter.js') }}"></script>
    <script src="{{ asset('user/assets/js/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('user/assets/js/bxslider.js') }}"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- main-js -->
    <script src="{{ asset('user/assets/js/script.js') }}"></script>
    <script>

        $(document).ready(function() {
            var mainMenu = $('.main-header .main-menu .navigation').clone();
            $('.sticky-header .main-menu').append(mainMenu);
        });
        
        fetch("/api/settings")
            .then((res) => res.json())
            .then((data) => {
                const title = data.website_title || "";
                const tagLine = data.tagline || "";
                const logo = data.logo || "";
                const favicon = data.favicon || "";

                // Set logo
                const logoImg = document.querySelector(".logo-box img");
                if (logoImg) {
                    logoImg.src = logo ? "/storage/" + logo : "/user/assets/images/logo.png";
                }

                // Set favicon
                if (favicon) {
                    let faviconTag = document.querySelector("link[rel='icon']");
                    if (!faviconTag) {
                        faviconTag = document.createElement("link");
                        faviconTag.rel = "icon";
                        document.head.appendChild(faviconTag);
                    }
                    faviconTag.href = "/storage/" + favicon;
                }

                // Set document title
                if (title) {
                    document.title = title + (tagLine ? " | " + tagLine : "");
                }
            });

    </script>
    @stack('scripts')
</body>

</html>