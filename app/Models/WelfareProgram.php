<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WelfareProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_name',
        'program_type',
        'description',
        'budget_allocated',
        'budget_spent',
        'start_date',
        'end_date',
        'status',
        'beneficiaries_count',
        'eligibility_criteria',
        'coordinator_id',
    ];

    protected $casts = [
        'budget_allocated' => 'decimal:2',
        'budget_spent' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'beneficiaries_count' => 'integer',
        'eligibility_criteria' => 'array',
    ];

    /**
     * Program type labels.
     */
    public const PROGRAM_TYPES = [
        'widows_orphans' => 'Widows & Orphans Support',
        'elderly_care' => 'Elderly Care',
        'scholarships' => 'Student Scholarships',
        'medical_assistance' => 'Medical Assistance',
        'food_bank' => 'Food Bank',
        'disaster_relief' => 'Disaster Relief',
        'other' => 'Other',
    ];

    /**
     * Relationships
     */
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function beneficiaries()
    {
        return $this->hasMany(WelfareProgramBeneficiary::class, 'program_id');
    }

    /**
     * Get program type display name.
     */
    public function getProgramTypeDisplayAttribute(): string
    {
        return self::PROGRAM_TYPES[$this->program_type] ?? ucfirst(str_replace('_', ' ', $this->program_type));
    }

    /**
     * Get budget remaining.
     */
    public function getBudgetRemainingAttribute(): float
    {
        return max(0, $this->budget_allocated - $this->budget_spent);
    }

    /**
     * Get budget utilization percentage.
     */
    public function getBudgetUtilizationAttribute(): float
    {
        if (! $this->budget_allocated || $this->budget_allocated == 0) {
            return 0;
        }

        return ($this->budget_spent / $this->budget_allocated) * 100;
    }

    /**
     * Check if program is active.
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Activate program.
     */
    public function activate(): self
    {
        $this->update(['status' => 'active']);

        return $this;
    }

    /**
     * Pause program.
     */
    public function pause(): self
    {
        $this->update(['status' => 'paused']);

        return $this;
    }

    /**
     * Complete program.
     */
    public function complete(): self
    {
        $this->update(['status' => 'completed', 'end_date' => today()]);

        return $this;
    }

    /**
     * Cancel program.
     */
    public function cancel(): self
    {
        $this->update(['status' => 'cancelled']);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active') // Changed from member_status to status
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', today());
            });
    }

    public function scopePaused($query)
    {
        return $query->where('status', 'paused');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('program_type', $type);
    }
}
