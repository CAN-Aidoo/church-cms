<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'role',
        'joined_at',
        'last_read_at',
        'is_muted',
        'muted_until',
        'notifications_enabled',
        'is_active',
        'left_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'last_read_at' => 'datetime',
        'muted_until' => 'datetime',
        'left_at' => 'datetime',
        'is_muted' => 'boolean',
        'notifications_enabled' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
