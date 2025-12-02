<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_date',
        'service_type',
        'announcement_type',
        'announcement_text',
        'member_ids',
        'displayed',
        'displayed_at',
        'created_by',
    ];

    protected $casts = [
        'service_date' => 'date',
        'member_ids' => 'array',
        'displayed' => 'boolean',
        'displayed_at' => 'datetime',
    ];

    /**
     * Get the user who created the announcement.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Get announcements for a specific service date.
     */
    public function scopeForServiceDate($query, Carbon $date)
    {
        return $query->whereDate('service_date', $date);
    }

    /**
     * Scope: Get undisplayed announcements.
     */
    public function scopeUndisplayed($query)
    {
        return $query->where('displayed', false);
    }

    /**
     * Scope: Get announcements by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('announcement_type', $type);
    }

    /**
     * Mark announcement as displayed.
     */
    public function markAsDisplayed(): void
    {
        $this->displayed = true;
        $this->displayed_at = now();
        $this->save();
    }

    /**
     * Get the members mentioned in this announcement.
     */
    public function getMembers()
    {
        if (! $this->member_ids || ! is_array($this->member_ids)) {
            return collect();
        }

        return Member::whereIn('id', $this->member_ids)->get();
    }
}
