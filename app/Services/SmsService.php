<?php

namespace App\Services;

use Exception;
use Twilio\Rest\Client;

class SmsService
{
    protected $client;

    protected $from;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.phone');

        if ($sid && $token) {
            $this->client = new Client($sid, $token);
        }
    }

    /**
     * Send a single SMS message.
     *
     * @param  string  $to  Recipient phone number
     * @param  string  $message  Message content
     * @return array ['success' => bool, 'message_sid' => string|null, 'error' => string|null]
     */
    public function sendSms(string $to, string $message): array
    {
        if (! $this->client) {
            return [
                'success' => false,
                'message_sid' => null,
                'error' => 'Twilio credentials not configured',
            ];
        }

        try {
            // Format phone number (ensure it starts with +)
            $to = $this->formatPhoneNumber($to);

            // Send message via Twilio
            $twilioMessage = $this->client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );

            return [
                'success' => true,
                'message_sid' => $twilioMessage->sid,
                'error' => null,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message_sid' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send SMS to multiple recipients.
     *
     * @param  array  $recipients  Array of ['phone' => string, 'message' => string]
     * @return array ['total' => int, 'sent' => int, 'failed' => int, 'results' => array]
     */
    public function sendBulkSms(array $recipients): array
    {
        $results = [
            'total' => count($recipients),
            'sent' => 0,
            'failed' => 0,
            'details' => [],
        ];

        foreach ($recipients as $recipient) {
            $result = $this->sendSms($recipient['phone'], $recipient['message']);

            if ($result['success']) {
                $results['sent']++;
            } else {
                $results['failed']++;
            }

            $results['details'][] = [
                'phone' => $recipient['phone'],
                'success' => $result['success'],
                'message_sid' => $result['message_sid'],
                'error' => $result['error'],
            ];

            // Rate limiting: Sleep for 100ms between messages to avoid API limits
            usleep(100000);
        }

        return $results;
    }

    /**
     * Calculate SMS cost estimate.
     *
     * @param  string  $message  Message content
     * @param  int  $recipientCount  Number of recipients
     * @return array ['segments' => int, 'cost_per_recipient' => float, 'total_cost' => float]
     */
    public function estimateCost(string $message, int $recipientCount): array
    {
        $messageLength = strlen($message);

        // Calculate segments (160 chars for single, 153 for multi-part)
        $segments = $messageLength <= 160 ? 1 : ceil($messageLength / 153);

        // Cost per SMS segment (adjust based on your Twilio pricing)
        $costPerSegment = 0.05; // GHS 0.05 per segment

        $costPerRecipient = $segments * $costPerSegment;
        $totalCost = $costPerRecipient * $recipientCount;

        return [
            'segments' => $segments,
            'cost_per_recipient' => $costPerRecipient,
            'total_cost' => $totalCost,
        ];
    }

    /**
     * Validate phone number format.
     *
     * @param  string  $phone  Phone number
     */
    public function validatePhoneNumber(string $phone): bool
    {
        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9+]/', '', $phone);

        // Check if it starts with + and has 10-15 digits
        if (preg_match('/^\+[0-9]{10,15}$/', $cleaned)) {
            return true;
        }

        // Check if it's a valid format without + (we'll add it)
        if (preg_match('/^[0-9]{9,15}$/', $cleaned)) {
            return true;
        }

        return false;
    }

    /**
     * Format phone number to international format.
     *
     * @param  string  $phone  Phone number
     * @return string Formatted phone number
     */
    public function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters except +
        $cleaned = preg_replace('/[^0-9+]/', '', $phone);

        // If it already starts with +, return as is
        if (substr($cleaned, 0, 1) === '+') {
            return $cleaned;
        }

        // If it starts with 0, replace with country code (Ghana +233)
        if (substr($cleaned, 0, 1) === '0') {
            return '+233'.substr($cleaned, 1);
        }

        // If it doesn't start with + or 0, assume it needs country code
        return '+233'.$cleaned;
    }

    /**
     * Get SMS delivery status from Twilio.
     *
     * @param  string  $messageSid  Twilio message SID
     * @return array ['status' => string, 'error_code' => string|null, 'error_message' => string|null]
     */
    public function getMessageStatus(string $messageSid): array
    {
        if (! $this->client) {
            return [
                'status' => 'unknown',
                'error_code' => null,
                'error_message' => 'Twilio credentials not configured',
            ];
        }

        try {
            $message = $this->client->messages($messageSid)->fetch();

            return [
                'status' => $message->status,
                'error_code' => $message->errorCode,
                'error_message' => $message->errorMessage,
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'error_code' => null,
                'error_message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check if Twilio is properly configured.
     */
    public function isConfigured(): bool
    {
        return $this->client !== null;
    }
}
