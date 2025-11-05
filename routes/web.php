<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ContactAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ManagementUserController;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\LandJaminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegularUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShadController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Serve favicon.ico from the root
Route::get('/favicon.ico', function () {
    return response()->file(public_path('user/assets/images/favicon.ico'), ['Content-Type' => 'image/x-icon']);
});

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/admin/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login']);
});

Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
})->name('refresh-csrf');

// Dashboard Route
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/admin/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// User Profile Routes for regular users
Route::middleware('auth')->group(function () {
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('user.profile.password.update');
});

// User Management Routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/users/management', [ManagementUserController::class, 'index'])->name('users.management');
    Route::post('/admin/users/management', [ManagementUserController::class, 'store'])->name('users.management.store');
    Route::put('/admin/users/management/{management_user}', [ManagementUserController::class, 'update'])->name('users.management.update');
    Route::delete('/admin/users/management/{management_user}', [ManagementUserController::class, 'destroy'])->name('users.management.delete');
    Route::patch('/admin/users/management/{management_user}/toggle-status', [ManagementUserController::class, 'toggleStatus'])->name('users.management.toggle-status');
    Route::get('/admin/users/management/{user}/permissions', [UserPermissionController::class, 'show'])->name('users.management.permissions');
    Route::get('/admin/users/management/{user}/permissions-data', [UserPermissionController::class, 'getUserPermissions'])->name('users.management.permissions.data');
    Route::post('/admin/users/management/{user}/permissions', [UserPermissionController::class, 'update'])->name('users.management.permissions.assign');

    Route::get('/admin/users/regular', [RegularUserController::class, 'index'])->name('users.regular');
    Route::post('/admin/users/regular', [RegularUserController::class, 'store'])->name('users.regular.store');
    Route::put('/admin/users/regular/{regular_user}', [RegularUserController::class, 'update'])->name('users.regular.update');
    Route::delete('/admin/users/regular/{regular_user}', [RegularUserController::class, 'destroy'])->name('users.regular.delete');
    Route::patch('/admin/users/regular/{regular_user}/toggle-status', [RegularUserController::class, 'toggleStatus'])->name('users.regular.toggle-status');

    // Role Management Routes
    Route::resource('/admin/roles', RoleController::class)->names([
        'index' => 'admin.roles.index',
        'create' => 'admin.roles.create',
        'store' => 'admin.roles.store',
        'show' => 'admin.roles.show',
        'edit' => 'admin.roles.edit',
        'update' => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
    ]);

    // Add route for getting role permissions
    Route::get('/admin/roles/{id}/permissions', [RoleController::class, 'getRolePermissions'])->name('admin.roles.permissions');

    // Permission Management Routes
    Route::resource('/admin/permissions', PermissionController::class)->names([
        'index' => 'admin.permissions.index',
        'create' => 'admin.permissions.create',
        'store' => 'admin.permissions.store',
        'show' => 'admin.permissions.show',
        'edit' => 'admin.permissions.edit',
        'update' => 'admin.permissions.update',
        'destroy' => 'admin.permissions.destroy',
    ]);

    // Master Data Routes
    Route::get('/admin/amenities', [MasterDataController::class, 'indexAmenities'])->name('admin.amenities.index');
    Route::get('/admin/amenities/create', [MasterDataController::class, 'createAmenity'])->name('admin.amenities.create');
    Route::post('/admin/amenities', [MasterDataController::class, 'storeAmenity'])->name('admin.amenities.store');
    Route::get('/admin/amenities/{amenity}/edit', [MasterDataController::class, 'editAmenity'])->name('admin.amenities.edit');
    Route::put('/admin/amenities/{amenity}', [MasterDataController::class, 'updateAmenity'])->name('admin.amenities.update');
    Route::delete('/admin/amenities/{amenity}', [MasterDataController::class, 'destroyAmenity'])->name('admin.amenities.destroy');

    Route::get('/admin/land-types', [MasterDataController::class, 'indexLandTypes'])->name('admin.land-types.index');
    Route::get('/admin/land-types/create', [MasterDataController::class, 'createLandType'])->name('admin.land-types.create');
    Route::post('/admin/land-types', [MasterDataController::class, 'storeLandType'])->name('admin.land-types.store');
    Route::get('/admin/land-types/{landType}/edit', [MasterDataController::class, 'editLandType'])->name('admin.land-types.edit');
    Route::put('/admin/land-types/{landType}', [MasterDataController::class, 'updateLandType'])->name('admin.land-types.update');
    Route::delete('/admin/land-types/{landType}', [MasterDataController::class, 'destroyLandType'])->name('admin.land-types.destroy');

    // Location Management Routes
    // Countries
    Route::get('/admin/countries', [LocationController::class, 'indexCountries'])->name('admin.countries.index');
    Route::post('/admin/countries', [LocationController::class, 'storeCountry'])->name('admin.countries.store');
    Route::put('/admin/countries/{country}', [LocationController::class, 'updateCountry'])->name('admin.countries.update');
    Route::delete('/admin/countries/{country}', [LocationController::class, 'destroyCountry'])->name('admin.countries.destroy');

    // States
    Route::get('/admin/states', [LocationController::class, 'indexStates'])->name('admin.states.index');
    Route::post('/admin/states', [LocationController::class, 'storeState'])->name('admin.states.store');
    Route::put('/admin/states/{state}', [LocationController::class, 'updateState'])->name('admin.states.update');
    Route::delete('/admin/states/{state}', [LocationController::class, 'destroyState'])->name('admin.states.destroy');

    // Districts
    Route::get('/admin/districts', [LocationController::class, 'indexDistricts'])->name('admin.districts.index');
    Route::post('/admin/districts', [LocationController::class, 'storeDistrict'])->name('admin.districts.store');
    Route::put('/admin/districts/{district}', [LocationController::class, 'updateDistrict'])->name('admin.districts.update');
    Route::delete('/admin/districts/{district}', [LocationController::class, 'destroyDistrict'])->name('admin.districts.destroy');

    // Cities/Talukas
    Route::get('/admin/cities', [LocationController::class, 'indexCities'])->name('admin.cities.index');
    Route::post('/admin/cities', [LocationController::class, 'storeCity'])->name('admin.cities.store');
    Route::put('/admin/cities/{city}', [LocationController::class, 'updateCity'])->name('admin.cities.update');
    Route::delete('/admin/cities/{city}', [LocationController::class, 'destroyCity'])->name('admin.cities.destroy');

    // AJAX routes for cascading dropdowns
    Route::get('/admin/locations/states/{countryId}', [LocationController::class, 'getStatesByCountry'])->name('admin.locations.states');
    Route::get('/admin/locations/districts/{stateId}', [LocationController::class, 'getDistrictsByState'])->name('admin.locations.districts');
    Route::get('/admin/locations/cities/{districtId}', [LocationController::class, 'getCitiesByDistrict'])->name('admin.locations.cities');

    // AJAX route for adding new entities
    Route::post('/admin/locations/entities', [LocationController::class, 'storeEntity'])->name('admin.locations.entities.store');
});

