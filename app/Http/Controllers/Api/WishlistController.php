<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Get authenticated user's wishlist
    public function index()
    {
        $userId = Auth::id();
        $wishlist = Wishlist::where('user_id', $userId)->pluck('property_id')->toArray();
        
        return response()->json([
            'message' => 'Wishlist retrieved successfully',
            'wishlist' => $wishlist
        ]);
    }

    // Add a property to wishlist
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $userId = Auth::id();
        
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $userId,
            'property_id' => $request->property_id,
        ]);

        return response()->json([
            'message' => 'Property added to wishlist',
            'wishlist' => $wishlist
        ]);
    }

    // Remove a property from wishlist
    public function destroy($propertyId)
    {
        $userId = Auth::id();
        
        $wishlist = Wishlist::where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['message' => 'Property removed from wishlist']);
        }

        return response()->json(['message' => 'Property not found in wishlist'], 404);
    }
}