<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'serial_number',
        'model',
        'purchase_date',
        'purchase_price',
        'current_value',
        'location',
        'status',
        'assigned_to',
        'last_maintenance',
        'next_maintenance',
        'notes',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date' => 'date',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'purchase_price' => 'decimal:2',
        'current_value' => 'decimal:2',
    ];

    /**
     * Get the user who created this equipment record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope query to only active equipment.
     */
    public function scopeActive($query)
    {
        return $query->where('member_status', 'active');
    }

    /**
     * Scope query to only inactive equipment.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope query to equipment under maintenance.
     */
    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    /**
     * Scope query by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope query by location.
     */
    public function scopeLocation($query, string $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope query for equipment needing maintenance.
     */
    public function scopeNeedsMaintenance($query)
    {
        return $query->where('next_maintenance', '<=', now()->addDays(7))
            ->where('status', '!=', 'retired');
    }

    /**
     * Check if equipment needs maintenance.
     */
    public function needsMaintenance(): bool
    {
        return $this->next_maintenance && $this->next_maintenance->isPast();
    }

    /**
     * Get days until next maintenance.
     */
    public function getDaysUntilMaintenanceAttribute(): ?int
    {
        return $this->next_maintenance ? now()->diffInDays($this->next_maintenance, false) : null;
    }

    /**
     * Get age in years.
     */
    public function getAgeInYearsAttribute(): ?float
    {
        return $this->purchase_date ? now()->floatDiffInYears($this->purchase_date) : null;
    }
}
