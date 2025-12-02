<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrensMinistryTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
        'age_groups_certified',
        'background_check_completed',
        'background_check_date',
        'background_check_expiry',
        'training_completed',
        'last_training_date',
        'years_experience',
        'special_skills',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'age_groups_certified' => 'array',
        'background_check_completed' => 'boolean',
        'background_check_date' => 'date',
        'background_check_expiry' => 'date',
        'training_completed' => 'array',
        'last_training_date' => 'date',
        'years_experience' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lessonSchedules()
    {
        return $this->hasMany(LessonSchedule::class, 'teacher_id');
    }

    /**
     * Check if background check is valid.
     */
    public function hasValidBackgroundCheck(): bool
    {
        return $this->background_check_completed &&
               $this->background_check_expiry &&
               $this->background_check_expiry->isFuture();
    }

    /**
     * Check if background check is expiring soon.
     */
    public function isBackgroundCheckExpiringSoon(int $days = 30): bool
    {
        if (! $this->background_check_expiry) {
            return false;
        }

        return $this->background_check_expiry->isFuture() &&
               $this->background_check_expiry->diffInDays(now()) <= $days;
    }

    /**
     * Check if certified for age group.
     */
    public function isCertifiedFor(string $ageGroup): bool
    {
        return in_array($ageGroup, $this->age_groups_certified ?? []);
    }

    /**
     * Add training.
     */
    public function addTraining(string $training): self
    {
        $trainings = $this->training_completed ?? [];
        $trainings[] = [
            'name' => $training,
            'date' => now()->toDateString(),
        ];

        $this->update([
            'training_completed' => $trainings,
            'last_training_date' => now(),
        ]);

        return $this;
    }

    /**
     * Activate teacher.
     */
    public function activate(): self
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate teacher.
     */
    public function deactivate(): self
    {
        $this->update(['is_active' => false]);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLeadTeachers($query)
    {
        return $query->where('role', 'lead_teacher');
    }

    public function scopeSubstitutes($query)
    {
        return $query->where('role', 'substitute');
    }

    public function scopeValidBackgroundCheck($query)
    {
        return $query->where('background_check_completed', true)
            ->where('background_check_expiry', '>=', now());
    }

    public function scopeExpiringBackgroundCheck($query, int $days = 30)
    {
        return $query->where('background_check_completed', true)
            ->whereBetween('background_check_expiry', [now(), now()->addDays($days)]);
    }

    public function scopeCertifiedFor($query, string $ageGroup)
    {
        return $query->whereJsonContains('age_groups_certified', $ageGroup);
    }
}
