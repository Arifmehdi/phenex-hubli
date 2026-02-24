<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle; // Import Vehicle model
use App\Models\VehicleAssignment; // Import VehicleAssignment model
use App\Models\Order; // Import Order model
use App\Models\Driver; // Import Driver model
use Illuminate\Support\Facades\Response;

class RiderDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if the user has the 'rider' role (assuming role is a string field on User model)
        if ($user->role !== 'rider') {
            return Response::json(['message' => 'Unauthorized: User is not a rider.'], 403);
        }

        // Get the driver record associated with this user
        $driver = $user->driver;

        if (!$driver) {
            return Response::json(['message' => 'No driver profile found for this rider.'], 404);
        }

        // Fetch vehicles currently assigned to this driver
        $assignedVehicles = VehicleAssignment::where('driver_id', $driver->id)
                                             ->with('vehicle')
                                             ->get();

        // Fetch orders currently assigned to this driver
        $assignedOrders = Order::where('driver_id', $driver->id)
                                ->with(['orderItems', 'user'])
                                ->orderBy('created_at', 'desc')
                                ->get();


        return Response::json([
            'success' => true,
            'message' => 'Rider dashboard data retrieved successfully.',
            'data' => [
                'rider' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'driver_profile' => $driver,
                'assigned_vehicles' => $assignedVehicles,
                'assigned_orders' => $assignedOrders,
            ]
        ]);
    }
}
