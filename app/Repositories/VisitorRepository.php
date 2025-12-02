<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VisitorRepository
{
    /**
     * Get paginated visitors with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Visitor::query();

        // Apply date range filter
        if (isset($filters['date_from'])) {
            $query->where('visit_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('visit_date', '<=', $filters['date_to']);
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            // Status column doesn't strictly exist in schema as 'status',
            // but there is 'follow_up_status'.
            // Assuming 'status' in filter maps to 'follow_up_status' or logical status
            // For now, if it's 'active', we might mean unconverted?
            // Let's map 'status' to 'follow_up_status' if applicable.
            $query->where('follow_up_status', $filters['status']);
        }

        // Apply conversion filter
        if (isset($filters['converted'])) {
            if ($filters['converted'] === 'yes') {
                $query->whereNotNull('converted_member_id');
            } elseif ($filters['converted'] === 'no') {
                $query->whereNull('converted_member_id');
            }
        }

        // Apply visit count filter
        if (isset($filters['visit_count_min'])) {
            $query->where('visit_count', '>=', $filters['visit_count_min']);
        }
        if (isset($filters['visit_count_max'])) {
            $query->where('visit_count', '<=', $filters['visit_count_max']);
        }

        // Apply search filter
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        // Handle sort column mapping
        if ($sortBy === 'first_visit_date') {
            $sortBy = 'visit_date';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Find visitor by ID.
     */
    public function findById(int $id): ?Visitor
    {
        return Visitor::with('convertedMember')->find($id);
    }

    /**
     * Create visitor.
     */
    public function create(array $data): Visitor
    {
        $data['visit_date'] = $data['visit_date'] ?? now();
        // 'last_visit_date' does not exist in schema, remove it.
        $data['visit_count'] = 1;
        // 'status' does not exist, assuming default or follow_up_status default 'pending'

        return Visitor::create($data);
    }

    /**
     * Update visitor.
     */
    public function update(Visitor $visitor, array $data): bool
    {
        return $visitor->update($data);
    }

    /**
     * Delete visitor.
     */
    public function delete(Visitor $visitor): bool
    {
        return $visitor->delete();
    }

    /**
     * Record a new visit for visitor.
     */
    public function recordVisit(Visitor $visitor, ?Carbon $visitDate = null): bool
    {
        $visitDate = $visitDate ?? now();

        return $visitor->update([
            'visit_date' => $visitDate, // Updating the latest visit date
            'visit_count' => $visitor->visit_count + 1,
        ]);
    }

    /**
     * Get visitors eligible for conversion (5+ visits).
     */
    public function getEligibleForConversion(): Collection
    {
        return Visitor::where('visit_count', '>=', 5)
            ->whereNull('converted_member_id')
            // 'member_status' column doesn't exist, removing check or checking follow_up_status
            // ->where('member_status', 'active')
            ->orderBy('visit_count', 'desc')
            ->get();
    }

    /**
     * Get visitors needing follow-up.
     */
    public function getNeedingFollowUp(int $daysSinceLastVisit = 14): Collection
    {
        return Visitor::whereNull('converted_member_id')
            ->where('visit_date', '<=', now()->subDays($daysSinceLastVisit))
            ->where('visit_count', '>=', 2)
            ->orderBy('visit_date', 'asc')
            ->get();
    }

    /**
     * Get recent visitors.
     */
    public function getRecent(int $limit = 10): Collection
    {
        return Visitor::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get visitor statistics.
     */
    public function getStatistics(array $filters = []): array
    {
        $query = Visitor::query();

        // Apply date range
        if (isset($filters['date_from'])) {
            $query->where('visit_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('visit_date', '<=', $filters['date_to']);
        }

        $total = (clone $query)->count();
        // 'member_status' doesn't exist. Using follow_up_status != 'converted' or similar?
        // Or just total unconverted?
        $active = (clone $query)->whereNull('converted_member_id')->count();
        $converted = (clone $query)->whereNotNull('converted_member_id')->count();
        $eligibleForConversion = (clone $query)
            ->where('visit_count', '>=', 5)
            ->whereNull('converted_member_id')
            ->count();

        $averageVisits = (clone $query)->avg('visit_count');
        $conversionRate = $total > 0 ? round(($converted / $total) * 100, 2) : 0;

        return [
            'total_visitors' => $total,
            'active_visitors' => $active,
            'converted_to_members' => $converted,
            'eligible_for_conversion' => $eligibleForConversion,
            'average_visits' => round($averageVisits, 2),
            'conversion_rate' => $conversionRate,
        ];
    }

    /**
     * Get visitor trends (monthly).
     */
    public function getMonthlyTrends(int $months = 12): array
    {
        $trends = [];
        $startDate = now()->subMonths($months);

        for ($i = $months - 1; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();
            $monthKey = $monthStart->format('M Y');

            // Using created_at for "New Visitors" since visit_date changes
            $newVisitors = Visitor::whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $returnVisitors = Visitor::where('created_at', '<', $monthStart)
                ->whereBetween('visit_date', [$monthStart, $monthEnd])
                ->count();

            $conversions = Visitor::whereNotNull('converted_member_id')
                ->whereBetween('updated_at', [$monthStart, $monthEnd])
                ->count();

            $trends[$monthKey] = [
                'new_visitors' => $newVisitors,
                'return_visitors' => $returnVisitors,
                'conversions' => $conversions,
            ];
        }

        return $trends;
    }

    /**
     * Convert visitor to member.
     */
    public function convertToMember(Visitor $visitor, Member $member): bool
    {
        return $visitor->update([
            'converted_member_id' => $member->id,
            'follow_up_status' => 'converted',
        ]);
    }

    /**
     * Mark visitor as inactive.
     */
    public function markAsInactive(Visitor $visitor, ?string $reason = null): bool
    {
        return $visitor->update([
            'follow_up_status' => 'no_response', // Mapping inactive to no_response or creating new status if enum allows
            'notes' => ($visitor->notes ? $visitor->notes."\n" : '').'Marked inactive: '.$reason,
        ]);
    }

    /**
     * Get visitors by visit count range.
     */
    public function getByVisitCountRange(int $min, ?int $max = null): Collection
    {
        $query = Visitor::where('visit_count', '>=', $min);

        if ($max !== null) {
            $query->where('visit_count', '<=', $max);
        }

        return $query->orderBy('visit_count', 'desc')->get();
    }

    /**
     * Get first-time visitors (visit_count = 1).
     */
    public function getFirstTimeVisitors(?Carbon $startDate = null, ?Carbon $endDate = null): Collection
    {
        $query = Visitor::where('visit_count', 1);

        if ($startDate) {
            $query->where('visit_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('visit_date', '<=', $endDate);
        }

        return $query->orderBy('visit_date', 'desc')->get();
    }

    /**
     * Get repeat visitors (visit_count > 1).
     */
    public function getRepeatVisitors(?Carbon $startDate = null, ?Carbon $endDate = null): Collection
    {
        $query = Visitor::where('visit_count', '>', 1)
            ->whereNull('converted_member_id');

        if ($startDate) {
            $query->where('visit_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('visit_date', '<=', $endDate);
        }

        return $query->orderBy('visit_count', 'desc')->get();
    }

    /**
     * Search visitors by name, email, or phone.
     */
    public function search(string $query, int $limit = 10): Collection
    {
        return Visitor::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit($limit)
            ->get();
    }

    /**
     * Get visitors by referral source.
     */
    public function getByReferralSource(string $source): Collection
    {
        return Visitor::where('how_heard', $source)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get referral source breakdown.
     */
    public function getReferralSourceBreakdown(?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = Visitor::select('how_heard', DB::raw('COUNT(*) as count'))
            ->whereNotNull('how_heard')
            ->groupBy('how_heard')
            ->orderByDesc('count');

        if ($startDate) {
            $query->where('visit_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('visit_date', '<=', $endDate);
        }

        $results = $query->get();

        $breakdown = [];
        foreach ($results as $item) {
            $breakdown[$item->how_heard] = $item->count;
        }

        return $breakdown;
    }

    /**
     * Get visitors who haven't returned.
     */
    public function getNotReturned(int $daysSinceFirstVisit = 30): Collection
    {
        // "Haven't returned" implies visited once, long ago, and never came back.
        return Visitor::where('visit_count', 1)
            ->where('visit_date', '<=', now()->subDays($daysSinceFirstVisit))
            ->whereNull('converted_member_id')
            ->orderBy('visit_date', 'asc')
            ->get();
    }

    /**
     * Export visitors.
     */
    public function export(array $filters = []): Collection
    {
        $query = Visitor::with('convertedMember');

        // Apply filters (same as getPaginated but without pagination)
        if (isset($filters['date_from'])) {
            $query->where('visit_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('visit_date', '<=', $filters['date_to']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('follow_up_status', $filters['status']);
        }

        if (isset($filters['converted'])) {
            if ($filters['converted'] === 'yes') {
                $query->whereNotNull('converted_member_id');
            } elseif ($filters['converted'] === 'no') {
                $query->whereNull('converted_member_id');
            }
        }

        return $query->orderBy('visit_date', 'desc')->get();
    }

    /**
     * Get conversion funnel data.
     */
    public function getConversionFunnel(): array
    {
        $totalVisitors = Visitor::count();
        $visitedTwice = Visitor::where('visit_count', '>=', 2)->count();
        $visitedFiveTimes = Visitor::where('visit_count', '>=', 5)->count();
        $converted = Visitor::whereNotNull('converted_member_id')->count();

        return [
            'total_visitors' => $totalVisitors,
            'visited_twice' => $visitedTwice,
            'visited_five_times' => $visitedFiveTimes,
            'converted_to_members' => $converted,
            'conversion_percentage' => [
                'visited_twice' => $totalVisitors > 0 ? round(($visitedTwice / $totalVisitors) * 100, 2) : 0,
                'visited_five_times' => $totalVisitors > 0 ? round(($visitedFiveTimes / $totalVisitors) * 100, 2) : 0,
                'converted' => $totalVisitors > 0 ? round(($converted / $totalVisitors) * 100, 2) : 0,
            ],
        ];
    }
}
