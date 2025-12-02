<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_report_id',
        'report_type',
        'name',
        'frequency',
        'recipients',
        'format',
        'parameters',
        'run_time',
        'day_of_week',
        'day_of_month',
        'last_run_at',
        'next_run_at',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'recipients' => 'array',
        'parameters' => 'array',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function customReport()
    {
        return $this->belongsTo(CustomReport::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function executions()
    {
        return $this->hasMany(ReportExecution::class);
    }

    /**
     * Calculate next run time.
     */
    public function calculateNextRun(): Carbon
    {
        $now = Carbon::now();
        $runTime = Carbon::createFromFormat('H:i:s', $this->run_time);

        return match ($this->frequency) {
            'daily' => $now->copy()->addDay()->setTime($runTime->hour, $runTime->minute),
            'weekly' => $now->copy()->next($this->day_of_week)->setTime($runTime->hour, $runTime->minute),
            'monthly' => $now->copy()->addMonth()->day($this->day_of_month)->setTime($runTime->hour, $runTime->minute),
            'quarterly' => $now->copy()->addMonths(3)->setTime($runTime->hour, $runTime->minute),
            'yearly' => $now->copy()->addYear()->setTime($runTime->hour, $runTime->minute),
            default => $now->copy()->addDay()->setTime($runTime->hour, $runTime->minute),
        };
    }

    /**
     * Mark as run.
     */
    public function markAsRun(): self
    {
        $this->update([
            'last_run_at' => now(),
            'next_run_at' => $this->calculateNextRun(),
        ]);

        return $this;
    }

    /**
     * Activate schedule.
     */
    public function activate(): self
    {
        $this->update([
            'is_active' => true,
            'next_run_at' => $this->calculateNextRun(),
        ]);

        return $this;
    }

    /**
     * Deactivate schedule.
     */
    public function deactivate(): self
    {
        $this->update(['is_active' => false]);

        return $this;
    }

    /**
     * Check if schedule is due to run.
     */
    public function isDue(): bool
    {
        return $this->is_active &&
               $this->next_run_at &&
               $this->next_run_at->isPast();
    }

    /**
     * Get frequency display name.
     */
    public function getFrequencyDisplayAttribute(): string
    {
        return match ($this->frequency) {
            'daily' => 'Daily',
            'weekly' => 'Weekly on '.Carbon::now()->dayName($this->day_of_week),
            'monthly' => 'Monthly on day '.$this->day_of_month,
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly',
            default => ucfirst($this->frequency),
        };
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDue($query)
    {
        return $query->where('is_active', true)
            ->where('next_run_at', '<=', now());
    }

    public function scopeByFrequency($query, string $frequency)
    {
        return $query->where('frequency', $frequency);
    }
}
