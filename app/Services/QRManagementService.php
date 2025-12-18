<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Equipment;
use App\Models\Member;
use App\Models\Program;
use App\Models\QRCode;
use App\Models\QRCodeSetting;
use App\Models\Transaction;
use App\Models\Visitor;
use App\Repositories\QRCodeRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrGenerator;

class QRManagementService
{
    public function __construct(
        private QRCodeRepository $repository,
        private QRSecurityService $securityService
    ) {}

    /**
     * Generate a new QR code with configuration.
     */
    public function generateQRCode(array $config): array
    {
        // Permission check
        if (!$this->hasGeneratePermission()) {
            throw new \Exception('Unauthorized: Admin or Pastor access required for QR generation');
        }

        // Rate limit check
        if (!$this->securityService->checkGenerationRateLimit(Auth::id())) {
            throw new \Exception('Rate limit exceeded: Too many QR codes generated');
        }

        // Calculate times
        $activation = $this->calculateActivationTime($config);
        $expiration = $this->calculateExpirationTime($config);

        // Get church coordinates
        $churchCoords = QRCodeSetting::get('church_coordinates', ['lat' => 5.6037, 'lng' => -0.1870]);

        // Create QR code record
        $qrCode = $this->repository->create([
            'type' => $config['type'],
            'church_id' => $config['church_id'] ?? null,
            'service_date' => $config['service_date'] ?? null,
            'service_type' => $config['service_type'] ?? null,
            'activation_time' => $activation,
            'expiration_time' => $expiration,
            'location_required' => $config['location_required'] ?? true,
            'location_latitude' => $churchCoords['lat'],
            'location_longitude' => $churchCoords['lng'],
            'location_radius' => $config['location_radius'] ?? 100,
            'generated_by' => Auth::id(),
            'generated_at' => now(),
            'status' => $activation->isPast() ? QRCode::STATUS_ACTIVE : QRCode::STATUS_PENDING,
            'revoked' => false,
            'max_scans' => $config['max_scans'] ?? null,
            'allow_family' => $config['allow_family'] ?? false,
            'requires_verification' => $config['requires_verification'] ?? true,
            'offline_allowed' => $config['offline_allowed'] ?? true,
            'metadata' => $config['metadata'] ?? [],
        ]);

        // Encode QR data
        $qrData = $this->encodeQRData($qrCode, $config);

        // Generate QR image
        $qrImage = $this->generateQRImage($qrData);

        return [
            'id' => $qrCode->id,
            'type' => $qrCode->type,
            'data' => $qrData,
            'image' => $qrImage,
            'activation_time' => $qrCode->activation_time,
            'expiration_time' => $qrCode->expiration_time,
            'status' => $qrCode->status,
            'url' => route('qr.scan', ['code' => $qrCode->id]),
        ];
    }

    /**
     * Validate and process a QR code scan.
     */
    public function validateAndProcessScan(string $qrData, array $scanData): array
    {
        $startTime = microtime(true);

        try {
            // Decode and validate signature
            $decoded = $this->securityService->decode($qrData);

            // Get QR code from database
            $qrCode = $this->repository->findById($decoded['id']);

            if (!$qrCode) {
                return $this->logFailedScan(null, $scanData, 'INVALID_QR', $startTime);
            }

            // Security checks
            $this->performSecurityChecks($qrCode, $scanData);

            // Validate time
            $this->validateTime($qrCode);

            // Validate location if required
            if ($qrCode->location_required) {
                $this->validateLocation($qrCode, $scanData['location'] ?? null);
            }

            // Check for duplicate scans
            if ($this->isDuplicateScan($qrCode, $scanData['user_id'])) {
                return $this->logFailedScan($qrCode->id, $scanData, QRCode::ERROR_DUPLICATE, $startTime);
            }

            // Check max scans
            if ($qrCode->hasReachedMaxScans()) {
                return $this->logFailedScan($qrCode->id, $scanData, QRCode::ERROR_MAX_SCANS, $startTime);
            }

            // Process based on type
            $result = $this->processScanByType($qrCode, $scanData);

            // Log successful scan
            $this->logSuccessfulScan($qrCode, $scanData, $result, $startTime);

            return [
                'success' => true,
                'result' => $result,
                'qr_code' => $qrCode,
                'processing_time' => round((microtime(true) - $startTime) * 1000),
            ];

        } catch (\Exception $e) {
            return $this->logFailedScan(
                $decoded['id'] ?? null,
                $scanData,
                $e->getMessage(),
                $startTime
            );
        }
    }

