@extends('layouts.app')

@section('title', 'Register for ' . $program->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        {{-- Program Header --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            @if($program->flyer_path)
            <img src="{{ Storage::url($program->flyer_path) }}" alt="{{ $program->name }}" class="w-full h-64 object-cover">
            @else
            <div class="w-full h-64 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                <svg class="w-32 h-32 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
                </svg>
            </div>
            @endif

            <div class="p-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $program->getStatusBadgeClass() }}">
                        {{ ucfirst($program->status) }}
                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                        {{ $program->getTypeLabel() }}
                    </span>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $program->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $program->description }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-200 pt-4">
                    <div>
                        <div class="flex items-center text-sm text-gray-700 mb-2">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Date:</span>
                            <span class="ml-1">{{ $program->start_date->format('M d') }} - {{ $program->end_date->format('M d, Y') }}</span>
                        </div>

                        @if($program->venue_name)
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Venue:</span>
                            <span class="ml-1">{{ $program->venue_name }}</span>
                        </div>
                        @endif
                    </div>

                    <div>
                        @if($program->registration_fee > 0)
                        <div class="flex items-center text-sm text-gray-700 mb-2">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Fee:</span>
                            <span class="ml-1 text-lg font-bold text-blue-600">GHS {{ number_format($program->registration_fee, 2) }}</span>
                        </div>
                        @else
                        <div class="flex items-center text-sm text-gray-700 mb-2">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium text-green-600">FREE Registration</span>
                        </div>
                        @endif

                        @if($program->max_participants)
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                            <span class="font-medium">Capacity:</span>
                            <span class="ml-1">{{ $program->current_participants }} / {{ $program->max_participants }}</span>
                            @if($program->has_spots_available)
                                <span class="ml-2 text-green-600">({{ $program->max_participants - $program->current_participants }} spots left)</span>
                            @else
                                <span class="ml-2 text-red-600">(Full - Waitlist)</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Registration Form --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Registration Form</h2>

            <form action="{{ route('programs.register', $program) }}" method="POST" class="space-y-6">
                @csrf

                {{-- Personal Information --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', Auth::user()->member->first_name ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror">
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', Auth::user()->member->last_name ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror">
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->member->phone ?? '') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Special Requirements --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
                    <div>
                        <label for="special_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                            Special Requirements or Dietary Restrictions (Optional)
                        </label>
                        <textarea name="special_requirements" id="special_requirements" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('special_requirements') border-red-500 @enderror"
                                  placeholder="E.g., wheelchair access, dietary restrictions, childcare needs...">{{ old('special_requirements') }}</textarea>
                        @error('special_requirements')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Payment Information --}}
                @if($program->registration_fee > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment Information</h3>
                    <p class="text-sm text-gray-700 mb-2">
                        Registration Fee: <span class="text-xl font-bold text-blue-600">GHS {{ number_format($program->registration_fee, 2) }}</span>
                    </p>
                    <p class="text-sm text-gray-600">
                        After submitting this form, you will receive payment instructions via email and SMS.
                        Your registration will be confirmed once payment is received.
                    </p>
                </div>
                @endif

                {{-- Terms & Conditions --}}
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-start">
                        <input type="checkbox" name="agree_terms" id="agree_terms" value="1" required
                               class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="agree_terms" class="ml-2 text-sm text-gray-700">
                            I agree to the terms and conditions and confirm that the information provided is accurate. *
                        </label>
                    </div>
                    @error('agree_terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex justify-end gap-4">
                    <a href="{{ route('programs.show', $program) }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-semibold">
                        Complete Registration
                    </button>
                </div>
            </form>
        </div>

        {{-- Help Section --}}
        <div class="bg-gray-50 rounded-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Need Help?</h3>
            <p class="text-sm text-gray-600 mb-2">
                If you have any questions about this program or the registration process, please contact:
            </p>
            <p class="text-sm text-gray-700">
                <strong>Email:</strong> info@church.com<br>
                <strong>Phone:</strong> +233 XX XXX XXXX
            </p>
        </div>
    </div>
</div>
@endsection
