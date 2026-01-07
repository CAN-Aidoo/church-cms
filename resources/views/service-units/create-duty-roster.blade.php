@extends('layouts.app')

@section('title', 'Create Duty Roster - ' . $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Create Duty Roster</h1>
            <p class="text-slate-600">Schedule a new duty for <span class="font-medium text-slate-900">{{ $serviceUnit->name }}</span></p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('service-units.store-duty-roster', $serviceUnit) }}" method="POST" class="space-y-8">
        @csrf

        <!-- Basic Information -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Duty Details</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Roster Name -->
                <div class="md:col-span-2">
                    <label for="roster_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Duty Name
                    </label>
                    <input type="text" name="roster_name" id="roster_name" value="{{ old('roster_name') }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           placeholder="e.g., Sunday Service - March 15, Rehearsal Session" required>
                    @error('roster_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duty Date -->
                <div>
                    <label for="duty_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Duty Date
                    </label>
                    <input type="date" name="duty_date" id="duty_date" value="{{ old('duty_date') }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           required>
                    @error('duty_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duty Type -->
                <div>
                    <label for="duty_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Duty Type
                    </label>
                    <select name="duty_type" id="duty_type"
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                            required>
                        <option value="">Select Type</option>
                        <option value="sunday_service" {{ old('duty_type') === 'sunday_service' ? 'selected' : '' }}>Sunday Service</option>
                        <option value="midweek_service" {{ old('duty_type') === 'midweek_service' ? 'selected' : '' }}>Midweek Service</option>
                        <option value="special_event" {{ old('duty_type') === 'special_event' ? 'selected' : '' }}>Special Event</option>
                        <option value="rehearsal" {{ old('duty_type') === 'rehearsal' ? 'selected' : '' }}>Rehearsal</option>
                        <option value="practice" {{ old('duty_type') === 'practice' ? 'selected' : '' }}>Practice</option>
                        <option value="other" {{ old('duty_type') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('duty_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Time -->
                <div>
                    <label for="start_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Start Time
                    </label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    @error('start_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Time -->
                <div>
                    <label for="end_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        End Time
                    </label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <p class="mt-1 text-xs text-slate-500">Must be after start time</p>
                    @error('end_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="md:col-span-2">
                    <label for="location" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Location
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           placeholder="e.g., Main Sanctuary, Conference Room A">
                    @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instructions -->
                <div class="md:col-span-2">
                    <label for="instructions" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Instructions / Notes
                    </label>
                    <textarea name="instructions" id="instructions" rows="4"
                              class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                              placeholder="Any special instructions or notes for this duty">{{ old('instructions') }}</textarea>
                    @error('instructions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Member Assignments -->
        <div class="card border border-slate-100 shadow-sm">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Assign Members</h3>
                <p class="text-sm text-slate-500 mt-1">Select members to assign for this duty. You can add or remove members later.</p>
            </div>

            <div class="p-6">
                @if($unitMembers->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($unitMembers as $unitMember)
                    <div class="relative group">
                        <input type="checkbox" name="assigned_members[]" id="member_{{ $unitMember->member->id }}" value="{{ $unitMember->member->id }}"
                               {{ in_array($unitMember->member->id, old('assigned_members', [])) ? 'checked' : '' }}
                               class="peer absolute opacity-0 w-full h-full cursor-pointer z-10">
                        
                        <label for="member_{{ $unitMember->member->id }}" 
                               class="flex items-center gap-4 p-4 border border-slate-200 rounded-xl cursor-pointer transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:shadow-sm group-hover:border-primary-200">
                            
                            <div class="relative">
                                @if($unitMember->member->photo_url)
                                <img src="{{ $unitMember->member->photo_url }}" alt="{{ $unitMember->member->full_name }}"
                                     class="w-12 h-12 rounded-full object-cover">
                                @else
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                    {{ strtoupper(substr($unitMember->member->first_name, 0, 1) . substr($unitMember->member->last_name, 0, 1)) }}
                                </div>
                                @endif
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-primary-600 rounded-full text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 group-hover:text-primary-700 transition-colors">{{ $unitMember->member->full_name }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full border
                                        @if($unitMember->role === 'leader') bg-purple-50 text-purple-700 border-purple-100
                                        @elseif($unitMember->role === 'assistant_leader') bg-blue-50 text-blue-700 border-blue-100
                                        @elseif($unitMember->role === 'trainee') bg-amber-50 text-amber-700 border-amber-100
                                        @else bg-slate-100 text-slate-600 border-slate-200
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $unitMember->role)) }}
                                    </span>
                                    
                                    @if($unitMember->proficiency_level)
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $unitMember->proficiency_level ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 flex items-start gap-3 p-4 bg-primary-50 border border-primary-100 rounded-xl">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-primary-900">Quick Tips</h4>
                        <ul class="text-sm text-primary-700 mt-1 space-y-1 list-disc list-inside">
                            <li>Select all members who should be on duty for this roster.</li>
                            <li>You can easily add or remove members after the roster is created.</li>
                            <li>Members will be notified automatically when you publish the roster.</li>
                        </ul>
                    </div>
                </div>
                @else
                <div class="text-center py-12">
                     <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-600 font-medium">No members in this unit yet.</p>
                    <p class="text-sm text-slate-500 mt-1">Please add members to the unit before creating duty rosters.</p>
                     <a href="{{ route('service-units.manage-members', $serviceUnit) }}" class="inline-block mt-4 text-primary-600 hover:text-primary-700 font-medium text-sm hover:underline">Go to Manage Members</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end gap-3 sticky bottom-6 bg-white/90 backdrop-blur-sm p-4 rounded-xl border border-slate-200 shadow-lg z-20">
            <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}"
               class="px-6 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm shadow-sm">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg hover:from-primary-700 hover:to-primary-800 transition font-medium text-sm shadow-md hover:shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Create Duty Roster (Draft)
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');

    // Validate that end time is after start time
    function validateTimes() {
        if (startTime.value && endTime.value) {
            if (endTime.value <= startTime.value) {
                endTime.setCustomValidity('End time must be after start time');
            } else {
                endTime.setCustomValidity('');
            }
        } else {
            endTime.setCustomValidity('');
        }
    }

    startTime.addEventListener('change', validateTimes);
    endTime.addEventListener('change', validateTimes);
});
</script>
@endsection
