<?php

namespace App\Repositories;

use App\Models\PrayerCategory;
use App\Models\PrayerGroup;
use App\Models\PrayerRequest;
use App\Models\PrayerTestimony;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PrayerRepository
{
    /**
     * Get all prayer requests with filters.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = PrayerRequest::with(['member', 'category', 'assignedIntercessor'])
            ->withCount('assignments');

        // Apply filters
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['urgency'])) {
            $query->where('urgency', $filters['urgency']);
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['privacy_level'])) {
            $query->where('privacy_level', $filters['privacy_level']);
        }

        if (! empty($filters['intercessor_id'])) {
            $query->byIntercessor($filters['intercessor_id']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('request_title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('request_details', 'like', '%'.$filters['search'].'%')
                    ->orWhere('requester_name', 'like', '%'.$filters['search'].'%');
            });
        }

        // Default ordering
        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDir = $filters['order_dir'] ?? 'desc';
        $query->orderBy($orderBy, $orderDir);

        return $query->paginate(20);
    }

    /**
     * Get active prayer requests.
     */
    public function getActive(): Collection
    {
        return PrayerRequest::active()
            ->with(['category', 'member', 'assignedIntercessor'])
            ->orderByRaw("FIELD(urgency, 'critical', 'high', 'normal', 'low')")
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get urgent prayer requests.
     */
    public function getUrgent(): Collection
    {
        return PrayerRequest::urgent()
            ->active()
            ->with(['category', 'member'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get public prayer requests.
     */
    public function getPublic(int $limit = 20): Collection
    {
        return PrayerRequest::public()
            ->active()
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get prayer requests assigned to an intercessor.
     */
    public function getForIntercessor(int $intercessorId): Collection
    {
        return PrayerRequest::byIntercessor($intercessorId)
            ->active()
            ->with(['category', 'member'])
            ->orderBy('urgency', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get prayer requests needing attention.
     */
    public function getNeedingAttention(): Collection
    {
        return PrayerRequest::active()
            ->with(['category', 'member'])
            ->get()
            ->filter(fn ($request) => $request->needsAttention());
    }

    /**
     * Find prayer request by ID.
     */
    public function find(int $id): ?PrayerRequest
    {
        return PrayerRequest::with([
            'member',
            'category',
            'assignedIntercessor',
            'assignments.intercessor',
            'updates.updater',
            'testimonies',
        ])
            ->withCount('assignments')
            ->find($id);
    }

    /**
     * Create new prayer request.
     */
    public function create(array $data): PrayerRequest
    {
        return PrayerRequest::create($data);
    }

    /**
     * Update prayer request.
     */
    public function update(PrayerRequest $prayerRequest, array $data): bool
    {
        return $prayerRequest->update($data);
    }

    /**
     * Delete prayer request.
     */
    public function delete(PrayerRequest $prayerRequest): bool
    {
        return $prayerRequest->delete();
    }

    /**
     * Assign prayer request to intercessor.
     */
    public function assignToIntercessor(PrayerRequest $prayerRequest, int $intercessorId, ?string $notes = null): void
    {
        $prayerRequest->assignIntercessor($intercessorId, $notes);
        $prayerRequest->assign($intercessorId);
    }

    /**
     * Add update to prayer request.
     */
    public function addUpdate(PrayerRequest $prayerRequest, int $userId, string $updateText, string $updateType = 'note', bool $notifyRequester = false): void
    {
        $prayerRequest->addUpdate($userId, $updateText, $updateType, $notifyRequester);
    }

    /**
     * Mark prayer request as answered.
     */
    public function markAnswered(PrayerRequest $prayerRequest, ?string $testimony = null, bool $shareTestimony = false): bool
    {
        return $prayerRequest->markAnswered($testimony, $shareTestimony);
    }

    /**
     * Get all categories.
     */
    public function getCategories(): Collection
    {
        return PrayerCategory::active()->get();
    }

    /**
     * Get category statistics.
     */
    public function getCategoryStatistics(): Collection
    {
        return PrayerCategory::withCount([
            'prayerRequests',
            'prayerRequests as active_requests_count' => function ($q) {
                $q->active();
            },
        ])->get();
    }

    /**
     * Get prayer groups.
     */
    public function getGroups(array $filters = []): Collection
    {
        $query = PrayerGroup::with(['leader', 'activeMembers'])
            ->withCount('activeMembers');

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * Get prayer group by ID.
     */
    public function findGroup(int $id): ?PrayerGroup
    {
        return PrayerGroup::with(['leader', 'members', 'meetings'])
            ->withCount('members')
            ->find($id);
    }

    /**
     * Get testimonies.
     */
    public function getTestimonies(array $filters = []): LengthAwarePaginator
    {
        $query = PrayerTestimony::with(['member', 'prayerRequest']);

        if (isset($filters['is_approved'])) {
            $query->where('is_approved', $filters['is_approved']);
        }

        if (isset($filters['share_publicly'])) {
            $query->where('share_publicly', $filters['share_publicly']);
        }

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('testimony', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->orderBy('testimony_date', 'desc')->paginate(20);
    }

    /**
     * Get public testimonies.
     */
    public function getPublicTestimonies(int $limit = 10): Collection
    {
        return PrayerTestimony::public()
            ->with(['member'])
            ->recent($limit)
            ->get();
    }

    /**
     * Create testimony.
     */
    public function createTestimony(array $data): PrayerTestimony
    {
        return PrayerTestimony::create($data);
    }

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStatistics(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total_active' => PrayerRequest::active()->count(),
            'pending' => PrayerRequest::pending()->count(),
            'praying' => PrayerRequest::praying()->count(),
            'answered_this_month' => PrayerRequest::answered()
                ->where('answered_at', '>=', $thisMonth)
                ->count(),
            'urgent' => PrayerRequest::urgent()->active()->count(),
            'new_today' => PrayerRequest::whereDate('created_at', $today)->count(),
            'new_this_week' => PrayerRequest::where('created_at', '>=', $thisWeek)->count(),
            'needs_attention' => PrayerRequest::active()->get()->filter(fn ($r) => $r->needsAttention())->count(),
            'active_intercessors' => PrayerRequest::active()
                ->whereNotNull('assigned_to')
                ->distinct('assigned_to')
                ->count('assigned_to'),
            'avg_response_time' => $this->getAverageResponseTime(),
        ];
    }

    /**
     * Get statistics by category.
     */
    public function getStatisticsByCategory(): Collection
    {
        return PrayerCategory::withCount([
            'prayerRequests as total' => function ($q) {
                // All time
            },
            'prayerRequests as active' => function ($q) {
                $q->active();
            },
            'prayerRequests as answered' => function ($q) {
                $q->answered();
            },
        ])->get();
    }

    /**
     * Get statistics by urgency.
     */
    public function getStatisticsByUrgency(): array
    {
        return [
            'critical' => PrayerRequest::where('urgency', 'critical')->active()->count(),
            'high' => PrayerRequest::where('urgency', 'high')->active()->count(),
            'normal' => PrayerRequest::where('urgency', 'normal')->active()->count(),
            'low' => PrayerRequest::where('urgency', 'low')->active()->count(),
        ];
    }

    /**
     * Get monthly statistics.
     */
    public function getMonthlyStatistics(int $months = 12): Collection
    {
        $startDate = Carbon::now()->subMonths($months)->startOfMonth();

        return collect(range(0, $months - 1))->map(function ($offset) use ($startDate) {
            $month = $startDate->copy()->addMonths($offset);
            $nextMonth = $month->copy()->addMonth();

            return [
                'month' => $month->format('M Y'),
                'new_requests' => PrayerRequest::whereBetween('created_at', [$month, $nextMonth])->count(),
                'answered' => PrayerRequest::answered()
                    ->whereBetween('answered_at', [$month, $nextMonth])
                    ->count(),
            ];
        });
    }

    /**
     * Get average response time (time from submission to assignment).
     */
    protected function getAverageResponseTime(): float
    {
        $assigned = PrayerRequest::whereNotNull('assigned_to')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->get();

        if ($assigned->isEmpty()) {
            return 0;
        }

        $totalHours = $assigned->sum(function ($request) {
            $assignment = $request->assignments()->first();
            if ($assignment) {
                return $request->created_at->diffInHours($assignment->assigned_at);
            }

            return 0;
        });

        return round($totalHours / $assigned->count(), 1);
    }

    /**
     * Get intercessor statistics.
     */
    public function getIntercessorStatistics(int $intercessorId): array
    {
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total_assigned' => PrayerRequest::byIntercessor($intercessorId)->count(),
            'active' => PrayerRequest::byIntercessor($intercessorId)->active()->count(),
            'answered' => PrayerRequest::byIntercessor($intercessorId)->answered()->count(),
            'this_month' => PrayerRequest::byIntercessor($intercessorId)
                ->where('created_at', '>=', $thisMonth)
                ->count(),
        ];
    }

    /**
     * Search prayer requests.
     */
    public function search(string $query, array $filters = []): Collection
    {
        $searchQuery = PrayerRequest::where(function ($q) use ($query) {
            $q->where('request_title', 'like', '%'.$query.'%')
                ->orWhere('request_details', 'like', '%'.$query.'%')
                ->orWhere('requester_name', 'like', '%'.$query.'%');
        });

        if (! empty($filters['status'])) {
            $searchQuery->where('status', $filters['status']);
        }

        if (! empty($filters['privacy_level'])) {
            $searchQuery->where('privacy_level', $filters['privacy_level']);
        }

        return $searchQuery->with(['category', 'member'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
    }
}
