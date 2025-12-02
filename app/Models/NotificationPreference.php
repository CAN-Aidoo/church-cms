<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'in_app_enabled',
        'in_app_types',
        'email_enabled',
        'email_types',
        'email_digest_time',
        'email_digest_enabled',
        'sms_enabled',
        'sms_types',
        'push_enabled',
        'push_types',
        'quiet_hours_start',
        'quiet_hours_end',
        'quiet_hours_enabled',
    ];

    protected $casts = [
        'in_app_enabled' => 'boolean',
        'in_app_types' => 'array',
        'email_enabled' => 'boolean',
        'email_types' => 'array',
        'email_digest_enabled' => 'boolean',
        'sms_enabled' => 'boolean',
        'sms_types' => 'array',
        'push_enabled' => 'boolean',
        'push_types' => 'array',
        'quiet_hours_enabled' => 'boolean',
    ];

    /**
     * Get the user for this preference.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get or create preferences for a user.
     */
    public static function forUser(User $user): self
    {
        return self::firstOrCreate(
            ['user_id' => $user->id],
            [
                'in_app_enabled' => true,
                'email_enabled' => true,
                'sms_enabled' => true,
                'push_enabled' => true,
            ]
        );
    }

    /**
     * Check if user wants notifications via channel.
     */
    public function wantsChannel(string $channel, ?string $type = null): bool
    {
        $enabled = match ($channel) {
            'in_app' => $this->in_app_enabled,
            'email' => $this->email_enabled,
            'sms' => $this->sms_enabled,
            'push' => $this->push_enabled,
            default => false,
        };

        if (! $enabled) {
            return false;
        }

        // Check if specific type is enabled
        if ($type) {
            $types = match ($channel) {
                'in_app' => $this->in_app_types,
                'email' => $this->email_types,
                'sms' => $this->sms_types,
                'push' => $this->push_types,
                default => null,
            };

            // If no specific types set, allow all
            if (! $types || empty($types)) {
                return true;
            }

            return in_array($type, $types);
        }

        return true;
    }

    /**
     * Check if currently in quiet hours.
     */
    public function isQuietHours(): bool
    {
        if (! $this->quiet_hours_enabled) {
            return false;
        }

        $now = now()->format('H:i:s');
        $start = $this->quiet_hours_start;
        $end = $this->quiet_hours_end;

        if ($start < $end) {
            // e.g., 22:00 to 07:00 next day
            return $now >= $start || $now < $end;
        } else {
            // e.g., 07:00 to 22:00 same day
            return $now >= $start && $now < $end;
        }
    }
}
