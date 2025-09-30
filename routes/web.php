<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return redirect('/admin/login');
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

// Dynamic CSS route
Route::get('/css/dynamic-styles.css', [SettingsController::class, 'dynamicCss'])->name('dynamic-css');

// Dashboard Route
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('/admin/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/admin/profile/password', [UserController::class, 'updatePassword'])->name('profile.password.update');
});

// User Management Routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/users/management', [UserController::class, 'managementUsers'])->name('users.management');
    Route::post('/admin/users/management', [UserController::class, 'storeManagementUser'])->name('users.management.store');
    Route::put('/admin/users/management/{id}', [UserController::class, 'updateManagementUser'])->name('users.management.update');
    Route::delete('/admin/users/management/{id}', [UserController::class, 'deleteManagementUser'])->name('users.management.delete');
    Route::patch('/admin/users/management/{id}/toggle-status', [UserController::class, 'toggleUserStatus'])->name('users.management.toggle-status');
    
    Route::get('/admin/users/regular', [UserController::class, 'regularUsers'])->name('users.regular');
    Route::post('/admin/users/regular', [UserController::class, 'storeRegularUser'])->name('users.regular.store');
    Route::put('/admin/users/regular/{id}', [UserController::class, 'updateRegularUser'])->name('users.regular.update');
    Route::delete('/admin/users/regular/{id}', [UserController::class, 'deleteRegularUser'])->name('users.regular.delete');
    Route::patch('/admin/users/regular/{id}/toggle-status', [UserController::class, 'toggleRegularUserStatus'])->name('users.regular.toggle-status');
    
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
    Route::post('/admin/settings/appearance', [SettingsController::class, 'updateAppearance'])->name('settings.appearance.update');
    Route::post('/admin/settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general.update');
    Route::post('/admin/settings/contact', [SettingsController::class, 'updateContact'])->name('settings.contact.update');
    Route::post('/admin/settings/social', [SettingsController::class, 'updateSocial'])->name('settings.social.update');
    Route::post('/admin/settings/custom-code', [SettingsController::class, 'updateCustomCode'])->name('settings.custom-code.update');
    Route::get('/admin/settings/export', [SettingsController::class, 'export'])->name('settings.export');
    Route::post('/admin/settings/import', [SettingsController::class, 'import'])->name('settings.import');
});

// Test route for checking PHP configuration
Route::get('/test-upload-config', function () {
    return response()->json([
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time')
    ]);
})->middleware('auth')->name('test.upload.config');

// Test route for debugging

// Land/Jamin routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/land-jamin', [PropertyController::class, 'index'])->name('land-jamin.index');
    Route::get('/admin/land-jamin/create', [PropertyController::class, 'create'])->name('land-jamin.create');
    Route::post('/admin/land-jamin', [PropertyController::class, 'store'])->name('land-jamin.store');
    Route::get('/admin/land-jamin/{property}', [PropertyController::class, 'show'])->name('land-jamin.show');
    Route::get('/admin/land-jamin/{property}/edit', [PropertyController::class, 'edit'])->name('land-jamin.edit');
    Route::put('/admin/land-jamin/{property}', [PropertyController::class, 'update'])->name('land-jamin.update');
    Route::delete('/admin/land-jamin/{property}', [PropertyController::class, 'destroy'])->name('land-jamin.destroy');
    Route::patch('/admin/land-jamin/{property}/update-status', [PropertyController::class, 'updateStatus'])->name('land-jamin.update-status');
    
    // AJAX routes for cascading dropdowns
    Route::get('/admin/land-jamin/states/{countryId}', [PropertyController::class, 'getStatesByCountry'])->name('land-jamin.states');
    Route::get('/admin/land-jamin/districts/{stateId}', [PropertyController::class, 'getDistrictsByState'])->name('land-jamin.districts');
    Route::get('/admin/land-jamin/talukas/{districtId}', [PropertyController::class, 'getTalukasByDistrict'])->name('land-jamin.talukas');
    
    // AJAX routes for amenities and land types
    Route::post('/admin/land-jamin/amenities', [PropertyController::class, 'storeAmenity'])->name('land-jamin.amenities.store');
    Route::post('/admin/land-jamin/land-types', [PropertyController::class, 'storeLandType'])->name('land-jamin.land-types.store');
    
    // AJAX routes for photo management
    Route::post('/admin/land-jamin/{property}/photo-positions', [PropertyController::class, 'updatePhotoPositions'])->name('land-jamin.photo-positions.update');
    Route::delete('/admin/land-jamin/{property}/photos/{photoIndex}', [PropertyController::class, 'deletePhoto'])->name('land-jamin.photos.destroy');
});

