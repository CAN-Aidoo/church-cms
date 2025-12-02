<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MemberRepository
{
    /**
     * Get all active members.
     */
    public function getActiveMembers(): Collection
    {
        return Member::active()->orderBy('first_name')->get();
    }

    /**
     * Get paginated members with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Member::query();

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('member_status', $filters['status']);
        } else {
            $query->active();
        }

        // Apply search filter (full-text search)
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $escapedSearch = addcslashes($search, '%_'); // Escape LIKE wildcards
            $query->where(function ($q) use ($search, $escapedSearch) {
                $q->whereRaw('MATCH(first_name, last_name, email) AGAINST(? IN NATURAL LANGUAGE MODE)', [$search])
                    ->orWhere('phone', 'like', DB::raw('CONCAT("%", ?, "%")'), [$escapedSearch])
                    ->orWhere('member_id', 'like', DB::raw('CONCAT("%", ?, "%")'), [$escapedSearch]);
            });
        }

        // Apply gender filter
        if (isset($filters['gender']) && $filters['gender'] !== '') {
            $query->where('gender', $filters['gender']);
        }

        // Apply age range filter
        if (isset($filters['age_min'])) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ?', [$filters['age_min']]);
        }
        if (isset($filters['age_max'])) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ?', [$filters['age_max']]);
        }

        // Apply marital status filter
        if (isset($filters['marital_status']) && $filters['marital_status'] !== '') {
            $query->where('marital_status', $filters['marital_status']);
        }

        // Apply join date range filter
        if (isset($filters['join_date_from'])) {
            $query->where('join_date', '>=', $filters['join_date_from']);
        }
        if (isset($filters['join_date_to'])) {
            $query->where('join_date', '<=', $filters['join_date_to']);
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'first_name';
        $sortOrder = $filters['sort_order'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Find member by ID.
     */
    public function findById(int $id): ?Member
    {
        return Member::find($id);
    }

    /**
     * Find member by member_id (unique identifier).
     */
    public function findByMemberId(string $memberId): ?Member
    {
        return Member::where('member_id', $memberId)->first();
    }

    /**
     * Find member by email.
     */
    public function findByEmail(string $email): ?Member
    {
        return Member::where('email', $email)->first();
    }

    /**
     * Create a new member.
     */
    public function create(array $data): Member
    {
        return DB::transaction(function () use ($data) {
            // Generate unique member_id if not provided
            if (! isset($data['member_id'])) {
                $data['member_id'] = $this->generateMemberId();
            }

            return Member::create($data);
        });
    }

    /**
     * Update a member.
     */
    public function update(Member $member, array $data): bool
    {
        return $member->update($data);
    }

    /**
     * Delete a member (soft delete).
     */
    public function delete(Member $member): bool
    {
        return $member->delete();
    }

    /**
     * Restore a soft-deleted member.
     */
    public function restore(int $id): bool
    {
        $member = Member::withTrashed()->find($id);

        return $member ? $member->restore() : false;
    }

    /**
     * Permanently delete a member.
     */
    public function forceDelete(Member $member): bool
    {
        return $member->forceDelete();
    }

    /**
     * Get members by status.
     */
    public function getByStatus(string $status): Collection
    {
        return Member::where('member_status', $status)
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Get members with birthdays in date range.
     */
    public function getUpcomingBirthdays(int $days = 30): Collection
    {
        return Member::active()
            ->whereNotNull('date_of_birth')
            ->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") >= DATE_FORMAT(CURDATE(), "%m-%d")')
            ->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") <= DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL ? DAY), "%m-%d")', [$days])
            ->orderByRaw('DATE_FORMAT(date_of_birth, "%m-%d")')
            ->get();
    }

    /**
     * Get members by department.
     */
    public function getByDepartment(string $department): Collection
    {
        return Member::active()
            ->where('department', $department)
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Get members with incomplete profiles.
     */
    public function getIncompleteProfiles(): Collection
    {
        return Member::active()
            ->where(function ($query) {
                $query->whereNull('photo_url')
                    ->orWhereNull('date_of_birth')
                    ->orWhereNull('phone')
                    ->orWhereNull('address');
            })
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Search members by name or email.
     */
    public function search(string $term): Collection
    {
        $escapedTerm = addcslashes($term, '%_'); // Escape LIKE wildcards

        return Member::active()
            ->where(function ($query) use ($term, $escapedTerm) {
                $query->whereRaw('MATCH(first_name, last_name, email) AGAINST(? IN NATURAL LANGUAGE MODE)', [$term])
                    ->orWhere('phone', 'like', DB::raw('CONCAT("%", ?, "%")'), [$escapedTerm])
                    ->orWhere('member_id', 'like', DB::raw('CONCAT("%", ?, "%")'), [$escapedTerm]);
            })
            ->limit(20)
            ->get();
    }

    /**
     * Get member statistics.
     */
    public function getStatistics(): array
    {
        $total = Member::count();
        $active = Member::active()->count();
        $inactive = Member::where('member_status', 'inactive')->count();
        $pending = Member::where('member_status', 'pending')->count();

        $maleCount = Member::active()->where('gender', 'male')->count();
        $femaleCount = Member::active()->where('gender', 'female')->count();

        $recentJoins = Member::where('join_date', '>=', now()->subMonths(1))->count();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'pending' => $pending,
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            'recent_joins' => $recentJoins,
        ];
    }

    /**
     * Generate unique member ID.
     */
    protected function generateMemberId(): string
    {
        $year = date('Y');
        $prefix = 'MEM';

        // Get the last member ID for the current year
        $lastMember = Member::where('member_id', 'like', "{$prefix}{$year}%")
            ->orderBy('member_id', 'desc')
            ->first();

        if ($lastMember) {
            // Extract the sequence number and increment
            $lastSequence = (int) substr($lastMember->member_id, -4);
            $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '0001';
        }

        return "{$prefix}{$year}{$newSequence}";
    }

    /**
     * Bulk update member status.
     */
    public function bulkUpdateStatus(array $memberIds, string $status): int
    {
        return Member::whereIn('id', $memberIds)->update(['member_status' => $status]);
    }

    /**
     * Get members without user accounts.
     */
    public function getMembersWithoutAccounts(): Collection
    {
        return Member::active()
            ->whereNull('user_id')
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Export members data.
     */
    public function export(array $filters = []): Collection
    {
        $query = Member::query();

        // Apply filters (same as getPaginated but without pagination)
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('member_status', $filters['status']);
        }

        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $escapedSearch = addcslashes($search, '%_'); // Escape LIKE wildcards
            $query->where(function ($q) use ($search, $escapedSearch) {
                $q->whereRaw('MATCH(first_name, last_name, email) AGAINST(? IN NATURAL LANGUAGE MODE)', [$search])
                    ->orWhere('phone', 'like', DB::raw('CONCAT("%", ?, "%")'), [$escapedSearch]);
            });
        }

        return $query->orderBy('first_name')->get();
    }
}
