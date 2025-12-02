<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'configuration',
        'columns',
        'filters',
        'group_by',
        'calculations',
        'chart_config',
        'is_template',
        'is_public',
        'created_by',
    ];

    protected $casts = [
        'configuration' => 'array',
        'columns' => 'array',
        'filters' => 'array',
        'calculations' => 'array',
        'chart_config' => 'array',
        'is_template' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * Boot method to auto-generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($report) {
            if (empty($report->slug)) {
                $report->slug = Str::slug($report->name);
            }
        });
    }

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function schedules()
    {
        return $this->hasMany(ReportSchedule::class);
    }

    public function executions()
    {
        return $this->hasMany(ReportExecution::class);
    }

    public function favorites()
    {
        return $this->hasMany(ReportFavorite::class);
    }

    /**
     * Check if user has favorited this report.
     */
    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    /**
     * Toggle favorite for user.
     */
    public function toggleFavorite(User $user): void
    {
        $favorite = $this->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            $this->favorites()->create(['user_id' => $user->id]);
        }
    }

    /**
     * Duplicate report.
     */
    public function duplicate(string $newName, ?int $userId = null): self
    {
        $duplicate = $this->replicate();
        $duplicate->name = $newName;
        $duplicate->slug = Str::slug($newName);
        $duplicate->is_template = false;
        $duplicate->created_by = $userId ?? auth()->id();
        $duplicate->save();

        return $duplicate;
    }

    /**
     * Get available fields for report type.
     */
    public static function getAvailableFields(string $type): array
    {
        return match ($type) {
            'membership' => [
                'id' => 'Member ID',
                'name' => 'Full Name',
                'email' => 'Email',
                'phone' => 'Phone',
                'gender' => 'Gender',
                'date_of_birth' => 'Date of Birth',
                'age' => 'Age',
                'marital_status' => 'Marital Status',
                'occupation' => 'Occupation',
                'status' => 'Status',
                'joined_at' => 'Join Date',
                'shepherd_name' => 'Shepherd',
                'service_units' => 'Service Units',
            ],
            'financial' => [
                'transaction_date' => 'Date',
                'type' => 'Type',
                'category' => 'Category',
                'amount' => 'Amount',
                'payment_method' => 'Payment Method',
                'member_name' => 'Member',
                'description' => 'Description',
                'status' => 'Status',
            ],
            'attendance' => [
                'service_date' => 'Service Date',
                'service_type' => 'Service Type',
                'member_name' => 'Member',
                'check_in_time' => 'Check-in Time',
                'check_in_method' => 'Check-in Method',
                'total_present' => 'Total Present',
            ],
            'program' => [
                'program_name' => 'Program',
                'category' => 'Category',
                'start_date' => 'Start Date',
                'end_date' => 'End Date',
                'status' => 'Status',
                'participants_count' => 'Participants',
                'attendance_rate' => 'Attendance Rate',
                'revenue' => 'Revenue',
                'expenses' => 'Expenses',
            ],
            default => [],
        };
    }

    /**
     * Get available filter operators.
     */
    public static function getFilterOperators(): array
    {
        return [
            'equals' => 'Equals',
            'not_equals' => 'Not Equals',
            'contains' => 'Contains',
            'starts_with' => 'Starts With',
            'ends_with' => 'Ends With',
            'greater_than' => 'Greater Than',
            'less_than' => 'Less Than',
            'between' => 'Between',
            'in' => 'In List',
            'is_null' => 'Is Empty',
            'is_not_null' => 'Is Not Empty',
        ];
    }

    /**
     * Get available calculation types.
     */
    public static function getCalculationTypes(): array
    {
        return [
            'sum' => 'Sum',
            'avg' => 'Average',
            'count' => 'Count',
            'min' => 'Minimum',
            'max' => 'Maximum',
        ];
    }

    /**
     * Query Scopes
     */
    public function scopeTemplates($query)
    {
        return $query->where('is_template', true);
    }

    public function scopeCustom($query)
    {
        return $query->where('is_template', false);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCreator($query, int $userId)
    {
        return $query->where('created_by', $userId);
    }
}
