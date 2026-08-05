<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle; // Import Vehicle model
use App\Models\VehicleAssignment; // Import VehicleAssignment model
use App\Models\Order; // Import Order model
use App\Models\Driver; // Import Driver model
use App\Models\Product; // Import Product model
use App\Http\Resources\OrderResource; // Import OrderResource
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderDeliveryOTP;

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
        $vehicle = $user->vehicle ? $user->vehicle : null;

        // Fetch orders currently assigned to this rider
        $ordersQuery = Order::where('driver_id', $user->id)
                            ->with(['orderItems.product', 'user'])
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
            'shipped_orders' => $assignedOrders->where('order_status', 'shipped')->count(),
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

        return Response::json([
            'success' => true,
            'message' => 'Rider dashboard data retrieved successfully.',
            'data' => [
                'rider' => $riderData,
                'stats' => $stats,
                'assigned_vehicle' => $vehicle,
                'recent_orders' => OrderResource::collection($assignedOrders->take(10)), // Use OrderResource
                'assigned_products' => $assignedProducts->take(10), // Limit products too
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

    /**
     * Get the active orders for the rider.
     */
    public function activeOrders(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        $activeOrders = Order::where('driver_id', $user->id)
            ->whereNotIn('order_status', ['delivered', 'canceled'])
            ->with(['orderItems.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Response::json([
            'success' => true,
            'message' => 'Active orders retrieved successfully.',
            'data' => OrderResource::collection($activeOrders)
        ]);
    }

    /**
     * Show details of a specific order assigned to the rider.
     */
    public function showOrder(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        $order = Order::where('driver_id', $user->id)
            ->with(['orderItems.product', 'user', 'vehicle'])
            ->find($id);

        if (!$order) {
            return Response::json([
                'success' => false,
                'message' => 'Order not found or not assigned to you.'
            ], 404);
        }

        return Response::json([
            'success' => true,
            'message' => 'Order details retrieved successfully.',
            'data' => new OrderResource($order)
        ]);
    }

    /**
     * Update the status of an order assigned to the rider.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        $request->validate([
            'status' => 'required|in:shipped,delivered,canceled',
            'order_note' => 'nullable|string|max:1000'
        ]);

        $order = Order::where('driver_id', $user->id)->find($id);

        if (!$order) {
            return Response::json([
                'success' => false,
                'message' => 'Order not found or not assigned to you.'
            ], 404);
        }

        $status = $request->status;
        $updateData = ['order_status' => $status];

        if ($request->has('order_note')) {
            $updateData['order_note'] = $request->order_note;
        }

        if ($status === 'shipped') {
            $updateData['shiped_at'] = now();
        } elseif ($status === 'delivered') {
            $updateData['delivered_at'] = now();
            $updateData['payment_status'] = 'paid'; // Assuming cash on delivery or similar
        } elseif ($status === 'canceled') {
            $updateData['canceled_at'] = now();
        }

        $order->update($updateData);

        return Response::json([
            'success' => true,
            'message' => "Order status updated to {$status} successfully.",
            'data' => new OrderResource($order->load(['orderItems.product', 'user']))
        ]);
    }

    public function sendDeliveryOtp(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        $request->validate([
            'email' => 'nullable|email'
        ]);

        $order = Order::where('driver_id', $user->id)->find($id);

        if (!$order) {
            return Response::json([
                'success' => false,
                'message' => 'Order not found or not assigned to you.'
            ], 404);
        }

        if ($order->order_status !== 'shipped') {
            return Response::json([
                'success' => false,
                'message' => 'Order must be in shipped status to send OTP.'
            ], 400);
        }

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        $order->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        // Determine the best email to send the OTP to:
        // 1. Request email (if provided)
        // 2. Order email
        // 3. User email
        $recipientEmail = $request->email ?: ($order->email ?: ($order->user ? $order->user->email : null));
        // $recipientEmail = 'smousumiakter94@gmail.com';

        if (!$recipientEmail) {
            return Response::json([
                'success' => false,
                'message' => 'Customer email not found. Please provide an email or update the order/user records.'
            ], 400);
        }

        // Send OTP via email
        try {
            Mail::to($recipientEmail)->send(new OrderDeliveryOTP($order, $otp));
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Failed to send OTP email: ' . $e->getMessage()
            ], 500);
        }

        return Response::json([
            'success' => true,
            'message' => "Delivery OTP has been sent to {$recipientEmail}."
        ]);
    }

    /**
     * Verify delivery OTP and mark order as delivered.
     */
    public function verifyDeliveryOtp(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $order = Order::where('driver_id', $user->id)->find($id);

        if (!$order) {
            return Response::json([
                'success' => false,
                'message' => 'Order not found or not assigned to you.'
            ], 404);
        }

        if ($order->otp !== $request->otp) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid OTP provided.'
            ], 400);
        }

        if (now()->gt($order->otp_expires_at)) {
            return Response::json([
                'success' => false,
                'message' => 'OTP has expired. Please send a new one.'
            ], 400);
        }

        // Update order to delivered
        $order->update([
            'order_status' => 'delivered',
            'delivered_at' => now(),
            'payment_status' => 'paid',
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return Response::json([
            'success' => true,
            'message' => 'Order delivered successfully.',
            'data' => new OrderResource($order->load(['orderItems.product', 'user']))
        ]);
    }
}