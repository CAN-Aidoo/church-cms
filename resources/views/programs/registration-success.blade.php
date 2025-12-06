@extends('layouts.app')

@section('title', 'Registration Successful')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        {{-- Success Message --}}
        <div class="bg-white rounded-lg shadow-md p-8 text-center mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Registration Successful!</h1>
            <p class="text-lg text-gray-600 mb-6">
                You have successfully registered for <strong>{{ $registration->program->name }}</strong>
            </p>

            <div class="inline-block bg-blue-50 border-2 border-blue-200 rounded-lg px-6 py-4 mb-4">
                <p class="text-sm text-gray-600 mb-1">Your Badge Number</p>
                <p class="text-3xl font-bold text-blue-600">{{ $registration->badge_number }}</p>
            </div>

            <p class="text-sm text-gray-500">
                Please keep this badge number for your records. You will need it for check-in.
            </p>
        </div>

        {{-- Registration Details --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Registration Details</h2>

            <dl class="space-y-4">
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Name</dt>
                    <dd class="text-sm text-gray-900 font-medium">{{ $registration->first_name }} {{ $registration->last_name }}</dd>
                </div>

                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Email</dt>
                    <dd class="text-sm text-gray-900">{{ $registration->email }}</dd>
                </div>

                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Phone</dt>
                    <dd class="text-sm text-gray-900">{{ $registration->phone }}</dd>
                </div>

                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Registration Status</dt>
                    <dd>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                               ($registration->status === 'waitlist' ? 'bg-yellow-100 text-yellow-800' :
                               'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </dd>
                </div>

                @if($registration->program->registration_fee > 0)
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Registration Fee</dt>
                    <dd class="text-sm text-gray-900 font-semibold">GHS {{ number_format($registration->amount_paid, 2) }}</dd>
                </div>

                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-600">Payment Status</dt>
                    <dd>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $registration->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                               ($registration->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' :
                               'bg-red-100 text-red-800') }}">
                            {{ ucfirst($registration->payment_status) }}
                        </span>
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        {{-- Program Information --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Program Information</h2>

            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-600">Program Name</p>
                    <p class="text-base text-gray-900">{{ $registration->program->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-600">Date</p>
                    <p class="text-base text-gray-900">
                        {{ $registration->program->start_date->format('l, F d, Y') }}
                        @if($registration->program->start_date != $registration->program->end_date)
                            - {{ $registration->program->end_date->format('l, F d, Y') }}
                        @endif
                    </p>
                </div>

                @if($registration->program->start_time && $registration->program->end_time)
                <div>
                    <p class="text-sm font-medium text-gray-600">Time</p>
                    <p class="text-base text-gray-900">
                        {{ \Carbon\Carbon::parse($registration->program->start_time)->format('g:i A') }}
                        - {{ \Carbon\Carbon::parse($registration->program->end_time)->format('g:i A') }}
                    </p>
                </div>
                @endif

                @if($registration->program->venue_name)
                <div>
                    <p class="text-sm font-medium text-gray-600">Venue</p>
                    <p class="text-base text-gray-900">{{ $registration->program->venue_name }}</p>
                    @if($registration->program->venue_address)
                        <p class="text-sm text-gray-600 mt-1">{{ $registration->program->venue_address }}</p>
                    @endif
                    @if($registration->program->venue_gps)
                        <p class="text-sm text-gray-600 mt-1">GPS: {{ $registration->program->venue_gps }}</p>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Payment Instructions --}}
        @if($registration->program->registration_fee > 0 && $registration->payment_status !== 'paid')
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Instructions</h2>
            <p class="text-sm text-gray-700 mb-4">
                Please complete your payment to confirm your registration. You can pay using any of the following methods:
            </p>

            <div class="space-y-3">
                <div class="bg-white rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Mobile Money</h3>
                    <p class="text-sm text-gray-700">
                        <strong>Number:</strong> +233 XX XXX XXXX<br>
                        <strong>Name:</strong> Church Account<br>
                        <strong>Reference:</strong> {{ $registration->badge_number }}
                    </p>
                </div>

                <div class="bg-white rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Bank Transfer</h3>
                    <p class="text-sm text-gray-700">
                        <strong>Bank:</strong> Example Bank<br>
                        <strong>Account Number:</strong> XXXXXXXXXXXX<br>
                        <strong>Account Name:</strong> Church Name<br>
                        <strong>Reference:</strong> {{ $registration->badge_number }}
                    </p>
                </div>

                <div class="bg-white rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Cash Payment</h3>
                    <p class="text-sm text-gray-700">
                        Visit the church office during business hours (Mon-Fri, 9:00 AM - 5:00 PM) to make your payment.
                    </p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mt-4">
                <strong>Important:</strong> After making payment, please send your payment receipt to
                <a href="mailto:finance@church.com" class="text-blue-600 hover:underline">finance@church.com</a>
                with your badge number for confirmation.
            </p>
        </div>
        @endif

        {{-- Next Steps --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">What's Next?</h2>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-gray-700">
                        <strong>Confirmation Email:</strong> Check your email ({{ $registration->email }}) for a confirmation message with all the details.
                    </span>
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-gray-700">
                        <strong>Add to Calendar:</strong> Add the program to your calendar so you don't forget!
                    </span>
                </li>
                @if($registration->program->registration_fee > 0 && $registration->payment_status !== 'paid')
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-gray-700">
                        <strong>Complete Payment:</strong> Follow the payment instructions above to confirm your registration.
                    </span>
                </li>
                @endif
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-gray-700">
                        <strong>Check-in Day:</strong> Bring your badge number on the day of the event for quick check-in.
                    </span>
                </li>
            </ul>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('programs.show', $registration->program) }}" class="flex-1 px-6 py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition">
                View Program Details
            </a>
            <a href="{{ route('programs.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 text-center rounded-lg hover:bg-gray-300 transition">
                Browse More Programs
            </a>
            <button onclick="window.print()" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 text-center rounded-lg hover:bg-gray-300 transition">
                Print Confirmation
            </button>
        </div>

        {{-- Contact Information --}}
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Questions? Contact us at <a href="mailto:info@church.com" class="text-blue-600 hover:underline">info@church.com</a> or +233 XX XXX XXXX</p>
        </div>
    </div>
</div>
@endsection
