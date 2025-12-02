<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Family extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'family_name',
        'family_code',
        'head_of_family_id',
        'family_address',
        'family_phone',
        'family_email',
        'family_photo_url',
        'wedding_anniversary',
        'family_notes',
    ];

    protected $casts = [
        'family_notes' => 'array',
        'wedding_anniversary' => 'date',
    ];

    /**
     * Boot method to auto-generate family code.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($family) {
            if (empty($family->family_code)) {
                $family->family_code = 'FAM-'.strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Relationships
     */
    public function headOfFamily()
    {
        return $this->belongsTo(Member::class, 'head_of_family_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    /**
     * Get all adult members in family.
     */
    public function adults()
    {
        return $this->members();
    }

    /**
     * Get family size (adults + children).
     */
    public function getFamilySizeAttribute(): int
    {
        return $this->members()->count() + $this->children()->count();
    }

    /**
     * Get total adults count.
     */
    public function getAdultsCountAttribute(): int
    {
        return $this->members()->count();
    }

    /**
     * Get total children count.
     */
    public function getChildrenCountAttribute(): int
    {
        return $this->children()->count();
    }

    /**
     * Get family attendance for a period.
     */
    public function getAttendanceForPeriod($startDate, $endDate)
    {
        $memberIds = $this->members()->pluck('id');

        return Attendance::whereIn('member_id', $memberIds)
            ->whereBetween('service_date', [$startDate, $endDate])
            ->get();
    }

    /**
     * Get family financial summary.
     */
    public function getFinancialSummary()
    {
        $memberIds = $this->members()->pluck('id');

        $tithes = Transaction::whereIn('member_id', $memberIds)
            ->where('type', 'income')
            ->where('category', 'tithe')
            ->where('status', 'completed')
            ->sum('amount');

        $offerings = Transaction::whereIn('member_id', $memberIds)
            ->where('type', 'income')
            ->where('category', 'offering')
            ->where('status', 'completed')
            ->sum('amount');

        return [
            'total_tithes' => $tithes,
            'total_offerings' => $offerings,
            'total_given' => $tithes + $offerings,
        ];
    }

    /**
     * Check if wedding anniversary is in given month.
     */
    public function hasAnniversaryInMonth(int $month): bool
    {
        return $this->wedding_anniversary && $this->wedding_anniversary->month === $month;
    }

    /**
     * Get years married.
     */
    public function getYearsMarriedAttribute(): ?int
    {
        return $this->wedding_anniversary ?
               $this->wedding_anniversary->diffInYears(now()) :
               null;
    }

    /**
     * Query Scopes
     */
    public function scopeWithHead($query)
    {
        return $query->with('headOfFamily');
    }

    public function scopeWithMembers($query)
    {
        return $query->with('members', 'children');
    }

    public function scopeAnniversaryMonth($query, int $month)
    {
        return $query->whereMonth('wedding_anniversary', $month);
    }

    public function scopeAnniversaryToday($query)
    {
        return $query->whereMonth('wedding_anniversary', now()->month)
            ->whereDay('wedding_anniversary', now()->day);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('family_name', 'like', '%'.$search.'%')
                ->orWhere('family_code', 'like', '%'.$search.'%')
                ->orWhereHas('headOfFamily', function ($q2) use ($search) {
                    $q2->where('first_name', 'like', '%'.$search.'%')
                        ->orWhere('last_name', 'like', '%'.$search.'%');
                });
        });
    }
}
