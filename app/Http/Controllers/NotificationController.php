<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Jika request format JSON (untuk AJAX)
        if ($request->wantsJson() || $request->get('format') === 'json') {
            return response()->json([
                'notifications' => $notifications->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => $notification->type,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'icon' => $notification->icon,
                        'link' => $notification->link,
                        'is_read' => $notification->is_read,
                        'time_ago' => $notification->time_ago,
                    ];
                }),
                'unread_count' => $user->unreadNotificationsCount(),
            ]);
        }

        // Tentukan route dashboard berdasarkan role
        $dashboardRoute = 'dashboard';
        if ($user->role === 'pembimbing' || $user->role === 'mentor') {
            $dashboardRoute = 'mentor.dashboard';
        } elseif ($user->role === 'admin') {
            $dashboardRoute = 'admin.dashboard';
        }

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route($dashboardRoute)],
            'Notifikasi'
        ];

        return view('notifications.index', compact('notifications', 'breadcrumbs'));
    }

    /**
     * Get unread notifications count (for AJAX).
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadNotificationsCount();
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications (for dropdown).
     */
    public function recent()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'notifications' => [],
                    'unread_count' => 0,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $notifications = $user->notifications()
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'notifications' => $notifications->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => $notification->type,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'icon' => $notification->icon,
                        'link' => $notification->link,
                        'is_read' => $notification->is_read,
                        'time_ago' => $notification->time_ago,
                    ];
                }),
                'unread_count' => $user->unreadNotificationsCount(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'notifications' => [],
                'unread_count' => 0,
                'message' => 'No notifications available'
            ], 200);
        }
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete notification.
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json(['success' => true]);
    }
}

