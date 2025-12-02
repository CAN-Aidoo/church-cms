<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerTestimony extends Model
{
    use HasFactory;

    protected $fillable = [
        'prayer_request_id',
        'member_id',
        'title',
        'testimony',
        'testimony_date',
        'is_approved',
        'approved_by',
        'approved_at',
        'share_publicly',
        'tags',
    ];

    protected $casts = [
        'testimony_date' => 'date',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'share_publicly' => 'boolean',
        'tags' => 'array',
    ];

    /**
     * Relationships
     */
    public function prayerRequest()
    {
        return $this->belongsTo(PrayerRequest::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Query Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePublic($query)
    {
        return $query->where('share_publicly', true)->where('is_approved', true);
    }

    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderBy('testimony_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }

    /**
     * State Management
     */
    public function approve(int $userId): bool
    {
        if (! $this->is_approved) {
            $this->is_approved = true;
            $this->approved_by = $userId;
            $this->approved_at = now();

            return $this->save();
        }

        return false;
    }

    public function unapprove(): bool
    {
        if ($this->is_approved) {
            $this->is_approved = false;
            $this->approved_by = null;
            $this->approved_at = null;

            return $this->save();
        }

        return false;
    }
}
