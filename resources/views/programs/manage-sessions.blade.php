@extends('layouts.app')

@section('title', 'Manage Sessions - ' . $program->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-blue-600">Programs</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-blue-600">{{ $program->name }}</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span>Manage Sessions</span>
        </div>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manage Sessions</h1>
                <p class="text-gray-600 mt-1">{{ $program->name }}</p>
            </div>
            <button onclick="showAddSessionModal()" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Session
            </button>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Sessions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->sessions->count() }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Upcoming</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->sessions->where('session_date', '>=', now())->count() }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Completed</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->sessions->where('session_date', '<', now())->count() }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Attendance</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->sessions->sum('current_attendees') }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Sessions Timeline --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Session Schedule</h2>

        @if($program->sessions->count() > 0)
            <div class="space-y-4">
                @foreach($program->sessions->sortBy('session_date') as $session)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-lg font-bold text-gray-900">{{ $session->title }}</h3>
                                @if($session->session_date->isFuture())
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Upcoming</span>
                                @elseif($session->session_date->isToday())
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Today</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Completed</span>
                                @endif
                            </div>

                            @if($session->description)
                            <p class="text-sm text-gray-600 mb-4">{{ $session->description }}</p>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Date & Time</p>
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <div>{{ $session->session_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} -
                                                {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($session->venue)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Venue</p>
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $session->venue }}
                                    </div>
                                </div>
                                @endif

                                @if($session->speaker_name)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Speaker</p>
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $session->speaker_name }}
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Attendance</p>
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                        </svg>
                                        {{ $session->current_attendees }}
                                        @if($session->max_attendees)
                                            / {{ $session->max_attendees }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($session->speaker_bio)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-500 mb-1">Speaker Bio</p>
                                <p class="text-sm text-gray-600">{{ $session->speaker_bio }}</p>
                            </div>
                            @endif

                            @if($session->materials_required)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-500 mb-1">Materials Required</p>
                                <p class="text-sm text-gray-600">{{ $session->materials_required }}</p>
                            </div>
                            @endif
                        </div>

                        <div class="ml-4 flex gap-2">
                            <button onclick="editSession({{ $session->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </button>
                            <button onclick="deleteSession({{ $session->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Sessions Yet</h3>
                <p class="text-gray-600 mb-4">Start by adding your first session to this program</p>
                <button onclick="showAddSessionModal()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Add Session
                </button>
            </div>
        @endif
    </div>
</div>

{{-- Add/Edit Session Modal --}}
<div id="session-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold" id="modal-title">Add Session</h3>
            <button onclick="closeSessionModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>

        <form id="session-form" action="{{ route('programs.store-session', $program) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Session Title *</label>
                <input type="text" name="title" id="title" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="session_date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                    <input type="date" name="session_date" id="session_date" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="venue" class="block text-sm font-medium text-gray-700 mb-2">Venue</label>
                    <input type="text" name="venue" id="venue"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                    <input type="time" name="start_time" id="start_time" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                    <input type="time" name="end_time" id="end_time" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="speaker_name" class="block text-sm font-medium text-gray-700 mb-2">Speaker Name</label>
                    <input type="text" name="speaker_name" id="speaker_name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="max_attendees" class="block text-sm font-medium text-gray-700 mb-2">Max Attendees</label>
                    <input type="number" name="max_attendees" id="max_attendees" min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="speaker_bio" class="block text-sm font-medium text-gray-700 mb-2">Speaker Bio</label>
                <textarea name="speaker_bio" id="speaker_bio" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label for="materials_required" class="block text-sm font-medium text-gray-700 mb-2">Materials Required</label>
                <textarea name="materials_required" id="materials_required" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <button type="button" onclick="closeSessionModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Save Session
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddSessionModal() {
    document.getElementById('modal-title').textContent = 'Add Session';
    document.getElementById('session-form').action = '{{ route("programs.store-session", $program) }}';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('session-form').reset();
    document.getElementById('session-modal').classList.remove('hidden');
}

function editSession(sessionId) {
    // In a real implementation, fetch session data and populate form
    alert('Edit session feature - would load session data into modal');
}

function deleteSession(sessionId) {
    if (confirm('Are you sure you want to delete this session?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/programs/sessions/${sessionId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function closeSessionModal() {
    document.getElementById('session-modal').classList.add('hidden');
}
</script>
@endsection
