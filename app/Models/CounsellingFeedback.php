<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounsellingFeedback extends Model
{
    use HasFactory;

    protected $table = 'counselling_feedback';

    protected $fillable = [
        'session_id',
        'member_id',
        'rating',
        'comments',
        'would_recommend',
        'helpful_aspects',
        'improvement_suggestions',
        'is_anonymous',
    ];

    protected $casts = [
        'rating' => 'integer',
        'would_recommend' => 'boolean',
        'helpful_aspects' => 'array',
        'improvement_suggestions' => 'array',
        'is_anonymous' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function session()
    {
        return $this->belongsTo(CounsellingSession::class, 'session_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get rating stars.
     */
    public function getRatingStarsAttribute(): string
    {
        return str_repeat('★', $this->rating).str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Query Scopes
     */
    public function scopeHighRating($query)
    {
        return $query->where('rating', '>=', 4);
    }

    public function scopeLowRating($query)
    {
        return $query->where('rating', '<=', 2);
    }
}
