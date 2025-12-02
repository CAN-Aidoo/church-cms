<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShepherdReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'shepherd_id',
        'report_period',
        'report_date',
        'period_start',
        'period_end',
        'total_members',
        'active_members',
        'inactive_members',
        'visits_conducted',
        'meetings_held',
        'new_members',
        'members_left',
        'highlights',
        'challenges',
        'prayer_needs',
        'recommendations',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the shepherd for this report.
     */
    public function shepherd(): BelongsTo
    {
        return $this->belongsTo(Shepherd::class);
    }

    /**
     * Get the user who reviewed this report.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope a query to only include submitted reports.
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope a query to only include draft reports.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include reviewed reports.
     */
    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    /**
     * Scope a query to only include reports for a specific period.
     */
    public function scopePeriod($query, string $period)
    {
        return $query->where('report_period', $period);
    }

    /**
     * Get activity rate (visits + meetings per member).
     */
    public function getActivityRateAttribute(): float
    {
        if ($this->total_members == 0) {
            return 0;
        }

        return ($this->visits_conducted + $this->meetings_held) / $this->total_members;
    }

    /**
     * Get member retention percentage.
     */
    public function getRetentionPercentageAttribute(): float
    {
        $totalChange = $this->new_members + $this->members_left;
        if ($totalChange == 0) {
            return 100;
        }

        return (($this->new_members - $this->members_left) / $totalChange) * 100;
    }

    /**
     * Get engagement score (0-100).
     */
    public function getEngagementScoreAttribute(): float
    {
        $score = 0;

        // Activity rate (40 points)
        $score += min(40, $this->activity_rate * 10);

        // Active members percentage (30 points)
        if ($this->total_members > 0) {
            $score += ($this->active_members / $this->total_members) * 30;
        }

        // Meetings held (15 points - assuming 1 meeting per week)
        $weeksInPeriod = $this->period_start->diffInWeeks($this->period_end);
        if ($weeksInPeriod > 0) {
            $score += min(15, ($this->meetings_held / $weeksInPeriod) * 15);
        }

        // Visits conducted (15 points)
        if ($this->total_members > 0) {
            $score += min(15, ($this->visits_conducted / $this->total_members) * 15);
        }

        return min(100, $score);
    }
}
