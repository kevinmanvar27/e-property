<?php

use App\Http\Controllers\Api\HouseApiController;
use App\Http\Controllers\Api\LandJaminApiController;
use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\ManagementUserApiController;
use App\Http\Controllers\Api\MasterDataApiController;
use App\Http\Controllers\Api\PermissionApiController;
use App\Http\Controllers\Api\PlotApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\RegularUserApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\ShadApiController;
use App\Http\Controllers\Api\ShopApiController;
use App\Http\Controllers\Api\UserPermissionApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\BasePropertyApiController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function () {
    // Auth APIs
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Settings API
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings/update', [SettingsController::class, 'update']);

    // Property APIs
    Route::apiResource('/land-jamin', LandJaminApiController::class)->names([
        'index' => 'api.land-jamin.index',
        'store' => 'api.land-jamin.store',
        'show' => 'api.land-jamin.show',
        'update' => 'api.land-jamin.update',
        'destroy' => 'api.land-jamin.destroy',
    ]);
    
    Route::apiResource('/plot', PlotApiController::class)->names([
        'index' => 'api.plot.index',
        'store' => 'api.plot.store',
        'show' => 'api.plot.show',
        'update' => 'api.plot.update',
        'destroy' => 'api.plot.destroy',
    ]);
    
    Route::apiResource('/shad', ShadApiController::class)->names([
        'index' => 'api.shad.index',
        'store' => 'api.shad.store',
        'show' => 'api.shad.show',
        'update' => 'api.shad.update',
        'destroy' => 'api.shad.destroy',
    ]);
    
    Route::apiResource('/shop', ShopApiController::class)->names([
        'index' => 'api.shop.index',
        'store' => 'api.shop.store',
        'show' => 'api.shop.show',
        'update' => 'api.shop.update',
        'destroy' => 'api.shop.destroy',
    ]);
    
    Route::apiResource('/house', HouseApiController::class)->names([
        'index' => 'api.house.index',
        'store' => 'api.house.store',
        'show' => 'api.house.show',
        'update' => 'api.house.update',
        'destroy' => 'api.house.destroy',
    ]);

    // Global search across all property types
    Route::get('/properties/search', [BasePropertyApiController::class, 'searchAll'])->name('api.properties.search');

    // Property specific endpoints for Land Jamin
    Route::get('/land-jamin/{property}/states/{countryId}', [LandJaminApiController::class, 'getStatesByCountry']);
    Route::get('/land-jamin/{property}/districts/{stateId}', [LandJaminApiController::class, 'getDistrictsByState']);
    Route::get('/land-jamin/{property}/talukas/{districtId}', [LandJaminApiController::class, 'getTalukasByDistrict']);
    Route::post('/land-jamin/{property}/amenities', [LandJaminApiController::class, 'storeAmenity']);
    Route::post('/land-jamin/{property}/land-types', [LandJaminApiController::class, 'storeLandType']);
    Route::post('/land-jamin/{property}/photo-positions', [LandJaminApiController::class, 'updatePhotoPositions']);
    Route::delete('/land-jamin/{property}/photos/{photoIndex}', [LandJaminApiController::class, 'deletePhoto']);
    Route::patch('/land-jamin/{property}/update-status', [LandJaminApiController::class, 'updateStatus']);

    // Property specific endpoints for Plot
    Route::get('/plot/{property}/states/{countryId}', [PlotApiController::class, 'getStatesByCountry']);
    Route::get('/plot/{property}/districts/{stateId}', [PlotApiController::class, 'getDistrictsByState']);
    Route::get('/plot/{property}/talukas/{districtId}', [PlotApiController::class, 'getTalukasByDistrict']);
    Route::post('/plot/{property}/amenities', [PlotApiController::class, 'storeAmenity']);
    Route::post('/plot/{property}/land-types', [PlotApiController::class, 'storeLandType']);
    Route::post('/plot/{property}/photo-positions', [PlotApiController::class, 'updatePhotoPositions']);
    Route::delete('/plot/{property}/photos/{photoIndex}', [PlotApiController::class, 'deletePhoto']);
    Route::patch('/plot/{property}/update-status', [PlotApiController::class, 'updateStatus']);

    // Property specific endpoints for Shad
    Route::get('/shad/{property}/states/{countryId}', [ShadApiController::class, 'getStatesByCountry']);
    Route::get('/shad/{property}/districts/{stateId}', [ShadApiController::class, 'getDistrictsByState']);
    Route::get('/shad/{property}/talukas/{districtId}', [ShadApiController::class, 'getTalukasByDistrict']);
    Route::post('/shad/{property}/amenities', [ShadApiController::class, 'storeAmenity']);
    Route::post('/shad/{property}/land-types', [ShadApiController::class, 'storeLandType']);
    Route::post('/shad/{property}/photo-positions', [ShadApiController::class, 'updatePhotoPositions']);
    Route::delete('/shad/{property}/photos/{photoIndex}', [ShadApiController::class, 'deletePhoto']);
    Route::patch('/shad/{property}/update-status', [ShadApiController::class, 'updateStatus']);

    // Property specific endpoints for Shop
    Route::get('/shop/{property}/states/{countryId}', [ShopApiController::class, 'getStatesByCountry']);
    Route::get('/shop/{property}/districts/{stateId}', [ShopApiController::class, 'getDistrictsByState']);
    Route::get('/shop/{property}/talukas/{districtId}', [ShopApiController::class, 'getTalukasByDistrict']);
    Route::post('/shop/{property}/amenities', [ShopApiController::class, 'storeAmenity']);
    Route::post('/shop/{property}/land-types', [ShopApiController::class, 'storeLandType']);
    Route::post('/shop/{property}/photo-positions', [ShopApiController::class, 'updatePhotoPositions']);
    Route::delete('/shop/{property}/photos/{photoIndex}', [ShopApiController::class, 'deletePhoto']);
    Route::patch('/shop/{property}/update-status', [ShopApiController::class, 'updateStatus']);

    // Property specific endpoints for House
    Route::get('/house/{property}/states/{countryId}', [HouseApiController::class, 'getStatesByCountry']);
    Route::get('/house/{property}/districts/{stateId}', [HouseApiController::class, 'getDistrictsByState']);
    Route::get('/house/{property}/talukas/{districtId}', [HouseApiController::class, 'getTalukasByDistrict']);
    Route::post('/house/{property}/amenities', [HouseApiController::class, 'storeAmenity']);
    Route::post('/house/{property}/land-types', [HouseApiController::class, 'storeLandType']);
    Route::post('/house/{property}/photo-positions', [HouseApiController::class, 'updatePhotoPositions']);
    Route::delete('/house/{property}/photos/{photoIndex}', [HouseApiController::class, 'deletePhoto']);
    Route::patch('/house/{property}/update-status', [HouseApiController::class, 'updateStatus']);

    // Location APIs
    Route::get('/countries', [LocationApiController::class, 'indexCountries']);
    Route::post('/countries', [LocationApiController::class, 'storeCountry']);
    Route::put('/countries/{country}', [LocationApiController::class, 'updateCountry']);
    Route::delete('/countries/{country}', [LocationApiController::class, 'destroyCountry']);

    Route::get('/states', [LocationApiController::class, 'indexStates']);
    Route::post('/states', [LocationApiController::class, 'storeState']);
    Route::put('/states/{state}', [LocationApiController::class, 'updateState']);
    Route::delete('/states/{state}', [LocationApiController::class, 'destroyState']);

    Route::get('/districts', [LocationApiController::class, 'indexDistricts']);
    Route::post('/districts', [LocationApiController::class, 'storeDistrict']);
    Route::put('/districts/{district}', [LocationApiController::class, 'updateDistrict']);
    Route::delete('/districts/{district}', [LocationApiController::class, 'destroyDistrict']);

    Route::get('/cities', [LocationApiController::class, 'indexCities']);
    Route::post('/cities', [LocationApiController::class, 'storeCity']);
    Route::put('/cities/{city}', [LocationApiController::class, 'updateCity']);
    Route::delete('/cities/{city}', [LocationApiController::class, 'destroyCity']);

    // Location cascading dropdowns
    Route::get('/locations/states/{countryId}', [LocationApiController::class, 'getStatesByCountry']);
    Route::get('/locations/districts/{stateId}', [LocationApiController::class, 'getDistrictsByState']);
    Route::get('/locations/cities/{districtId}', [LocationApiController::class, 'getCitiesByDistrict']);
    Route::post('/locations/entities', [LocationApiController::class, 'storeEntity']);

    // Master Data APIs
    Route::get('/amenities', [MasterDataApiController::class, 'indexAmenities']);
    Route::post('/amenities', [MasterDataApiController::class, 'storeAmenity']);
    Route::put('/amenities/{amenity}', [MasterDataApiController::class, 'updateAmenity']);
    Route::delete('/amenities/{amenity}', [MasterDataApiController::class, 'destroyAmenity']);

    Route::get('/land-types', [MasterDataApiController::class, 'indexLandTypes']);
    Route::post('/land-types', [MasterDataApiController::class, 'storeLandType']);
    Route::put('/land-types/{landType}', [MasterDataApiController::class, 'updateLandType']);
    Route::delete('/land-types/{landType}', [MasterDataApiController::class, 'destroyLandType']);

    // User Management APIs
    Route::apiResource('/management-users', ManagementUserApiController::class)->names([
        'index' => 'api.management-users.index',
        'store' => 'api.management-users.store',
        'show' => 'api.management-users.show',
        'update' => 'api.management-users.update',
        'destroy' => 'api.management-users.destroy',
    ]);
    Route::patch('/management-users/{management_user}/toggle-status', [ManagementUserApiController::class, 'toggleStatus']);

    Route::apiResource('/regular-users', RegularUserApiController::class)->names([
        'index' => 'api.regular-users.index',
        'store' => 'api.regular-users.store',
        'show' => 'api.regular-users.show',
        'update' => 'api.regular-users.update',
        'destroy' => 'api.regular-users.destroy',
    ]);
    Route::patch('/regular-users/{regular_user}/toggle-status', [RegularUserApiController::class, 'toggleStatus']);

    // Role APIs
    Route::apiResource('/roles', RoleApiController::class)->names([
        'index' => 'api.roles.index',
        'store' => 'api.roles.store',
        'show' => 'api.roles.show',
        'edit' => 'api.roles.edit',
        'update' => 'api.roles.update',
        'destroy' => 'api.roles.destroy',
    ]);
    Route::get('/roles/{role}/permissions', [RoleApiController::class, 'getRolePermissions']);
    Route::post('/roles/{role}/permissions', [RoleApiController::class, 'assignPermissions']);

    // Permission APIs
    Route::apiResource('/permissions', PermissionApiController::class)->names([
        'index' => 'api.permissions.index',
        'store' => 'api.permissions.store',
        'show' => 'api.permissions.show',
        'edit' => 'api.permissions.edit',
        'update' => 'api.permissions.update',
        'destroy' => 'api.permissions.destroy',
    ]);

    // User Permission APIs
    Route::get('/users/{user}/permissions', [UserPermissionApiController::class, 'show']);
    Route::post('/users/{user}/permissions', [UserPermissionApiController::class, 'update']);

    // Profile APIs
    Route::get('/profile', [ProfileApiController::class, 'show'])->middleware('auth:sanctum');
    Route::put('/profile', [ProfileApiController::class, 'update'])->middleware('auth:sanctum');
    Route::put('/profile/password', [ProfileApiController::class, 'updatePassword'])->middleware('auth:sanctum');

    // Wishlist APIs
    Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/wishlist', [WishlistController::class, 'store'])->middleware('auth:sanctum');
    Route::delete('/wishlist/{propertyId}', [WishlistController::class, 'destroy'])->middleware('auth:sanctum');

    // Password Reset API Routes
    Route::post('/auth/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email|exists:users']);
        
        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );
        
        if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent to your email.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reset link. Please try again.'
            ], 422);
        }
    })->middleware('guest')->name('api.password.email');
    
    Route::post('/auth/reset-password', function (Request $request) {
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
            }
        );
        
        if ($status === \Illuminate\Support\Facades\Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully. You can now login with your new password.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password. Please try again.'
            ], 422);
        }
    })->middleware('guest')->name('api.password.reset');

});