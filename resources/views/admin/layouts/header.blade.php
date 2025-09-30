<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>

            <div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                <a href="javascript:;" class="btn d-flex align-items-center"><i class='bx bx-search'></i>Search</a>
            </div>

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a class="nav-link" href="javascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>
                    <li class="nav-item dark-mode d-flex">
                        <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="user-img" alt="user avatar">
                    @else
                        <!-- Default SVG avatar when no photo is uploaded -->
                        <div class="user-img bg-primary text-white d-flex align-items-center justify-content-center">
                            <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    @endif 
                    <div class="user-info">
                        <p class="user-name mb-0">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="designattion mb-0">{{ Auth::user()->role == 'super_admin' ? 'Super Administrator' : (Auth::user()->role == 'admin' ? 'Administrator' : 'User') }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}"><i class="bx bx-user fs-5"></i><span>Edit Profile</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}#changePassword"><i class="bx bx-lock-open fs-5"></i><span>Reset Password</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-log-out-circle"></i><span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>