<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\NotificationService;
use App\Services\PaymentGatewayService;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MobilePaymentController extends Controller
{
    public function __construct(
        protected QrCodeService $qrCodeService,
        protected PaymentGatewayService $paymentGatewayService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Initiate mobile payment via QR code scan.
     */
    public function initiatePayment(Request $request)
    {
        $validated = $request->validate([
            'token' => 'nullable|string', // QR code token
            'amount' => 'required|numeric|min:1',
            'category' => 'required|in:tithe,offering,pledge,donation,welfare,project',
            'payment_method' => 'required|in:mobile_money,card,bank_transfer',
            'description' => 'nullable|string|max:500',
            'is_anonymous' => 'nullable|boolean',
            'mobile_money_number' => 'required_if:payment_method,mobile_money|string',
            'mobile_money_provider' => 'required_if:payment_method,mobile_money|in:mtn,vodafone,airteltigo',
        ]);

        $user = $request->user();
        $member = $user ? $user->member : null;

        // Verify user is allowed to make payments (requires admin verification)
        if (! $user || ! $user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Payment requires verified account. Please wait for admin approval.',
            ], 403);
        }

        try {
            DB::beginTransaction();

            // Generate unique transaction code
            $transactionCode = 'TXN-'.date('YmdHis').'-'.strtoupper(Str::random(6));

            // Create transaction record
            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'member_id' => $validated['is_anonymous'] ? null : ($member ? $member->id : null),
                'user_id' => $user->id,
                'transaction_type' => 'income',
                'category' => $validated['category'],
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'description' => $validated['description'] ?? ucfirst($validated['category']).' via mobile',
                'transaction_date' => now(),
                'status' => 'pending',
                'is_anonymous' => $validated['is_anonymous'] ?? false,
                'metadata' => json_encode([
                    'source' => 'mobile_app',
                    'qr_token' => $validated['token'] ?? null,
                    'mobile_money_number' => $validated['mobile_money_number'] ?? null,
                    'mobile_money_provider' => $validated['mobile_money_provider'] ?? null,
                ]),
            ]);

            // Process payment based on method
            $paymentResult = match ($validated['payment_method']) {
                'mobile_money' => $this->paymentGatewayService->processMobileMoney([
                    'amount' => $validated['amount'],
                    'phone' => $validated['mobile_money_number'],
                    'provider' => $validated['mobile_money_provider'],
                    'transaction_code' => $transactionCode,
                    'description' => $validated['description'] ?? ucfirst($validated['category']),
                ]),
                'card' => $this->paymentGatewayService->initiateCardPayment([
                    'amount' => $validated['amount'],
                    'transaction_code' => $transactionCode,
                    'callback_url' => route('mobile.payment.callback'),
                ]),
                'bank_transfer' => [
                    'success' => true,
                    'message' => 'Bank transfer details provided',
                    'payment_pending' => true,
                ],
                default => throw new \Exception('Invalid payment method')
            };

            if (! $paymentResult['success']) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => $paymentResult['message'] ?? 'Payment initiation failed',
                ], 400);
            }

            // Update transaction with payment reference
            $transaction->update([
                'payment_reference' => $paymentResult['reference'] ?? null,
                'payment_url' => $paymentResult['payment_url'] ?? null,
            ]);

            DB::commit();

            // Send notification
            if (! $validated['is_anonymous'] && $member) {
                $this->notificationService->notifyPaymentInitiated($transaction, $member);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment initiated successfully',
                'data' => [
                    'transaction_code' => $transactionCode,
                    'amount' => $validated['amount'],
                    'category' => $validated['category'],
                    'status' => 'pending',
                    'payment_reference' => $paymentResult['reference'] ?? null,
                    'payment_url' => $paymentResult['payment_url'] ?? null,
                    'instructions' => $this->getPaymentInstructions($validated['payment_method'], $paymentResult),
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Payment failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify payment status.
     */
    public function verifyPayment(Request $request)
    {
        $validated = $request->validate([
            'transaction_code' => 'required|string|exists:transactions,transaction_code',
        ]);

        $transaction = Transaction::where('transaction_code', $validated['transaction_code'])->first();

        if (! $transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        // Verify with payment gateway
        $verificationResult = $this->paymentGatewayService->verifyPayment(
            $transaction->payment_reference ?? $transaction->transaction_code
        );

        // Update transaction status based on verification
        if ($verificationResult['success'] && $verificationResult['status'] === 'completed') {
            $transaction->update([
                'status' => 'completed',
                'approved_by' => null, // Auto-approved for mobile payments
                'approved_at' => now(),
            ]);

            // Generate receipt
            $receipt = $this->generateDigitalReceipt($transaction);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified and completed',
                'data' => [
                    'transaction_code' => $transaction->transaction_code,
                    'amount' => $transaction->amount,
                    'category' => $transaction->category,
                    'status' => 'completed',
                    'completed_at' => $transaction->approved_at,
                    'receipt_url' => $receipt['url'],
                    'receipt_pdf' => $receipt['pdf_url'],
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment status retrieved',
            'data' => [
                'transaction_code' => $transaction->transaction_code,
                'status' => $transaction->status,
                'payment_status' => $verificationResult['status'] ?? 'pending',
            ],
        ]);
    }

    /**
     * Get payment QR code details.
     */
    public function getPaymentQrDetails(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $qrData = $this->qrCodeService->validateToken($validated['token'], 'payment');

        if (! $qrData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired QR code',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'amount' => $qrData['amount'],
                'category' => $qrData['category'],
                'description' => $qrData['description'],
                'suggested_amounts' => $this->getSuggestedAmounts($qrData['category']),
                'payment_methods' => [
                    'mobile_money' => [
                        'available' => true,
                        'providers' => ['mtn', 'vodafone', 'airteltigo'],
                    ],
                    'card' => ['available' => true],
                    'bank_transfer' => ['available' => true],
                ],
            ],
        ]);
    }

    /**
     * Setup recurring payment.
     */
    public function setupRecurringPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'category' => 'required|in:tithe,offering,donation',
            'frequency' => 'required|in:weekly,monthly,quarterly',
            'start_date' => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:mobile_money,card',
            'mobile_money_number' => 'required_if:payment_method,mobile_money|string',
            'mobile_money_provider' => 'required_if:payment_method,mobile_money|in:mtn,vodafone,airteltigo',
        ]);

        $user = $request->user();
        $member = $user->member;

        if (! $user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Recurring payments require verified account',
            ], 403);
        }

        try {
            // Create recurring payment schedule
            $schedule = DB::table('recurring_payments')->insert([
                'member_id' => $member->id,
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'category' => $validated['category'],
                'frequency' => $validated['frequency'],
                'payment_method' => $validated['payment_method'],
                'start_date' => $validated['start_date'],
                'next_payment_date' => $validated['start_date'],
                'status' => 'active',
                'metadata' => json_encode([
                    'mobile_money_number' => $validated['mobile_money_number'] ?? null,
                    'mobile_money_provider' => $validated['mobile_money_provider'] ?? null,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recurring payment setup successfully',
                'data' => [
                    'amount' => $validated['amount'],
                    'category' => $validated['category'],
                    'frequency' => $validated['frequency'],
                    'start_date' => $validated['start_date'],
                    'next_payment_date' => $validated['start_date'],
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Setup failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get payment history.
     */
    public function paymentHistory(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        $transactions = Transaction::where('user_id', $user->id)
            ->orWhere(function ($query) use ($member) {
                if ($member) {
                    $query->where('member_id', $member->id)
                        ->where('is_anonymous', false);
                }
            })
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => [
                'transactions' => $transactions->map(function ($transaction) {
                    return [
                        'transaction_code' => $transaction->transaction_code,
                        'amount' => $transaction->amount,
                        'category' => $transaction->category,
                        'payment_method' => $transaction->payment_method,
                        'status' => $transaction->status,
                        'date' => $transaction->transaction_date,
                        'receipt_available' => $transaction->status === 'completed',
                    ];
                }),
                'pagination' => [
                    'total' => $transactions->total(),
                    'per_page' => $transactions->perPage(),
                    'current_page' => $transactions->currentPage(),
                    'last_page' => $transactions->lastPage(),
                ],
                'summary' => [
                    'total_paid_this_year' => Transaction::where('user_id', $user->id)
                        ->whereYear('transaction_date', now()->year)
                        ->where('status', 'completed')
                        ->sum('amount'),
                    'total_paid_this_month' => Transaction::where('user_id', $user->id)
                        ->whereMonth('transaction_date', now()->month)
                        ->where('status', 'completed')
                        ->sum('amount'),
                ],
            ],
        ]);
    }

    /**
     * Get suggested amounts for a category.
     */
    private function getSuggestedAmounts(string $category): array
    {
        return match ($category) {
            'tithe' => [50, 100, 200, 500],
            'offering' => [20, 50, 100, 200],
            'donation' => [100, 500, 1000, 5000],
            'welfare' => [50, 100, 200, 500],
            default => [50, 100, 200, 500]
        };
    }

    /**
     * Get payment instructions based on method.
     */
    private function getPaymentInstructions(string $method, array $result): string
    {
        return match ($method) {
            'mobile_money' => 'Please authorize the payment on your phone. A prompt has been sent to '.($result['phone'] ?? 'your number'),
            'card' => 'Please complete payment at the provided URL',
            'bank_transfer' => 'Please transfer to the church bank account. Details have been sent to your email.',
            default => 'Complete the payment to finalize your transaction'
        };
    }

    /**
     * Generate digital receipt.
     */
    private function generateDigitalReceipt(Transaction $transaction): array
    {
        // This would generate actual PDF receipt
        return [
            'url' => route('receipts.view', $transaction->transaction_code),
            'pdf_url' => route('receipts.pdf', $transaction->transaction_code),
        ];
    }
}
