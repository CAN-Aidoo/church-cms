<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramRegistration;
use App\Models\ProgramSession;
use App\Repositories\ProgramRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function __construct(
        protected ProgramRepository $programRepository
    ) {}

    /**
     * Display a listing of programs.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'type', 'category', 'search', 'date_from', 'date_to']);
        $programs = $this->programRepository->getAll($filters);
        $summary = $this->programRepository->getDashboardSummary();

        return view('programs.index', compact('programs', 'summary', 'filters'));
    }

    /**
     * Show the form for creating a new program.
     */
    public function create()
    {
        return view('programs.create');
    }

    /**
     * Store a newly created program.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:conference,seminar,crusade,retreat,workshop,training,other',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_gps' => 'nullable|string|max:100',
            'target_audience' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'registration_fee' => 'nullable|numeric|min:0',
            'requires_registration' => 'boolean',
            'flyer' => 'nullable|image|max:2048',
        ]);

        // Handle flyer upload using secure file upload service
        if ($request->hasFile('flyer')) {
            $fileUploadService = app(\App\Services\FileUploadService::class);
            $validated['flyer_path'] = $fileUploadService->uploadFile(
                $request->file('flyer'),
                'programs/flyers',
                'image'
            );
        }

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'draft';

        $program = $this->programRepository->create($validated);

        return redirect()
            ->route('programs.show', $program)
            ->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified program.
     */
    public function show(Program $program)
    {
        $program = $this->programRepository->find($program->id);
        $statistics = $this->programRepository->getStatistics($program);
        $registrationStats = $this->programRepository->getRegistrationStatistics($program);

        // QR Code Statistics
        $qrStats = [
            'registration_scans' => $program->registrations()
                ->whereNotNull('qr_scanned_at')->count(),
            'checkin_scans' => $program->registrations()
                ->where('check_in_method', 'qr')->count(),
            'recent_scans' => $program->registrations()
                ->where('check_in_method', 'qr')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('programs.show', compact('program', 'statistics', 'registrationStats', 'qrStats'));
    }

    /**
     * Show the form for editing the program.
     */
    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    /**
     * Update the specified program.
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_gps' => 'nullable|string|max:100',
            'target_audience' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'registration_fee' => 'nullable|numeric|min:0',
            'requires_registration' => 'boolean',
            'flyer' => 'nullable|image|max:2048',
        ]);

        // Handle flyer upload using secure file upload service
        if ($request->hasFile('flyer')) {
            // Delete old flyer
            if ($program->flyer_path) {
                $fileUploadService = app(\App\Services\FileUploadService::class);
                $fileUploadService->deleteFile($program->flyer_path);
            }
            $fileUploadService = app(\App\Services\FileUploadService::class);
            $validated['flyer_path'] = $fileUploadService->uploadFile(
                $request->file('flyer'),
                'programs/flyers',
                'image'
            );
        }

        $this->programRepository->update($program, $validated);

        return redirect()
            ->route('programs.show', $program)
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program.
     */
    public function destroy(Program $program)
    {
        $this->programRepository->delete($program);

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    /**
     * Publish program.
     */
    public function publish(Program $program)
    {
        if ($this->programRepository->publish($program)) {
            return redirect()
                ->back()
                ->with('success', 'Program published successfully.');
        }

        return redirect()->back()->with('error', 'Cannot publish this program.');
    }

    /**
     * Start program.
     */
    public function start(Program $program)
    {
        if ($this->programRepository->start($program)) {
            return redirect()
                ->back()
                ->with('success', 'Program started successfully.');
        }

        return redirect()->back()->with('error', 'Cannot start this program.');
    }

    /**
     * Complete program.
     */
    public function complete(Program $program)
    {
        if ($this->programRepository->complete($program)) {
            return redirect()
                ->back()
                ->with('success', 'Program marked as completed.');
        }

        return redirect()->back()->with('error', 'Cannot complete this program.');
    }

    /**
     * Cancel program.
     */
    public function cancel(Program $program)
    {
        if ($this->programRepository->cancel($program)) {
            return redirect()
                ->back()
                ->with('success', 'Program cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Cannot cancel this program.');
    }

    /**
     * Show registration form.
     */
    public function showRegistrationForm(Program $program)
    {
        if (! $program->canRegister()) {
            return redirect()
                ->route('programs.show', $program)
                ->with('error', 'Registration is not available for this program.');
        }

        return view('programs.register', compact('program'));
    }

    /**
     * Handle registration submission.
     */
    public function register(Request $request, Program $program)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'special_requirements' => 'nullable|string',
        ]);

        $validated['program_id'] = $program->id;
        $validated['amount_paid'] = $program->registration_fee;
        $validated['payment_status'] = $program->registration_fee > 0 ? 'unpaid' : 'paid';

        $registration = $this->programRepository->registerParticipant($program, $validated);

        return redirect()
            ->route('programs.registration-success', $registration)
            ->with('success', 'Registration successful!');
    }

    /**
     * Show registration success page.
     */
    public function registrationSuccess(ProgramRegistration $registration)
    {
        return view('programs.registration-success', compact('registration'));
    }

    /**
     * Manage program registrations.
     */
    public function manageRegistrations(Program $program)
    {
        $program = $this->programRepository->find($program->id);

        return view('programs.manage-registrations', compact('program'));
    }

    /**
     * Check in participant.
     */
    public function checkIn(Request $request, ProgramRegistration $registration)
    {
        $this->programRepository->checkInParticipant($registration);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Participant checked in successfully.');
    }

    /**
     * Manage program sessions.
     */
    public function manageSessions(Program $program)
    {
        $program = $this->programRepository->find($program->id);

        return view('programs.manage-sessions', compact('program'));
    }

    /**
     * Store session.
     */
    public function storeSession(Request $request, Program $program)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'venue' => 'nullable|string|max:255',
            'speaker_name' => 'nullable|string|max:255',
            'speaker_bio' => 'nullable|string',
            'materials_required' => 'nullable|string',
            'max_attendees' => 'nullable|integer|min:1',
        ]);

        $this->programRepository->addSession($program, $validated);

        return redirect()
            ->back()
            ->with('success', 'Session added successfully.');
    }

    /**
     * Update session.
     */
    public function updateSession(Request $request, ProgramSession $session)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'venue' => 'nullable|string|max:255',
            'speaker_name' => 'nullable|string|max:255',
            'speaker_bio' => 'nullable|string',
            'materials_required' => 'nullable|string',
            'max_attendees' => 'nullable|integer|min:1',
        ]);

        $this->programRepository->updateSession($session, $validated);

        return redirect()
            ->back()
            ->with('success', 'Session updated successfully.');
    }

    /**
     * Delete session.
     */
    public function destroySession(ProgramSession $session)
    {
        $this->programRepository->deleteSession($session);

        return redirect()
            ->back()
            ->with('success', 'Session deleted successfully.');
    }

    /**
     * Show program analytics.
     */
    public function analytics(Program $program)
    {
        $statistics = $this->programRepository->getStatistics($program);
        $registrationStats = $this->programRepository->getRegistrationStatistics($program);
        $attendanceStats = $this->programRepository->getAttendanceStatistics($program);
        $feedbackSummary = $this->programRepository->getFeedbackSummary($program);

        return view('programs.analytics', compact(
            'program',
            'statistics',
            'registrationStats',
            'attendanceStats',
            'feedbackSummary'
        ));
    }

    /**
     * Generate registration QR code for a program.
     */
    public function generateRegistrationQR(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        // Generate unique registration QR code if not exists
        if (!$program->registration_qr_code) {
            $program->registration_qr_code = 'PROG-REG-' . strtoupper(uniqid()) . '-' . $program->id;
            $program->qr_registration_enabled = true;
            $program->save();
        }

        // Generate QR code image URL
        $qrCodeUrl = route('programs.registration-qr-image', $program->id);

        return response()->json([
            'success' => true,
            'message' => 'Registration QR code generated successfully',
            'data' => [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'qr_code' => $program->registration_qr_code,
                'qr_image_url' => $qrCodeUrl,
                'enabled' => $program->qr_registration_enabled,
            ],
        ]);
    }

    /**
     * Generate check-in QR code for a program.
     */
    public function generateCheckInQR(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        // Generate unique check-in QR code if not exists
        if (!$program->check_in_qr_code) {
            $program->check_in_qr_code = 'PROG-CHK-' . strtoupper(uniqid()) . '-' . $program->id;
            $program->qr_checkin_enabled = true;
            $program->save();
        }

        // Generate QR code image URL
        $qrCodeUrl = route('programs.checkin-qr-image', $program->id);

        return response()->json([
            'success' => true,
            'message' => 'Check-in QR code generated successfully',
            'data' => [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'qr_code' => $program->check_in_qr_code,
                'qr_image_url' => $qrCodeUrl,
                'enabled' => $program->qr_checkin_enabled,
            ],
        ]);
    }

    /**
     * Regenerate registration QR code for a program.
     */
    public function regenerateRegistrationQR(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        // Generate new registration QR code
        $program->registration_qr_code = 'PROG-REG-' . strtoupper(uniqid()) . '-' . $program->id;
        $program->qr_registration_enabled = true;
        $program->save();

        $qrCodeUrl = route('programs.registration-qr-image', $program->id);

        return response()->json([
            'success' => true,
            'message' => 'Registration QR code regenerated successfully',
            'data' => [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'qr_code' => $program->registration_qr_code,
                'qr_image_url' => $qrCodeUrl,
            ],
        ]);
    }

    /**
     * Regenerate check-in QR code for a program.
     */
    public function regenerateCheckInQR(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        // Generate new check-in QR code
        $program->check_in_qr_code = 'PROG-CHK-' . strtoupper(uniqid()) . '-' . $program->id;
        $program->qr_checkin_enabled = true;
        $program->save();

        $qrCodeUrl = route('programs.checkin-qr-image', $program->id);

        return response()->json([
            'success' => true,
            'message' => 'Check-in QR code regenerated successfully',
            'data' => [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'qr_code' => $program->check_in_qr_code,
                'qr_image_url' => $qrCodeUrl,
            ],
        ]);
    }

    /**
     * Toggle QR registration for a program.
     */
    public function toggleQRRegistration(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $program->qr_registration_enabled = !$program->qr_registration_enabled;
        $program->save();

        return response()->json([
            'success' => true,
            'message' => 'QR registration ' . ($program->qr_registration_enabled ? 'enabled' : 'disabled'),
            'enabled' => $program->qr_registration_enabled,
        ]);
    }

    /**
     * Toggle QR check-in for a program.
     */
    public function toggleQRCheckIn(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $program->qr_checkin_enabled = !$program->qr_checkin_enabled;
        $program->save();

        return response()->json([
            'success' => true,
            'message' => 'QR check-in ' . ($program->qr_checkin_enabled ? 'enabled' : 'disabled'),
            'enabled' => $program->qr_checkin_enabled,
        ]);
    }

    /**
     * Download program registration QR code as image.
     */
    public function downloadRegistrationQR(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        // Ensure registration QR code exists
        if (!$program->registration_qr_code) {
            $program->registration_qr_code = 'PROG-REG-' . strtoupper(uniqid()) . '-' . $program->id;
            $program->save();
        }

        // Generate QR code image
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(500)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($program->registration_qr_code);

        $fileName = 'program-registration-qr-' . $program->id . '.png';

        return response($qrCode, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Download program check-in QR code as image.
     */
    public function downloadCheckInQR(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        // Ensure check-in QR code exists
        if (!$program->check_in_qr_code) {
            $program->check_in_qr_code = 'PROG-CHK-' . strtoupper(uniqid()) . '-' . $program->id;
            $program->save();
        }

        // Generate QR code image
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(500)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($program->check_in_qr_code);

        $fileName = 'program-checkin-qr-' . $program->id . '.png';

        return response($qrCode, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Display program registration QR code image.
     */
    public function showRegistrationQRImage($id)
    {
        $program = Program::findOrFail($id);

        // Ensure registration QR code exists
        if (!$program->registration_qr_code) {
            $program->registration_qr_code = 'PROG-REG-' . strtoupper(uniqid()) . '-' . $program->id;
            $program->save();
        }

        // Generate QR code image
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(300)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($program->registration_qr_code);

        return response($qrCode, 200)->header('Content-Type', 'image/png');
    }

    /**
     * Display program check-in QR code image.
     */
    public function showCheckInQRImage($id)
    {
        $program = Program::findOrFail($id);

        // Ensure check-in QR code exists
        if (!$program->check_in_qr_code) {
            $program->check_in_qr_code = 'PROG-CHK-' . strtoupper(uniqid()) . '-' . $program->id;
            $program->save();
        }

        // Generate QR code image
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(300)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($program->check_in_qr_code);

        return response($qrCode, 200)->header('Content-Type', 'image/png');
    }

    /**
     * Show printable registration QR poster
     */
    public function printRegistrationQRPoster($id)
    {
        $program = \App\Models\Program::findOrFail($id);

        return view('programs.print-qr-poster', [
            'program' => $program,
            'qrType' => 'registration',
        ]);
    }

    /**
     * Show printable check-in QR poster
     */
    public function printCheckInQRPoster($id)
    {
        $program = \App\Models\Program::findOrFail($id);

        return view('programs.print-qr-poster', [
            'program' => $program,
            'qrType' => 'checkin',
        ]);
    }

    /**
     * Export QR poster as PDF
     */
    public function exportQRPosterPdf(Request $request, $id)
    {
        $program = \App\Models\Program::findOrFail($id);
        $qrType = $request->get('type', 'registration'); // registration or checkin

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('programs.pdf.qr-poster', [
            'program' => $program,
            'qrType' => $qrType,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = "program-{$qrType}-qr-{$program->id}.pdf";

        return $pdf->download($filename);
    }
}
