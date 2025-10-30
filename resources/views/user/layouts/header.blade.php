<!-- main header -->
<header class="main-header">
    <!-- header-upper -->
    <div class="header-upper">
        <div class="large-container">
            <div class="upper-inner">
                <div class="logo-and-toggle">
                    <figure class="logo-box"><a href="{{ route('home') }}"><img src="{{ asset('assets/images/products/logo.png') }}" alt="Logo" style="max-width: 180px; max-height: 80px;"></a></figure>
                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler">
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                    </div>
                </div>
                <div class="search-area">
                    <!-- <div class="category-inner">
                        <div class="select-box">
                            <select class="wide" id="header-property-type-select">
                                <option data-display="Select Property Type" data-type="shop">Shop</option>
                                <option data-type="landJamin">Land Jamin</option>
                                <option data-type="plot">Plot</option>
                                <option data-type="shad">Shad</option>
                                <option data-type="house">House</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="search-box">
                        <!-- Header search form uses global search when query is present -->
                        <form method="GET" action="{{ route('properties') }}" id="header-search-form">
                            <div class="form-group">
                                <input type="search" name="search" placeholder="Search Properties" value="{{ request('search') }}">
                                <input type="hidden" name="property_type" id="header-property-type-input" value="shop">
                                <button type="submit"><i class="icon-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="right-column">
                    @if(Auth::check())
                    <div class="support-box">
                        <div class="icon-box"><img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name ?? '' }}" style="max-width: 40px; max-height: 40px;"></div>
                        <a href="{{ route('user-profile') }}">{{ ucwords(Auth::user()->name) ?? '' }}</a>
                        <p>{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    @else
                    <div class="support-box">
                        <a href="{{ route('user-login') }}"  class="d-flex align-items-center"><i class="fas fa-sign-in-alt me-2"></i> Login</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- header-lower -->
    <div class="header-lower">
        <div class="large-container">
            <div class="outer-box">
                <div class="menu-area">
                    <nav class="main-menu navbar-expand-md navbar-light clearfix">
                        <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li class="{{ request()->is('/') ? 'current' : '' }}">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>

                                <!-- <li class="{{ request()->is('properties') && !request()->has('property_type') ? 'current' : '' }}">
                                    <a href="{{ route('properties') }}">Properties</a>
                                </li> -->

                                <li class="{{ request()->is('properties') && request('property_type') == 'shop' ? 'current' : '' }}">
                                    <a href="{{ route('properties', ['property_type' => 'shop']) }}">Shop</a>
                                </li>

                                <li class="{{ request()->is('properties') && request('property_type') == 'landJamin' ? 'current' : '' }}">
                                    <a href="{{ route('properties', ['property_type' => 'landJamin']) }}">Land Jamin</a>
                                </li>

                                <li class="{{ request()->is('properties') && request('property_type') == 'plot' ? 'current' : '' }}">
                                    <a href="{{ route('properties', ['property_type' => 'plot']) }}">Plot</a>
                                </li>

                                <li class="{{ request()->is('properties') && request('property_type') == 'shad' ? 'current' : '' }}">
                                    <a href="{{ route('properties', ['property_type' => 'shad']) }}">Shad</a>
                                </li>

                                <li class="{{ request()->is('properties') && request('property_type') == 'house' ? 'current' : '' }}">
                                    <a href="{{ route('properties', ['property_type' => 'house']) }}">House</a>
                                </li>

                                <li class="{{ request()->is('about-us') ? 'current' : '' }}">
                                    <a href="{{ route('about-us') }}">About Us</a>
                                </li>

                                <li class="{{ request()->is('contact') ? 'current' : '' }}">
                                    <a href="{{ route('contact') }}">Contact</a>
                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>
                @if(Auth::check())
                    <div class="menu-right-content">
                        <ul class="info-list">
                            <li>
                                <form id="logout-form" action="{{ route('user-logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!--sticky Header-->
    <div class="sticky-header">
        <div class="auto-container">
            <div class="outer-box">
                <div class="menu-area">
                    <nav class="main-menu clearfix">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav>
                </div>
                <div class="menu-right-content">
                    <ul class="info-list">
                        <li>
                            @if(Auth::check())
                                <form id="logout-form" action="{{ route('user-logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            @else
                            <div class="support-box">
                                <a href="{{ route('user-login') }}"  class="d-flex align-items-center"><i class="fas fa-sign-in-alt me-2"></i> Login</a>
                            </div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- main-header end -->

@push('scripts')
<script>
    $(document).ready(function() {
        // Set initial value based on URL parameter or default
        var urlParams = new URLSearchParams(window.location.search);
        var propertyTypeParam = urlParams.get('property_type') || 'shop';
        var searchQuery = urlParams.get('search') || '';
        
        // Set the select dropdown value
        $('#header-property-type-select').find('option').each(function() {
            if ($(this).data('type') === propertyTypeParam) {
                $(this).prop('selected', true);
                return false; // Break the loop
            }
        });
        
        // Set the hidden input value
        $('#header-property-type-input').val(propertyTypeParam);
        
        // Handle property type selection in header
        $('#header-property-type-select').on('change', function() {
            var selectedType = $(this).find(':selected').data('type');
            $('#header-property-type-input').val(selectedType);
        });
        
        // Handle form submission - use global search when search query is present
        $('#header-search-form').on('submit', function(e) {
            var searchInput = $(this).find('input[name="search"]');
            var searchValue = searchInput.val().trim();
            
            // If there's a search query, we'll use the global search
            if (searchValue !== '') {
                // Add a flag to indicate global search
                if ($(this).find('input[name="global_search"]').length === 0) {
                    $(this).append('<input type="hidden" name="global_search" value="1">');
                }
                // Remove property_type parameter for global search
                $('#header-property-type-input').remove();
            } else {
                // If no search query, remove global search flag if it exists
                $(this).find('input[name="global_search"]').remove();
            }
        });
    });
</script>
@endpush