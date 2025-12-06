<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounsellingReferral extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'case_id',
        'referred_to_name',
        'referred_to_organization',
        'contact_info',
        'referral_date',
        'reason',
        'status',
        'referred_by',
        'outcome',
        'notes',
    ];

    protected $casts = [
        'referral_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function case()
    {
        return $this->belongsTo(CounsellingCase::class, 'case_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Mark referral as accepted.
     */
    public function accept(): self
    {
        $this->update(['status' => 'accepted']);

        return $this;
    }

    /**
     * Mark referral as declined.
     */
    public function decline(string $reason): self
    {
        $this->update(['status' => 'declined', 'notes' => $reason]);

        return $this;
    }

    /**
     * Complete referral.
     */
    public function complete(string $outcome): self
    {
        $this->update(['status' => 'completed', 'outcome' => $outcome]);

        return $this;
    }
}