    /**
     * Process scan based on QR code type.
     */
    private function processScanByType(QRCode $qrCode, array $scanData): array
    {
        return match ($qrCode->type) {
            QRCode::TYPE_SERVICE_ATTENDANCE => $this->processAttendanceScan($qrCode, $scanData),
            QRCode::TYPE_EVENT_REGISTRATION => $this->processEventRegistration($qrCode, $scanData),
            QRCode::TYPE_PAYMENT => $this->processPayment($qrCode, $scanData),
            QRCode::TYPE_CHECK_IN => $this->processCheckIn($qrCode, $scanData),
            QRCode::TYPE_VISITOR_REGISTRATION => $this->processVisitorRegistration($qrCode, $scanData),
            QRCode::TYPE_EQUIPMENT_CHECKOUT => $this->processEquipmentCheckout($qrCode, $scanData),
            QRCode::TYPE_VERIFICATION => $this->processVerification($qrCode, $scanData),
            default => throw new \Exception('Unknown QR code type'),
        };
    }

    /**
     * Process service attendance scan.
     */
    private function processAttendanceScan(QRCode $qrCode, array $scanData): array
    {
        $member = Member::find($scanData['user_id']);

        if (!$member) {
            throw new \Exception('Member not found');
        }

        // Check for existing attendance
        $existing = Attendance::where('member_id', $member->id)
            ->whereDate('service_date', $qrCode->service_date)
            ->where('service_type', $qrCode->service_type)
            ->first();

        if ($existing) {
            throw new \Exception('Attendance already marked for this service');
        }

        // Mark attendance
        $attendance = Attendance::create([
            'member_id' => $member->id,
            'service_date' => $qrCode->service_date,
            'service_type' => $qrCode->service_type,
            'status' => 'present',
            'check_in_time' => now(),
            'check_in_method' => 'qr_code',
            'marked_by' => $member->user_id,
        ]);

        return [
            'type' => 'ATTENDANCE_MARKED',
            'attendance_id' => $attendance->id,
            'member' => $member->only(['id', 'first_name', 'last_name']),
            'service' => [
                'date' => $qrCode->service_date,
                'type' => $qrCode->service_type,
            ],
        ];
    }

