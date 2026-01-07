@extends('layouts.app')

@section('title', 'Registration Successful')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full mb-6 ring-8 ring-emerald-50">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-3xl font-heading font-bold text-slate-900 mb-2">Registration Successful!</h1>
        <p class="text-lg text-slate-600">
            You have successfully registered for <span class="font-bold text-slate-900">{{ $registration->program->name }}</span>
        </p>
    </div>

    <!-- Badge Card -->
    <div class="card bg-white border border-slate-200 shadow-lg overflow-hidden mb-8 relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary-500 to-indigo-600"></div>
        <div class="p-8 text-center">
            <p class="text-sm uppercase tracking-wider text-slate-500 font-semibold mb-2">Your Badge Number</p>
            <div class="inline-block bg-slate-50 border-2 border-slate-200 border-dashed rounded-xl px-8 py-4 mb-4">
                <span class="text-4xl font-mono font-bold text-primary-600 tracking-wider">{{ $registration->badge_number }}</span>
            </div>
            <p class="text-sm text-slate-500 max-w-sm mx-auto">
                Please keep this badge number for your records. You will need it for check-in on the day of the event.
            </p>
        </div>
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-between items-center text-sm">
             <span class="text-slate-600">Status: 
                <span class="font-bold {{ $registration->status === 'confirmed' ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ ucfirst($registration->status) }}
                </span>
            </span>
             <button onclick="window.print()" class="text-primary-600 hover:text-primary-700 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Details Column -->
        <div class="space-y-6">
            <div class="card border border-slate-100 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Registration Details</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Name</dt>
                        <dd class="font-medium text-slate-900">{{ $registration->first_name }} {{ $registration->last_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Email</dt>
                        <dd class="font-medium text-slate-900">{{ $registration->email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Phone</dt>
                        <dd class="font-medium text-slate-900">{{ $registration->phone }}</dd>
                    </div>
                    @if($registration->program->registration_fee > 0)
                    <div class="flex justify-between pt-2 border-t border-slate-100 mt-2">
                        <dt class="text-slate-500">Fee</dt>
                        <dd class="font-medium text-slate-900">GHS {{ number_format($registration->amount_paid, 2) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Payment</dt>
                        <dd class="font-medium">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium capitalize
                                {{ $registration->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' :
                                   ($registration->payment_status === 'partial' ? 'bg-amber-100 text-amber-800' :
                                   'bg-red-100 text-red-800') }}">
                                {{ $registration->payment_status }}
                            </span>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
            
             <div class="card border border-slate-100 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Program Info</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-slate-500 mb-1">Date & Time</dt>
                        <dd class="font-medium text-slate-900">
                             {{ $registration->program->start_date->format('D, M d, Y') }}<br>
                             <span class="text-slate-500 font-normal">
                                {{ \Carbon\Carbon::parse($registration->program->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($registration->program->end_time)->format('g:i A') }}
                             </span>
                        </dd>
                    </div>
                    @if($registration->program->venue_name)
                    <div>
                        <dt class="text-slate-500 mb-1">Venue</dt>
                        <dd class="font-medium text-slate-900">
                            {{ $registration->program->venue_name }}
                            @if($registration->program->venue_address)
                            <br><span class="text-slate-500 font-normal">{{ $registration->program->venue_address }}</span>
                            @endif
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Instructions Column -->
        <div class="space-y-6">
           @if($registration->program->registration_fee > 0 && $registration->payment_status !== 'paid')
            <div class="card bg-amber-50 border border-amber-200 shadow-sm p-6">
                <h3 class="font-bold text-amber-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Payment Required
                </h3>
                <p class="text-sm text-amber-800 mb-4">To confirm your registration, please complete payment:</p>
                
                <div class="space-y-3">
                    <div class="bg-white/60 rounded p-3 text-sm">
                        <p class="font-bold text-amber-900">Mobile Money</p>
                        <p class="text-amber-800">055-555-5555 (Church Name)</p>
                        <p class="text-xs text-amber-700 mt-1">Ref: {{ $registration->badge_number }}</p>
                    </div>
                    <div class="bg-white/60 rounded p-3 text-sm">
                        <p class="font-bold text-amber-900">Bank Transfer</p>
                        <p class="text-amber-800">Bank Name | 1234567890</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="card border border-slate-100 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Next Steps</h3>
                <ul class="space-y-4">
                    <li class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">1</div>
                        <div>
                            <p class="font-medium text-slate-900 text-sm">Check Email</p>
                            <p class="text-xs text-slate-500">Confirmation sent to {{ $registration->email }}</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">2</div>
                        <div>
                            <p class="font-medium text-slate-900 text-sm">Add to Calendar</p>
                            <p class="text-xs text-slate-500">Save the date so you don't miss out</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">3</div>
                        <div>
                            <p class="font-medium text-slate-900 text-sm">Check In</p>
                            <p class="text-xs text-slate-500">Present Badge #{{ $registration->badge_number }} at entry</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{ route('programs.show', $registration->program) }}" class="btn btn-primary px-8">
            Return to Program
        </a>
        <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary px-8">
            Browse More Programs
        </a>
    </div>
</div>
@endsection
