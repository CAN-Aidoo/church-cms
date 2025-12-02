<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'type',
        'category',
        'status',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'venue_name',
        'venue_address',
        'venue_gps',
        'target_audience',
        'max_participants',
        'current_participants',
        'registration_fee',
        'requires_registration',
        'flyer_path',
        'additional_info',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_fee' => 'decimal:2',
        'requires_registration' => 'boolean',
        'additional_info' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sessions()
    {
        return $this->hasMany(ProgramSession::class);
    }

    public function registrations()
    {
        return $this->hasMany(ProgramRegistration::class);
    }

    public function attendance()
    {
        return $this->hasMany(ProgramAttendance::class);
    }

    public function resources()
    {
        return $this->hasMany(ProgramResource::class);
    }

    public function feedback()
    {
        return $this->hasMany(ProgramFeedback::class);
    }

    public function volunteers()
    {
        return $this->hasMany(ProgramVolunteer::class);
    }

    public function certificates()
    {
        return $this->hasMany(ProgramCertificate::class);
    }

    public function announcements()
    {
        return $this->hasMany(ProgramAnnouncement::class);
    }

    public function expenses()
    {
        return $this->hasMany(ProgramExpense::class);
    }

    /**
     * Scopes
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', Carbon::today())
            ->whereIn('status', ['published', 'ongoing'])
            ->orderBy('start_date');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing')
            ->where('start_date', '<=', Carbon::today())
            ->where('end_date', '>=', Carbon::today());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
            ->orderBy('end_date', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Accessors & Mutators
     */
    public function getIsOngoingAttribute(): bool
    {
        return $this->status === 'ongoing' &&
            Carbon::parse($this->start_date)->isPast() &&
            Carbon::parse($this->end_date)->isFuture();
    }

    public function getIsUpcomingAttribute(): bool
    {
        return in_array($this->status, ['published', 'ongoing']) &&
            Carbon::parse($this->start_date)->isFuture();
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed' ||
            Carbon::parse($this->end_date)->isPast();
    }

    public function getHasSpotsAvailableAttribute(): bool
    {
        if (! $this->max_participants) {
            return true;
        }

        return $this->current_participants < $this->max_participants;
    }

    public function getSpotsRemainingAttribute(): int
    {
        if (! $this->max_participants) {
            return PHP_INT_MAX;
        }

        return max(0, $this->max_participants - $this->current_participants);
    }

    public function getCapacityPercentageAttribute(): float
    {
        if (! $this->max_participants) {
            return 0;
        }

        return ($this->current_participants / $this->max_participants) * 100;
    }

    public function getDurationDaysAttribute(): int
    {
        return Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;
    }

    public function getTotalRevenueAttribute(): float
    {
        return $this->registrations()
            ->where('payment_status', 'paid')
            ->sum('amount_paid');
    }

    public function getTotalExpensesAttribute(): float
    {
        return $this->expenses()
            ->where('status', 'approved')
            ->sum('amount');
    }

    public function getNetRevenueAttribute(): float
    {
        return $this->total_revenue - $this->total_expenses;
    }

    public function getAverageRatingAttribute(): ?float
    {
        return $this->feedback()->avg('overall_rating');
    }

    /**
     * Business Logic Methods
     */
    public function canRegister(): bool
    {
        return $this->requires_registration &&
            $this->status === 'published' &&
            $this->has_spots_available &&
            Carbon::parse($this->start_date)->isFuture();
    }

    public function incrementParticipants(): void
    {
        $this->increment('current_participants');
    }

    public function decrementParticipants(): void
    {
        $this->decrement('current_participants');
    }

    public function publish(): bool
    {
        if ($this->status === 'draft') {
            $this->status = 'published';

            return $this->save();
        }

        return false;
    }

    public function start(): bool
    {
        if ($this->status === 'published' && Carbon::parse($this->start_date)->isToday()) {
            $this->status = 'ongoing';

            return $this->save();
        }

        return false;
    }

    public function complete(): bool
    {
        if (in_array($this->status, ['published', 'ongoing'])) {
            $this->status = 'completed';

            return $this->save();
        }

        return false;
    }

    public function cancel(): bool
    {
        if (! in_array($this->status, ['completed', 'cancelled'])) {
            $this->status = 'cancelled';

            return $this->save();
        }

        return false;
    }

    public function getConfirmedRegistrationsCount(): int
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    public function getAttendanceRate(): float
    {
        $totalSessions = $this->sessions()->count();
        if ($totalSessions === 0) {
            return 0;
        }

        $totalPossibleAttendance = $this->getConfirmedRegistrationsCount() * $totalSessions;
        if ($totalPossibleAttendance === 0) {
            return 0;
        }

        $actualAttendance = $this->attendance()->count();

        return ($actualAttendance / $totalPossibleAttendance) * 100;
    }

    /**
     * Helper methods for display
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'draft' => 'badge-gray',
            'published' => 'badge-blue',
            'ongoing' => 'badge-green',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger',
            default => 'badge-gray',
        };
    }

    public function getTypeLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->type));
    }

    public function getCategoryLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->category));
    }
}