// Settings routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general.update');
    Route::post('/admin/settings/contact', [SettingsController::class, 'updateContact'])->name('settings.contact.update');
    Route::post('/admin/settings/social', [SettingsController::class, 'updateSocial'])->name('settings.social.update');
    Route::post('/admin/settings/custom-code', [SettingsController::class, 'updateCustomCode'])->name('settings.custom-code.update');
    Route::post('/admin/settings/app-link', [SettingsController::class, 'updateAppLink'])->name('settings.app-link.update');
    Route::get('/admin/settings/export', [SettingsController::class, 'export'])->name('settings.export');
    Route::post('/admin/settings/import', [SettingsController::class, 'import'])->name('settings.import');

    // Contact Us Admin Routes
    Route::get('/admin/contact-us', [ContactAdminController::class, 'index'])->name('admin.contact-us.index');
    Route::get('/admin/contact-us/{contact}', [ContactAdminController::class, 'show'])->name('admin.contact-us.show');
    Route::patch('/admin/contact-us/{contact}', [ContactAdminController::class, 'updateStatus'])->name('admin.contact-us.update-status');
});

// Land/Jamin routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/land-jamin', [LandJaminController::class, 'index'])->name('land-jamin.index');
    Route::get('/admin/land-jamin/create', [LandJaminController::class, 'create'])->name('land-jamin.create');
    Route::post('/admin/land-jamin', [LandJaminController::class, 'store'])->name('land-jamin.store');
    Route::get('/admin/land-jamin/{property}', [LandJaminController::class, 'show'])->name('land-jamin.show');
    Route::get('/admin/land-jamin/{property}/edit', [LandJaminController::class, 'edit'])->name('land-jamin.edit');
    Route::put('/admin/land-jamin/{property}', [LandJaminController::class, 'update'])->name('land-jamin.update');
    Route::delete('/admin/land-jamin/{property}', [LandJaminController::class, 'destroy'])->name('land-jamin.destroy');
    Route::patch('/admin/land-jamin/{property}/update-status', [LandJaminController::class, 'updateStatus'])->name('land-jamin.update-status');

    // AJAX routes for cascading dropdowns
    Route::get('/admin/land-jamin/states/{countryId}', [LandJaminController::class, 'getStatesByCountry'])->name('land-jamin.states');
    Route::get('/admin/land-jamin/districts/{stateId}', [LandJaminController::class, 'getDistrictsByState'])->name('land-jamin.districts');
    Route::get('/admin/land-jamin/talukas/{districtId}', [LandJaminController::class, 'getTalukasByDistrict'])->name('land-jamin.talukas');

    // AJAX routes for amenities and land types
    Route::post('/admin/land-jamin/amenities', [LandJaminController::class, 'storeAmenity'])->name('land-jamin.amenities.store');
    Route::post('/admin/land-jamin/land-types', [LandJaminController::class, 'storeLandType'])->name('land-jamin.land-types.store');

    // AJAX routes for photo management
    Route::post('/admin/land-jamin/{property}/photo-positions', [LandJaminController::class, 'updatePhotoPositions'])->name('land-jamin.photo-positions.update');
    Route::delete('/admin/land-jamin/{property}/photos/{photoIndex}', [LandJaminController::class, 'deletePhoto'])->name('land-jamin.photos.destroy');
});

