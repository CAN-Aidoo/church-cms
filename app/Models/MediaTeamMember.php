<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaTeamMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'primary_role', 'skills', 'availability', 'phone',
        'email', 'notes', 'is_active', 'joined_date',
    ];

    protected $casts = [
        'skills' => 'array',
        'availability' => 'array',
        'is_active' => 'boolean',
        'joined_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('primary_role', $role);
    }
}
