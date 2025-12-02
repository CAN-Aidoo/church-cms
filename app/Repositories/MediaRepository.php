<?php

namespace App\Repositories;

use App\Models\LiveStream;
use App\Models\MediaContent;
use App\Models\MediaTeamMember;

class MediaRepository
{
    public function getContent(array $filters = [])
    {
        $query = MediaContent::with(['uploader', 'editor']);

        if (isset($filters['content_type'])) {
            $query->byType($filters['content_type']);
        }
        if (isset($filters['is_published'])) {
            $query->where('is_published', $filters['is_published']);
        }

        return $query->recent()->paginate($filters['per_page'] ?? 20);
    }

    public function getStreams(array $filters = [])
    {
        $query = LiveStream::with('technician.user');

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('scheduled_start', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    public function getTeamMembers(array $filters = [])
    {
        $query = MediaTeamMember::with('user');

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }
        if (isset($filters['primary_role'])) {
            $query->byRole($filters['primary_role']);
        }

        return $query->paginate($filters['per_page'] ?? 20);
    }

    public function getDashboardStatistics(): array
    {
        return [
            'total_content' => MediaContent::published()->count(),
            'total_team_members' => MediaTeamMember::active()->count(),
            'upcoming_streams' => LiveStream::upcoming()->count(),
            'total_views' => MediaContent::published()->sum('views_count'),
        ];
    }
}
