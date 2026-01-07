<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'member_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'work_email',
        'phone',
        'whatsapp_phone',
        'alternate_phone',
        'date_of_birth',
        'gender',
        'marital_status',
        'occupation',
        'workplace',
        'education_level',
        'blood_group',
        'allergies',
        'medical_conditions',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'gps_location',
        'profile_photo_url',
        'photo_url',
        'bio',
        'join_date',
        'member_status',
        'status',
        'department',
        'emergency_contact_name',
        'emergency_contact_phone',
        'last_contact_date',
        'referral_source',
        'notes',
        'is_baptized',
        'baptism_date',
        'baptism_location',
        'is_holy_spirit_baptized',
        'holy_spirit_baptism_date',
        'spiritual_gifts',
        'ministry_involvement',
        'custom_fields',
        'family_id',
        'spouse_id',
        'shepherd_id',
        'created_by',
        'member_qr_code',
        'last_qr_scan',
        'qr_scan_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'join_date' => 'date',
        'last_contact_date' => 'date',
        'baptism_date' => 'date',
        'holy_spirit_baptism_date' => 'date',
        'is_baptized' => 'boolean',
        'is_holy_spirit_baptized' => 'boolean',
        'spiritual_gifts' => 'array',
        'ministry_involvement' => 'array',
        'custom_fields' => 'array',
        'last_qr_scan' => 'datetime',
    ];

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the age attribute.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Get the user account associated with this member.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who created this member record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all attendance records for this member.
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get all transactions for this member.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the shepherd for this member.
     */
    public function shepherd(): BelongsTo
    {
        return $this->belongsTo(Shepherd::class);
    }

    /**
     * Get the shepherd role if this member is a shepherd.
     */
    public function shepherdRole(): HasMany
    {
        return $this->hasMany(Shepherd::class);
    }

    /**
     * Scope query to only active members.
     */
    public function scopeActive($query)
    {
        return $query->where('member_status', 'active');
    }

    /**
     * Scope query to only inactive members.
     */
    public function scopeInactive($query)
    {
        return $query->where('member_status', 'inactive');
    }

    /**
     * Scope query to only pending members.
     */
    public function scopePending($query)
    {
        return $query->where('member_status', 'pending');
    }

    /**
     * Scope query by gender.
     */
    public function scopeGender($query, string $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope query by marital status.
     */
    public function scopeMaritalStatus($query, string $status)
    {
        return $query->where('marital_status', $status);
    }

    /**
     * Scope query for members with birthdays in a given month.
     */
    public function scopeBirthdayMonth($query, int $month)
    {
        return $query->whereMonth('date_of_birth', $month);
    }

    /**
     * Scope query for members with birthdays today.
     */
    public function scopeBirthdayToday($query)
    {
        return $query->whereMonth('date_of_birth', now()->month)
            ->whereDay('date_of_birth', now()->day);
    }

    /**
     * Scope query for new members (within last N days).
     */
    public function scopeNewMembers($query, int $days = 30)
    {
        return $query->where('join_date', '>=', now()->subDays($days));
    }

    /**
     * Search members by name, email, or phone.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Get attendance statistics for this member.
     */
    public function getAttendanceStats()
    {
        $totalServices = $this->attendance()->count();
        $presentCount = $this->attendance()->where('status', 'present')->count();

        return [
            'total_services' => $totalServices,
            'present_count' => $presentCount,
            'absent_count' => $this->attendance()->where('status', 'absent')->count(),
            'excused_count' => $this->attendance()->where('status', 'excused')->count(),
            'attendance_percentage' => $totalServices > 0
                ? round(($presentCount / $totalServices) * 100, 2)
                : 0,
        ];
    }

    /**
     * Get financial summary for this member.
     */
    public function getFinancialSummary()
    {
        $tithes = $this->transactions()
            ->where('transaction_type', 'tithe')
            ->where('status', 'completed')
            ->sum('amount');

        $offerings = $this->transactions()
            ->where('transaction_type', 'offering')
            ->where('status', 'completed')
            ->sum('amount');

        $donations = $this->transactions()
            ->where('transaction_type', 'donation')
            ->where('status', 'completed')
            ->sum('amount');

        return [
            'tithes' => $tithes,
            'offerings' => $offerings,
            'donations' => $donations,
            'total_given' => $tithes + $offerings + $donations,
            'total_tithes' => $tithes,  // Backward compatibility
            'total_offerings' => $offerings,  // Backward compatibility
            'total_donations' => $donations,  // Backward compatibility
        ];
    }

    /**
     * Check if member has attended in the last N days.
     */
    public function hasRecentAttendance(int $days = 30): bool
    {
        return $this->attendance()
            ->where('status', 'present')
            ->where('service_date', '>=', now()->subDays($days))
            ->exists();
    }

    /**
     * Get the family this member belongs to.
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get the spouse of this member.
     */
    public function spouse()
    {
        return $this->belongsTo(Member::class, 'spouse_id');
    }

    /**
     * Get members documents.
     */
    public function documents()
    {
        return $this->hasMany(MemberDocument::class);
    }

    /**
     * Get member lifecycle events.
     */
    public function lifecycleEvents()
    {
        return $this->hasMany(MemberLifecycleEvent::class);
    }

    /**
     * Get member notes.
     */
    public function notes()
    {
        return $this->hasMany(MemberNote::class);
    }

    /**
     * Get service units member belongs to.
     */
    public function serviceUnits()
    {
        return $this->belongsToMany(ServiceUnit::class, 'member_service_unit')
            ->withPivot('role', 'joined_date', 'left_date', 'is_active')
            ->withTimestamps();
    }

    /**
     * Get active service units.
     */
    public function activeServiceUnits()
    {
        return $this->serviceUnits()->wherePivot('is_active', true);
    }

    /**
     * Get photo versions.
     */
    public function photoVersions()
    {
        return $this->hasMany(MemberPhotoVersion::class);
    }

    /**
     * Get transfers.
     */
    public function transfers()
    {
        return $this->hasMany(MemberTransfer::class);
    }

    /**
     * Get full name with middle name.
     */
    public function getFullNameWithMiddleAttribute(): string
    {
        $parts = array_filter([$this->first_name, $this->middle_name, $this->last_name]);

        return implode(' ', $parts);
    }

    /**
     * Check if member is married.
     */
    public function isMarried(): bool
    {
        return $this->marital_status === 'married';
    }

    /**
     * Check if member has spouse in system.
     */
    public function hasSpouse(): bool
    {
        return ! is_null($this->spouse_id);
    }

    /**
     * Record lifecycle event.
     */
    public function recordLifecycleEvent(
        string $eventType,
        $eventDate = null,
        ?string $location = null,
        ?string $details = null,
        ?array $metadata = null
    ): MemberLifecycleEvent {
        return MemberLifecycleEvent::recordEvent(
            $this,
            $eventType,
            $eventDate,
            $location,
            $details,
            $metadata
        );
    }

    /**
     * Add note to member.
     */
    public function addNote(
        string $noteType,
        string $title,
        string $content,
        string $visibility = 'pastors_only',
        bool $isSensitive = false
    ): MemberNote {
        return $this->notes()->create([
            'note_type' => $noteType,
            'title' => $title,
            'content' => $content,
            'visibility' => $visibility,
            'is_sensitive' => $isSensitive,
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * Upload document.
     */
    public function uploadDocument(
        string $documentType,
        string $documentName,
        string $filePath,
        string $fileType,
        int $fileSize,
        ?array $additionalData = null
    ): MemberDocument {
        return $this->documents()->create(array_merge([
            'document_type' => $documentType,
            'document_name' => $documentName,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'uploaded_by' => auth()->id(),
        ], $additionalData ?? []));
    }

    /**
     * Scope for members with families.
     */
    public function scopeWithFamily($query)
    {
        return $query->with('family');
    }

    /**
     * Scope for baptized members.
     */
    public function scopeBaptized($query)
    {
        return $query->where('is_baptized', true);
    }

    /**
     * Scope for members not baptized.
     */
    public function scopeNotBaptized($query)
    {
        return $query->where('is_baptized', false);
    }
}
