<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function prayerRequests()
    {
        return $this->hasMany(PrayerRequest::class, 'category_id');
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Helper Methods
     */
    public function getRequestsCountAttribute(): int
    {
        return $this->prayerRequests()->count();
    }

    public function getActiveRequestsCountAttribute(): int
    {
        return $this->prayerRequests()->active()->count();
    }
}
