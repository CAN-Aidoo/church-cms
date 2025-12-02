<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SmsBroadcast;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SmsBroadcastController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Display a listing of SMS broadcasts.
     */
    public function index(Request $request)
    {
        $query = SmsBroadcast::with('sender');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('message', 'like', '%'.$request->search.'%');
            });
        }

        $broadcasts = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get statistics
        $stats = [
            'total' => SmsBroadcast::count(),
            'draft' => SmsBroadcast::where('status', 'draft')->count(),
            'scheduled' => SmsBroadcast::where('status', 'scheduled')->count(),
            'sending' => SmsBroadcast::where('status', 'sending')->count(),
            'completed' => SmsBroadcast::where('status', 'completed')->count(),
            'failed' => SmsBroadcast::where('status', 'failed')->count(),
        ];

        return view('sms.index', compact('broadcasts', 'stats'));
    }

    /**
     * Show the form for creating a new SMS broadcast.
     */
    public function create()
    {
        // Get member counts by category for recipient selection
        $recipientOptions = [
            'all_members' => Member::where('member_status', 'active')->count(),
            'pending_members' => Member::where('member_status', 'pending')->count(),
            'birthdays_today' => Member::whereDay('date_of_birth', today()->day)
                ->whereMonth('date_of_birth', today()->month)
                ->where('member_status', 'active')
                ->count(),
            'birthdays_this_week' => Member::whereBetween('date_of_birth', function ($query) {
                $query->selectRaw('DATE_FORMAT(?, "%m-%d")', [today()->startOfWeek()])
                    ->selectRaw('DATE_FORMAT(?, "%m-%d")', [today()->endOfWeek()]);
            })->where('member_status', 'active')->count(),
        ];

        // Get unique values for custom filters
        $genders = Member::distinct()->pluck('gender');
        $maritalStatuses = Member::distinct()->whereNotNull('marital_status')->pluck('marital_status');

        return view('sms.create', compact('recipientOptions', 'genders', 'maritalStatuses'));
    }

    /**
     * Store a newly created SMS broadcast.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1600',
            'recipient_type' => 'required|in:all_members,pending_members,custom,birthdays_today,birthdays_this_week,specific_members',
            'recipient_filter' => 'nullable|array',
            'specific_member_ids' => 'nullable|array',
            'specific_member_ids.*' => 'exists:members,id',
            'schedule_type' => 'required|in:send_now,schedule',
            'scheduled_at' => 'nullable|required_if:schedule_type,schedule|date|after:now',
        ]);

        // Get recipients based on selection
        $recipients = $this->getRecipients(
            $validated['recipient_type'],
            $validated['recipient_filter'] ?? [],
            $validated['specific_member_ids'] ?? []
        );

        if ($recipients->isEmpty()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No recipients match your selection criteria.');
        }

        // Calculate cost estimate (assuming GHS 0.05 per SMS)
        $messageLength = strlen($validated['message']);
        $segmentsPerSms = $messageLength <= 160 ? 1 : ceil($messageLength / 153);
        $totalRecipients = $recipients->count();
        $totalSms = $totalRecipients * $segmentsPerSms;
        $estimatedCost = $totalSms * 0.05;

        // Create broadcast record
        $broadcast = SmsBroadcast::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'recipient_type' => $validated['recipient_type'],
            'recipient_filter' => ! empty($validated['recipient_filter']) ? json_encode($validated['recipient_filter']) : null,
            'recipient_count' => $totalRecipients,
            'status' => $validated['schedule_type'] === 'send_now' ? 'pending' : 'scheduled',
            'scheduled_at' => $validated['schedule_type'] === 'schedule' ? $validated['scheduled_at'] : null,
            'sent_by' => Auth::id(),
            'estimated_cost' => $estimatedCost,
            'message_segments' => $segmentsPerSms,
        ]);

        // Store recipients
        $recipientData = $recipients->map(function ($member) use ($broadcast) {
            return [
                'sms_broadcast_id' => $broadcast->id,
                'member_id' => $member->id,
                'phone_number' => $member->phone,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::table('sms_recipients')->insert($recipientData);

        // If send now, dispatch to queue
        if ($validated['schedule_type'] === 'send_now') {
            $message = 'SMS broadcast created and queued for sending.';
            // TODO: Dispatch job to send SMS
            // SendSmsBroadcast::dispatch($broadcast);
        } else {
            $message = 'SMS broadcast scheduled for '.$broadcast->scheduled_at->format('M d, Y H:i');
        }

        return redirect()
            ->route('sms.show', $broadcast)
            ->with('success', $message);
    }

    /**
     * Display the specified SMS broadcast.
     */
    public function show(SmsBroadcast $broadcast)
    {
        $broadcast->load('sender');

        // Get recipient statistics
        $recipientStats = DB::table('sms_recipients')
            ->where('sms_broadcast_id', $broadcast->id)
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent'),
                DB::raw('SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')
            )
            ->first();

        // Get recent recipients (for display)
        $recentRecipients = DB::table('sms_recipients')
            ->join('members', 'sms_recipients.member_id', '=', 'members.id')
            ->where('sms_recipients.sms_broadcast_id', $broadcast->id)
            ->select('members.first_name', 'members.last_name', 'sms_recipients.phone_number', 'sms_recipients.status', 'sms_recipients.sent_at', 'sms_recipients.error_message')
            ->orderBy('sms_recipients.sent_at', 'desc')
            ->limit(50)
            ->get();

        return view('sms.show', compact('broadcast', 'recipientStats', 'recentRecipients'));
    }

    /**
     * Send a scheduled broadcast immediately.
     */
    public function send(SmsBroadcast $broadcast)
    {
        if ($broadcast->status !== 'scheduled' && $broadcast->status !== 'draft' && $broadcast->status !== 'pending') {
            return redirect()
                ->route('sms.show', $broadcast)
                ->with('error', 'This broadcast cannot be sent at this time.');
        }

        $broadcast->update([
            'status' => 'pending',
            'scheduled_at' => null,
        ]);

        // TODO: Dispatch job to send SMS
        // SendSmsBroadcast::dispatch($broadcast);

        return redirect()
            ->route('sms.show', $broadcast)
            ->with('success', 'SMS broadcast queued for sending.');
    }

    /**
     * Get broadcast status (for AJAX polling).
     */
    public function status(SmsBroadcast $broadcast)
    {
        $recipientStats = DB::table('sms_recipients')
            ->where('sms_broadcast_id', $broadcast->id)
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent'),
                DB::raw('SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')
            )
            ->first();

        return response()->json([
            'broadcast' => [
                'status' => $broadcast->status,
                'sent_count' => $broadcast->sent_count,
                'failed_count' => $broadcast->failed_count,
                'actual_cost' => $broadcast->actual_cost,
            ],
            'recipients' => $recipientStats,
        ]);
    }

    /**
     * Get recipients based on selection criteria.
     */
    protected function getRecipients(string $type, array $filters, array $specificIds)
    {
        $query = Member::where('member_status', 'active')->whereNotNull('phone');

        switch ($type) {
            case 'all_members':
                // Already filtered to active members with phone
                break;

            case 'pending_members':
                $query->where('status', 'pending');
                break;

            case 'birthdays_today':
                $query->whereDay('date_of_birth', today()->day)
                    ->whereMonth('date_of_birth', today()->month);
                break;

            case 'birthdays_this_week':
                $startOfWeek = today()->startOfWeek();
                $endOfWeek = today()->endOfWeek();

                $query->where(function ($q) use ($startOfWeek, $endOfWeek) {
                    for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
                        $q->orWhere(function ($subQ) use ($date) {
                            $subQ->whereDay('date_of_birth', $date->day)
                                ->whereMonth('date_of_birth', $date->month);
                        });
                    }
                });
                break;

            case 'custom':
                // Apply custom filters
                if (! empty($filters['gender'])) {
                    $query->where('gender', $filters['gender']);
                }

                if (! empty($filters['marital_status'])) {
                    $query->where('marital_status', $filters['marital_status']);
                }

                if (! empty($filters['age_min'])) {
                    $maxDate = today()->subYears($filters['age_min']);
                    $query->where('date_of_birth', '<=', $maxDate);
                }

                if (! empty($filters['age_max'])) {
                    $minDate = today()->subYears($filters['age_max'] + 1)->addDay();
                    $query->where('date_of_birth', '>=', $minDate);
                }

                if (! empty($filters['membership_type'])) {
                    $query->where('membership_type', $filters['membership_type']);
                }
                break;

            case 'specific_members':
                $query->whereIn('id', $specificIds);
                break;
        }

        return $query->select('id', 'first_name', 'last_name', 'phone')->get();
    }
}
