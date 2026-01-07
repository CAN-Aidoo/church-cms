@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Create Event</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.events') }}" class="hover:text-primary-600 transition-colors">Events</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Create</span>
        </nav>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">New Event Details</h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('childrens-ministry.events.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                         <label for="event_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Event Name</label>
                        <input type="text" 
                               name="event_name" 
                               id="event_name" 
                               value="{{ old('event_name') }}" 
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" 
                               placeholder="e.g. Summer Vacation Bible School"
                               required>
                    </div>
                    
                     <div>
                        <label for="event_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Event Type</label>
                        <select name="event_type" id="event_type" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
                             @foreach($eventTypes as $type => $label)
                                <option value="{{ $type }}" {{ old('event_type') == $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                         <label for="coordinator_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Coordinator (User ID)</label>
                        {{-- Ideally a user select with search --}}
                         <input type="number" 
                                name="coordinator_id" 
                                id="coordinator_id" 
                                value="{{ old('coordinator_id', auth()->id()) }}" 
                                class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" 
                                required>
                        <p class="text-xs text-slate-500 mt-1">Enter user ID of the event lead.</p>
                    </div>

                    <div>
                        <label for="start_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Start Date</label>
                        <input type="date" 
                               name="start_date" 
                               id="start_date" 
                               value="{{ old('start_date') }}" 
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" 
                               required>
                    </div>

                     <div>
                        <label for="start_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Start Time</label>
                        <input type="time" 
                               name="start_time" 
                               id="start_time" 
                               value="{{ old('start_time') }}" 
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" 
                               required>
                    </div>

                    <div class="col-span-2">
                        <label for="description" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl"
                                  placeholder="Event details, activities involved, items to bring...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('childrens-ministry.events') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary shadow-lg shadow-primary-500/30">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