// Plot routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/plot', [PlotController::class, 'index'])->name('plot.index');
    Route::get('/admin/plot/create', [PlotController::class, 'create'])->name('plot.create');
    Route::post('/admin/plot', [PlotController::class, 'store'])->name('plot.store');
    Route::get('/admin/plot/{property}', [PlotController::class, 'show'])->name('plot.show');
    Route::get('/admin/plot/{property}/edit', [PlotController::class, 'edit'])->name('plot.edit');
    Route::put('/admin/plot/{property}', [PlotController::class, 'update'])->name('plot.update');
    Route::delete('/admin/plot/{property}', [PlotController::class, 'destroy'])->name('plot.destroy');
    Route::patch('/admin/plot/{property}/update-status', [PlotController::class, 'updateStatus'])->name('plot.update-status');

    // AJAX routes for cascading dropdowns
    Route::get('/admin/plot/states/{countryId}', [PlotController::class, 'getStatesByCountry'])->name('plot.states');
    Route::get('/admin/plot/districts/{stateId}', [PlotController::class, 'getDistrictsByState'])->name('plot.districts');
    Route::get('/admin/plot/talukas/{districtId}', [PlotController::class, 'getTalukasByDistrict'])->name('plot.talukas');

    // AJAX routes for amenities and land types
    Route::post('/admin/plot/amenities', [PlotController::class, 'storeAmenity'])->name('plot.amenities.store');
    Route::post('/admin/plot/land-types', [PlotController::class, 'storeLandType'])->name('plot.land-types.store');

    // AJAX routes for photo management
    Route::post('/admin/plot/{property}/photo-positions', [PlotController::class, 'updatePhotoPositions'])->name('plot.photo-positions.update');
    Route::delete('/admin/plot/{property}/photos/{photoIndex}', [PlotController::class, 'deletePhoto'])->name('plot.photos.destroy');
});

