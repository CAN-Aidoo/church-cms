<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display user's notifications.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Notification::where('user_id', $user->id)
            ->active()
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('is_read')) {
            $query->where('is_read', $request->is_read === 'true');
        }

        $notifications = $query->paginate(20);
        $unreadCount = $this->notificationService->getUnreadCount($user);

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Get unread notifications (for AJAX).
     */
    public function unread()
    {
        $user = Auth::user();
        $notifications = $this->notificationService->getUnread($user, 10);
        $unreadCount = $this->notificationService->getUnreadCount($user);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        // Ensure user owns this notification
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $this->notificationService->markAsRead($notification);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $count = $this->notificationService->markAllAsRead($user);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => $count,
            ]);
        }

        return redirect()
            ->back()
            ->with('success', "{$count} notification(s) marked as read.");
    }

    /**
     * Delete notification.
     */
    public function destroy(Notification $notification)
    {
        // Ensure user owns this notification
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $this->notificationService->delete($notification);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    /**
     * Delete all read notifications.
     */
    public function deleteAllRead()
    {
        $user = Auth::user();
        $count = $this->notificationService->deleteAllRead($user);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => $count,
            ]);
        }

        return redirect()
            ->back()
            ->with('success', "{$count} notification(s) deleted.");
    }

    /**
     * Display notification preferences.
     */
    public function preferences()
    {
        $user = Auth::user();
        $preferences = NotificationPreference::forUser($user);

        $availableTypes = [
            'birthday' => 'Birthday Wishes',
            'anniversary' => 'Anniversaries',
            'attendance_alert' => 'Attendance Alerts',
            'finance_approval' => 'Finance Approvals',
            'duty_roster' => 'Duty Rosters',
            'meeting_reminder' => 'Meeting Reminders',
            'general' => 'General Notifications',
        ];

        return view('notifications.preferences', compact('preferences', 'availableTypes'));
    }

    /**
     * Update notification preferences.
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'in_app_enabled' => 'required|boolean',
            'in_app_types' => 'nullable|array',
            'email_enabled' => 'required|boolean',
            'email_types' => 'nullable|array',
            'email_digest_enabled' => 'required|boolean',
            'email_digest_time' => 'nullable|date_format:H:i',
            'sms_enabled' => 'required|boolean',
            'sms_types' => 'nullable|array',
            'push_enabled' => 'required|boolean',
            'push_types' => 'nullable|array',
            'quiet_hours_enabled' => 'required|boolean',
            'quiet_hours_start' => 'nullable|date_format:H:i',
            'quiet_hours_end' => 'nullable|date_format:H:i',
        ]);

        NotificationPreference::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()
            ->back()
            ->with('success', 'Notification preferences updated successfully.');
    }
}
