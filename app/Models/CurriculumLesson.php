<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumLesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'series',
        'age_group',
        'bible_story',
        'bible_reference',
        'memory_verse',
        'lesson_objective',
        'lesson_content',
        'activities',
        'craft_projects',
        'resources',
        'duration_minutes',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'activities' => 'array',
        'craft_projects' => 'array',
        'resources' => 'array',
        'is_published' => 'boolean',
        'duration_minutes' => 'integer',
    ];

    /**
     * Age group labels.
     */
    public const AGE_GROUPS = [
        'nursery' => 'Nursery (0-2 years)',
        'toddlers' => 'Toddlers (3-4 years)',
        'beginners' => 'Beginners (5-6 years)',
        'primary' => 'Primary (7-9 years)',
        'juniors' => 'Juniors (10-12 years)',
        'teens' => 'Teens (13-17 years)',
    ];

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function schedules()
    {
        return $this->hasMany(LessonSchedule::class);
    }

    /**
     * Get age group display name.
     */
    public function getAgeGroupDisplayAttribute(): string
    {
        return self::AGE_GROUPS[$this->age_group] ?? ucfirst($this->age_group);
    }

    /**
     * Publish lesson.
     */
    public function publish(): self
    {
        $this->update(['is_published' => true]);

        return $this;
    }

    /**
     * Unpublish lesson.
     */
    public function unpublish(): self
    {
        $this->update(['is_published' => false]);

        return $this;
    }

    /**
     * Duplicate lesson.
     */
    public function duplicate(): self
    {
        $duplicate = $this->replicate();
        $duplicate->title = $this->title.' (Copy)';
        $duplicate->is_published = false;
        $duplicate->created_by = auth()->id();
        $duplicate->save();

        return $duplicate;
    }

    /**
     * Get total activities count.
     */
    public function getTotalActivitiesAttribute(): int
    {
        return count($this->activities ?? []) +
               count($this->craft_projects ?? []) +
               count($this->resources ?? []);
    }

    /**
     * Query Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByAgeGroup($query, string $ageGroup)
    {
        return $query->where('age_group', $ageGroup);
    }

    public function scopeBySeries($query, string $series)
    {
        return $query->where('series', $series);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%'.$search.'%')
                ->orWhere('bible_story', 'like', '%'.$search.'%')
                ->orWhere('bible_reference', 'like', '%'.$search.'%');
        });
    }
}
