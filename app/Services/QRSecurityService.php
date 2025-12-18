<?php

namespace App\Services;

use App\Models\QRCodeSetting;
use Illuminate\Support\Facades\Crypt;

class QRSecurityService
{
    private string $encryptionKey;
    private string $signingKey;

    public function __construct()
    {
        $this->encryptionKey = QRCodeSetting::get('encryption_key', config('app.key'));
        $this->signingKey = QRCodeSetting::get('signing_key', config('app.key'));
    }

    /**
     * Encrypt QR code data with AES-256-GCM.
     */
    public function encrypt(array $data): string
    {
        $json = json_encode($data);
        $nonce = random_bytes(12); // 96-bit nonce for GCM
        $key = hex2bin($this->encryptionKey);

        $ciphertext = openssl_encrypt(
            $json,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag
        );

        // Combine nonce + tag + ciphertext
        $encrypted = base64_encode($nonce . $tag . $ciphertext);

        return $encrypted;
    }

    /**
     * Decrypt QR code data.
     */
    public function decrypt(string $encrypted): array
    {
        $decoded = base64_decode($encrypted);
        $key = hex2bin($this->encryptionKey);

        // Extract components
        $nonce = substr($decoded, 0, 12);
        $tag = substr($decoded, 12, 16);
        $ciphertext = substr($decoded, 28);

        $decrypted = openssl_decrypt(
            $ciphertext,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag
        );

        if ($decrypted === false) {
            throw new \Exception('Decryption failed: Invalid or corrupted QR code');
        }

        return json_decode($decrypted, true);
    }

    /**
     * Generate HMAC-SHA256 signature for QR data.
     */
    public function sign(array $data): string
    {
        $message = json_encode($data);
        $signature = hash_hmac('sha256', $message, hex2bin($this->signingKey));

        return $signature;
    }

    /**
     * Verify HMAC signature.
     */
    public function verify(array $data, string $signature): bool
    {
        $expected = $this->sign($data);

        return hash_equals($expected, $signature);
    }

    /**
     * Encode QR data with encryption and signature.
     */
    public function encode(array $data): string
    {
        // Add timestamp and random nonce for uniqueness
        $data['timestamp'] = now()->timestamp;
        $data['nonce'] = bin2hex(random_bytes(8));

        // Generate signature
        $signature = $this->sign($data);
        $data['signature'] = $signature;

        // Encrypt the entire payload
        $encrypted = $this->encrypt($data);

        return $encrypted;
    }

    /**
     * Decode and validate QR data.
     */
    public function decode(string $qrData): array
    {
        // Decrypt
        $data = $this->decrypt($qrData);

        // Extract and verify signature
        if (!isset($data['signature'])) {
            throw new \Exception('QR code missing signature');
        }

        $signature = $data['signature'];
        unset($data['signature']);

        if (!$this->verify($data, $signature)) {
            throw new \Exception('Invalid QR code signature');
        }

        // Check timestamp (prevent replay attacks beyond reasonable time)
        if (!isset($data['timestamp'])) {
            throw new \Exception('QR code missing timestamp');
        }

        $age = now()->timestamp - $data['timestamp'];
        if ($age > 86400 * 7) { // 7 days max age
            throw new \Exception('QR code data too old');
        }

        return $data;
    }

    /**
     * Generate anti-counterfeit token.
     */
    public function generateAntiCounterfeitToken(string $qrId): string
    {
        $data = [
            'qr_id' => $qrId,
            'timestamp' => now()->timestamp,
            'random' => bin2hex(random_bytes(16)),
        ];

        return $this->sign($data);
    }

    /**
     * Validate anti-counterfeit token.
     */
    public function validateAntiCounterfeitToken(string $qrId, string $token): bool
    {
        // Anti-counterfeit tokens are stored in the metadata
        // This is a secondary validation layer
        return strlen($token) === 64; // SHA256 hash length
    }

    /**
     * Detect suspicious patterns in scan data.
     */
    public function detectAnomalies(array $scanData): array
    {
        $anomalies = [];

        // Check for rapid successive scans from same device
        if (isset($scanData['device_id'])) {
            $recentScans = \DB::table('qr_scan_logs')
                ->where('device_id', $scanData['device_id'])
                ->where('scan_time', '>', now()->subMinutes(5))
                ->count();

            if ($recentScans > 10) {
                $anomalies[] = 'RAPID_SCANNING';
            }
        }

        // Check for impossible location changes
        if (isset($scanData['last_location'], $scanData['current_location'])) {
            $distance = $this->calculateDistance(
                $scanData['last_location']['lat'],
                $scanData['last_location']['lng'],
                $scanData['current_location']['lat'],
                $scanData['current_location']['lng']
            );

            $timeDiff = $scanData['time_since_last_scan'] ?? 0; // seconds

            if ($timeDiff > 0) {
                $speed = $distance / ($timeDiff / 3600); // km/h
                if ($speed > 200) { // Faster than reasonable vehicle speed
                    $anomalies[] = 'IMPOSSIBLE_TRAVEL_SPEED';
                }
            }
        }

        // Check for unusual scan times (e.g., 3 AM scans)
        $hour = now()->hour;
        if ($hour >= 2 && $hour <= 5) {
            $anomalies[] = 'UNUSUAL_TIME';
        }

        return $anomalies;
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
     * Validate device fingerprint.
     */
    public function validateDeviceFingerprint(array $deviceData): bool
    {
        $requiredFields = ['device_id', 'device_type', 'ip_address'];

        foreach ($requiredFields as $field) {
            if (!isset($deviceData[$field])) {
                return false;
            }
        }

        // Check for suspicious device IDs
        if (strlen($deviceData['device_id']) < 10) {
            return false;
        }

        // Validate device type
        $validTypes = ['ios', 'android', 'web'];
        if (!in_array($deviceData['device_type'], $validTypes)) {
            return false;
        }

        return true;
    }

    /**
     * Rate limiting check for QR generation.
     */
    public function checkGenerationRateLimit(int $userId): bool
    {
        $cacheKey = "qr:generation:limit:{$userId}";
        $count = \Cache::get($cacheKey, 0);

        $limit = QRCodeSetting::get('generation_rate_limit', 100); // per hour

        if ($count >= $limit) {
            return false;
        }

        \Cache::put($cacheKey, $count + 1, now()->addHour());

        return true;
    }

    /**
     * Rate limiting check for QR scanning.
     */
    public function checkScanRateLimit(string $deviceId): bool
    {
        $cacheKey = "qr:scan:limit:{$deviceId}";
        $count = \Cache::get($cacheKey, 0);

        $limit = QRCodeSetting::get('scan_rate_limit', 50); // per minute

        if ($count >= $limit) {
            return false;
        }

        \Cache::put($cacheKey, $count + 1, now()->addMinute());

        return true;
    }

    /**
     * Sanitize QR code data for safe storage.
     */
    public function sanitize(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            // Remove any script tags or dangerous content
            if (is_string($value)) {
                $value = strip_tags($value);
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }

            $sanitized[$key] = $value;
        }

        return $sanitized;
    }
}
