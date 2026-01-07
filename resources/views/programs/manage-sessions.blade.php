@extends('layouts.app')

@section('title', 'Manage Sessions - ' . $program->name)

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-primary-600 transition-colors">Programs</a>
            <span>/</span>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-primary-600 transition-colors">{{ $program->name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Sessions</span>
        </nav>
        <h1 class="text-3xl font-heading font-bold text-slate-900">Manage Sessions</h1>
    </div>
    
    <button onclick="showAddSessionModal()" class="btn btn-primary shadow-lg shadow-primary-500/20">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Session
    </button>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Sessions</p>
            <p class="text-3xl font-bold text-slate-900">{{ $program->sessions->count() }}</p>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Upcoming</p>
            <p class="text-3xl font-bold text-slate-900">{{ $program->sessions->where('session_date', '>=', now())->count() }}</p>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Completed</p>
             <p class="text-3xl font-bold text-slate-900">{{ $program->sessions->where('session_date', '<', now())->count() }}</p>
        </div>
        <div class="w-12 h-12 bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Attendance</p>
             <p class="text-3xl font-bold text-slate-900">{{ $program->sessions->sum('current_attendees') }}</p>
        </div>
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>
</div>

<!-- Sessions List -->
<div class="card border border-slate-100 shadow-sm p-6">
    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center">
        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Session Schedule
    </h2>

    @if($program->sessions->count() > 0)
        <div class="space-y-4">
            @foreach($program->sessions->sortBy('session_date') as $session)
            <div class="group border border-slate-200 rounded-xl p-5 hover:border-primary-200 hover:shadow-md hover:shadow-primary-500/5 transition-all duration-200 bg-white">
                <div class="flex flex-col lg:flex-row lg:items-start gap-5">
                    
                    <!-- Date Badge -->
                    <div class="flex-shrink-0 flex flex-col items-center justify-center w-16 h-16 bg-slate-50 border border-slate-100 rounded-xl">
                        <span class="text-xs font-bold text-slate-500 uppercase">{{ $session->session_date->format('M') }}</span>
                        <span class="text-2xl font-bold text-slate-900">{{ $session->session_date->format('d') }}</span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                            <h3 class="text-lg font-bold text-slate-900 truncate">{{ $session->title }}</h3>
                             @if($session->session_date->isFuture())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800">Upcoming</span>
                            @elseif($session->session_date->isToday())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Today</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600">Completed</span>
                            @endif
                        </div>

                        @if($session->description)
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $session->description }}</p>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                            <div class="flex items-center text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}
                            </div>
                            
                            @if($session->venue)
                            <div class="flex items-center text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $session->venue }}
                            </div>
                            @endif

                            @if($session->speaker_name)
                            <div class="flex items-center text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $session->speaker_name }}
                            </div>
                            @endif

                             <div class="flex items-center text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                {{ $session->current_attendees }}
                                @if($session->max_attendees)
                                    <span class="text-slate-400 mx-1">/</span> {{ $session->max_attendees }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex lg:flex-col gap-2 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity">
                        <button onclick="editSession({{ $session->id }})" class="btn btn-sm btn-outline-primary whitespace-nowrap">
                            Edit
                        </button>
                        <button onclick="deleteSession({{ $session->id }})" class="btn btn-sm btn-outline-danger whitespace-nowrap">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1">No Sessions Scheduled</h3>
            <p class="text-slate-500 mb-4">Start by adding your first session to this program.</p>
            <button onclick="showAddSessionModal()" class="btn btn-primary">
                Add Session
            </button>
        </div>
    @endif
</div>

{{-- Add/Edit Session Modal --}}
<div id="session-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeSessionModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-slate-900" id="modal-title">Add Session</h3>
                    <button onclick="closeSessionModal()" class="text-slate-400 hover:text-slate-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="session-form" action="{{ route('programs.store-session', $program) }}" method="POST" class="space-y-6">
                    @csrf
                     <input type="hidden" name="_method" id="form-method" value="POST">

                    <div>
                        <label for="title" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Session Title</label>
                        <input type="text" name="title" id="title" required
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    </div>

                    <div>
                        <label for="description" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="session_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Date</label>
                            <input type="date" name="session_date" id="session_date" required
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                        </div>
                        <div>
                            <label for="venue" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Venue</label>
                            <input type="text" name="venue" id="venue"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                         <div>
                            <label for="start_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Start Time</label>
                            <input type="time" name="start_time" id="start_time" required
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                        </div>
                        <div>
                            <label for="end_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">End Time</label>
                            <input type="time" name="end_time" id="end_time" required
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="speaker_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Speaker Name</label>
                            <input type="text" name="speaker_name" id="speaker_name"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                        </div>
                         <div>
                            <label for="max_attendees" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Max Attendees</label>
                            <input type="number" name="max_attendees" id="max_attendees" min="1"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                        </div>
                    </div>

                    <div>
                        <label for="speaker_bio" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Speaker Bio</label>
                        <textarea name="speaker_bio" id="speaker_bio" rows="2"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"></textarea>
                    </div>

                     <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeSessionModal()" class="btn btn-outline-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
