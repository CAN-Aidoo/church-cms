@extends('layouts.app')

@section('title', 'Manage Members - ' . $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('service-units.show', $serviceUnit) }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Manage Members</h1>
            </div>
            <p class="text-gray-600">{{ $serviceUnit->name }} - Add or remove unit members</p>
        </div>
    </div>

    <!-- Capacity Warning -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-3">Unit Capacity</h2>
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-700">{{ $serviceUnit->current_members }} of {{ $serviceUnit->max_members }} members</span>
            <span class="text-sm font-semibold text-gray-900">{{ number_format($serviceUnit->capacity_percentage, 1) }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="
                @if($serviceUnit->capacity_percentage >= 100) bg-red-500
                @elseif($serviceUnit->capacity_percentage >= 80) bg-yellow-500
                @else bg-green-500
                @endif
                h-4 rounded-full transition-all"
                 style="width: {{ min($serviceUnit->capacity_percentage, 100) }}%"></div>
        </div>

        @if($serviceUnit->current_members < $serviceUnit->min_members)
        <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3">
            <p class="text-sm text-red-800">
                <span class="font-semibold">⚠️ Below Minimum:</span>
                Need {{ $serviceUnit->min_members - $serviceUnit->current_members }} more member(s) to meet minimum requirements
            </p>
        </div>
        @elseif(!$serviceUnit->hasCapacity())
        <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3">
            <p class="text-sm text-red-800">
                <span class="font-semibold">⚠️ At Maximum Capacity:</span>
                Remove members before adding new ones
            </p>
        </div>
        @elseif($serviceUnit->capacity_percentage >= 80)
        <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
            <p class="text-sm text-yellow-800">
                <span class="font-semibold">⚠️ Nearly Full:</span>
                {{ $serviceUnit->max_members - $serviceUnit->current_members }} spot(s) remaining
            </p>
        </div>
        @else
        <div class="mt-3 bg-green-50 border border-green-200 rounded-lg p-3">
            <p class="text-sm text-green-800">
                <span class="font-semibold">✓ Good Capacity:</span>
                {{ $serviceUnit->max_members - $serviceUnit->current_members }} spot(s) available
            </p>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Current Unit Members -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Current Members ({{ $unitMembers->count() }})</h2>
            </div>

            @if($unitMembers->isNotEmpty())
            <div class="space-y-3 max-h-[600px] overflow-y-auto">
                @foreach($unitMembers as $unitMember)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3 flex-1">
                            @if($unitMember->member->photo_url)
                            <img src="{{ $unitMember->member->photo_url }}" alt="{{ $unitMember->member->full_name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($unitMember->member->first_name, 0, 1) . substr($unitMember->member->last_name, 0, 1)) }}
                            </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $unitMember->member->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $unitMember->member->phone }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($unitMember->role === 'leader') bg-purple-100 text-purple-800
                                        @elseif($unitMember->role === 'assistant_leader') bg-blue-100 text-blue-800
                                        @elseif($unitMember->role === 'trainee') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $unitMember->role)) }}
                                    </span>
                                    @if($unitMember->proficiency_level)
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $unitMember->proficiency_level ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                    </div>
                                    @endif
                                </div>
                                @if($unitMember->skills && is_array($unitMember->skills) && count($unitMember->skills) > 0)
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach(array_slice($unitMember->skills, 0, 3) as $skill)
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($unitMember->skills) > 3)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">+{{ count($unitMember->skills) - 3 }}</span>
                                    @endif
                                </div>
                                @endif
                                @if($unitMember->notes)
                                <p class="text-xs text-gray-500 mt-2">{{ Str::limit($unitMember->notes, 50) }}</p>
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('service-units.remove-member', $serviceUnit) }}" method="POST" class="ml-3"
                              onsubmit="return confirm('Remove {{ $unitMember->member->full_name }} from this unit?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="unit_member_id" value="{{ $unitMember->id }}">
                            <button type="submit"
                                    class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-sm">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <p class="text-gray-600">No members in this unit yet</p>
            </div>
            @endif
        </div>

        <!-- Add New Member -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Add New Member</h2>

            <form action="{{ route('service-units.add-member', $serviceUnit) }}" method="POST" class="space-y-4">
                @csrf

                <!-- Member Selection -->
                <div>
                    <label for="member_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Member <span class="text-red-500">*</span>
                    </label>
                    <select name="member_id" id="member_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('member_id') border-red-500 @enderror"
                            required {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                        <option value="">Choose a member...</option>
                        @foreach($availableMembers as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }} - {{ $member->phone }}
                        </option>
                        @endforeach
                    </select>
                    @error('member_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($availableMembers->isEmpty())
                    <p class="mt-1 text-sm text-yellow-600">All active members are already assigned to units</p>
                    @endif
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror"
                            required {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                        <option value="">Select Role</option>
                        <option value="leader" {{ old('role') === 'leader' ? 'selected' : '' }}>Leader</option>
                        <option value="assistant_leader" {{ old('role') === 'assistant_leader' ? 'selected' : '' }}>Assistant Leader</option>
                        <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                        <option value="trainee" {{ old('role') === 'trainee' ? 'selected' : '' }}>Trainee</option>
                    </select>
                    @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Joined Date -->
                <div>
                    <label for="joined_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Joined Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="joined_date" id="joined_date" value="{{ old('joined_date', now()->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('joined_date') border-red-500 @enderror"
                           required {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                    @error('joined_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Proficiency Level -->
                <div>
                    <label for="proficiency_level" class="block text-sm font-medium text-gray-700 mb-2">
                        Proficiency Level (1-5)
                    </label>
                    <select name="proficiency_level" id="proficiency_level"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('proficiency_level') border-red-500 @enderror"
                            {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                        <option value="">Not Rated</option>
                        <option value="1" {{ old('proficiency_level') == 1 ? 'selected' : '' }}>1 - Beginner</option>
                        <option value="2" {{ old('proficiency_level') == 2 ? 'selected' : '' }}>2 - Novice</option>
                        <option value="3" {{ old('proficiency_level') == 3 ? 'selected' : '' }}>3 - Intermediate</option>
                        <option value="4" {{ old('proficiency_level') == 4 ? 'selected' : '' }}>4 - Advanced</option>
                        <option value="5" {{ old('proficiency_level') == 5 ? 'selected' : '' }}>5 - Expert</option>
                    </select>
                    @error('proficiency_level')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Skills -->
                <div>
                    <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">
                        Skills
                    </label>
                    <input type="text" name="skills" id="skills" value="{{ old('skills') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('skills') border-red-500 @enderror"
                           placeholder="e.g., Sound Engineering, Mixing, Vocals (comma-separated)"
                           {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                    @error('skills')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Separate multiple skills with commas</p>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                              placeholder="Any additional notes or comments"
                              {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>{{ old('notes') }}</textarea>
                    @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ !$serviceUnit->hasCapacity() || $availableMembers->isEmpty() ? 'disabled' : '' }}>
                    @if(!$serviceUnit->hasCapacity())
                        Unit at Maximum Capacity
                    @elseif($availableMembers->isEmpty())
                        No Available Members
                    @else
                        Add Member to Unit
                    @endif
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
