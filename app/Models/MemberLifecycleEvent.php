<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLifecycleEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'event_type',
        'event_date',
        'event_location',
        'event_details',
        'metadata',
        'recorded_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'metadata' => 'array',
    ];

    /**
     * Available event types.
     */
    public const EVENT_TYPES = [
        'joined' => 'Joined Church',
        'baptized' => 'Water Baptism',
        'holy_spirit_baptized' => 'Holy Spirit Baptism',
        'married' => 'Marriage',
        'dedicated' => 'Child Dedication',
        'ordained' => 'Ordination',
        'transferred_in' => 'Transferred In',
        'transferred_out' => 'Transferred Out',
        'suspended' => 'Suspended',
        'reinstated' => 'Reinstated',
        'deceased' => 'Deceased',
        'promoted' => 'Promoted to Leadership',
        'retired' => 'Retired from Ministry',
    ];

    /**
     * Relationships
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Get event type display name.
     */
    public function getEventTypeDisplayAttribute(): string
    {
        return self::EVENT_TYPES[$this->event_type] ?? ucfirst(str_replace('_', ' ', $this->event_type));
    }

    /**
     * Get event icon.
     */
    public function getEventIconAttribute(): string
    {
        return match ($this->event_type) {
            'joined' => 'user-plus',
            'baptized', 'holy_spirit_baptized' => 'droplet',
            'married' => 'heart',
            'dedicated' => 'baby',
            'ordained' => 'award',
            'transferred_in' => 'arrow-down-circle',
            'transferred_out' => 'arrow-up-circle',
            'suspended' => 'pause-circle',
            'reinstated' => 'play-circle',
            'deceased' => 'tombstone',
            'promoted' => 'trending-up',
            'retired' => 'sunset',
            default => 'circle',
        };
    }

    /**
     * Get event color class.
     */
    public function getEventColorAttribute(): string
    {
        return match ($this->event_type) {
            'joined', 'reinstated', 'promoted' => 'green',
            'baptized', 'holy_spirit_baptized', 'married', 'ordained' => 'blue',
            'dedicated' => 'purple',
            'transferred_in' => 'indigo',
            'transferred_out' => 'orange',
            'suspended' => 'yellow',
            'deceased', 'retired' => 'gray',
            default => 'blue',
        };
    }

    /**
     * Record a lifecycle event.
     */
    public static function recordEvent(
        Member $member,
        string $eventType,
        $eventDate = null,
        ?string $location = null,
        ?string $details = null,
        ?array $metadata = null
    ): self {
        return self::create([
            'member_id' => $member->id,
            'event_type' => $eventType,
            'event_date' => $eventDate ?? now(),
            'event_location' => $location,
            'event_details' => $details,
            'metadata' => $metadata,
            'recorded_by' => auth()->id(),
        ]);
    }

    /**
     * Get member's timeline.
     */
    public static function getMemberTimeline(Member $member)
    {
        return self::where('member_id', $member->id)
            ->orderBy('event_date', 'desc')
            ->get();
    }

    /**
     * Query Scopes
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('event_type', $type);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('event_date', $date);
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('event_date', [$startDate, $endDate]);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('event_date', '>=', now()->subDays($days));
    }

    public function scopeByMonth($query, int $month, ?int $year = null)
    {
        $query->whereMonth('event_date', $month);

        if ($year) {
            $query->whereYear('event_date', $year);
        }

        return $query;
    }
}
