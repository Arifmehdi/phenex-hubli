<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart; // Assuming cart is used to place order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource (authenticated user's orders).
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->with(['orderItems', 'user']) // Eager load relationships
                        ->paginate(10);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage (place an order from cart).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\OrderResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address_title' => 'required|string|max:255',
            'payment_method' => 'required|string|max:50',
            'order_note' => 'nullable|string',
            // Add validation for delivery_cost, payment_gateway if necessary
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return DB::transaction(function () use ($request, $user, $cartItems) {
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * ($item->product->final_price ?? 0);
            });
            $deliveryCost = 0; // Implement logic to calculate delivery cost
            $grandTotal = $subtotal + $deliveryCost;

            $order = Order::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address_title' => $request->address_title,
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending', // Default status
                'delivery_cost' => $deliveryCost,
                'order_note' => $request->order_note,
                'addedby_id' => $user->id,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'product_price' => $cartItem->product->final_price ?? 0,
                    'product_name' => $cartItem->product->name_en ?? $cartItem->product->name_bn,
                    'total_cost' => $cartItem->quantity * ($cartItem->product->final_price ?? 0),
                    'addedby_id' => $user->id,
                ]);

                // Decrement product stock (if applicable)
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Clear the user's cart
            Cart::where('user_id', $user->id)->delete();

            return new OrderResource($order->load(['orderItems', 'user']));
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \App\Http\Resources\OrderResource|\Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->load(['orderItems', 'user', 'payments']); // Eager load relationships
        return new OrderResource($order);
    }
}
