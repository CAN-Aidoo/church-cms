@extends('layouts.app')

@section('title', 'Manage Members - ' . $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('service-units.show', $serviceUnit) }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manage Members</h1>
            <p class="text-slate-600">Add or remove members for <span class="font-medium text-slate-900">{{ $serviceUnit->name }}</span></p>
        </div>
    </div>

    <!-- Capacity Warning -->
    <div class="card border border-slate-100 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-base font-bold text-slate-800">Unit Capacity</h2>
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-600">{{ $serviceUnit->current_members }} of {{ $serviceUnit->max_members }} members</span>
                <span class="text-sm font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded">{{ number_format($serviceUnit->capacity_percentage, 1) }}%</span>
            </div>
        </div>
        
        <div class="w-full bg-slate-100 rounded-full h-3 mb-4">
            <div class="
                @if($serviceUnit->capacity_percentage >= 100) bg-rose-500
                @elseif($serviceUnit->capacity_percentage >= 80) bg-amber-500
                @else bg-emerald-500
                @endif
                h-3 rounded-full transition-all shadow-sm"
                 style="width: {{ min($serviceUnit->capacity_percentage, 100) }}%"></div>
        </div>

        @if($serviceUnit->current_members < $serviceUnit->min_members)
        <div class="bg-rose-50 border border-rose-100 rounded-lg p-3 flex gap-3 items-center">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-sm text-rose-800">
                <span class="font-bold">Below Minimum:</span>
                Need {{ $serviceUnit->min_members - $serviceUnit->current_members }} more member(s) to meet minimum requirements.
            </p>
        </div>
        @elseif(!$serviceUnit->hasCapacity())
        <div class="bg-rose-50 border border-rose-100 rounded-lg p-3 flex gap-3 items-center">
             <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-rose-800">
                <span class="font-bold">At Maximum Capacity:</span>
                Remove members before adding new ones.
            </p>
        </div>
        @elseif($serviceUnit->capacity_percentage >= 80)
        <div class="bg-amber-50 border border-amber-100 rounded-lg p-3 flex gap-3 items-center">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-amber-800">
                <span class="font-bold">Nearly Full:</span>
                {{ $serviceUnit->max_members - $serviceUnit->current_members }} spot(s) remaining.
            </p>
        </div>
        @else
        <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-3 flex gap-3 items-center">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-emerald-800">
                <span class="font-bold">Good Capacity:</span>
                {{ $serviceUnit->max_members - $serviceUnit->current_members }} spot(s) available.
            </p>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Current Unit Members -->
        <div class="card border border-slate-100 shadow-sm flex flex-col h-full">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-base font-bold text-slate-800">Current Members <span class="text-slate-500 font-normal ml-1">({{ $unitMembers->count() }})</span></h2>
            </div>

            <div class="p-4 flex-1 overflow-y-auto max-h-[600px] custom-scrollbar">
                @if($unitMembers->isNotEmpty())
                <div class="space-y-3">
                    @foreach($unitMembers as $unitMember)
                    <div class="group border border-slate-200 rounded-xl p-4 hover:border-primary-200 hover:shadow-sm hover:bg-slate-50/50 transition-all">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="relative">
                                    @if($unitMember->member->photo_url)
                                    <img src="{{ $unitMember->member->photo_url }}" alt="{{ $unitMember->member->full_name }}"
                                         class="w-12 h-12 rounded-full object-cover border border-slate-200">
                                    @else
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                        {{ strtoupper(substr($unitMember->member->first_name, 0, 1) . substr($unitMember->member->last_name, 0, 1)) }}
                                    </div>
                                    @endif
                                    <span class="absolute -bottom-1 -right-1 flex h-4 w-4">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500 border-2 border-white"></span>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <h3 class="font-bold text-slate-900 truncate">{{ $unitMember->member->full_name }}</h3>
                                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full border
                                            @if($unitMember->role === 'leader') bg-purple-50 text-purple-700 border-purple-100
                                            @elseif($unitMember->role === 'assistant_leader') bg-blue-50 text-blue-700 border-blue-100
                                            @elseif($unitMember->role === 'trainee') bg-amber-50 text-amber-700 border-amber-100
                                            @else bg-slate-100 text-slate-600 border-slate-200
                                            @endif">
                                            {{ ucwords(str_replace('_', ' ', $unitMember->role)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mb-2">{{ $unitMember->member->phone }}</p>
                                    
                                    @if($unitMember->proficiency_level)
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $unitMember->proficiency_level ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                    </div>
                                    @endif

                                    @if($unitMember->skills && is_array($unitMember->skills) && count($unitMember->skills) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($unitMember->skills, 0, 3) as $skill)
                                        <span class="px-1.5 py-0.5 bg-white text-slate-600 rounded text-[10px] font-medium border border-slate-200 shadow-sm">{{ $skill }}</span>
                                        @endforeach
                                        @if(count($unitMember->skills) > 3)
                                        <span class="px-1.5 py-0.5 bg-slate-50 text-slate-500 rounded text-[10px] border border-slate-200">+{{ count($unitMember->skills) - 3 }}</span>
                                        @endif
                                    </div>
                                    @endif

                                    @if($unitMember->notes)
                                    <div class="mt-2 text-xs text-slate-500 bg-slate-50 p-2 rounded border border-slate-100 italic">
                                        "{{ Str::limit($unitMember->notes, 60) }}"
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('service-units.remove-member', $serviceUnit) }}" method="POST" class="ml-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                  onsubmit="return confirm('Remove {{ $unitMember->member->full_name }} from this unit?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="unit_member_id" value="{{ $unitMember->id }}">
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Remove Member">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">No members in this unit yet</p>
                    <p class="text-slate-400 text-sm mt-1">Use the form to add the first member.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Add New Member -->
        <div class="card border border-slate-100 shadow-sm h-fit sticky top-6">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-base font-bold text-slate-800">Add New Member</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('service-units.add-member', $serviceUnit) }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Member Selection -->
                    <div>
                        <label for="member_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                            Select Member
                        </label>
                        <select name="member_id" id="member_id"
                                class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                required {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                            <option value="">Choose a member...</option>
                            @foreach($availableMembers as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->full_name }} ({{ $member->phone }})
                            </option>
                            @endforeach
                        </select>
                        @error('member_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                        @if($availableMembers->isEmpty())
                        <p class="mt-2 text-sm text-amber-600 bg-amber-50 p-2 rounded border border-amber-100">All active members are already assigned to units.</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <!-- Role -->
                        <div>
                            <label for="role" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                                Role
                            </label>
                            <select name="role" id="role"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                    required {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                                <option value="">Select Role</option>
                                <option value="leader" {{ old('role') === 'leader' ? 'selected' : '' }}>Leader</option>
                                <option value="assistant_leader" {{ old('role') === 'assistant_leader' ? 'selected' : '' }}>Assistant Leader</option>
                                <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                                <option value="trainee" {{ old('role') === 'trainee' ? 'selected' : '' }}>Trainee</option>
                            </select>
                            @error('role')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Joined Date -->
                        <div>
                            <label for="joined_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                                Joined Date
                            </label>
                            <input type="date" name="joined_date" id="joined_date" value="{{ old('joined_date', now()->format('Y-m-d')) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                   required {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                            @error('joined_date')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Proficiency Level -->
                    <div>
                        <label for="proficiency_level" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                            Proficiency Level (1-5)
                        </label>
                        <select name="proficiency_level" id="proficiency_level"
                                class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                            <option value="">Not Rated</option>
                            <option value="1" {{ old('proficiency_level') == 1 ? 'selected' : '' }}>1 - Beginner</option>
                            <option value="2" {{ old('proficiency_level') == 2 ? 'selected' : '' }}>2 - Novice</option>
                            <option value="3" {{ old('proficiency_level') == 3 ? 'selected' : '' }}>3 - Intermediate</option>
                            <option value="4" {{ old('proficiency_level') == 4 ? 'selected' : '' }}>4 - Advanced</option>
                            <option value="5" {{ old('proficiency_level') == 5 ? 'selected' : '' }}>5 - Expert</option>
                        </select>
                        @error('proficiency_level')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Skills -->
                    <div>
                        <label for="skills" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                            Skills
                        </label>
                        <input type="text" name="skills" id="skills" value="{{ old('skills') }}"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                               placeholder="e.g., Sound Engineering, Mixing, Vocals"
                               {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>
                        <p class="mt-1 text-xs text-slate-500">Separate multiple skills with commas</p>
                        @error('skills')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                  placeholder="Any additional notes or comments"
                                  {{ !$serviceUnit->hasCapacity() ? 'disabled' : '' }}>{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg shadow-sm hover:shadow-md hover:from-primary-700 hover:to-primary-800 transition-all font-semibold disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none"
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
</div>
@endsection
