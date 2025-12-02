<?php

namespace App\Repositories;

use App\Models\Program;
use App\Models\ProgramAttendance;
use App\Models\ProgramRegistration;
use App\Models\ProgramSession;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProgramRepository
{
    /**
     * Get all programs with optional filters.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Program::with(['creator', 'sessions'])
            ->withCount('registrations');

        // Apply filters
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%'.$filters['search'].'%')
                    ->orWhere('description', 'like', '%'.$filters['search'].'%');
            });
        }

        if (! empty($filters['date_from'])) {
            $query->where('start_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('end_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('start_date', 'desc')->paginate(20);
    }

    /**
     * Get upcoming programs.
     */
    public function getUpcoming(int $limit = 10): Collection
    {
        return Program::upcoming()
            ->with(['creator', 'sessions'])
            ->withCount('registrations')
            ->take($limit)
            ->get();
    }

    /**
     * Get ongoing programs.
     */
    public function getOngoing(): Collection
    {
        return Program::ongoing()
            ->with(['creator', 'sessions', 'registrations'])
            ->withCount('registrations')
            ->get();
    }

    /**
     * Get completed programs.
     */
    public function getCompleted(int $limit = 20): LengthAwarePaginator
    {
        return Program::completed()
            ->with(['creator'])
            ->withCount(['registrations', 'feedback'])
            ->paginate($limit);
    }

    /**
     * Find program by ID.
     */
    public function find(int $id): ?Program
    {
        return Program::with([
            'creator',
            'sessions',
            'registrations.member',
            'resources',
            'volunteers.member',
            'expenses',
            'announcements',
        ])
            ->withCount(['registrations', 'feedback'])
            ->find($id);
    }

    /**
     * Create new program.
     */
    public function create(array $data): Program
    {
        return Program::create($data);
    }

    /**
     * Update program.
     */
    public function update(Program $program, array $data): bool
    {
        return $program->update($data);
    }

    /**
     * Delete program.
     */
    public function delete(Program $program): bool
    {
        return $program->delete();
    }

    /**
     * Register participant for program.
     */
    public function registerParticipant(Program $program, array $data): ProgramRegistration
    {
        // Check capacity
        if (! $program->has_spots_available) {
            $data['status'] = 'waitlist';
        } else {
            $data['status'] = 'confirmed';
            $program->incrementParticipants();
        }

        $registration = $program->registrations()->create($data);

        // Generate badge number
        $registration->badge_number = 'BADGE-'.$program->id.'-'.str_pad($registration->id, 6, '0', STR_PAD_LEFT);
        $registration->save();

        return $registration;
    }

    /**
     * Confirm registration.
     */
    public function confirmRegistration(ProgramRegistration $registration): bool
    {
        if ($registration->status === 'pending' && $registration->program->has_spots_available) {
            $registration->confirm();
            $registration->program->incrementParticipants();

            return true;
        }

        return false;
    }

    /**
     * Cancel registration.
     */
    public function cancelRegistration(ProgramRegistration $registration): bool
    {
        if ($registration->cancel()) {
            if ($registration->status === 'confirmed') {
                $registration->program->decrementParticipants();
            }

            return true;
        }

        return false;
    }

    /**
     * Check in participant.
     */
    public function checkInParticipant(ProgramRegistration $registration): void
    {
        $registration->checkIn();
    }

    /**
     * Mark session attendance.
     */
    public function markSessionAttendance(ProgramSession $session, ProgramRegistration $registration, string $method = 'manual'): ProgramAttendance
    {
        $attendance = ProgramAttendance::create([
            'program_id' => $session->program_id,
            'session_id' => $session->id,
            'registration_id' => $registration->id,
            'checked_in_at' => now(),
            'attendance_method' => $method,
        ]);

        // Increment session attendance count
        $session->increment('current_attendees');

        return $attendance;
    }

    /**
     * Add session to program.
     */
    public function addSession(Program $program, array $data): ProgramSession
    {
        return $program->sessions()->create($data);
    }

    /**
     * Update session.
     */
    public function updateSession(ProgramSession $session, array $data): bool
    {
        return $session->update($data);
    }

    /**
     * Delete session.
     */
    public function deleteSession(ProgramSession $session): bool
    {
        return $session->delete();
    }

    /**
     * Get program statistics.
     */
    public function getStatistics(Program $program): array
    {
        return [
            'total_registrations' => $program->registrations()->count(),
            'confirmed_registrations' => $program->registrations()->where('status', 'confirmed')->count(),
            'waitlist_count' => $program->registrations()->where('status', 'waitlist')->count(),
            'attendance_rate' => $program->getAttendanceRate(),
            'total_revenue' => $program->total_revenue,
            'total_expenses' => $program->total_expenses,
            'net_revenue' => $program->net_revenue,
            'average_rating' => $program->average_rating,
            'feedback_count' => $program->feedback()->count(),
            'capacity_percentage' => $program->capacity_percentage,
        ];
    }

    /**
     * Get registration statistics.
     */
    public function getRegistrationStatistics(Program $program): array
    {
        $registrations = $program->registrations;

        return [
            'by_status' => $registrations->groupBy('status')->map->count(),
            'by_payment_status' => $registrations->groupBy('payment_status')->map->count(),
            'daily_registrations' => $registrations->groupBy(function ($reg) {
                return Carbon::parse($reg->registered_at)->format('Y-m-d');
            })->map->count(),
        ];
    }

    /**
     * Get attendance statistics.
     */
    public function getAttendanceStatistics(Program $program): array
    {
        $sessions = $program->sessions()->withCount('attendance')->get();
        $totalSessions = $sessions->count();
        $confirmedParticipants = $program->getConfirmedRegistrationsCount();

        return [
            'total_sessions' => $totalSessions,
            'sessions_completed' => $sessions->where('session_date', '<', Carbon::today())->count(),
            'overall_attendance_rate' => $program->getAttendanceRate(),
            'session_attendance' => $sessions->map(function ($session) use ($confirmedParticipants) {
                return [
                    'session_id' => $session->id,
                    'title' => $session->title,
                    'date' => $session->session_date->format('Y-m-d'),
                    'attendance_count' => $session->attendance_count,
                    'attendance_rate' => $confirmedParticipants > 0
                        ? ($session->attendance_count / $confirmedParticipants) * 100
                        : 0,
                ];
            }),
        ];
    }

    /**
     * Get feedback summary.
     */
    public function getFeedbackSummary(Program $program): array
    {
        $feedback = $program->feedback;

        return [
            'total_responses' => $feedback->count(),
            'average_overall' => $feedback->avg('overall_rating'),
            'average_content' => $feedback->avg('content_rating'),
            'average_organization' => $feedback->avg('organization_rating'),
            'average_venue' => $feedback->avg('venue_rating'),
            'would_recommend_percentage' => $feedback->count() > 0
                ? ($feedback->where('would_recommend', true)->count() / $feedback->count()) * 100
                : 0,
            'rating_distribution' => $feedback->groupBy('overall_rating')->map->count(),
        ];
    }

    /**
     * Publish program.
     */
    public function publish(Program $program): bool
    {
        return $program->publish();
    }

    /**
     * Start program.
     */
    public function start(Program $program): bool
    {
        return $program->start();
    }

    /**
     * Complete program.
     */
    public function complete(Program $program): bool
    {
        return $program->complete();
    }

    /**
     * Cancel program.
     */
    public function cancel(Program $program): bool
    {
        return $program->cancel();
    }

    /**
     * Get programs summary for dashboard.
     */
    public function getDashboardSummary(): array
    {
        return [
            'total' => Program::count(),
            'upcoming' => Program::upcoming()->count(),
            'ongoing' => Program::ongoing()->count(),
            'completed_this_year' => Program::completed()
                ->whereYear('end_date', Carbon::now()->year)
                ->count(),
            'total_participants_this_year' => ProgramRegistration::whereHas('program', function ($q) {
                $q->whereYear('start_date', Carbon::now()->year);
            })
                ->where('status', 'confirmed')
                ->count(),
        ];
    }
}
