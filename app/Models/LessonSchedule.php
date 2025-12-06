<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'curriculum_lesson_id',
        'teacher_id',
        'service_id',
        'scheduled_date',
        'scheduled_time',
        'classroom',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function lesson()
    {
        return $this->belongsTo(CurriculumLesson::class, 'curriculum_lesson_id');
    }

    public function teacher()
    {
        return $this->belongsTo(ChildrensMinistryTeacher::class, 'teacher_id');
    }

    public function service()
    {
        return $this->belongsTo(ServiceSchedule::class, 'service_id');
    }

    /**
     * Mark as completed.
     */
    public function complete(): self
    {
        $this->update(['status' => 'completed']);

        return $this;
    }

    /**
     * Mark as cancelled.
     */
    public function cancel(): self
    {
        $this->update(['status' => 'cancelled']);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', today())
            ->where('status', 'scheduled');
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('scheduled_date', $date);
    }

    public function scopeByClassroom($query, string $classroom)
    {
        return $query->where('classroom', $classroom);
    }
}
