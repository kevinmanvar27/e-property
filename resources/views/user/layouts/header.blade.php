<!-- page-direction -->
<div class="page_direction">
    <div class="demo-rtl direction_switch"><button class="rtl">RTL</button></div>
    <div class="demo-ltr direction_switch"><button class="ltr">LTR</button></div>
</div>
<!-- page-direction end -->

<!-- main header -->
<header class="main-header">
    <!-- header-upper -->
    <div class="header-upper">
        <div class="large-container">
            <div class="upper-inner">
                <figure class="logo-box"><a href="index.html"><img src="" alt="" style="max-width: 180px; max-height: 80px;"></a></figure>
                <div class="search-area">
                    <div class="category-inner">
                        <div class="select-box">
                            <select class="wide">
                                <option data-display="Select Property Type" data-type="shop">Shop</option>
                                <option data-type="landJamin">Land Jamin</option>
                                <option data-type="plot">Plot</option>
                                <option data-type="shad">Shad</option>
                                <option data-type="house">House</option>
                            </select>
                        </div>
                    </div>
                    <div class="search-box">
                        <form method="post" action="">
                            <div class="form-group">
                                <input type="search" name="search-field" placeholder="Search Products" required>
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
                        <a href="{{ route('user-login') }}">Login</a>
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
                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler">
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                    </div>
                    <nav class="main-menu navbar-expand-md navbar-light clearfix">
                        <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li><a href="#">Home</a>
                                </li> 
                                <li class="{{ request()->is('properties') ? 'current dropdown' : '' }}"><a href="{{ route('properties') }}">Properties</a>
                                    <ul>
                                        <li><a href="#" data-type="shop">Shop</a></li> 
                                        <li><a href="#" data-type="landJamin">Land Jamin</a></li>
                                        <li><a href="#" data-type="plot">Plot</a></li>
                                        <li><a href="#" data-type="shad">Shad</a></li>
                                        <li><a href="#" data-type="house">House</a></li>
                                    </ul>
                                </li> 
                                <li class="{{ request()->is('contact') ? 'current' : '' }}"><a href="{{ 'contact' }}">Contact</a></li> 
                                <!-- <li><a href="#" data-type="shop">Shop</a></li> 
                                <li><a href="#" data-type="landJamin">Land Jamin</a></li>
                                <li><a href="#" data-type="plot">Plot</a></li>
                                <li><a href="#" data-type="shad">Shad</a></li>
                                <li><a href="#" data-type="house">House</a></li> -->
                            </ul>
                        </div>
                    </nav>
                </div>
                @if(Auth::check())
                    <div class="menu-right-content">
                        <ul class="info-list">
                            <li><a href="#"><i class="icon-6"></i></a></li>
                            <li>
                                <form id="logout-form" action="{{ route('user-logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
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
                        <li><a href="index.html"><i class="icon-6"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- main-header end -->