// Shad routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/shad', [ShadController::class, 'index'])->name('shad.index');
    Route::get('/admin/shad/create', [ShadController::class, 'create'])->name('shad.create');
    Route::post('/admin/shad', [ShadController::class, 'store'])->name('shad.store');
    Route::get('/admin/shad/{property}', [ShadController::class, 'show'])->name('shad.show');
    Route::get('/admin/shad/{property}/edit', [ShadController::class, 'edit'])->name('shad.edit');
    Route::put('/admin/shad/{property}', [ShadController::class, 'update'])->name('shad.update');
    Route::delete('/admin/shad/{property}', [ShadController::class, 'destroy'])->name('shad.destroy');
    Route::patch('/admin/shad/{property}/update-status', [ShadController::class, 'updateStatus'])->name('shad.update-status');

    // AJAX routes for cascading dropdowns
    Route::get('/admin/shad/states/{countryId}', [ShadController::class, 'getStatesByCountry'])->name('shad.states');
    Route::get('/admin/shad/districts/{stateId}', [ShadController::class, 'getDistrictsByState'])->name('shad.districts');
    Route::get('/admin/shad/talukas/{districtId}', [ShadController::class, 'getTalukasByDistrict'])->name('shad.talukas');

    // AJAX routes for amenities and land types
    Route::post('/admin/shad/amenities', [ShadController::class, 'storeAmenity'])->name('shad.amenities.store');
    Route::post('/admin/shad/land-types', [ShadController::class, 'storeLandType'])->name('shad.land-types.store');

    // AJAX routes for photo management
    Route::post('/admin/shad/{property}/photo-positions', [ShadController::class, 'updatePhotoPositions'])->name('shad.photo-positions.update');
    Route::delete('/admin/shad/{property}/photos/{photoIndex}', [ShadController::class, 'deletePhoto'])->name('shad.photos.destroy');
});

// Shop routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/admin/shop/create', [ShopController::class, 'create'])->name('shop.create');
    Route::post('/admin/shop', [ShopController::class, 'store'])->name('shop.store');
    Route::get('/admin/shop/{property}', [ShopController::class, 'show'])->name('shop.show');
    Route::get('/admin/shop/{property}/edit', [ShopController::class, 'edit'])->name('shop.edit');
    Route::put('/admin/shop/{property}', [ShopController::class, 'update'])->name('shop.update');
    Route::delete('/admin/shop/{property}', [ShopController::class, 'destroy'])->name('shop.destroy');
    Route::patch('/admin/shop/{property}/update-status', [ShopController::class, 'updateStatus'])->name('shop.update-status');

    // AJAX routes for cascading dropdowns
    Route::get('/admin/shop/states/{countryId}', [ShopController::class, 'getStatesByCountry'])->name('shop.states');
    Route::get('/admin/shop/districts/{stateId}', [ShopController::class, 'getDistrictsByState'])->name('shop.districts');
    Route::get('/admin/shop/talukas/{districtId}', [ShopController::class, 'getTalukasByDistrict'])->name('shop.talukas');

    // AJAX routes for amenities and land types
    Route::post('/admin/shop/amenities', [ShopController::class, 'storeAmenity'])->name('shop.amenities.store');
    Route::post('/admin/shop/land-types', [ShopController::class, 'storeLandType'])->name('shop.land-types.store');

    // AJAX routes for photo management
    Route::post('/admin/shop/{property}/photo-positions', [ShopController::class, 'updatePhotoPositions'])->name('shop.photo-positions.update');
    Route::delete('/admin/shop/{property}/photos/{photoIndex}', [ShopController::class, 'deletePhoto'])->name('shop.photos.destroy');
});

