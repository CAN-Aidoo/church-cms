<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthdayAutomationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'enabled',
        'sms_enabled',
        'email_enabled',
        'send_time',
        'sms_template',
        'email_subject',
        'email_template',
        'notify_pastor',
        'announce_in_service',
        'special_milestones',
        'special_milestone_message',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'sms_enabled' => 'boolean',
        'email_enabled' => 'boolean',
        'notify_pastor' => 'boolean',
        'announce_in_service' => 'boolean',
        'special_milestones' => 'array',
    ];

    /**
     * Get setting by event type.
     */
    public static function forEventType(string $eventType): ?self
    {
        return self::where('event_type', $eventType)->first();
    }

    /**
     * Check if event type is enabled.
     */
    public static function isEnabled(string $eventType): bool
    {
        $setting = self::forEventType($eventType);

        return $setting ? $setting->enabled : false;
    }

    /**
     * Get parsed message with placeholders replaced.
     */
    public function getParsedMessage(Member $member, array $additionalData = []): string
    {
        $message = $this->sms_template;

        // Replace common placeholders
        $replacements = [
            '{first_name}' => $member->first_name,
            '{full_name}' => $member->full_name,
            '{title}' => $member->title ?? '',
            '{church_name}' => config('church.name', 'Church'),
        ];

        // Add additional data
        $replacements = array_merge($replacements, $additionalData);

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $message
        );
    }

    /**
     * Check if milestone year is special.
     */
    public function isSpecialMilestone(int $years): bool
    {
        return in_array($years, $this->special_milestones ?? []);
    }
}
