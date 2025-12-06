<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role',
        'phone',
        'avatar_url',
        'is_active',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a pastor.
     */
    public function isPastor(): bool
    {
        return $this->role === 'pastor';
    }

    /**
     * Check if user is a staff member.
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Check if user is a regular member.
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Check if user can approve transactions.
     */
    public function canApproveTransactions(): bool
    {
        return in_array($this->role, ['admin', 'pastor']);
    }

    /**
     * Check if user can manage settings.
     */
    public function canManageSettings(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the member associated with this user.
     */
    public function member()
    {
        return $this->hasOne(Member::class);
    }

    /**
     * Get the media team member profile associated with this user.
     */
    public function mediaTeamMember()
    {
        return $this->hasOne(MediaTeamMember::class);
    }

    /**
     * Get transactions created by this user.
     */
    public function transactionsCreated()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    /**
     * Get transactions approved by this user.
     */
    public function transactionsApproved()
    {
        return $this->hasMany(Transaction::class, 'approved_by');
    }

    /**
     * Get SMS broadcasts created by this user.
     */
    public function smsBroadcasts()
    {
        return $this->hasMany(SmsBroadcast::class, 'created_by');
    }

    /**
     * Get audit logs for this user.
     */
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Update last login timestamp.
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Scope query to only active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope query by role.
     */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}