// House routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/house', [HouseController::class, 'index'])->name('house.index');
    Route::get('/admin/house/create', [HouseController::class, 'create'])->name('house.create');
    Route::post('/admin/house', [HouseController::class, 'store'])->name('house.store');
    Route::get('/admin/house/{property}', [HouseController::class, 'show'])->name('house.show');
    Route::get('/admin/house/{property}/edit', [HouseController::class, 'edit'])->name('house.edit');
    Route::put('/admin/house/{property}', [HouseController::class, 'update'])->name('house.update');
    Route::delete('/admin/house/{property}', [HouseController::class, 'destroy'])->name('house.destroy');
    Route::patch('/admin/house/{property}/update-status', [HouseController::class, 'updateStatus'])->name('house.update-status');

    // AJAX routes for cascading dropdowns
    Route::get('/admin/house/states/{countryId}', [HouseController::class, 'getStatesByCountry'])->name('house.states');
    Route::get('/admin/house/districts/{stateId}', [HouseController::class, 'getDistrictsByState'])->name('house.districts');
    Route::get('/admin/house/talukas/{districtId}', [HouseController::class, 'getTalukasByDistrict'])->name('house.talukas');

    // AJAX routes for amenities and land types
    Route::post('/admin/house/amenities', [HouseController::class, 'storeAmenity'])->name('house.amenities.store');
    Route::post('/admin/house/land-types', [HouseController::class, 'storeLandType'])->name('house.land-types.store');

    // AJAX routes for photo management
    Route::post('/admin/house/{property}/photo-positions', [HouseController::class, 'updatePhotoPositions'])->name('house.photo-positions.update');
    Route::delete('/admin/house/{property}/photos/{photoIndex}', [HouseController::class, 'deletePhoto'])->name('house.photos.destroy');
});


// routes for user pages

Route::get('/', function() {
    return view('user.home');
})->name('home');

Route::get('/contact', function() {
    return view('user.contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/properties', function() {
    return view('user.properties');
})->name('properties');

Route::get('/privacy-policy', function() {
    return view('user.privacy-policy');
})->name('privacy-policy');

Route::get('/terms-and-conditions', function() {
    return view('user.terms-conditions');
})->name('terms-conditions');

Route::get('/faq', function() {
    return view('user.faq');
})->name('faq');

Route::get('/about-us', function() {
    return view('user.about-us');
})->name('about-us');

Route::get('/user-profile', function() {
    $user = Auth::user();
    
    if (!$user) {
        return redirect()->route('user-login');
    }
    
    $wishlistItems = $user->wishlistedProperties()->with(['state', 'district', 'taluka'])->get();
    
    // Ensure photos and amenities data are properly formatted for each wishlist item
    foreach ($wishlistItems as $item) {
        $item->photos = $item->getPhotosList();
        $item->amenities = $item->getAmenitiesListAttribute();
    }
    
    return view('user.user-profile', compact('wishlistItems'));
})->name('user-profile')->middleware('auth');

Route::get('/property-details/{id}', function($id) {
    $property = Property::with('state', 'district', 'taluka')->find($id);
    if (app('request')->ajax()) {
        // Ensure photos data is properly formatted
        if ($property) {
            $property->photos = $property->getPhotosList();
            $property->amenities = $property->getAmenitiesListAttribute();
        }
        return response()->json($property);
    }
    return view('user.property-details', compact('property'));
})->name('property-details');


Route::put('/user/update/{id}', [ManagementUserController::class, 'update'])->name('users.update');

// Auth routes
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user-login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::get('/sign-up', [UserAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/sign-up', [UserAuthController::class, 'register'])->name('register.post');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user-logout');

Route::get('/email/verify', fn() => view('user.verify-email'))
    // ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [UserAuthController::class, 'verify'])
    ->middleware(['signed', 'guest:web'])
    ->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if ($user->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'Email already verified.'
        ]);
    }

    $user->sendEmailVerificationNotification();

    return response()->json([
        'message' => 'Verification link sent!'
    ]);
})->name('verification.send');

// Password Reset Routes
Route::get('/forgot-password', function () {
    return view('user.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email|exists:users']);

    $status = \Illuminate\Support\Facades\Password::sendResetLink(
        $request->only('email')
    );

    return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('user.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email|exists:users',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = \Illuminate\Support\Facades\Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => \Illuminate\Support\Facades\Hash::make($password)
            ])->save();

            $user->markPasswordAsChanged();
        }
    );

    return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
                ? redirect()->route('user-login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

// Wishlist routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [App\Http\Controllers\Api\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [App\Http\Controllers\Api\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{propertyId}', [App\Http\Controllers\Api\WishlistController::class, 'destroy'])->name('wishlist.destroy');
});
