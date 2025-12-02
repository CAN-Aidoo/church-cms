<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnniversaryMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'milestone_type',
        'milestone_date',
        'years_completed',
        'is_special',
        'recognition_given',
        'recognized_on',
        'recognition_notes',
    ];

    protected $casts = [
        'milestone_date' => 'date',
        'recognized_on' => 'date',
        'is_special' => 'boolean',
        'recognition_given' => 'boolean',
    ];

    /**
     * Get the member for this milestone.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope: Get unrecognized milestones.
     */
    public function scopeUnrecognized($query)
    {
        return $query->where('recognition_given', false);
    }

    /**
     * Scope: Get special milestones.
     */
    public function scopeSpecial($query)
    {
        return $query->where('is_special', true);
    }

    /**
     * Scope: Get milestones by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('milestone_type', $type);
    }

    /**
     * Scope: Get upcoming milestones.
     */
    public function scopeUpcoming($query, int $days = 30)
    {
        return $query->whereBetween('milestone_date', [
            now()->toDateString(),
            now()->addDays($days)->toDateString(),
        ]);
    }

    /**
     * Mark milestone as recognized.
     */
    public function markAsRecognized(?string $notes = null): void
    {
        $this->recognition_given = true;
        $this->recognized_on = today();
        $this->recognition_notes = $notes;
        $this->save();
    }

    /**
     * Check if milestone is this week.
     */
    public function isThisWeek(): bool
    {
        return $this->milestone_date->isBetween(
            now()->startOfWeek(),
            now()->endOfWeek()
        );
    }

    /**
     * Get formatted milestone description.
     */
    public function getDescriptionAttribute(): string
    {
        $type = ucwords(str_replace('_', ' ', $this->milestone_type));

        return "{$this->years_completed} Year {$type}";
    }
}