    /**
     * Process event registration scan.
     */
    private function processEventRegistration(QRCode $qrCode, array $scanData): array
    {
        $programId = $qrCode->metadata['program_id'] ?? null;

        if (!$programId) {
            throw new \Exception('Program information missing');
        }

        $program = Program::find($programId);

        if (!$program) {
            throw new \Exception('Program not found');
        }

        $member = Member::find($scanData['user_id']);

        // Register for program
        DB::table('program_registrations')->insert([
            'program_id' => $program->id,
            'member_id' => $member->id,
            'registration_date' => now(),
            'status' => 'confirmed',
            'source' => 'qr_scan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [
            'type' => 'EVENT_REGISTERED',
            'program' => $program->only(['id', 'name', 'start_date']),
            'member' => $member->only(['id', 'first_name', 'last_name']),
        ];
    }

    /**
     * Process payment scan.
     */
    private function processPayment(QRCode $qrCode, array $scanData): array
    {
        $amount = $scanData['amount'] ?? $qrCode->metadata['amount'] ?? null;
        $category = $qrCode->metadata['category'] ?? 'offering';

        if (!$amount) {
            throw new \Exception('Payment amount required');
        }

        $member = Member::find($scanData['user_id']);

        // Record transaction
        $transaction = Transaction::create([
            'member_id' => $member->id,
            'date' => now(),
            'type' => 'income',
            'category' => $category,
            'amount' => $amount,
            'payment_method' => $scanData['payment_method'] ?? 'mobile_money',
            'reference' => 'QR-' . strtoupper(uniqid()),
            'status' => 'completed',
            'recorded_by' => $member->user_id,
            'approved_by' => null,
            'notes' => 'Payment via QR code scan',
        ]);

        return [
            'type' => 'PAYMENT_PROCESSED',
            'transaction_id' => $transaction->id,
            'amount' => $amount,
            'category' => $category,
            'reference' => $transaction->reference,
        ];
    }

    /**
     * Process general check-in scan.
     */
    private function processCheckIn(QRCode $qrCode, array $scanData): array
    {
        $member = Member::find($scanData['user_id']);

        return [
            'type' => 'CHECK_IN_SUCCESS',
            'member' => $member->only(['id', 'first_name', 'last_name']),
            'time' => now(),
            'location' => $scanData['location'] ?? null,
        ];
    }

    /**
     * Process visitor registration scan.
     */
    private function processVisitorRegistration(QRCode $qrCode, array $scanData): array
    {
        // Create visitor record
        $visitor = Visitor::create([
            'first_name' => $scanData['first_name'],
            'last_name' => $scanData['last_name'],
            'phone' => $scanData['phone'],
            'email' => $scanData['email'] ?? null,
            'address' => $scanData['address'] ?? null,
            'visit_date' => now()->toDateString(),
            'source' => 'qr_scan',
            'follow_up_status' => 'pending',
        ]);

        return [
            'type' => 'VISITOR_REGISTERED',
            'visitor_id' => $visitor->id,
            'name' => $visitor->first_name . ' ' . $visitor->last_name,
        ];
    }

    /**
     * Process equipment checkout scan.
     */
    private function processEquipmentCheckout(QRCode $qrCode, array $scanData): array
    {
        $equipmentId = $qrCode->metadata['equipment_id'] ?? null;

        if (!$equipmentId) {
            throw new \Exception('Equipment information missing');
        }

        $equipment = Equipment::find($equipmentId);

        if (!$equipment) {
            throw new \Exception('Equipment not found');
        }

        // Record checkout
        DB::table('equipment_checkouts')->insert([
            'equipment_id' => $equipment->id,
            'checked_out_by' => $scanData['user_id'],
            'checkout_time' => now(),
            'expected_return' => now()->addHours($qrCode->metadata['checkout_duration'] ?? 24),
            'status' => 'checked_out',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [
            'type' => 'EQUIPMENT_CHECKED_OUT',
            'equipment' => $equipment->only(['id', 'name', 'serial_number']),
            'checkout_time' => now(),
        ];
    }

    /**
     * Process verification scan.
     */
    private function processVerification(QRCode $qrCode, array $scanData): array
    {
        return [
            'type' => 'VERIFIED',
            'verified' => true,
            'verification_data' => $qrCode->metadata,
        ];
    }

    /**
     * Validate QR code time window.
     */
    private function validateTime(QRCode $qrCode): void
    {
        if ($qrCode->revoked) {
            throw new \Exception(QRCode::ERROR_REVOKED);
        }

        if ($qrCode->isExpired()) {
            throw new \Exception(QRCode::ERROR_EXPIRED);
        }

        if ($qrCode->isPending()) {
            throw new \Exception(QRCode::ERROR_NOT_ACTIVE);
        }

        if (!$qrCode->isActive()) {
            throw new \Exception(QRCode::ERROR_NOT_ACTIVE);
        }
    }

    /**
     * Validate GPS location.
     */
    private function validateLocation(QRCode $qrCode, ?array $location): void
    {
        if (!$location || !isset($location['latitude'], $location['longitude'])) {
            throw new \Exception(QRCode::ERROR_GPS_FAILED . ': Location data missing');
        }

        $distance = $this->calculateDistance(
            $qrCode->location_latitude,
            $qrCode->location_longitude,
            $location['latitude'],
            $location['longitude']
        );

        // Distance is in kilometers, convert radius from meters
        $maxDistance = $qrCode->location_radius / 1000;

        if ($distance > $maxDistance) {
            throw new \Exception(QRCode::ERROR_GPS_FAILED . ': Outside allowed radius');
        }
    }

    /**
     * Calculate distance between two GPS coordinates (Haversine formula).
     */
    private function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // kilometers

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLng = deg2rad($lng2 - $lng1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($deltaLng / 2) * sin($deltaLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Check if user has already scanned this QR code.
     */
    private function isDuplicateScan(QRCode $qrCode, int $userId): bool
    {
        return $this->repository->hasUserScanned($qrCode->id, $userId);
    }

    /**
     * Perform security checks.
     */
    private function performSecurityChecks(QRCode $qrCode, array $scanData): void
    {
        // Device fingerprint validation
        if (!$this->securityService->validateDeviceFingerprint($scanData)) {
            throw new \Exception('Invalid device fingerprint');
        }

        // Rate limiting
        if (!$this->securityService->checkScanRateLimit($scanData['device_id'])) {
            throw new \Exception('Rate limit exceeded: Too many scans');
        }

        // Anomaly detection
        $anomalies = $this->securityService->detectAnomalies($scanData);
        if (!empty($anomalies)) {
            // Log anomalies but don't block (for now)
            \Log::warning('QR scan anomalies detected', [
                'qr_id' => $qrCode->id,
                'anomalies' => $anomalies,
                'scan_data' => $scanData,
            ]);
        }
    }

    /**
     * Log successful scan.
     */
    private function logSuccessfulScan(QRCode $qrCode, array $scanData, array $result, float $startTime): void
    {
        $this->repository->logScan([
            'qr_id' => $qrCode->id,
            'user_id' => $scanData['user_id'],
            'scan_time' => now(),
            'location_latitude' => $scanData['location']['latitude'] ?? null,
            'location_longitude' => $scanData['location']['longitude'] ?? null,
            'location_accuracy' => $scanData['location']['accuracy'] ?? null,
            'distance_from_church' => isset($scanData['location'])
                ? $this->calculateDistance(
                    $qrCode->location_latitude,
                    $qrCode->location_longitude,
                    $scanData['location']['latitude'],
                    $scanData['location']['longitude']
                ) * 1000 // meters
                : null,
            'device_id' => $scanData['device_id'],
            'device_type' => $scanData['device_type'],
            'ip_address' => $scanData['ip_address'] ?? request()->ip(),
            'success' => true,
            'error_reason' => null,
            'processing_time' => round((microtime(true) - $startTime) * 1000),
            'offline_sync' => $scanData['offline_sync'] ?? false,
            'scan_result' => $result['type'],
            'metadata' => $result,
        ]);
    }

    /**
     * Log failed scan.
     */
    private function logFailedScan(?string $qrId, array $scanData, string $error, float $startTime): array
    {
        if ($qrId) {
            $this->repository->logScan([
                'qr_id' => $qrId,
                'user_id' => $scanData['user_id'] ?? null,
                'scan_time' => now(),
                'location_latitude' => $scanData['location']['latitude'] ?? null,
                'location_longitude' => $scanData['location']['longitude'] ?? null,
                'device_id' => $scanData['device_id'] ?? null,
                'device_type' => $scanData['device_type'] ?? 'unknown',
                'ip_address' => $scanData['ip_address'] ?? request()->ip(),
                'success' => false,
                'error_reason' => $error,
                'processing_time' => round((microtime(true) - $startTime) * 1000),
                'offline_sync' => $scanData['offline_sync'] ?? false,
            ]);
        }

        return [
            'success' => false,
            'error' => $error,
            'processing_time' => round((microtime(true) - $startTime) * 1000),
        ];
    }

    /**
     * Encode QR data with encryption and signature.
     */
    private function encodeQRData(QRCode $qrCode, array $config): string
    {
        $data = [
            'id' => $qrCode->id,
            'type' => $qrCode->type,
            'church_id' => $qrCode->church_id,
            'activation' => $qrCode->activation_time->timestamp,
            'expiration' => $qrCode->expiration_time->timestamp,
            'metadata' => $config['metadata'] ?? [],
        ];

        return $this->securityService->encode($data);
    }

    /**
     * Generate QR code image.
     */
    private function generateQRImage(string $data, int $size = 300): string
    {
        try {
            // Generate QR code using SimpleSoftwareIO library
            $qrCode = QrGenerator::format('png')
                ->size($size)
                ->errorCorrection('H')
                ->margin(1)
                ->generate($data);

            // Return as base64 data URL for easy embedding
            return 'data:image/png;base64,' . base64_encode($qrCode);
        } catch (\Exception $e) {
            // Fallback to external API if generation fails
            \Log::warning('QR generation failed, using fallback', ['error' => $e->getMessage()]);
            return "https://api.qrserver.com/v1/create-qr-code/?size=" . $size . "x" . $size . "&data=" . urlencode($data);
        }
    }

    /**
     * Generate QR code image for download (binary).
     */
    public function generateQRImageBinary(string $qrId, int $size = 300): string
    {
        $qrCode = $this->repository->findById($qrId);

        if (!$qrCode) {
            throw new \Exception('QR code not found');
        }

        // Encode QR data
        $config = [];
        $qrData = $this->encodeQRData($qrCode, $config);

        // Generate binary image
        return QrGenerator::format('png')
            ->size($size)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($qrData);
    }

    /**
     * Calculate activation time based on config.
     */
    private function calculateActivationTime(array $config): Carbon
    {
        if (isset($config['activation_time'])) {
            return Carbon::parse($config['activation_time']);
        }

        // For service attendance, activate 30 minutes before service
        if ($config['type'] === QRCode::TYPE_SERVICE_ATTENDANCE && isset($config['service_time'])) {
            return Carbon::parse($config['service_date'] . ' ' . $config['service_time'])
                ->subMinutes(30);
        }

        // Default: Activate immediately
        return now();
    }

    /**
     * Calculate expiration time based on config.
     */
    private function calculateExpirationTime(array $config): Carbon
    {
        if (isset($config['expiration_time'])) {
            return Carbon::parse($config['expiration_time']);
        }

        // For service attendance, expire 2 hours after service start
        if ($config['type'] === QRCode::TYPE_SERVICE_ATTENDANCE && isset($config['service_time'])) {
            return Carbon::parse($config['service_date'] . ' ' . $config['service_time'])
                ->addHours(2);
        }

        // Default: 24 hours
        return now()->addHours(24);
    }

    /**
     * Check if user has permission to generate QR codes.
     */
    private function hasGeneratePermission(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return in_array($user->role, ['admin', 'pastor']);
    }

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStatistics(): array
    {
        return $this->repository->getDashboardStatistics();
    }

    /**
     * Get analytics for a specific QR code.
     */
    public function getQRAnalytics(string $qrId, ?string $date = null): array
    {
        $analytics = $this->repository->getAnalytics($qrId, $date);

        if (!$analytics) {
            // Generate if not exists
            $analytics = $this->repository->generateAnalytics($qrId, $date ?? today());
        }

        return $analytics->toArray();
    }

    /**
     * Revoke a QR code.
     */
    public function revokeQRCode(string $qrId): bool
    {
        $qrCode = $this->repository->findById($qrId);

        if (!$qrCode) {
            throw new \Exception('QR code not found');
        }

        $qrCode->revoke(Auth::id());

        return true;
    }

    /**
     * Extend QR code expiration.
     */
    public function extendQRCode(string $qrId, int $minutes): bool
    {
        $qrCode = $this->repository->findById($qrId);

        if (!$qrCode) {
            throw new \Exception('QR code not found');
        }

        $qrCode->extend($minutes);

        return true;
    }

    /**
     * Get QR code settings.
     */
    public function getSettings(): array
    {
        return $this->repository->getSettings();
    }

    /**
     * Update QR code settings.
     */
    public function updateSetting(string $key, $value): void
    {
        $this->repository->updateSetting($key, $value, Auth::id());
    }
}
