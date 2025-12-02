<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'note_type',
        'title',
        'content',
        'visibility',
        'is_sensitive',
        'created_by',
    ];

    protected $casts = [
        'is_sensitive' => 'boolean',
    ];

    /**
     * Note types.
     */
    public const NOTE_TYPES = [
        'pastoral' => 'Pastoral Care',
        'counselling' => 'Counselling Session',
        'disciplinary' => 'Disciplinary Action',
        'award' => 'Award/Recognition',
        'general' => 'General Note',
        'follow_up' => 'Follow-up',
        'visit' => 'Home Visit',
        'phone_call' => 'Phone Call',
    ];

    /**
     * Visibility levels.
     */
    public const VISIBILITY_LEVELS = [
        'private' => 'Private (Creator Only)',
        'pastors_only' => 'Pastors Only',
        'staff' => 'All Staff',
    ];

    /**
     * Relationships
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get note type display name.
     */
    public function getNoteTypeDisplayAttribute(): string
    {
        return self::NOTE_TYPES[$this->note_type] ?? ucfirst(str_replace('_', ' ', $this->note_type));
    }

    /**
     * Get visibility display name.
     */
    public function getVisibilityDisplayAttribute(): string
    {
        return self::VISIBILITY_LEVELS[$this->visibility] ?? ucfirst($this->visibility);
    }

    /**
     * Get note icon.
     */
    public function getNoteIconAttribute(): string
    {
        return match ($this->note_type) {
            'pastoral' => 'heart',
            'counselling' => 'user-check',
            'disciplinary' => 'alert-triangle',
            'award' => 'award',
            'follow_up' => 'clock',
            'visit' => 'home',
            'phone_call' => 'phone',
            default => 'file-text',
        };
    }

    /**
     * Get note color.
     */
    public function getNoteColorAttribute(): string
    {
        return match ($this->note_type) {
            'pastoral' => 'blue',
            'counselling' => 'green',
            'disciplinary' => 'red',
            'award' => 'yellow',
            'follow_up' => 'purple',
            'visit' => 'indigo',
            'phone_call' => 'cyan',
            default => 'gray',
        };
    }

    /**
     * Check if user can view this note.
     */
    public function canView(User $user): bool
    {
        // Creator can always view
        if ($this->created_by === $user->id) {
            return true;
        }

        // Check visibility level
        return match ($this->visibility) {
            'private' => false,
            'pastors_only' => in_array($user->role, ['admin', 'pastor']),
            'staff' => in_array($user->role, ['admin', 'pastor', 'staff']),
            default => false,
        };
    }

    /**
     * Check if user can edit this note.
     */
    public function canEdit(User $user): bool
    {
        // Only creator or admin can edit
        return $this->created_by === $user->id || $user->role === 'admin';
    }

    /**
     * Get excerpt of content.
     */
    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 100);
    }

    /**
     * Query Scopes
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('note_type', $type);
    }

    public function scopeByVisibility($query, string $visibility)
    {
        return $query->where('visibility', $visibility);
    }

    public function scopeSensitive($query)
    {
        return $query->where('is_sensitive', true);
    }

    public function scopeViewableBy($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('created_by', $user->id)
                ->orWhere(function ($q2) use ($user) {
                    if ($user->role === 'admin') {
                        // Admin can see all
                        return;
                    } elseif ($user->role === 'pastor') {
                        $q2->whereIn('visibility', ['pastors_only', 'staff']);
                    } elseif ($user->role === 'staff') {
                        $q2->where('visibility', 'staff');
                    }
                });
        });
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
