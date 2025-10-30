<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="WishlistItem",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="property_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="WishlistArray",
 *     type="array",
 *     @OA\Items(type="integer", example=1)
 * )
 *
 * @OA\Schema(
 *     schema="AddToWishlistRequest",
 *     type="object",
 *     @OA\Property(property="property_id", type="integer", example=1),
 *     required={"property_id"}
 * )
 *
 * @OA\Schema(
 *     schema="WishlistResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Wishlist retrieved successfully"),
 *     @OA\Property(property="data", ref="#/components/schemas/WishlistArray")
 * )
 *
 * @OA\Schema(
 *     schema="AddToWishlistResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Property added to wishlist"),
 *     @OA\Property(property="data", ref="#/components/schemas/WishlistItem")
 * )
 *
 * @OA\Schema(
 *     schema="RemoveFromWishlistResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Property removed from wishlist")
 * )
 *
 * @OA\Tag(
 *     name="Wishlist",
 *     description="API Endpoints for User Wishlist Management"
 * )
 */

class WishlistController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/wishlist",
     *      operationId="getWishlist",
     *      tags={"Wishlist"},
     *      summary="Get user's wishlist",
     *      description="Retrieve all properties in the authenticated user's wishlist",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/WishlistResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      )
     * )
     */
    // Get authenticated user's wishlist
    public function index()
    {
        $userId = Auth::id();
        $wishlist = Wishlist::where('user_id', $userId)->pluck('property_id')->toArray();
        
        return response()->json([
            'success' => true,
            'message' => 'Wishlist retrieved successfully',
            'data' => $wishlist
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/wishlist",
     *      operationId="addToWishlist",
     *      tags={"Wishlist"},
     *      summary="Add property to wishlist",
     *      description="Add a property to the authenticated user's wishlist",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AddToWishlistRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AddToWishlistResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      )
     * )
     */
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
            'success' => true,
            'message' => 'Property added to wishlist',
            'data' => $wishlist
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/api/wishlist/{propertyId}",
     *      operationId="removeFromWishlist",
     *      tags={"Wishlist"},
     *      summary="Remove property from wishlist",
     *      description="Remove a property from the authenticated user's wishlist",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="propertyId",
     *          description="Property ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RemoveFromWishlistResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found in wishlist"
     *      )
     * )
     */
    // Remove a property from wishlist
    public function destroy($propertyId)
    {
        $userId = Auth::id();
        
        $wishlist = Wishlist::where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'message' => 'Property removed from wishlist'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Property not found in wishlist'
        ], 404);
    }
}