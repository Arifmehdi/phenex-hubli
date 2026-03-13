<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $ip = $request->ip();

        $notifications = Notification::where(function ($query) use ($user, $ip) {

            $query->whereNull('user_id'); // broadcast

            if ($user) {
                $query->orWhere('user_id', $user->id);
            }

            $query->orWhere('ip_address', $ip);

        })
        ->latest()
        ->paginate(20);

        return response()->json([
            'status' => true,
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();
        $ip = $request->ip();

        $notification = Notification::where('id', $id)
            ->where(function ($query) use ($user, $ip) {

                $query->whereNull('user_id');

                if ($user) {
                    $query->orWhere('user_id', $user->id);
                }

                $query->orWhere('ip_address', $ip);

            })
            ->first();

        if (!$notification) {
            return response()->json([
                'status' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->update([
            'is_read' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    public function markAllRead(Request $request)
    {
        $user = $request->user();

        Notification::where(function ($query) use ($user) {
            $query->whereNull('user_id')
                ->orWhere('user_id', $user->id);
        })
        ->update([
            'is_read' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    public function ipNotifications(Request $request)
    {
        $ip = $request->ip();

        $notifications = Notification::where('ip_address', $ip)
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'ip' => $ip,
            'notifications' => $notifications
        ]);
    }
}
