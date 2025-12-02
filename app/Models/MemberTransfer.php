<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MemberTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'transfer_type',
        'previous_church',
        'new_church',
        'transfer_date',
        'transfer_reason',
        'transfer_letter_path',
        'status',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Transfer statuses.
     */
    public const STATUSES = [
        'pending' => 'Pending Review',
        'approved' => 'Approved',
        'completed' => 'Completed',
        'rejected' => 'Rejected',
    ];

    /**
     * Transfer types.
     */
    public const TYPES = [
        'incoming' => 'Incoming Transfer',
        'outgoing' => 'Outgoing Transfer',
    ];

    /**
     * Relationships
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get status display name.
     */
    public function getStatusDisplayAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get transfer type display name.
     */
    public function getTransferTypeDisplayAttribute(): string
    {
        return self::TYPES[$this->transfer_type] ?? ucfirst(str_replace('_', ' ', $this->transfer_type));
    }

    /**
     * Get church name based on transfer type.
     */
    public function getChurchNameAttribute(): string
    {
        return $this->transfer_type === 'incoming' ?
               $this->previous_church :
               $this->new_church;
    }

    /**
     * Check if transfer letter exists.
     */
    public function hasTransferLetter(): bool
    {
        return ! is_null($this->transfer_letter_path) &&
               Storage::exists($this->transfer_letter_path);
    }

    /**
     * Get transfer letter URL.
     */
    public function getTransferLetterUrlAttribute(): ?string
    {
        return $this->hasTransferLetter() ?
               Storage::url($this->transfer_letter_path) :
               null;
    }

    /**
     * Delete transfer letter.
     */
    public function deleteTransferLetter(): bool
    {
        if ($this->hasTransferLetter()) {
            return Storage::delete($this->transfer_letter_path);
        }

        return true;
    }

    /**
     * Approve transfer.
     */
    public function approve(?int $approverId = null): self
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approverId ?? auth()->id(),
            'approved_at' => now(),
        ]);

        return $this;
    }

    /**
     * Reject transfer.
     */
    public function reject(string $reason): self
    {
        $this->update([
            'status' => 'rejected',
            'notes' => $reason,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return $this;
    }

    /**
     * Complete transfer.
     */
    public function complete(): self
    {
        $this->update(['status' => 'completed']);

        // Record lifecycle event
        $this->member->recordLifecycleEvent(
            $this->transfer_type === 'incoming' ? 'transferred_in' : 'transferred_out',
            $this->transfer_date,
            $this->church_name,
            $this->transfer_reason
        );

        // Update member status if outgoing
        if ($this->transfer_type === 'outgoing') {
            $this->member->update(['member_status' => 'transferred']);
        }

        return $this;
    }

    /**
     * Check if transfer is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transfer is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if transfer is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Query Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeIncoming($query)
    {
        return $query->where('transfer_type', 'incoming');
    }

    public function scopeOutgoing($query)
    {
        return $query->where('transfer_type', 'outgoing');
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('transfer_date', '>=', now()->subDays($days));
    }
}
