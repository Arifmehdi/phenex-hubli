<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Import Product model
use App\Models\Order;   // Import Order model
use App\Models\OrderItem; // Import OrderItem model
use Illuminate\Support\Facades\Response; // Import Response facade

class SellerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if the user has the 'seller' role
        // Assuming roles are managed via the User model's hasRole method
        // You might need to adjust this based on your actual role management
        if (!$user->role = 'seller') {
             return Response::json(['message' => 'Unauthorized: User is not a seller.'], 403);
        }

        // Fetch products added by this seller
        $products = Product::where('addedby_id', $user->id)->get();

        // Fetch orders related to this seller's products
        // Get product IDs for the current seller
        $sellerProductIds = $products->pluck('id')->toArray();

        // Find OrderItems that belong to these seller products
        $orderItems = OrderItem::whereIn('product_id', $sellerProductIds)->with('order')->get();

        // Get unique orders from these order items
        $orders = $orderItems->pluck('order')->unique('id')->values();


        return Response::json([
            'message' => 'Seller dashboard data',
            'seller' => $user->name,
            'products_count' => $products->count(),
            'products' => $products,
            'orders_count' => $orders->count(),
            'orders' => $orders,
            // Add other relevant data for seller dashboard
        ]);
    }
}
