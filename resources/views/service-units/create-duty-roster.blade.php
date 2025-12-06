@extends('layouts.app')

@section('title', 'Create Duty Roster - ' . $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create Duty Roster</h1>
        </div>
        <p class="text-gray-600">{{ $serviceUnit->name }} - Schedule a new duty</p>
    </div>

    <!-- Form -->
    <form action="{{ route('service-units.store-duty-roster', $serviceUnit) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Duty Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Roster Name -->
                <div class="md:col-span-2">
                    <label for="roster_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Duty Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="roster_name" id="roster_name" value="{{ old('roster_name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('roster_name') border-red-500 @enderror"
                           placeholder="e.g., Sunday Service - March 15, Rehearsal Session" required>
                    @error('roster_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duty Date -->
                <div>
                    <label for="duty_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Duty Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="duty_date" id="duty_date" value="{{ old('duty_date') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duty_date') border-red-500 @enderror"
                           required>
                    @error('duty_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duty Type -->
                <div>
                    <label for="duty_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Duty Type <span class="text-red-500">*</span>
                    </label>
                    <select name="duty_type" id="duty_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duty_type') border-red-500 @enderror"
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
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Start Time
                    </label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Time -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                        End Time
                    </label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Must be after start time</p>
                </div>

                <!-- Location -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Location
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                           placeholder="e.g., Main Sanctuary, Conference Room A">
                    @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instructions -->
                <div class="md:col-span-2">
                    <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">
                        Instructions / Notes
                    </label>
                    <textarea name="instructions" id="instructions" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('instructions') border-red-500 @enderror"
                              placeholder="Any special instructions or notes for this duty">{{ old('instructions') }}</textarea>
                    @error('instructions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Member Assignments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Assign Members</h2>
            <p class="text-gray-600 mb-4">Select members to assign for this duty (optional - you can add members later)</p>

            @if($unitMembers->isNotEmpty())
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach($unitMembers as $unitMember)
                <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                    <input type="checkbox" name="assigned_members[]" value="{{ $unitMember->member->id }}"
                           {{ in_array($unitMember->member->id, old('assigned_members', [])) ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <div class="flex items-center gap-3 flex-1">
                        @if($unitMember->member->photo_url)
                        <img src="{{ $unitMember->member->photo_url }}" alt="{{ $unitMember->member->full_name }}"
                             class="w-10 h-10 rounded-full object-cover">
                        @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr($unitMember->member->first_name, 0, 1) . substr($unitMember->member->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-900">{{ $unitMember->member->full_name }}</p>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($unitMember->role === 'leader') bg-purple-100 text-purple-800
                                    @elseif($unitMember->role === 'assistant_leader') bg-blue-100 text-blue-800
                                    @elseif($unitMember->role === 'trainee') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $unitMember->role)) }}
                                </span>
                                @if($unitMember->proficiency_level)
                                <div class="flex items-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3 h-3 {{ $i <= $unitMember->proficiency_level ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    @endfor
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>

            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">Quick Tips:</p>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Select all members who should be on duty</li>
                            <li>You can add or remove members after creation</li>
                            <li>Members will be notified when the roster is published</li>
                        </ul>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <p class="text-gray-600">No members in this unit yet.</p>
                <p class="text-sm text-gray-500 mt-1">Add members to the unit before creating duty rosters.</p>
            </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}"
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
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
