<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    /**
     * Display a listing of the resource (authenticated user's cart).
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                            ->with('product')
                            ->get();

        return CartResource::collection($cartItems);
    }

    /**
     * Add a product to the cart or update its quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\CartResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available'], 422);
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => $request->quantity,
                // If using session_id for guests, would need logic here
                // 'session_id' => !Auth::check() ? session('session_id') : null,
            ]
        );

        return new CartResource($cart->load('product'));
    }

    /**
     * Remove the specified resource from storage (a cart item).
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Cart $cart)
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Item removed from cart successfully'], 204);
    }
}
