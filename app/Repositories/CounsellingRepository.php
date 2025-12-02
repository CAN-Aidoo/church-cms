<?php

namespace App\Repositories;

use App\Models\CounsellingCase;
use App\Models\CounsellingResource;
use App\Models\CounsellingSession;
use App\Models\Counsellor;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CounsellingRepository
{
    /**
     * Get all counsellors with filters.
     */
    public function getCounsellors(array $filters = [])
    {
        $query = Counsellor::with('user');

        if (isset($filters['active'])) {
            $query->where('is_active', $filters['active']);
        }

        if (isset($filters['availability_status'])) {
            $query->where('availability_status', $filters['availability_status']);
        }

        if (isset($filters['specialization'])) {
            $query->specializingIn($filters['specialization']);
        }

        if (isset($filters['accepting_bookings'])) {
            $query->acceptingBookings();
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get available counsellors for a session type.
     */
    public function getAvailableCounsellors(string $sessionType, Carbon $date): Collection
    {
        return Counsellor::with('user')
            ->active()
            ->specializingIn($sessionType)
            ->underCapacity()
            ->get()
            ->filter(function ($counsellor) use ($date) {
                return ! empty($counsellor->getAvailableSlots($date));
            });
    }

    /**
     * Create counselling session.
     */
    public function createSession(array $data): CounsellingSession
    {
        $data['booked_by'] = $data['booked_by'] ?? auth()->id();
        $data['status'] = $data['status'] ?? 'scheduled';

        return CounsellingSession::create($data);
    }

    /**
     * Get sessions with filters.
     */
    public function getSessions(array $filters = [])
    {
        $query = CounsellingSession::with(['member', 'counsellor.user']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['session_type'])) {
            $query->byType($filters['session_type']);
        }

        if (isset($filters['member_id'])) {
            $query->byMember($filters['member_id']);
        }

        if (isset($filters['counsellor_id'])) {
            $query->byCounsellor($filters['counsellor_id']);
        }

        if (isset($filters['urgency'])) {
            $query->byUrgency($filters['urgency']);
        }

        if (isset($filters['upcoming'])) {
            $query->upcoming();
        }

        if (isset($filters['past'])) {
            $query->past();
        }

        if (isset($filters['today'])) {
            $query->today();
        }

        if (isset($filters['this_week'])) {
            $query->thisWeek();
        }

        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $query->whereBetween('session_date', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->orderBy('session_date', 'desc')
            ->orderBy('session_time', 'desc')
            ->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get today's sessions.
     */
    public function getTodaysSessions(): Collection
    {
        return CounsellingSession::with(['member', 'counsellor.user'])
            ->today()
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->orderBy('session_time')
            ->get();
    }

    /**
     * Get upcoming sessions for a member.
     */
    public function getMemberUpcomingSessions(Member $member): Collection
    {
        return CounsellingSession::with('counsellor.user')
            ->byMember($member->id)
            ->upcoming()
            ->orderBy('session_date')
            ->orderBy('session_time')
            ->get();
    }

    /**
     * Get session history for a member.
     */
    public function getMemberSessionHistory(Member $member, int $limit = 10): Collection
    {
        return CounsellingSession::with('counsellor.user')
            ->byMember($member->id)
            ->completed()
            ->latest('session_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Create or get case for member.
     */
    public function createCase(array $data): CounsellingCase
    {
        $data['opened_by'] = $data['opened_by'] ?? auth()->id();
        $data['opened_date'] = $data['opened_date'] ?? today();
        $data['status'] = $data['status'] ?? 'open';

        return CounsellingCase::create($data);
    }

    /**
     * Get cases with filters.
     */
    public function getCases(array $filters = [])
    {
        $query = CounsellingCase::with(['member', 'primaryCounsellor.user']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['priority'])) {
            $query->byPriority($filters['priority']);
        }

        if (isset($filters['counsellor_id'])) {
            $query->byCounsellor($filters['counsellor_id']);
        }

        if (isset($filters['member_id'])) {
            $query->byMember($filters['member_id']);
        }

        if (isset($filters['overdue'])) {
            $query->overdue();
        }

        return $query->orderBy('priority', 'desc')
            ->orderBy('opened_date', 'desc')
            ->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get active cases.
     */
    public function getActiveCases(): Collection
    {
        return CounsellingCase::with(['member', 'primaryCounsellor.user'])
            ->whereIn('status', ['open', 'active'])
            ->orderBy('priority', 'desc')
            ->get();
    }

    /**
     * Get counsellor's active cases.
     */
    public function getCounsellorActiveCases(Counsellor $counsellor): Collection
    {
        return CounsellingCase::with('member')
            ->byCounsellor($counsellor->id)
            ->whereIn('status', ['open', 'active'])
            ->orderBy('priority', 'desc')
            ->get();
    }

    /**
     * Get resources with filters.
     */
    public function getResources(array $filters = [])
    {
        $query = CounsellingResource::with('creator');

        if (isset($filters['resource_type'])) {
            $query->byType($filters['resource_type']);
        }

        if (isset($filters['category'])) {
            $query->byCategory($filters['category']);
        }

        if (isset($filters['is_public'])) {
            $query->where('is_public', $filters['is_public']);
        }

        if (isset($filters['is_featured'])) {
            $query->featured();
        }

        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get public resources.
     */
    public function getPublicResources(array $filters = []): Collection
    {
        $query = CounsellingResource::public();

        if (isset($filters['category'])) {
            $query->byCategory($filters['category']);
        }

        if (isset($filters['resource_type'])) {
            $query->byType($filters['resource_type']);
        }

        if (isset($filters['featured'])) {
            $query->featured();
        }

        return $query->orderBy('views_count', 'desc')->get();
    }

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStatistics(): array
    {
        return [
            'total_counsellors' => Counsellor::active()->count(),
            'available_counsellors' => Counsellor::available()->count(),
            'todays_sessions' => CounsellingSession::today()->count(),
            'upcoming_sessions' => CounsellingSession::upcoming()->count(),
            'active_cases' => CounsellingCase::whereIn('status', ['open', 'active'])->count(),
            'high_priority_cases' => CounsellingCase::highPriority()->whereIn('status', ['open', 'active'])->count(),
            'sessions_this_week' => CounsellingSession::thisWeek()->count(),
            'completed_this_month' => CounsellingSession::completed()
                ->whereMonth('session_date', now()->month)
                ->count(),
            'sessions_by_type' => CounsellingSession::whereMonth('session_date', now()->month)
                ->selectRaw('session_type, COUNT(*) as count')
                ->groupBy('session_type')
                ->pluck('count', 'session_type')
                ->toArray(),
            'sessions_requiring_followup' => CounsellingSession::requiringFollowUp()->count(),
        ];
    }

    /**
     * Get counsellor statistics.
     */
    public function getCounsellorStatistics(Counsellor $counsellor, ?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $startDate = $startDate ?? now()->subMonths(3);
        $endDate = $endDate ?? now();

        $sessions = CounsellingSession::byCounsellor($counsellor->id)
            ->whereBetween('session_date', [$startDate, $endDate])
            ->get();

        return [
            'total_sessions' => $sessions->count(),
            'completed_sessions' => $sessions->where('status', 'completed')->count(),
            'cancelled_sessions' => $sessions->where('status', 'cancelled')->count(),
            'no_show_sessions' => $sessions->where('status', 'no_show')->count(),
            'active_cases' => CounsellingCase::byCounsellor($counsellor->id)
                ->whereIn('status', ['open', 'active'])
                ->count(),
            'closed_cases' => CounsellingCase::byCounsellor($counsellor->id)
                ->closed()
                ->whereBetween('closed_date', [$startDate, $endDate])
                ->count(),
            'sessions_by_type' => $sessions->groupBy('session_type')->map->count()->toArray(),
            'average_rating' => $sessions->filter(fn ($s) => $s->feedback)
                ->avg(fn ($s) => $s->feedback->rating),
            'workload_percentage' => $counsellor->workload_percentage,
        ];
    }

    /**
     * Get counselling report.
     */
    public function getCounsellingReport(Carbon $startDate, Carbon $endDate): array
    {
        $sessions = CounsellingSession::whereBetween('session_date', [$startDate, $endDate])->get();
        $cases = CounsellingCase::whereBetween('opened_date', [$startDate, $endDate])->get();

        return [
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
            'sessions' => [
                'total' => $sessions->count(),
                'completed' => $sessions->where('status', 'completed')->count(),
                'cancelled' => $sessions->where('status', 'cancelled')->count(),
                'no_show' => $sessions->where('status', 'no_show')->count(),
                'by_type' => $sessions->groupBy('session_type')->map->count(),
                'by_mode' => $sessions->groupBy('mode')->map->count(),
                'by_urgency' => $sessions->groupBy('urgency_level')->map->count(),
            ],
            'cases' => [
                'total_opened' => $cases->count(),
                'total_active' => $cases->whereIn('status', ['open', 'active'])->count(),
                'total_closed' => $cases->where('status', 'closed')->count(),
                'by_priority' => $cases->groupBy('priority')->map->count(),
                'average_duration_days' => $cases->where('status', 'closed')->avg(fn ($c) => $c->duration_days),
            ],
            'unique_members_counselled' => $sessions->unique('member_id')->count(),
            'average_sessions_per_case' => $cases->avg('total_sessions'),
        ];
    }

    /**
     * Check slot availability.
     */
    public function isSlotAvailable(int $counsellorId, Carbon $date, string $time): bool
    {
        $counsellor = Counsellor::find($counsellorId);

        if (! $counsellor || ! $counsellor->isAvailableAt($date->copy()->setTimeFromTimeString($time))) {
            return false;
        }

        return ! CounsellingSession::byCounsellor($counsellorId)
            ->where('session_date', $date->toDateString())
            ->where('session_time', $time)
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->exists();
    }

    /**
     * Find best available counsellor.
     */
    public function findBestCounsellor(string $sessionType, Carbon $preferredDate, ?string $genderPreference = null): ?Counsellor
    {
        $counsellors = Counsellor::active()
            ->specializingIn($sessionType)
            ->acceptingBookings()
            ->underCapacity()
            ->get();

        // Filter by gender preference if specified
        if ($genderPreference) {
            $counsellors = $counsellors->filter(function ($counsellor) use ($genderPreference) {
                return $counsellor->user->gender === $genderPreference;
            });
        }

        // Sort by workload (lowest first)
        $counsellors = $counsellors->sortBy('workload_percentage');

        // Find first counsellor with available slots
        foreach ($counsellors as $counsellor) {
            if (! empty($counsellor->getAvailableSlots($preferredDate))) {
                return $counsellor;
            }
        }

        return null;
    }
}
