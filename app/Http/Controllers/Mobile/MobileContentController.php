<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ChurchInfo;
use App\Models\Program;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MobileContentController extends Controller
{
    /**
     * Get public announcements for mobile app.
     */
    public function getAnnouncements(Request $request)
    {
        $category = $request->input('category'); // general, event, emergency, maintenance
        $limit = $request->input('limit', 20);

        $query = Announcement::where('status', 'published')
            ->where('visibility', 'public')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            });

        if ($category) {
            $query->where('category', $category);
        }

        $announcements = $query->orderBy('priority', 'desc')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'announcements' => $announcements->map(function ($announcement) {
                    return [
                        'id' => $announcement->id,
                        'title' => $announcement->title,
                        'content' => $announcement->content,
                        'category' => $announcement->category,
                        'priority' => $announcement->priority,
                        'published_at' => $announcement->published_at,
                        'expires_at' => $announcement->expires_at,
                        'image_url' => $announcement->image_url,
                        'action_button' => $announcement->action_button ? [
                            'text' => $announcement->action_button_text,
                            'url' => $announcement->action_button_url,
                        ] : null,
                        'is_pinned' => $announcement->is_pinned,
                        'is_urgent' => $announcement->priority === 'urgent',
                    ];
                }),
                'categories' => [
                    'general' => $announcements->where('category', 'general')->count(),
                    'event' => $announcements->where('category', 'event')->count(),
                    'emergency' => $announcements->where('category', 'emergency')->count(),
                ],
            ],
        ]);
    }

    /**
     * Get service times and schedule.
     */
    public function getServiceTimes(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $period = $request->input('period', 'week'); // day, week, month

        $startDate = match ($period) {
            'day' => Carbon::parse($date),
            'week' => Carbon::parse($date)->startOfWeek(),
            'month' => Carbon::parse($date)->startOfMonth(),
            default => Carbon::parse($date)->startOfWeek(),
        };

        $endDate = match ($period) {
            'day' => Carbon::parse($date),
            'week' => Carbon::parse($date)->endOfWeek(),
            'month' => Carbon::parse($date)->endOfMonth(),
            default => Carbon::parse($date)->endOfWeek(),
        };

        // Get scheduled services
        $services = Service::whereBetween('service_date', [$startDate, $endDate])
            ->orderBy('service_date')
            ->orderBy('service_time')
            ->get();

        // Get regular service schedule from church settings
        $regularSchedule = $this->getRegularServiceSchedule();

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $period,
                'date_range' => [
                    'start' => $startDate->format('Y-m-d'),
                    'end' => $endDate->format('Y-m-d'),
                ],
                'services' => $services->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'title' => $service->title,
                        'type' => $service->service_type,
                        'date' => $service->service_date,
                        'time' => $service->service_time,
                        'duration_minutes' => $service->duration_minutes,
                        'location' => $service->location,
                        'speaker' => $service->speaker_name,
                        'theme' => $service->theme,
                        'is_online' => $service->is_online_available,
                        'online_url' => $service->online_url,
                        'description' => $service->description,
                    ];
                }),
                'regular_schedule' => $regularSchedule,
                'today_services' => $services->filter(function ($service) {
                    return Carbon::parse($service->service_date)->isToday();
                })->values(),
            ],
        ]);
    }

    /**
     * Get church information.
     */
    public function getChurchInfo(Request $request)
    {
        $info = ChurchInfo::first();

        if (! $info) {
            $info = $this->getDefaultChurchInfo();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'church' => [
                    'name' => $info->name ?? config('app.name'),
                    'tagline' => $info->tagline,
                    'description' => $info->description,
                    'logo_url' => $info->logo_url,
                    'banner_url' => $info->banner_url,
                ],
                'contact' => [
                    'phone' => $info->phone,
                    'email' => $info->email,
                    'website' => $info->website,
                    'whatsapp' => $info->whatsapp_number,
                ],
                'location' => [
                    'address' => $info->address,
                    'city' => $info->city,
                    'country' => $info->country,
                    'latitude' => $info->latitude,
                    'longitude' => $info->longitude,
                    'google_maps_url' => $info->google_maps_url,
                    'directions' => $info->directions_instructions,
                ],
                'social_media' => [
                    'facebook' => $info->facebook_url,
                    'twitter' => $info->twitter_url,
                    'instagram' => $info->instagram_url,
                    'youtube' => $info->youtube_url,
                ],
                'facilities' => [
                    'has_parking' => $info->has_parking,
                    'is_wheelchair_accessible' => $info->is_wheelchair_accessible,
                    'has_nursery' => $info->has_nursery,
                    'has_wifi' => $info->has_wifi,
                ],
                'service_times_summary' => $this->getServiceTimesSummary(),
            ],
        ]);
    }

    /**
     * Get upcoming events and programs.
     */
    public function getUpcomingEvents(Request $request)
    {
        $category = $request->input('category'); // conference, seminar, retreat, etc.
        $limit = $request->input('limit', 20);

        $query = Program::where('status', 'published')
            ->where('start_date', '>=', now())
            ->orderBy('start_date');

        if ($category) {
            $query->where('category', $category);
        }

        $programs = $query->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'events' => $programs->map(function ($program) {
                    $isRegistrationOpen = $program->registration_start_date <= now() &&
                                         $program->registration_end_date >= now();

                    $spotsAvailable = null;
                    if ($program->max_participants) {
                        $registered = $program->registrations()->count();
                        $spotsAvailable = $program->max_participants - $registered;
                    }

                    return [
                        'id' => $program->id,
                        'code' => $program->program_code,
                        'name' => $program->name,
                        'description' => $program->description,
                        'category' => $program->category,
                        'start_date' => $program->start_date,
                        'end_date' => $program->end_date,
                        'location' => $program->location,
                        'venue' => $program->venue,
                        'flyer_url' => $program->flyer_url,
                        'registration' => [
                            'is_open' => $isRegistrationOpen,
                            'start_date' => $program->registration_start_date,
                            'end_date' => $program->registration_end_date,
                            'fee' => $program->registration_fee,
                            'max_participants' => $program->max_participants,
                            'spots_available' => $spotsAvailable,
                            'requires_approval' => $program->requires_approval,
                        ],
                        'contact' => [
                            'coordinator' => $program->coordinator_name,
                            'phone' => $program->coordinator_phone,
                            'email' => $program->coordinator_email,
                        ],
                        'days_until' => now()->diffInDays($program->start_date),
                        'is_featured' => $program->is_featured,
                    ];
                }),
                'summary' => [
                    'total_upcoming' => $programs->count(),
                    'this_week' => $programs->filter(function ($p) {
                        return Carbon::parse($p->start_date)->isCurrentWeek();
                    })->count(),
                    'this_month' => $programs->filter(function ($p) {
                        return Carbon::parse($p->start_date)->isCurrentMonth();
                    })->count(),
                ],
                'categories_available' => $programs->pluck('category')->unique()->values(),
            ],
        ]);
    }

    /**
     * Get event details by ID.
     */
    public function getEventDetails(Request $request, int $eventId)
    {
        $program = Program::with(['sessions', 'speakers'])->find($eventId);

        if (! $program) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ], 404);
        }

        $user = $request->user();
        $isRegistered = false;

        if ($user && $user->member) {
            $isRegistered = $program->registrations()
                ->where('member_id', $user->member->id)
                ->exists();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'event' => [
                    'id' => $program->id,
                    'code' => $program->program_code,
                    'name' => $program->name,
                    'description' => $program->description,
                    'full_description' => $program->full_description,
                    'category' => $program->category,
                    'start_date' => $program->start_date,
                    'end_date' => $program->end_date,
                    'location' => $program->location,
                    'venue' => $program->venue,
                    'flyer_url' => $program->flyer_url,
                ],
                'sessions' => $program->sessions->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'title' => $session->title,
                        'description' => $session->description,
                        'date' => $session->session_date,
                        'start_time' => $session->start_time,
                        'end_time' => $session->end_time,
                        'speaker' => $session->speaker_name,
                        'location' => $session->location,
                    ];
                }),
                'speakers' => $program->speakers->map(function ($speaker) {
                    return [
                        'name' => $speaker->name,
                        'title' => $speaker->title,
                        'bio' => $speaker->bio,
                        'photo_url' => $speaker->photo_url,
                    ];
                }),
                'registration_status' => [
                    'is_registered' => $isRegistered,
                    'can_register' => ! $isRegistered && $program->registration_start_date <= now() &&
                                     $program->registration_end_date >= now(),
                    'registration_fee' => $program->registration_fee,
                ],
            ],
        ]);
    }

    /**
     * Search content (announcements, events, services).
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'nullable|in:all,announcements,events,services',
        ]);

        $query = $validated['query'];
        $type = $validated['type'] ?? 'all';

        $results = [
            'announcements' => [],
            'events' => [],
            'services' => [],
        ];

        if (in_array($type, ['all', 'announcements'])) {
            $results['announcements'] = Announcement::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get()
                ->map(fn ($a) => [
                    'id' => $a->id,
                    'title' => $a->title,
                    'excerpt' => substr($a->content, 0, 150),
                    'type' => 'announcement',
                ]);
        }

        if (in_array($type, ['all', 'events'])) {
            $results['events'] = Program::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'title' => $p->name,
                    'date' => $p->start_date,
                    'type' => 'event',
                ]);
        }

        if (in_array($type, ['all', 'services'])) {
            $results['services'] = Service::where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('theme', 'like', "%{$query}%")
                    ->orWhere('speaker_name', 'like', "%{$query}%");
            })
                ->where('service_date', '>=', now())
                ->limit(10)
                ->get()
                ->map(fn ($s) => [
                'id' => $s->id,
                'title' => $s->title,
                'date' => $s->service_date,
                'time' => $s->service_time,
                'type' => 'service',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'query' => $query,
                'results' => $results,
                'total_results' => collect($results)->flatten(1)->count(),
            ],
        ]);
    }

    /**
     * Get regular service schedule from settings.
     */
    private function getRegularServiceSchedule(): array
    {
        return [
            'sunday' => [
                ['time' => '07:00', 'name' => 'First Service'],
                ['time' => '09:30', 'name' => 'Second Service'],
                ['time' => '17:00', 'name' => 'Evening Service'],
            ],
            'wednesday' => [
                ['time' => '18:00', 'name' => 'Midweek Service'],
            ],
            'friday' => [
                ['time' => '18:00', 'name' => 'Prayer & Fasting'],
            ],
        ];
    }

    /**
     * Get service times summary.
     */
    private function getServiceTimesSummary(): string
    {
        return 'Sundays: 7:00am, 9:30am, 5:00pm | Wednesdays: 6:00pm | Fridays: 6:00pm';
    }

    /**
     * Get default church info.
     */
    private function getDefaultChurchInfo(): object
    {
        return (object) [
            'name' => config('app.name'),
            'tagline' => 'A Place to Call Home',
            'description' => 'Welcome to our church family',
            'phone' => '+233 XX XXX XXXX',
            'email' => 'info@church.com',
            'address' => 'Church Address',
            'city' => 'City',
            'country' => 'Ghana',
        ];
    }
}
