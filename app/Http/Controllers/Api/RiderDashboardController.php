<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle; // Import Vehicle model
use App\Models\VehicleAssignment; // Import VehicleAssignment model
use App\Models\Order; // Import Order model
use App\Models\Driver; // Import Driver model
use App\Models\Product; // Import Product model
use Illuminate\Support\Facades\Response;

class RiderDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if the user has the 'rider' role
        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        // Fetch assigned vehicle details
        $vehicle = $user->vehicle_id ? Vehicle::find($user->vehicle_id) : null;

        // Fetch orders currently assigned to this rider
        $ordersQuery = Order::where('driver_id', $user->id)
                            ->with(['orderItems', 'user'])
                            ->orderBy('created_at', 'desc');
        
        $assignedOrders = (clone $ordersQuery)->get();

        // Fetch products currently assigned to this rider
        $assignedProducts = Product::where('rider_id', $user->id)
                                    ->with('media')
                                    ->latest()
                                    ->get();

        // Prepare Statistics
        $stats = [
            'total_orders' => $assignedOrders->count(),
            'pending_orders' => $assignedOrders->where('order_status', 'pending')->count(),
            'confirmed_orders' => $assignedOrders->where('order_status', 'confirmed')->count(),
            'delivered_orders' => $assignedOrders->where('order_status', 'delivered')->count(),
            'total_products' => $assignedProducts->count(),
        ];

        // Format Rider Data for API
        $riderData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'license_no' => $user->license_no,
            'address' => $user->address,
            'image' => $user->image ? asset('storage/product_images/' . $user->image) : asset('img/profile.jpg'),
            'status' => $user->is_approve ? 'Active' : 'Pending Approval',
        ];

        // Transform Product Data to include full image URLs
        $transformedProducts = $assignedProducts->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name_en,
                'stock' => $product->stock,
                'price' => $product->price,
                'image' => asset('storage/product_images/' . $product->fi()),
                'sku' => $product->sku,
            ];
        });

        return Response::json([
            'success' => true,
            'message' => 'Rider dashboard data retrieved successfully.',
            'data' => [
                'rider' => $riderData,
                'stats' => $stats,
                'assigned_vehicle' => $vehicle,
                'recent_orders' => $assignedOrders->take(10), // Limit to 10 for dashboard
                'assigned_products' => $transformedProducts,
            ]
        ]);
    }

    public function assignedProducts(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        $products = Product::where('rider_id', $user->id)
                            ->with(['categories', 'media'])
                            ->latest()
                            ->paginate(20);

        return Response::json([
            'success' => true,
            'message' => 'Assigned products retrieved successfully.',
            'data' => $products
        ]);
    }
}
