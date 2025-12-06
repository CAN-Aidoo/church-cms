<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'reported_by',
        'reason',
        'description',
        'status',
        'reviewed_by',
        'reviewed_at',
        'resolution_notes',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Mark as reviewed.
     */
    public function review(int $reviewerId, string $status, ?string $notes = null): self
    {
        $this->update([
            'status' => $status,
            'reviewed_by' => $reviewerId,
            'reviewed_at' => now(),
            'resolution_notes' => $notes,
        ]);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }
}
