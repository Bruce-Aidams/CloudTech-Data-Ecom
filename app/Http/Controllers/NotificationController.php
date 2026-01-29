<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // User: Get my notifications
    public function index(Request $request)
    {
        return $request->user()->notifications()->latest()->take(20)->get();
    }

    // Admin: Get all notifications
    public function adminIndex(Request $request)
    {
        $notifications = Notification::with('user')->latest()->paginate(20);

        if ($request->expectsJson() || $request->is('api/*')) {
            return $notifications;
        }

        $users = User::all();
        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    // User: Toggle read/unread status
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->update(['is_read' => !$notification->is_read]);
        return response()->json([
            'message' => $notification->is_read ? 'Marked as read' : 'Marked as unread',
            'is_read' => $notification->is_read
        ]);
    }

    // Admin: Send Notification
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required', // Can be "all" or specific ID
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'in:info,success,warning,error'
        ]);

        if ($request->user_id === 'all') {
            $users = User::where('role', 'user')->get();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'type' => $request->type ?? 'info',
                    'is_read' => false
                ]);
            }
            return redirect()->back()->with('success', 'Notification sent to all users');
        }

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type ?? 'info',
            'is_read' => false
        ]);

        return redirect()->back()->with('success', 'Notification sent successfully');
    }
    public function destroy($id)
    {
        Notification::destroy($id);
        return redirect()->back()->with('success', 'Notification deleted successfully');
    }
}
