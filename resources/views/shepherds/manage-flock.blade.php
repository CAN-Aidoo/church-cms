@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('shepherds.show', $shepherd) }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manage Flock</h1>
                    <p class="text-gray-600">{{ $shepherd->flock_name }} - {{ $shepherd->full_name }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Capacity</p>
                <p class="text-2xl font-bold
                    @if($shepherd->capacity_percentage >= 100) text-red-600
                    @elseif($shepherd->capacity_percentage >= 80) text-yellow-600
                    @else text-green-600
                    @endif">
                    {{ $shepherd->current_flock_size }} / {{ $shepherd->max_flock_size }}
                </p>
            </div>
        </div>
    </div>

    <!-- Capacity Bar -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Flock Capacity</span>
                <span>{{ number_format($shepherd->capacity_percentage, 0) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="
                    @if($shepherd->capacity_percentage >= 100) bg-red-500
                    @elseif($shepherd->capacity_percentage >= 80) bg-yellow-500
                    @else bg-green-500
                    @endif
                    h-4 rounded-full transition-all"
                     style="width: {{ min($shepherd->capacity_percentage, 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                @if($shepherd->hasCapacity())
                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                {{ $shepherd->available_capacity }} spots available
                @else
                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i>
                Flock is at maximum capacity
                @endif
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Current Flock Members -->
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h2 class="text-xl font-semibold">Current Flock Members ({{ $flockMembers->count() }})</h2>
            </div>
            <div class="card-body">
                @if($flockMembers->count() > 0)
                <div class="space-y-3">
                    @foreach($flockMembers as $member)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center gap-3 flex-1">
                            @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}"
                                 alt="{{ $member->full_name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            @else
                            <div class="w-12 h-12 rounded-full bg-gradient-blue flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                            </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $member->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $member->phone }}</p>
                                @if($member->email)
                                <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('members.show', $member) }}"
                               class="btn btn-sm btn-secondary"
                               target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('shepherds.unassign-member', $shepherd) }}"
                                  class="inline"
                                  onsubmit="return confirm('Remove {{ $member->full_name }} from this flock?')">
                                @csrf
                                <input type="hidden" name="member_id" value="{{ $member->id }}">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-300 text-5xl mb-3"></i>
                    <p class="text-gray-500">No members assigned to this flock yet</p>
                    <p class="text-sm text-gray-400 mt-1">Assign members from the right panel</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Unassigned Members -->
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h2 class="text-xl font-semibold">Unassigned Members ({{ $unassignedMembers->count() }})</h2>
            </div>
            <div class="card-body">
                @if($unassignedMembers->count() > 0)
                <div class="mb-4">
                    <input type="text"
                           id="searchUnassigned"
                           placeholder="Search members..."
                           class="form-input w-full"
                           onkeyup="filterMembers()">
                </div>
                <div class="space-y-3 max-h-[600px] overflow-y-auto" id="unassignedList">
                    @foreach($unassignedMembers as $member)
                    <div class="member-item flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition"
                         data-name="{{ strtolower($member->full_name) }}"
                         data-phone="{{ $member->phone }}">
                        <div class="flex items-center gap-3 flex-1">
                            @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}"
                                 alt="{{ $member->full_name }}"
                                 class="w-10 h-10 rounded-full object-cover">
                            @else
                            <div class="w-10 h-10 rounded-full bg-gradient-gold flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                            </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-medium text-gray-800 text-sm">{{ $member->full_name }}</p>
                                <p class="text-xs text-gray-600">{{ $member->phone }}</p>
                            </div>
                        </div>
                        <form method="POST"
                              action="{{ route('shepherds.assign-member', $shepherd) }}"
                              class="inline">
                            @csrf
                            <input type="hidden" name="member_id" value="{{ $member->id }}">
                            <button type="submit"
                                    class="btn btn-sm btn-primary"
                                    @if(!$shepherd->hasCapacity()) disabled @endif>
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-green-400 text-5xl mb-3"></i>
                    <p class="text-gray-500">All active members are assigned to shepherds</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function filterMembers() {
    const searchInput = document.getElementById('searchUnassigned').value.toLowerCase();
    const memberItems = document.querySelectorAll('.member-item');

    memberItems.forEach(item => {
        const name = item.getAttribute('data-name');
        const phone = item.getAttribute('data-phone');

        if (name.includes(searchInput) || phone.includes(searchInput)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endsection
