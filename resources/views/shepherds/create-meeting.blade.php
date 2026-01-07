@extends('layouts.app')

@section('title', 'Schedule Meeting')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Schedule Meeting</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
            <span>/</span>
            <a href="{{ route('shepherds.show', $shepherd) }}" class="hover:text-primary-600 transition-colors">{{ $shepherd->flock_name }}</a>
            <span>/</span>
            <a href="{{ route('shepherds.meetings', $shepherd) }}" class="hover:text-primary-600 transition-colors">Meetings</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Schedule</span>
        </nav>
    </div>
</div>

<form method="POST" action="{{ route('shepherds.store-meeting', $shepherd) }}" class="max-w-5xl mx-auto">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Meeting Details -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Meeting Details</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Meeting Date -->
                        <div>
                            <label for="meeting_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Date</label>
                            <input type="date"
                                   name="meeting_date"
                                   id="meeting_date"
                                   value="{{ old('meeting_date') }}"
                                   required
                                   min="{{ date('Y-m-d') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('meeting_date') border-red-500 @enderror">
                            @error('meeting_date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meeting Time -->
                        <div>
                            <label for="meeting_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Time</label>
                            <input type="time"
                                   name="meeting_time"
                                   id="meeting_time"
                                   value="{{ old('meeting_time') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('meeting_time') border-red-500 @enderror">
                            @error('meeting_time')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Location</label>
                        <input type="text"
                               name="location"
                               id="location"
                               value="{{ old('location') }}"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('location') border-red-500 @enderror"
                               placeholder="e.g., Church Hall, Zoom, Leader's House">
                        @error('location')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Meeting Type -->
                    <div>
                        <label for="meeting_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Type</label>
                        <select name="meeting_type"
                                id="meeting_type"
                                required
                                class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('meeting_type') border-red-500 @enderror">
                            <option value="">Select type...</option>
                            <option value="regular" {{ old('meeting_type') == 'regular' ? 'selected' : '' }}>Regular Meeting</option>
                            <option value="special" {{ old('meeting_type') == 'special' ? 'selected' : '' }}>Special Event</option>
                            <option value="emergency" {{ old('meeting_type') == 'emergency' ? 'selected' : '' }}>Emergency Meeting</option>
                            <option value="social" {{ old('meeting_type') == 'social' ? 'selected' : '' }}>Social Gathering</option>
                        </select>
                        @error('meeting_type')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agenda -->
                    <div>
                        <label for="agenda" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Agenda</label>
                        <textarea name="agenda"
                                  id="agenda"
                                  rows="4"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('agenda') border-red-500 @enderror"
                                  placeholder="List topics to be discussed...">{{ old('agenda') }}</textarea>
                        @error('agenda')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Additional Notes</label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('notes') border-red-500 @enderror"
                                  placeholder="Any other details...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Instructions Card -->
            <div class="card p-6 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 text-lg mb-2">Meeting Guidelines</h4>
                        <ul class="text-sm text-blue-800 space-y-2 list-none">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Plan agenda in advance</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Notify members at least 24 hours before</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Record attendance after the meeting</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Schedule Meeting
                    </button>
                    <a href="{{ route('shepherds.meetings', $shepherd) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
