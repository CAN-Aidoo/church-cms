<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'service_type',
        'service_date',
        'start_time',
        'end_time',
        'venue',
        'theme',
        'sermon_title',
        'sermon_text',
        'preacher_id',
        'expected_attendance',
        'actual_attendance',
        'status',
        'notes',
        'additional_info',
        'created_by',
    ];

    protected $casts = [
        'service_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'expected_attendance' => 'integer',
        'actual_attendance' => 'integer',
        'additional_info' => 'array',
    ];

    /**
     * Relationships
     */
    public function preacher()
    {
        return $this->belongsTo(Member::class, 'preacher_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function worshipPlan()
    {
        return $this->hasMany(WorshipPlan::class)->orderBy('order_number');
    }

    public function volunteers()
    {
        return $this->hasMany(ServiceVolunteer::class);
    }

    public function resources()
    {
        return $this->hasMany(ServiceResource::class);
    }

    public function announcements()
    {
        return $this->hasMany(ServiceAnnouncement::class);
    }

    public function sermon()
    {
        return $this->hasOne(Sermon::class);
    }

    public function feedback()
    {
        return $this->hasMany(ServiceFeedback::class);
    }

    /**
     * Query Scopes
     */
    public function scopeUpcoming($query)
    {
        return $query->where('service_date', '>=', Carbon::today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('service_date')
            ->orderBy('start_time');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('service_date', Carbon::today())
            ->where('status', '!=', 'cancelled');
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('service_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->where('status', '!=', 'cancelled');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('service_type', $type);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Computed Attributes
     */
    public function getDurationAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return Carbon::parse($this->start_time)->diffInMinutes(Carbon::parse($this->end_time));
        }

        return null;
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->service_date->isFuture() || $this->service_date->isToday();
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->service_date->isToday();
    }

    public function getAttendanceRateAttribute(): float
    {
        if ($this->expected_attendance && $this->actual_attendance) {
            return ($this->actual_attendance / $this->expected_attendance) * 100;
        }

        return 0;
    }

    public function getVolunteerCompletionRateAttribute(): float
    {
        $total = $this->volunteers()->count();
        if ($total === 0) {
            return 0;
        }

        $confirmed = $this->volunteers()->whereIn('status', ['confirmed', 'completed'])->count();

        return ($confirmed / $total) * 100;
    }

    public function getAverageRatingAttribute(): ?float
    {
        return $this->feedback()->avg('overall_rating');
    }

    /**
     * Helper Methods
     */
    public function getServiceTypeLabelAttribute(): string
    {
        return match ($this->service_type) {
            'regular' => 'Regular Service',
            'special' => 'Special Service',
            'midweek' => 'Midweek Service',
            'youth' => 'Youth Service',
            'children' => 'Children Service',
            'prayer_meeting' => 'Prayer Meeting',
            'bible_study' => 'Bible Study',
            'other' => 'Other',
            default => ucfirst($this->service_type),
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'scheduled' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-green-100 text-green-800',
            'completed' => 'bg-purple-100 text-purple-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * State Management Methods
     */
    public function schedule(): bool
    {
        if ($this->status === 'draft' && $this->isReadyToSchedule()) {
            $this->status = 'scheduled';

            return $this->save();
        }

        return false;
    }

    public function start(): bool
    {
        if ($this->status === 'scheduled' && $this->service_date->isToday()) {
            $this->status = 'in_progress';

            return $this->save();
        }

        return false;
    }

    public function complete(): bool
    {
        if ($this->status === 'in_progress') {
            $this->status = 'completed';

            return $this->save();
        }

        return false;
    }

    public function cancel(): bool
    {
        if (in_array($this->status, ['draft', 'scheduled'])) {
            $this->status = 'cancelled';

            return $this->save();
        }

        return false;
    }

    /**
     * Validation Helpers
     */
    public function isReadyToSchedule(): bool
    {
        return $this->name &&
               $this->service_date &&
               $this->start_time &&
               $this->worshipPlan()->count() > 0;
    }

    public function hasAllVolunteersConfirmed(): bool
    {
        $total = $this->volunteers()->count();
        if ($total === 0) {
            return true;
        }

        $confirmed = $this->volunteers()->where('status', 'confirmed')->count();

        return $confirmed === $total;
    }

    /**
     * Statistics Methods
     */
    public function getVolunteersByRole(): array
    {
        return $this->volunteers()
            ->selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
    }

    public function getAttendanceComparison(): array
    {
        return [
            'expected' => $this->expected_attendance,
            'actual' => $this->actual_attendance,
            'difference' => $this->actual_attendance - $this->expected_attendance,
            'percentage' => $this->attendance_rate,
        ];
    }
}
