<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        @php
            $logoPath = \App\Models\Setting::get('general', 'logo');
            $faviconPath = \App\Models\Setting::get('general', 'favicon');
            $websiteTitle = \App\Models\Setting::get('general', 'website_title', 'E-Property');
        @endphp
        
        <div>
            @if($logoPath)
                <!-- Full logo when sidebar is expanded -->
                <img src="{{ safe_asset('storage/' . $logoPath, 'assets/images/logo-img.png') }}" class="logo-icon" alt="logo icon" id="full-logo">
                <!-- Favicon when sidebar is collapsed -->
                <img src="{{ $faviconPath ? safe_asset('storage/' . $faviconPath, 'assets/images/favicon-32x32.png') : asset('assets/images/favicon-32x32.png') }}" class="logo-icon" alt="favicon" id="favicon-logo">
            @else
                <!-- Website title when no logo is uploaded -->
                <h4 class="logo-text">{{ $websiteTitle }}</h4>
            @endif
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ url('/admin/dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        
        @if(hasPermission('users-management', 'view'))
        <li class="menu-label">User Management</li>
        <li>
            <a href="{{ url('/admin/users/management') }}">
                <div class="parent-icon"><i class='bx bx-user-pin'></i>
                </div>
                <div class="menu-title">Management Users</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('users-regular', 'view'))
        <li>
            <a href="{{ url('/admin/users/regular') }}">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Regular Users</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('land-jamin', 'view'))
        <li>
            <a href="{{ url('/admin/land-jamin') }}">
                <div class="parent-icon"><i class='bx bx-map'></i>
                </div>
                <div class="menu-title">Land / Jamin</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('plot', 'view'))
        <li>
            <a href="{{ url('/admin/plot') }}">
                <div class="parent-icon"><i class='bx bx-grid-alt'></i>
                </div>
                <div class="menu-title">Plot</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('shad', 'view'))
        <li>
            <a href="{{ url('/admin/shad') }}">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Shad</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('shop', 'view'))
        <li>
            <a href="{{ url('/admin/shop') }}">
                <div class="parent-icon"><i class='bx bx-store'></i>
                </div>
                <div class="menu-title">Shop</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('house', 'view'))
        <li>
            <a href="{{ url('/admin/house') }}">
                <div class="parent-icon"><i class='bx bx-building-house'></i>
                </div>
                <div class="menu-title">House</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('amenities', 'view') || hasPermission('land-types', 'view'))
        <li class="menu-label">Master Data</li>
        @endif
        
        @if(hasPermission('amenities', 'view'))
        <li>
            <a href="{{ url('/admin/amenities') }}">
                <div class="parent-icon"><i class='bx bx-list-check'></i>
                </div>
                <div class="menu-title">Amenities</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('land-types', 'view'))
        <li>
            <a href="{{ url('/admin/land-types') }}">
                <div class="parent-icon"><i class='bx bx-category'></i>
                </div>
                <div class="menu-title">Land Types</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('countries', 'view') || hasPermission('states', 'view') || hasPermission('districts', 'view') || hasPermission('cities', 'view'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-map-pin'></i>
                </div>
                <div class="menu-title">Locations</div>
            </a>
            <ul>
                @if(hasPermission('countries', 'view'))
                <li>
                    <a href="{{ url('/admin/countries') }}"><i class="bx bx-right-arrow-alt"></i>Countries</a>
                </li>
                @endif
                
                @if(hasPermission('states', 'view'))
                <li>
                    <a href="{{ url('/admin/states') }}"><i class="bx bx-right-arrow-alt"></i>States</a>
                </li>
                @endif
                
                @if(hasPermission('districts', 'view'))
                <li>
                    <a href="{{ url('/admin/districts') }}"><i class="bx bx-right-arrow-alt"></i>Districts</a>
                </li>
                @endif
                
                @if(hasPermission('cities', 'view'))
                <li>
                    <a href="{{ url('/admin/cities') }}"><i class="bx bx-right-arrow-alt"></i>Cities/Talukas</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        
        @if(hasPermission('settings', 'view'))
        <li>
            <a href="{{ url('/admin/settings') }}">
                <div class="parent-icon"><i class="bx bx-cog"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('role', 'view') || hasPermission('permission', 'view'))
        <li class="menu-label">Access Control</li>
        @endif
        
        @if(hasPermission('role', 'view'))
        <li>
            <a href="{{ route('admin.roles.index') }}">
                <div class="parent-icon"><i class='bx bx-lock'></i>
                </div>
                <div class="menu-title">Roles</div>
            </a>
        </li>
        @endif
        
        @if(hasPermission('permission', 'view'))
        <li>
            <a href="{{ route('admin.permissions.index') }}">
                <div class="parent-icon"><i class='bx bx-key'></i>
                </div>
                <div class="menu-title">Permissions</div>
            </a>
        </li>
        @endif
        
        <!-- You can add more real navigation items here as needed -->
        
    </ul>
    <!--end navigation-->
</div>

<script>
// Logo visibility is now handled by CSS
// No JavaScript needed for this functionality
</script>