// Plot routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/plot', [PropertyController::class, 'index'])->name('plot.index');
    Route::get('/admin/plot/create', [PropertyController::class, 'create'])->name('plot.create');
    Route::post('/admin/plot', [PropertyController::class, 'store'])->name('plot.store');
    Route::get('/admin/plot/{property}', [PropertyController::class, 'show'])->name('plot.show');
    Route::get('/admin/plot/{property}/edit', [PropertyController::class, 'edit'])->name('plot.edit');
    Route::put('/admin/plot/{property}', [PropertyController::class, 'update'])->name('plot.update');
    Route::delete('/admin/plot/{property}', [PropertyController::class, 'destroy'])->name('plot.destroy');
    Route::patch('/admin/plot/{property}/update-status', [PropertyController::class, 'updateStatus'])->name('plot.update-status');
    
    // AJAX routes for cascading dropdowns
    Route::get('/admin/plot/states/{countryId}', [PropertyController::class, 'getStatesByCountry'])->name('plot.states');
    Route::get('/admin/plot/districts/{stateId}', [PropertyController::class, 'getDistrictsByState'])->name('plot.districts');
    Route::get('/admin/plot/talukas/{districtId}', [PropertyController::class, 'getTalukasByDistrict'])->name('plot.talukas');
    
    // AJAX routes for amenities and land types
    Route::post('/admin/plot/amenities', [PropertyController::class, 'storeAmenity'])->name('plot.amenities.store');
    Route::post('/admin/plot/land-types', [PropertyController::class, 'storeLandType'])->name('plot.land-types.store');
    
    // AJAX routes for photo management
    Route::post('/admin/plot/{property}/photo-positions', [PropertyController::class, 'updatePhotoPositions'])->name('plot.photo-positions.update');
    Route::delete('/admin/plot/{property}/photos/{photoIndex}', [PropertyController::class, 'deletePhoto'])->name('plot.photos.destroy');
});

// Shad routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/shad', [PropertyController::class, 'index'])->name('shad.index');
    Route::get('/admin/shad/create', [PropertyController::class, 'create'])->name('shad.create');
    Route::post('/admin/shad', [PropertyController::class, 'store'])->name('shad.store');
    Route::get('/admin/shad/{property}', [PropertyController::class, 'show'])->name('shad.show');
    Route::get('/admin/shad/{property}/edit', [PropertyController::class, 'edit'])->name('shad.edit');
    Route::put('/admin/shad/{property}', [PropertyController::class, 'update'])->name('shad.update');
    Route::delete('/admin/shad/{property}', [PropertyController::class, 'destroy'])->name('shad.destroy');
    Route::patch('/admin/shad/{property}/update-status', [PropertyController::class, 'updateStatus'])->name('shad.update-status');
    
    // AJAX routes for cascading dropdowns
    Route::get('/admin/shad/states/{countryId}', [PropertyController::class, 'getStatesByCountry'])->name('shad.states');
    Route::get('/admin/shad/districts/{stateId}', [PropertyController::class, 'getDistrictsByState'])->name('shad.districts');
    Route::get('/admin/shad/talukas/{districtId}', [PropertyController::class, 'getTalukasByDistrict'])->name('shad.talukas');
    
    // AJAX routes for amenities and land types
    Route::post('/admin/shad/amenities', [PropertyController::class, 'storeAmenity'])->name('shad.amenities.store');
    Route::post('/admin/shad/land-types', [PropertyController::class, 'storeLandType'])->name('shad.land-types.store');
    
    // AJAX routes for photo management
    Route::post('/admin/shad/{property}/photo-positions', [PropertyController::class, 'updatePhotoPositions'])->name('shad.photo-positions.update');
    Route::delete('/admin/shad/{property}/photos/{photoIndex}', [PropertyController::class, 'deletePhoto'])->name('shad.photos.destroy');
});

