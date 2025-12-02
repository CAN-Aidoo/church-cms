<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'family_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'blood_group',
        'allergies',
        'medical_conditions',
        'school',
        'grade_level',
        'photo_url',
        'pick_up_authorization',
        'emergency_contacts',
        'growth_milestones',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'pick_up_authorization' => 'array',
        'emergency_contacts' => 'array',
        'growth_milestones' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.($this->middle_name ?? '').' '.$this->last_name);
    }

    /**
     * Get age in years.
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->diffInYears(now());
    }

    /**
     * Get age in months (for babies/toddlers).
     */
    public function getAgeInMonthsAttribute(): int
    {
        return $this->date_of_birth->diffInMonths(now());
    }

    /**
     * Get appropriate class/group based on age.
     */
    public function getAgeGroupAttribute(): string
    {
        $age = $this->age;

        return match (true) {
            $age < 2 => 'Nursery',
            $age < 5 => 'Toddlers',
            $age < 8 => 'Beginners',
            $age < 11 => 'Primary',
            $age < 14 => 'Junior Teens',
            $age < 18 => 'Senior Teens',
            default => 'Youth',
        };
    }

    /**
     * Check if child is authorized for pickup by person.
     */
    public function isAuthorizedForPickup(string $personId): bool
    {
        if (empty($this->pick_up_authorization)) {
            return false;
        }

        return in_array($personId, array_column($this->pick_up_authorization, 'person_id'));
    }

    /**
     * Add pickup authorization.
     */
    public function addPickupAuthorization(array $person): self
    {
        $authorizations = $this->pick_up_authorization ?? [];
        $authorizations[] = $person;

        $this->update(['pick_up_authorization' => $authorizations]);

        return $this;
    }

    /**
     * Remove pickup authorization.
     */
    public function removePickupAuthorization(string $personId): self
    {
        if (empty($this->pick_up_authorization)) {
            return $this;
        }

        $authorizations = array_filter(
            $this->pick_up_authorization,
            fn ($auth) => $auth['person_id'] !== $personId
        );

        $this->update(['pick_up_authorization' => array_values($authorizations)]);

        return $this;
    }

    /**
     * Add growth milestone.
     */
    public function addMilestone(string $milestone, $date = null): self
    {
        $milestones = $this->growth_milestones ?? [];
        $milestones[] = [
            'milestone' => $milestone,
            'date' => $date ?? now()->toDateString(),
            'recorded_at' => now()->toDateTimeString(),
        ];

        $this->update(['growth_milestones' => $milestones]);

        return $this;
    }

    /**
     * Check if child has birthday this month.
     */
    public function hasBirthdayThisMonth(): bool
    {
        return $this->date_of_birth->month === now()->month;
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByAgeGroup($query, string $ageGroup)
    {
        $ageRanges = [
            'nursery' => [0, 1],
            'toddlers' => [2, 4],
            'beginners' => [5, 7],
            'primary' => [8, 10],
            'junior_teens' => [11, 13],
            'senior_teens' => [14, 17],
        ];

        if (! isset($ageRanges[$ageGroup])) {
            return $query;
        }

        [$minAge, $maxAge] = $ageRanges[$ageGroup];

        return $query->whereBetween('date_of_birth', [
            now()->subYears($maxAge + 1)->addDay(),
            now()->subYears($minAge),
        ]);
    }

    public function scopeBirthdayMonth($query, int $month)
    {
        return $query->whereMonth('date_of_birth', $month);
    }

    public function scopeBirthdayToday($query)
    {
        return $query->whereMonth('date_of_birth', now()->month)
            ->whereDay('date_of_birth', now()->day);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%'.$search.'%')
                ->orWhere('last_name', 'like', '%'.$search.'%');
        });
    }
}
