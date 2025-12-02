<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'visit_date',
        'service_type',
        'how_heard',
        'follow_up_required',
        'follow_up_status',
        'follow_up_date',
        'notes',
        'visit_count',
        'converted_member_id',
        'recorded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visit_date' => 'date',
        'follow_up_date' => 'date',
        'follow_up_required' => 'boolean',
        'visit_count' => 'integer',
    ];

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the member this visitor was converted to.
     */
    public function convertedMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'converted_member_id');
    }

    /**
     * Get the user who recorded this visitor.
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope query to only unconverted visitors.
     */
    public function scopeUnconverted($query)
    {
        return $query->whereNull('converted_member_id');
    }

    /**
     * Scope query to only converted visitors.
     */
    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_member_id');
    }

    /**
     * Scope query by follow-up status.
     */
    public function scopeFollowUpStatus($query, string $status)
    {
        return $query->where('follow_up_status', $status);
    }

    /**
     * Scope query for visitors requiring follow-up.
     */
    public function scopeRequiresFollowUp($query)
    {
        return $query->where('follow_up_required', true)
            ->where('follow_up_status', '!=', 'converted');
    }

    /**
     * Scope query for visitors eligible for conversion (5+ visits).
     */
    public function scopeEligibleForConversion($query)
    {
        return $query->where('visit_count', '>=', 5)
            ->whereNull('converted_member_id');
    }

    /**
     * Scope query for recent visitors (within last N days).
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('visit_date', '>=', now()->subDays($days));
    }

    /**
     * Check if visitor is eligible for conversion.
     */
    public function isEligibleForConversion(): bool
    {
        return $this->visit_count >= 5 && $this->converted_member_id === null;
    }

    /**
     * Increment visit count.
     */
    public function incrementVisitCount(): bool
    {
        return $this->increment('visit_count');
    }

    /**
     * Mark as converted to member.
     */
    public function markAsConverted(Member $member): bool
    {
        return $this->update([
            'converted_member_id' => $member->id,
            'follow_up_status' => 'converted',
        ]);
    }
}
