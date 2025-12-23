<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\Member;
use App\Models\Program;
use App\Models\Visitor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class QrCodeService
{
    /**
     * Generate QR code data for member check-in.
     */
    public function generateMemberCheckInCode(Member $member): array
    {
        $token = Str::random(32);
        $expiresAt = now()->addHours(24);

        Cache::put("qr:member:{$token}", [
            'member_id' => $member->id,
            'type' => 'member_checkin',
            'expires_at' => $expiresAt,
        ], $expiresAt);

        return [
            'token' => $token,
            'url' => route('mobile.checkin', ['token' => $token]),
            'data' => json_encode([
                'type' => 'member_checkin',
                'member_id' => $member->id,
                'name' => $member->first_name.' '.$member->last_name,
                'token' => $token,
            ]),
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * Generate dynamic service check-in QR code.
     */
    public function generateServiceCheckInCode(string $serviceDate, string $serviceType): array
    {
        $token = Str::random(32);
        $expiresAt = now()->addHours(6); // Service codes expire in 6 hours

        Cache::put("qr:service:{$token}", [
            'service_date' => $serviceDate,
            'service_type' => $serviceType,
            'type' => 'service_checkin',
            'expires_at' => $expiresAt,
        ], $expiresAt);

        return [
            'token' => $token,
            'url' => route('mobile.service-checkin', ['token' => $token]),
            'data' => json_encode([
                'type' => 'service_checkin',
                'service_date' => $serviceDate,
                'service_type' => $serviceType,
                'token' => $token,
            ]),
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * Generate visitor registration QR code.
     */
    public function generateVisitorRegistrationCode(): array
    {
        $token = Str::random(32);

        return [
            'token' => $token,
            'url' => route('mobile.visitor-register', ['token' => $token]),
            'data' => json_encode([
                'type' => 'visitor_registration',
                'church_id' => config('app.name'),
                'token' => $token,
            ]),
        ];
    }

    /**
     * Generate member self-registration QR code.
     */
    public function generateMemberRegistrationCode(): array
    {
        $token = Str::random(32);

        return [
            'token' => $token,
            'url' => route('mobile.member-register', ['token' => $token]),
            'data' => json_encode([
                'type' => 'member_registration',
                'church_id' => config('app.name'),
                'token' => $token,
            ]),
        ];
    }

    /**
     * Generate payment QR code.
     */
    public function generatePaymentCode(array $paymentData): array
    {
        $token = Str::random(32);
        $expiresAt = now()->addMinutes(30);

        Cache::put("qr:payment:{$token}", [
            'amount' => $paymentData['amount'] ?? null,
            'category' => $paymentData['category'] ?? 'offering',
            'description' => $paymentData['description'] ?? 'Offering',
            'type' => 'payment',
            'expires_at' => $expiresAt,
        ], $expiresAt);

        return [
            'token' => $token,
            'url' => route('mobile.payment', ['token' => $token]),
            'data' => json_encode([
                'type' => 'payment',
                'amount' => $paymentData['amount'] ?? null,
                'category' => $paymentData['category'] ?? 'offering',
                'token' => $token,
            ]),
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * Generate equipment QR code.
     */
    public function generateEquipmentCode(Equipment $equipment): array
    {
        return [
            'equipment_id' => $equipment->id,
            'url' => route('mobile.equipment', ['id' => $equipment->id]),
            'data' => json_encode([
                'type' => 'equipment',
                'equipment_id' => $equipment->id,
                'name' => $equipment->name,
                'serial_number' => $equipment->serial_number,
            ]),
        ];
    }

    /**
     * Generate program registration QR code.
     */
    public function generateProgramRegistrationCode(Program $program): array
    {
        $token = Str::random(32);

        return [
            'token' => $token,
            'url' => route('mobile.program-register', ['program' => $program->id, 'token' => $token]),
            'data' => json_encode([
                'type' => 'program_registration',
                'program_id' => $program->id,
                'program_name' => $program->name,
                'token' => $token,
            ]),
        ];
    }

    /**
     * Generate children check-in security code.
     */
    public function generateChildrenSecurityCode(int $childId, int $parentId): array
    {
        $securityCode = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        $expiresAt = now()->addHours(12);

        Cache::put("security:child:{$childId}:{$securityCode}", [
            'child_id' => $childId,
            'parent_id' => $parentId,
            'type' => 'child_checkin',
            'expires_at' => $expiresAt,
        ], $expiresAt);

        return [
            'security_code' => $securityCode,
            'child_id' => $childId,
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * Validate QR code token.
     */
    public function validateToken(string $token, string $type): ?array
    {
        $key = "qr:{$type}:{$token}";
        $data = Cache::get($key);

        if (! $data) {
            return null;
        }

        // Check expiration
        if (isset($data['expires_at']) && now()->gt($data['expires_at'])) {
            Cache::forget($key);

            return null;
        }

        return $data;
    }

    /**
     * Validate children security code.
     */
    public function validateSecurityCode(int $childId, string $code): ?array
    {
        $key = "security:child:{$childId}:{$code}";
        $data = Cache::get($key);

        if (! $data) {
            return null;
        }

        if (isset($data['expires_at']) && now()->gt($data['expires_at'])) {
            Cache::forget($key);

            return null;
        }

        return $data;
    }

    /**
     * Invalidate QR code token after use.
     */
    public function invalidateToken(string $token, string $type): void
    {
        Cache::forget("qr:{$type}:{$token}");
    }

    /**
     * Generate QR code image data URL.
     */
    public function generateQrImageUrl(string $data): string
    {
        try {
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size(300)
                ->errorCorrection('H')
                ->generate($data);

            return 'data:image/png;base64,'.base64_encode($qrCode);
        } catch (\Exception $e) {
            \Log::warning('QR generation failed', ['error' => $e->getMessage()]);

            return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode($data);
        }
    }

    /**
     * Generate QR code image binary.
     */
    public function generateQrImage(string $data, int $size = 300): string
    {
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size($size)
            ->errorCorrection('H')
            ->generate($data);
    }

    /**
     * Generate QR code with custom styling.
     */
    public function generateStyledQrImage(string $data, array $options = []): string
    {
        $size = $options['size'] ?? 300;
        $margin = $options['margin'] ?? 1;

        return \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size($size)
            ->margin($margin)
            ->errorCorrection('H')
            ->generate($data);
    }
}
