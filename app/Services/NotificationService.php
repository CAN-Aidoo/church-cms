<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Send notification to a user.
     */
    public function send(User $user, array $data): Notification
    {
        $preferences = NotificationPreference::forUser($user);

        // Check if user wants in-app notifications for this type
        if (! $preferences->wantsChannel('in_app', $data['type'] ?? null)) {
            return null;
        }

        // Check quiet hours for non-urgent notifications
        if (($data['priority'] ?? 'normal') !== 'urgent' && $preferences->isQuietHours()) {
            // Schedule for after quiet hours
            $data['created_at'] = $this->getAfterQuietHours($preferences);
        }

        return Notification::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'] ?? 'info',
            'icon' => $data['icon'] ?? null,
            'action_url' => $data['action_url'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'priority' => $data['priority'] ?? 'normal',
            'expires_at' => $data['expires_at'] ?? null,
        ]);
    }

    /**
     * Send notification to multiple users.
     */
    public function sendToMany(Collection $users, array $data): int
    {
        $count = 0;

        foreach ($users as $user) {
            if ($this->send($user, $data)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Send notification to all users with a specific role.
     */
    public function sendToRole(string $role, array $data): int
    {
        $users = User::where('role', $role)->get();

        return $this->sendToMany($users, $data);
    }

    /**
     * Get user's unread notifications.
     */
    public function getUnread(User $user, ?int $limit = null): Collection
    {
        $query = Notification::where('user_id', $user->id)
            ->unread()
            ->active()
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get user's unread count.
     */
    public function getUnreadCount(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->unread()
            ->active()
            ->count();
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification): void
    {
        $notification->markAsRead();
    }

    /**
     * Mark all notifications as read for user.
     */
    public function markAllAsRead(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Delete notification.
     */
    public function delete(Notification $notification): void
    {
        $notification->delete();
    }

    /**
     * Delete all read notifications for user.
     */
    public function deleteAllRead(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->read()
            ->delete();
    }

    /**
     * Clean up expired notifications.
     */
    public function cleanupExpired(): int
    {
        return Notification::where('expires_at', '<=', now())->delete();
    }

    /**
     * Send birthday notification.
     */
    public function sendBirthdayNotification(User $user, string $memberName): Notification
    {
        return $this->send($user, [
            'title' => 'Birthday Today!',
            'message' => "{$memberName} is celebrating their birthday today.",
            'type' => 'birthday',
            'icon' => '🎂',
            'priority' => 'normal',
            'expires_at' => now()->endOfDay(),
        ]);
    }

    /**
     * Send attendance alert notification.
     */
    public function sendAttendanceAlert(User $user, string $memberName, int $consecutiveAbsences): Notification
    {
        return $this->send($user, [
            'title' => 'Attendance Alert',
            'message' => "{$memberName} has been absent for {$consecutiveAbsences} consecutive services.",
            'type' => 'attendance_alert',
            'icon' => '⚠️',
            'priority' => $consecutiveAbsences >= 3 ? 'high' : 'normal',
        ]);
    }

    /**
     * Send finance approval notification.
     */
    public function sendFinanceApprovalNotification(User $user, string $transactionType, float $amount): Notification
    {
        return $this->send($user, [
            'title' => 'Approval Required',
            'message' => "A {$transactionType} of GHS ".number_format($amount, 2).' requires your approval.',
            'type' => 'finance_approval',
            'icon' => '💰',
            'priority' => $amount > 5000 ? 'high' : 'normal',
            'action_url' => route('transactions.pending'),
        ]);
    }

    /**
     * Send duty roster notification.
     */
    public function sendDutyRosterNotification(User $user, string $unitName, string $dutyDate): Notification
    {
        return $this->send($user, [
            'title' => 'Duty Roster Published',
            'message' => "You have been assigned to {$unitName} duty on {$dutyDate}.",
            'type' => 'duty_roster',
            'icon' => '📋',
            'priority' => 'normal',
        ]);
    }

    /**
     * Send meeting reminder notification.
     */
    public function sendMeetingReminder(User $user, string $meetingName, string $meetingTime): Notification
    {
        return $this->send($user, [
            'title' => 'Meeting Reminder',
            'message' => "{$meetingName} is scheduled for {$meetingTime}.",
            'type' => 'meeting_reminder',
            'icon' => '📅',
            'priority' => 'normal',
        ]);
    }

    /**
     * Get after quiet hours timestamp.
     */
    protected function getAfterQuietHours(NotificationPreference $preferences): Carbon
    {
        if (! $preferences->quiet_hours_enabled) {
            return now();
        }

        $endTime = $preferences->quiet_hours_end;
        $now = now();

        // If currently in quiet hours, schedule for after quiet hours end
        if ($preferences->isQuietHours()) {
            return $now->copy()->setTimeFromTimeString($endTime);
        }

        return $now;
    }
}
