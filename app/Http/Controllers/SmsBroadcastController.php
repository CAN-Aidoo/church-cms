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

    /**
     * Get SMS templates (AJAX endpoint).
     */
    public function getTemplates()
    {
        $templates = [
            'birthday' => [
                'name' => 'Birthday Greeting',
                'message' => 'Happy Birthday {first_name}! May God bless you abundantly on your special day. Enjoy your celebration! - {church_name}',
                'variables' => ['first_name', 'church_name']
            ],
            'welcome' => [
                'name' => 'New Member Welcome',
                'message' => 'Welcome to {church_name}, {first_name}! We are blessed to have you as part of our family. See you this Sunday!',
                'variables' => ['first_name', 'church_name']
            ],
            'reminder' => [
                'name' => 'Service Reminder',
                'message' => 'Reminder: {service_name} today at {service_time}. Location: {church_address}. We look forward to seeing you!',
                'variables' => ['service_name', 'service_time', 'church_address']
            ],
            'announcement' => [
                'name' => 'General Announcement',
                'message' => '{announcement_text} For more info, contact us at {contact_number}. God bless! - {church_name}',
                'variables' => ['announcement_text', 'contact_number', 'church_name']
            ],
            'prayer' => [
                'name' => 'Prayer Meeting',
                'message' => 'Join us for prayer meeting {day} at {time}. "The prayer of a righteous person is powerful and effective." - James 5:16',
                'variables' => ['day', 'time']
            ],
            'giving' => [
                'name' => 'Giving Receipt',
                'message' => 'Thank you {first_name} for your generous gift of GHS {amount}. "God loves a cheerful giver" - 2 Cor 9:7. Receipt: {receipt_number}',
                'variables' => ['first_name', 'amount', 'receipt_number']
            ],
        ];

        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }

    /**
     * Preview message with variable substitution (AJAX endpoint).
     */
    public function previewMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'sample_member_id' => 'nullable|exists:members,id'
        ]);

        $message = $validated['message'];
        $sampleMember = null;

        if (isset($validated['sample_member_id'])) {
            $sampleMember = Member::find($validated['sample_member_id']);
        } else {
            // Use first active member as sample
            $sampleMember = Member::where('member_status', 'active')->first();
        }

        // Substitute variables
        $preview = $this->substituteVariables($message, $sampleMember);

        // Calculate segments
        $length = strlen($preview);
        $segments = $length <= 160 ? 1 : ceil($length / 153);

        return response()->json([
            'success' => true,
            'preview' => $preview,
            'original' => $message,
            'length' => $length,
            'segments' => $segments,
            'sample_member' => $sampleMember ? $sampleMember->full_name : null
        ]);
    }

    /**
     * Get delivery statistics (AJAX endpoint).
     */
    public function deliveryStats(Request $request)
    {
        $days = $request->input('days', 30);
        $startDate = now()->subDays($days);

        $stats = [
            'total_sent' => SmsBroadcast::where('status', 'completed')
                ->where('created_at', '>=', $startDate)
                ->sum('sent_count'),
            'total_failed' => SmsBroadcast::where('created_at', '>=', $startDate)
                ->sum('failed_count'),
            'total_cost' => SmsBroadcast::where('status', 'completed')
                ->where('created_at', '>=', $startDate)
                ->sum('actual_cost'),
            'broadcasts_sent' => SmsBroadcast::where('status', 'completed')
                ->where('created_at', '>=', $startDate)
                ->count(),
            'success_rate' => 0,
        ];

        $totalAttempted = $stats['total_sent'] + $stats['total_failed'];
        if ($totalAttempted > 0) {
            $stats['success_rate'] = round(($stats['total_sent'] / $totalAttempted) * 100, 2);
        }

        // Daily breakdown
        $dailyStats = SmsBroadcast::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(sent_count) as sent, SUM(failed_count) as failed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'daily_breakdown' => $dailyStats
        ]);
    }

    /**
     * Validate phone numbers (AJAX endpoint).
     */
    public function validatePhones(Request $request)
    {
        $validated = $request->validate([
            'phone_numbers' => 'required|array',
            'phone_numbers.*' => 'string'
        ]);

        $results = [];
        foreach ($validated['phone_numbers'] as $phone) {
            $results[] = [
                'phone' => $phone,
                'valid' => $this->isValidPhoneNumber($phone),
                'formatted' => $this->formatPhoneNumber($phone)
            ];
        }

        $validCount = collect($results)->where('valid', true)->count();

        return response()->json([
            'success' => true,
            'results' => $results,
            'valid_count' => $validCount,
            'invalid_count' => count($results) - $validCount
        ]);
    }

    /**
     * Get character count and segment info (AJAX endpoint).
     */
    public function getMessageInfo(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string'
        ]);

        $message = $validated['message'];
        $length = strlen($message);
        $segments = $length <= 160 ? 1 : ceil($length / 153);
        $remaining = $segments === 1 ? (160 - $length) : (($segments * 153) - $length);

        return response()->json([
            'success' => true,
            'length' => $length,
            'segments' => $segments,
            'remaining' => $remaining,
            'max_length' => 1600,
            'warning' => $segments > 3 ? 'Long message may incur additional costs' : null
        ]);
    }

    /**
     * Substitute variables in message.
     */
    protected function substituteVariables(string $message, $member = null): string
    {
        if (!$member) {
            return $message;
        }

        $variables = [
            '{first_name}' => $member->first_name ?? '',
            '{last_name}' => $member->last_name ?? '',
            '{full_name}' => $member->full_name ?? '',
            '{church_name}' => config('app.name', 'Our Church'),
            '{church_address}' => config('church.address', ''),
            '{contact_number}' => config('church.phone', ''),
        ];

        return str_replace(array_keys($variables), array_values($variables), $message);
    }

    /**
     * Validate phone number format.
     */
    protected function isValidPhoneNumber(string $phone): bool
    {
        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        // Check if it's a valid Ghana phone number (10 digits starting with 0, or with country code)
        return preg_match('/^(0[0-9]{9}|233[0-9]{9}|\+233[0-9]{9})$/', $cleaned);
    }

    /**
     * Format phone number to standard format.
     */
    protected function formatPhoneNumber(string $phone): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        // Convert to international format
        if (strlen($cleaned) === 10 && $cleaned[0] === '0') {
            return '+233' . substr($cleaned, 1);
        } elseif (strlen($cleaned) === 12 && substr($cleaned, 0, 3) === '233') {
            return '+' . $cleaned;
        } elseif (strlen($cleaned) === 13 && $cleaned[0] === '+') {
            return $cleaned;
        }

        return $phone;
    }
}
