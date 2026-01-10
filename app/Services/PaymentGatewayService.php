<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    protected ?string $paystackSecretKey;

    protected ?string $paystackPublicKey;

    protected ?string $hubtelClientId;

    protected ?string $hubtelClientSecret;

    public function __construct()
    {
        $this->paystackSecretKey = config('services.paystack.secret_key');
        $this->paystackPublicKey = config('services.paystack.public_key');
        $this->hubtelClientId = config('services.hubtel.client_id');
        $this->hubtelClientSecret = config('services.hubtel.client_secret');

        // Validate that at least one payment gateway is configured
        $missingCredentials = [];

        // Check Paystack configuration
        if (empty($this->paystackSecretKey)) {
            $missingCredentials[] = 'PAYSTACK_SECRET_KEY';
        }
        if (empty($this->paystackPublicKey)) {
            $missingCredentials[] = 'PAYSTACK_PUBLIC_KEY';
        }

        // Check Hubtel configuration
        if (empty($this->hubtelClientId)) {
            $missingCredentials[] = 'HUBTEL_CLIENT_ID';
        }
        if (empty($this->hubtelClientSecret)) {
            $missingCredentials[] = 'HUBTEL_CLIENT_SECRET';
        }

        // Only throw exception if ALL payment gateways are unconfigured
        $paystackConfigured = !empty($this->paystackSecretKey) && !empty($this->paystackPublicKey);
        $hubtelConfigured = !empty($this->hubtelClientId) && !empty($this->hubtelClientSecret);

        if (!$paystackConfigured && !$hubtelConfigured) {
            throw new \InvalidArgumentException(
                'Payment gateway configuration incomplete. At least one payment gateway (Paystack or Hubtel) must be configured. Missing credentials: '.implode(', ', $missingCredentials).'. Please check config/services.php and your .env file.'
            );
        }

        // Log warning if only one gateway is configured
        if ($missingCredentials) {
            Log::warning('Some payment gateway credentials are missing', [
                'missing' => $missingCredentials,
                'paystack_configured' => $paystackConfigured,
                'hubtel_configured' => $hubtelConfigured,
            ]);
        }
    }

    /**
     * Process mobile money payment (MTN, Vodafone, AirtelTigo).
     * Uses Hubtel Payment Gateway for Ghana mobile money.
     */
    public function processMobileMoney(array $data): array
    {
        try {
            $reference = 'MM-'.strtoupper(Str::random(12));

            // Format phone number for mobile money
            $phone = $this->formatPhoneNumber($data['phone']);

            // Map provider names
            $providerMap = [
                'mtn' => 'mtn-gh',
                'vodafone' => 'vodafone-gh',
                'airteltigo' => 'tigo-gh',
            ];

            $provider = $providerMap[$data['provider']] ?? 'mtn-gh';

            // Hubtel Mobile Money API call
            $response = Http::withBasicAuth($this->hubtelClientId, $this->hubtelClientSecret)
                ->post('https://api.hubtel.com/v1/merchantaccount/merchants/charges', [
                    'CustomerName' => 'Church Member',
                    'CustomerMsisdn' => $phone,
                    'CustomerEmail' => '',
                    'Channel' => $provider,
                    'Amount' => $data['amount'],
                    'PrimaryCallbackUrl' => route('api.mobile.payment.callback'),
                    'Description' => $data['description'] ?? 'Church Offering',
                    'ClientReference' => $reference,
                ]);

            if ($response->successful()) {
                $result = $response->json();

                return [
                    'success' => true,
                    'message' => 'Mobile money payment initiated. Check your phone for approval prompt.',
                    'reference' => $reference,
                    'transaction_id' => $result['TransactionId'] ?? null,
                    'phone' => $phone,
                    'status' => 'pending',
                ];
            }

            Log::error('Mobile money payment failed', [
                'response' => $response->body(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => 'Mobile money payment initiation failed. Please try again.',
            ];

        } catch (\Exception $e) {
            Log::error('Mobile money exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Payment processing error: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Initiate card payment via Paystack.
     */
    public function initiateCardPayment(array $data): array
    {
        try {
            $reference = 'CARD-'.strtoupper(Str::random(12));

            $response = Http::withToken($this->paystackSecretKey)
                ->post('https://api.paystack.co/transaction/initialize', [
                    'amount' => $data['amount'] * 100, // Paystack uses kobo/pesewas
                    'email' => $data['email'] ?? 'member@church.local',
                    'reference' => $reference,
                    'callback_url' => $data['callback_url'] ?? route('api.mobile.payment.callback'),
                    'metadata' => [
                        'transaction_code' => $data['transaction_code'] ?? null,
                        'description' => $data['description'] ?? 'Church Payment',
                    ],
                ]);

            if ($response->successful()) {
                $result = $response->json();

                if ($result['status']) {
                    return [
                        'success' => true,
                        'message' => 'Card payment page ready',
                        'reference' => $reference,
                        'payment_url' => $result['data']['authorization_url'],
                        'access_code' => $result['data']['access_code'],
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Card payment initialization failed',
            ];

        } catch (\Exception $e) {
            Log::error('Card payment exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Payment processing error: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Verify payment status with payment gateway.
     */
    public function verifyPayment(string $reference): array
    {
        try {
            // Determine payment method from reference prefix
            if (str_starts_with($reference, 'MM-')) {
                return $this->verifyMobileMoneyPayment($reference);
            } elseif (str_starts_with($reference, 'CARD-')) {
                return $this->verifyCardPayment($reference);
            }

            // Default to Paystack verification
            return $this->verifyCardPayment($reference);

        } catch (\Exception $e) {
            Log::error('Payment verification exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'status' => 'unknown',
                'message' => 'Verification failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Verify mobile money payment via Hubtel.
     */
    private function verifyMobileMoneyPayment(string $reference): array
    {
        try {
            $response = Http::withBasicAuth($this->hubtelClientId, $this->hubtelClientSecret)
                ->get("https://api.hubtel.com/v1/merchantaccount/merchants/transactions/{$reference}");

            if ($response->successful()) {
                $result = $response->json();

                $status = match (strtolower($result['Status'] ?? '')) {
                    'success', 'successful' => 'completed',
                    'pending' => 'pending',
                    'failed', 'cancelled' => 'failed',
                    default => 'pending',
                };

                return [
                    'success' => true,
                    'status' => $status,
                    'amount' => $result['Amount'] ?? 0,
                    'message' => $result['Message'] ?? 'Payment verified',
                ];
            }

            return [
                'success' => false,
                'status' => 'unknown',
                'message' => 'Unable to verify payment',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'status' => 'unknown',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify card payment via Paystack.
     */
    private function verifyCardPayment(string $reference): array
    {
        try {
            $response = Http::withToken($this->paystackSecretKey)
                ->get("https://api.paystack.co/transaction/verify/{$reference}");

            if ($response->successful()) {
                $result = $response->json();

                if ($result['status']) {
                    $data = $result['data'];

                    $status = match (strtolower($data['status'] ?? '')) {
                        'success' => 'completed',
                        'pending' => 'pending',
                        'failed', 'abandoned' => 'failed',
                        default => 'pending',
                    };

                    return [
                        'success' => true,
                        'status' => $status,
                        'amount' => $data['amount'] / 100, // Convert from kobo/pesewas
                        'message' => $data['gateway_response'] ?? 'Payment verified',
                    ];
                }
            }

            return [
                'success' => false,
                'status' => 'unknown',
                'message' => 'Unable to verify payment',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'status' => 'unknown',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Format phone number for mobile money (Ghana format).
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with country code +233, remove it
        if (str_starts_with($phone, '233')) {
            $phone = '0'.substr($phone, 3);
        }

        // Ensure it starts with 0
        if (! str_starts_with($phone, '0')) {
            $phone = '0'.$phone;
        }

        return $phone;
    }

    /**
     * Process refund (admin only).
     */
    public function processRefund(string $reference, float $amount): array
    {
        try {
            // Determine payment method
            if (str_starts_with($reference, 'CARD-')) {
                return $this->refundCardPayment($reference, $amount);
            }

            return [
                'success' => false,
                'message' => 'Refunds only supported for card payments currently',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Refund failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Refund card payment via Paystack.
     */
    private function refundCardPayment(string $reference, float $amount): array
    {
        try {
            $response = Http::withToken($this->paystackSecretKey)
                ->post('https://api.paystack.co/refund', [
                    'transaction' => $reference,
                    'amount' => $amount * 100, // Convert to kobo/pesewas
                ]);

            if ($response->successful()) {
                $result = $response->json();

                if ($result['status']) {
                    return [
                        'success' => true,
                        'message' => 'Refund processed successfully',
                        'refund_reference' => $result['data']['id'] ?? null,
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Refund processing failed',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Refund error: '.$e->getMessage(),
            ];
        }
    }
}
