<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WelfareCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'case_number',
        'beneficiary_id',
        'beneficiary_name',
        'beneficiary_phone',
        'beneficiary_email',
        'address',
        'case_category',
        'case_title',
        'case_description',
        'supporting_documents',
        'amount_requested',
        'amount_approved',
        'amount_disbursed',
        'status',
        'priority',
        'priority_score',
        'verification_status',
        'verification_notes',
        'verified_by',
        'verified_at',
        'approval_notes',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'case_date',
        'closed_date',
        'submitted_by',
    ];

    protected $casts = [
        'supporting_documents' => 'array',
        'amount_requested' => 'decimal:2',
        'amount_approved' => 'decimal:2',
        'amount_disbursed' => 'decimal:2',
        'priority_score' => 'integer',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'case_date' => 'date',
        'closed_date' => 'date',
    ];

    /**
     * Case category labels.
     */
    public const CATEGORIES = [
        'medical' => 'Medical Assistance',
        'education' => 'Education Support',
        'housing' => 'Housing Assistance',
        'food' => 'Food Bank',
        'emergency' => 'Emergency Relief',
        'bereavement' => 'Bereavement Support',
        'job_loss' => 'Job Loss Support',
        'other' => 'Other',
    ];

    /**
     * Boot method to auto-generate case number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($case) {
            if (empty($case->case_number)) {
                $case->case_number = 'WF-'.date('Y').'-'.strtoupper(Str::random(8));
            }

            if (empty($case->case_date)) {
                $case->case_date = today();
            }

            // Auto-calculate priority score
            $case->priority_score = $case->calculatePriorityScore();
        });
    }

    /**
     * Relationships
     */
    public function beneficiary()
    {
        return $this->belongsTo(Member::class, 'beneficiary_id');
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function visits()
    {
        return $this->hasMany(WelfareVisit::class, 'case_id');
    }

    public function transactions()
    {
        return $this->hasMany(WelfareFundTransaction::class, 'case_id');
    }

    public function impactAssessments()
    {
        return $this->hasMany(WelfareImpactAssessment::class, 'case_id');
    }

    public function committeeDecisions()
    {
        return $this->hasMany(WelfareCommitteeDecision::class, 'case_id');
    }

    /**
     * Get category display name.
     */
    public function getCategoryDisplayAttribute(): string
    {
        return self::CATEGORIES[$this->case_category] ?? ucfirst(str_replace('_', ' ', $this->case_category));
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'blue',
            'under_review' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'disbursed' => 'purple',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get priority badge color.
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'gray',
            'medium' => 'blue',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get outstanding balance.
     */
    public function getOutstandingBalanceAttribute(): float
    {
        return max(0, $this->amount_approved - $this->amount_disbursed);
    }

    /**
     * Calculate priority score.
     */
    public function calculatePriorityScore(): int
    {
        $score = 0;

        // Category weight
        $categoryWeights = [
            'emergency' => 40,
            'medical' => 35,
            'bereavement' => 30,
            'housing' => 25,
            'food' => 20,
            'education' => 15,
            'job_loss' => 20,
            'other' => 10,
        ];
        $score += $categoryWeights[$this->case_category] ?? 10;

        // Priority weight
        $priorityWeights = [
            'critical' => 40,
            'high' => 30,
            'medium' => 20,
            'low' => 10,
        ];
        $score += $priorityWeights[$this->priority] ?? 10;

        // Amount requested (scaled)
        if ($this->amount_requested) {
            $score += min(20, ($this->amount_requested / 1000) * 5);
        }

        return (int) $score;
    }

    /**
     * Mark as under review.
     */
    public function markUnderReview(): self
    {
        $this->update(['status' => 'under_review']);

        return $this;
    }

    /**
     * Verify case.
     */
    public function verify(int $verifiedBy, ?string $notes = null): self
    {
        $this->update([
            'verification_status' => 'verified',
            'verification_notes' => $notes,
            'verified_by' => $verifiedBy,
            'verified_at' => now(),
        ]);

        return $this;
    }

    /**
     * Reject verification.
     */
    public function rejectVerification(int $verifiedBy, string $notes): self
    {
        $this->update([
            'verification_status' => 'rejected',
            'verification_notes' => $notes,
            'verified_by' => $verifiedBy,
            'verified_at' => now(),
            'status' => 'rejected',
        ]);

        return $this;
    }

    /**
     * Approve case.
     */
    public function approve(float $approvedAmount, int $approvedBy, ?string $notes = null): self
    {
        $this->update([
            'status' => 'approved',
            'amount_approved' => $approvedAmount,
            'approved_by' => $approvedBy,
            'approved_at' => now(),
            'approval_notes' => $notes,
        ]);

        return $this;
    }

    /**
     * Reject case.
     */
    public function reject(string $reason): self
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return $this;
    }

    /**
     * Record disbursement.
     */
    public function recordDisbursement(float $amount): self
    {
        $newDisbursed = $this->amount_disbursed + $amount;

        $this->update([
            'amount_disbursed' => $newDisbursed,
            'status' => $newDisbursed >= $this->amount_approved ? 'disbursed' : 'approved',
        ]);

        return $this;
    }

    /**
     * Close case.
     */
    public function close(): self
    {
        $this->update([
            'status' => 'closed',
            'closed_date' => today(),
        ]);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeDisbursed($query)
    {
        return $query->where('status', 'disbursed');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('case_category', $category);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'critical']);
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopePendingVerification($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopePendingDisbursement($query)
    {
        return $query->where('status', 'approved')
            ->whereColumn('amount_disbursed', '<', 'amount_approved');
    }
}
