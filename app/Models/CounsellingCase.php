<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CounsellingCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'case_number',
        'member_id',
        'primary_counsellor_id',
        'case_title',
        'case_description',
        'issue_categories',
        'priority',
        'status',
        'opened_date',
        'closed_date',
        'closure_notes',
        'closure_reason',
        'total_sessions',
        'planned_sessions',
        'goals',
        'opened_by',
        'closed_by',
    ];

    protected $casts = [
        'issue_categories' => 'array',
        'goals' => 'array',
        'opened_date' => 'date',
        'closed_date' => 'date',
        'total_sessions' => 'integer',
        'planned_sessions' => 'integer',
    ];

    /**
     * Issue category options.
     */
    public const ISSUE_CATEGORIES = [
        'marital' => 'Marital Issues',
        'family' => 'Family Conflict',
        'addiction' => 'Addiction',
        'grief' => 'Grief & Loss',
        'depression' => 'Depression',
        'anxiety' => 'Anxiety',
        'anger' => 'Anger Management',
        'spiritual' => 'Spiritual Struggle',
        'career' => 'Career/Financial',
        'youth' => 'Youth Issues',
        'trauma' => 'Trauma',
        'other' => 'Other',
    ];

    /**
     * Boot method to auto-generate case number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($case) {
            if (empty($case->case_number)) {
                $case->case_number = 'CASE-'.date('Y').'-'.strtoupper(Str::random(8));
            }

            if (empty($case->opened_date)) {
                $case->opened_date = today();
            }
        });
    }

    /**
     * Relationships
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function primaryCounsellor()
    {
        return $this->belongsTo(Counsellor::class, 'primary_counsellor_id');
    }

    public function sessions()
    {
        return $this->hasMany(CounsellingSession::class, 'case_id');
    }

    public function documents()
    {
        return $this->hasMany(CounsellingDocument::class, 'case_id');
    }

    public function referrals()
    {
        return $this->hasMany(CounsellingReferral::class, 'case_id');
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * Get issue categories display.
     */
    public function getIssueCategoriesDisplayAttribute(): array
    {
        return array_map(function ($category) {
            return self::ISSUE_CATEGORIES[$category] ?? ucfirst(str_replace('_', ' ', $category));
        }, $this->issue_categories ?? []);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'open' => 'yellow',
            'active' => 'blue',
            'on_hold' => 'orange',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get priority badge color.
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'gray',
            'medium' => 'blue',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get duration in days.
     */
    public function getDurationDaysAttribute(): int
    {
        $endDate = $this->closed_date ?? today();

        return $this->opened_date->diffInDays($endDate);
    }

    /**
     * Get case progress percentage.
     */
    public function getProgressPercentageAttribute(): ?float
    {
        if (! $this->planned_sessions || $this->planned_sessions == 0) {
            return null;
        }

        return min(100, ($this->total_sessions / $this->planned_sessions) * 100);
    }

    /**
     * Check if case is overdue.
     */
    public function isOverdue(): bool
    {
        if ($this->status === 'closed') {
            return false;
        }

        // Consider overdue if no session in last 30 days
        $lastSession = $this->sessions()->latest('session_date')->first();

        if (! $lastSession) {
            return $this->opened_date->diffInDays(today()) > 30;
        }

        return $lastSession->session_date->diffInDays(today()) > 30;
    }

    /**
     * Activate case.
     */
    public function activate(): self
    {
        $this->update(['status' => 'active']);

        return $this;
    }

    /**
     * Put case on hold.
     */
    public function putOnHold(): self
    {
        $this->update(['status' => 'on_hold']);

        return $this;
    }

    /**
     * Close case.
     */
    public function close(string $reason, ?string $notes = null, ?int $closedBy = null): self
    {
        $this->update([
            'status' => 'closed',
            'closed_date' => today(),
            'closure_reason' => $reason,
            'closure_notes' => $notes,
            'closed_by' => $closedBy ?? auth()->id(),
        ]);

        return $this;
    }

    /**
     * Reopen case.
     */
    public function reopen(): self
    {
        $this->update([
            'status' => 'open',
            'closed_date' => null,
            'closure_reason' => null,
            'closure_notes' => null,
            'closed_by' => null,
        ]);

        return $this;
    }

    /**
     * Add goal.
     */
    public function addGoal(string $goal): self
    {
        $goals = $this->goals ?? [];
        $goals[] = [
            'description' => $goal,
            'added_at' => now()->toDateTimeString(),
            'achieved' => false,
        ];

        $this->update(['goals' => $goals]);

        return $this;
    }

    /**
     * Mark goal as achieved.
     */
    public function achieveGoal(int $index): self
    {
        $goals = $this->goals ?? [];

        if (isset($goals[$index])) {
            $goals[$index]['achieved'] = true;
            $goals[$index]['achieved_at'] = now()->toDateTimeString();
            $this->update(['goals' => $goals]);
        }

        return $this;
    }

    /**
     * Get upcoming session.
     */
    public function getUpcomingSession()
    {
        return $this->sessions()
            ->upcoming()
            ->orderBy('session_date')
            ->orderBy('session_time')
            ->first();
    }

    /**
     * Get last session.
     */
    public function getLastSession()
    {
        return $this->sessions()
            ->completed()
            ->latest('session_date')
            ->first();
    }

    /**
     * Query Scopes
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeOnHold($query)
    {
        return $query->where('status', 'on_hold');
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'critical']);
    }

    public function scopeByCounsellor($query, int $counsellorId)
    {
        return $query->where('primary_counsellor_id', $counsellorId);
    }

    public function scopeByMember($query, int $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeOverdue($query)
    {
        return $query->whereIn('status', ['open', 'active'])
            ->whereDoesntHave('sessions', function ($q) {
                $q->where('session_date', '>=', now()->subDays(30));
            });
    }
}
