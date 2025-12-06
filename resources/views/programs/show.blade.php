@extends('layouts.app')

@section('title', $program->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-blue-600">Programs</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $program->name }}</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $program->name }}</h1>
                <div class="flex items-center gap-3 mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $program->getStatusBadgeClass() }}">
                        {{ ucfirst($program->status) }}
                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                        {{ $program->getTypeLabel() }}
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                @can('update', $program)
                    @if($program->status === 'draft')
                        <form action="{{ route('programs.publish', $program) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Publish
                            </button>
                        </form>
                    @endif

                    @if($program->status === 'published' && $program->start_date->isToday())
                        <form action="{{ route('programs.start', $program) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Start Program
                            </button>
                        </form>
                    @endif

                    @if($program->status === 'ongoing' && $program->end_date->isPast())
                        <form action="{{ route('programs.complete', $program) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                Mark Complete
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('programs.edit', $program) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Edit
                    </a>

                    @if(in_array($program->status, ['draft', 'published']))
                        <form action="{{ route('programs.cancel', $program) }}" method="POST" class="inline"
                              onsubmit="return confirm('Are you sure you want to cancel this program?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Cancel Program
                            </button>
                        </form>
                    @endif
                @endcan

                @if($program->canRegister())
                    <a href="{{ route('programs.registration-form', $program) }}" class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition">
                        Register Now
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Flyer --}}
    @if($program->flyer_path)
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <img src="{{ Storage::url($program->flyer_path) }}" alt="{{ $program->name }}" class="w-full max-h-96 object-cover">
    </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Registrations</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $statistics['total_registrations'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Confirmed</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $statistics['confirmed_registrations'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Capacity</p>
                    <p class="text-3xl font-bold text-gray-900">{{ round($statistics['capacity_percentage']) }}%</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">GHS {{ number_format($statistics['total_revenue'], 2) }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Avg Rating</p>
                    <p class="text-3xl font-bold text-gray-900">
                        @if($statistics['average_rating'])
                            {{ number_format($statistics['average_rating'], 1) }} ⭐
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button onclick="showTab('overview')" id="tab-overview" class="tab-button py-4 px-6 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                    Overview
                </button>
                <button onclick="showTab('sessions')" id="tab-sessions" class="tab-button py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent">
                    Sessions ({{ $program->sessions->count() }})
                </button>
                <button onclick="showTab('registrations')" id="tab-registrations" class="tab-button py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent">
                    Registrations ({{ $program->registrations->count() }})
                </button>
                <button onclick="showTab('feedback')" id="tab-feedback" class="tab-button py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent">
                    Feedback ({{ $statistics['feedback_count'] }})
                </button>
                <button onclick="showTab('resources')" id="tab-resources" class="tab-button py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent">
                    Resources ({{ $program->resources->count() }})
                </button>
            </nav>
        </div>

        {{-- Overview Tab --}}
        <div id="content-overview" class="tab-content p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Program Details</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $program->description }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $program->start_date->format('M d, Y') }} - {{ $program->end_date->format('M d, Y') }}
                                ({{ $program->start_date->diffInDays($program->end_date) + 1 }} days)
                            </dd>
                        </div>
                        @if($program->start_time && $program->end_time)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                            </dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucwords(str_replace('_', ' ', $program->category)) }}</dd>
                        </div>
                        @if($program->target_audience)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Target Audience</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $program->target_audience }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Venue Information</h3>
                    <dl class="space-y-3">
                        @if($program->venue_name)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Venue</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $program->venue_name }}</dd>
                        </div>
                        @endif
                        @if($program->venue_address)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $program->venue_address }}</dd>
                        </div>
                        @endif
                        @if($program->venue_gps)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">GPS Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $program->venue_gps }}</dd>
                        </div>
                        @endif
                    </dl>

                    @if($program->requires_registration)
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 mt-6">Registration Info</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Registration Fee</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($program->registration_fee > 0)
                                    GHS {{ number_format($program->registration_fee, 2) }}
                                @else
                                    Free
                                @endif
                            </dd>
                        </div>
                        @if($program->max_participants)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Capacity</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $program->current_participants }} / {{ $program->max_participants }} registered
                            </dd>
                        </div>
                        @endif
                    </dl>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sessions Tab --}}
        <div id="content-sessions" class="tab-content p-6" style="display: none;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Program Sessions</h3>
                @can('update', $program)
                <a href="{{ route('programs.manage-sessions', $program) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Manage Sessions
                </a>
                @endcan
            </div>

            @forelse($program->sessions as $session)
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $session->title }}</h4>
                        @if($session->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $session->description }}</p>
                        @endif
                        <div class="mt-3 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date & Time</p>
                                <p class="text-sm text-gray-900">
                                    {{ $session->session_date->format('M d, Y') }}
                                    {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}
                                </p>
                            </div>
                            @if($session->venue)
                            <div>
                                <p class="text-sm text-gray-500">Venue</p>
                                <p class="text-sm text-gray-900">{{ $session->venue }}</p>
                            </div>
                            @endif
                            @if($session->speaker_name)
                            <div>
                                <p class="text-sm text-gray-500">Speaker</p>
                                <p class="text-sm text-gray-900">{{ $session->speaker_name }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-500">Attendance</p>
                                <p class="text-sm text-gray-900">
                                    {{ $session->current_attendees }}
                                    @if($session->max_attendees)
                                        / {{ $session->max_attendees }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-500">No sessions scheduled yet</p>
            </div>
            @endforelse
        </div>

        {{-- Registrations Tab --}}
        <div id="content-registrations" class="tab-content p-6" style="display: none;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Participant Registrations</h3>
                @can('update', $program)
                <a href="{{ route('programs.manage-registrations', $program) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Manage Registrations
                </a>
                @endcan
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($program->registrations->take(10) as $registration)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $registration->first_name }} {{ $registration->last_name }}</div>
                                @if($registration->badge_number)
                                <div class="text-sm text-gray-500">{{ $registration->badge_number }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $registration->email }}</div>
                                <div class="text-sm text-gray-500">{{ $registration->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                       ($registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       ($registration->status === 'attended' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $registration->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                       ($registration->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($registration->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $registration->registered_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-gray-500">No registrations yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($program->registrations->count() > 10)
            <div class="mt-4 text-center">
                <a href="{{ route('programs.manage-registrations', $program) }}" class="text-blue-600 hover:text-blue-800">
                    View all {{ $program->registrations->count() }} registrations →
                </a>
            </div>
            @endif
        </div>

        {{-- Feedback Tab --}}
        <div id="content-feedback" class="tab-content p-6" style="display: none;">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Program Feedback</h3>

            @if($program->feedback->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">Average Rating</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($statistics['average_rating'], 1) }} ⭐</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">Total Responses</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $statistics['feedback_count'] }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">Would Recommend</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $program->feedback->where('would_recommend', true)->count() }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($program->feedback->take(5) as $feedback)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-gray-900">{{ $feedback->registration->first_name }} {{ $feedback->registration->last_name }}</p>
                                <p class="text-sm text-gray-500">{{ $feedback->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">{{ $feedback->overall_rating }} ⭐</p>
                            </div>
                        </div>
                        @if($feedback->comments)
                        <p class="text-sm text-gray-700 mt-2">{{ $feedback->comments }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <p class="text-gray-500">No feedback submitted yet</p>
            </div>
            @endif
        </div>

        {{-- Resources Tab --}}
        <div id="content-resources" class="tab-content p-6" style="display: none;">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Program Resources</h3>

            @forelse($program->resources as $resource)
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">{{ ucfirst($resource->resource_type) }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $resource->resource_name }}</p>
                        @if($resource->quantity)
                        <p class="text-sm text-gray-500 mt-2">Quantity: {{ $resource->quantity }}</p>
                        @endif
                        @if($resource->cost)
                        <p class="text-sm text-gray-500">Cost: GHS {{ number_format($resource->cost, 2) }}</p>
                        @endif
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm {{ $resource->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($resource->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($resource->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <p class="text-gray-500">No resources allocated yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });

    // Reset all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('text-blue-600', 'border-blue-600');
        button.classList.add('text-gray-500', 'border-transparent');
    });

    // Show selected tab content
    document.getElementById('content-' + tabName).style.display = 'block';

    // Highlight selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('text-gray-500', 'border-transparent');
    activeButton.classList.add('text-blue-600', 'border-blue-600');
}
</script>
@endsection