// Shop routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/shop', [PropertyController::class, 'index'])->name('shop.index');
    Route::get('/admin/shop/create', [PropertyController::class, 'create'])->name('shop.create');
    Route::post('/admin/shop', [PropertyController::class, 'store'])->name('shop.store');
    Route::get('/admin/shop/{property}', [PropertyController::class, 'show'])->name('shop.show');
    Route::get('/admin/shop/{property}/edit', [PropertyController::class, 'edit'])->name('shop.edit');
    Route::put('/admin/shop/{property}', [PropertyController::class, 'update'])->name('shop.update');
    Route::delete('/admin/shop/{property}', [PropertyController::class, 'destroy'])->name('shop.destroy');
    Route::patch('/admin/shop/{property}/update-status', [PropertyController::class, 'updateStatus'])->name('shop.update-status');
    
    // AJAX routes for cascading dropdowns
    Route::get('/admin/shop/states/{countryId}', [PropertyController::class, 'getStatesByCountry'])->name('shop.states');
    Route::get('/admin/shop/districts/{stateId}', [PropertyController::class, 'getDistrictsByState'])->name('shop.districts');
    Route::get('/admin/shop/talukas/{districtId}', [PropertyController::class, 'getTalukasByDistrict'])->name('shop.talukas');
    
    // AJAX routes for amenities and land types
    Route::post('/admin/shop/amenities', [PropertyController::class, 'storeAmenity'])->name('shop.amenities.store');
    Route::post('/admin/shop/land-types', [PropertyController::class, 'storeLandType'])->name('shop.land-types.store');
    
    // AJAX routes for photo management
    Route::post('/admin/shop/{property}/photo-positions', [PropertyController::class, 'updatePhotoPositions'])->name('shop.photo-positions.update');
    Route::delete('/admin/shop/{property}/photos/{photoIndex}', [PropertyController::class, 'deletePhoto'])->name('shop.photos.destroy');
});

// House routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/admin/house', [PropertyController::class, 'index'])->name('house.index');
    Route::get('/admin/house/create', [PropertyController::class, 'create'])->name('house.create');
    Route::post('/admin/house', [PropertyController::class, 'store'])->name('house.store');
    Route::get('/admin/house/{property}', [PropertyController::class, 'show'])->name('house.show');
    Route::get('/admin/house/{property}/edit', [PropertyController::class, 'edit'])->name('house.edit');
    Route::put('/admin/house/{property}', [PropertyController::class, 'update'])->name('house.update');
    Route::delete('/admin/house/{property}', [PropertyController::class, 'destroy'])->name('house.destroy');
    Route::patch('/admin/house/{property}/update-status', [PropertyController::class, 'updateStatus'])->name('house.update-status');
    
    // AJAX routes for cascading dropdowns
    Route::get('/admin/house/states/{countryId}', [PropertyController::class, 'getStatesByCountry'])->name('house.states');
    Route::get('/admin/house/districts/{stateId}', [PropertyController::class, 'getDistrictsByState'])->name('house.districts');
    Route::get('/admin/house/talukas/{districtId}', [PropertyController::class, 'getTalukasByDistrict'])->name('house.talukas');
    
    // AJAX routes for amenities and land types
    Route::post('/admin/house/amenities', [PropertyController::class, 'storeAmenity'])->name('house.amenities.store');
    Route::post('/admin/house/land-types', [PropertyController::class, 'storeLandType'])->name('house.land-types.store');
    
    // AJAX routes for photo management
    Route::post('/admin/house/{property}/photo-positions', [PropertyController::class, 'updatePhotoPositions'])->name('house.photo-positions.update');
    Route::delete('/admin/house/{property}/photos/{photoIndex}', [PropertyController::class, 'deletePhoto'])->name('house.photos.destroy');
});
