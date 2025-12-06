@extends('layouts.app')

@section('title', 'Volunteers')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manage Volunteers</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $service->name }}</p>
        </div>
        <a href="{{ route('services.show', $service) }}" class="text-sm text-gray-500 hover:text-gray-700">Back to Service</a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Assign Form --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Assign Volunteer</h3>
                <form action="{{ route('services.assign-volunteer', $service) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select name="role" class="w-full rounded-lg border-gray-300 text-sm" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Member ID</label>
                            <input type="number" name="member_id" class="w-full rounded-lg border-gray-300 text-sm" required placeholder="Search or enter ID">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Specific Duty</label>
                            <input type="text" name="specific_duty" class="w-full rounded-lg border-gray-300 text-sm" placeholder="e.g. Door 1 Greeter">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium">Assign</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Volunteer List --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900">Assigned Volunteers</h3>
                    <span class="px-2 py-1 bg-white rounded border border-gray-200 text-xs font-medium">{{ $service->volunteers->count() }} Total</span>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse($service->volunteers as $volunteer)
                        <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-sm">
                                    {{ substr($volunteer->member->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $volunteer->member->full_name }}</p>
                                    <p class="text-xs text-gray-500 capitalize">
                                        {{ str_replace('_', ' ', $volunteer->role) }} 
                                        @if($volunteer->specific_duty)
                                            <span class="text-gray-400">• {{ $volunteer->specific_duty }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $volunteer->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                      ($volunteer->status === 'declined' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($volunteer->status) }}
                                </span>
                                <form action="{{ route('services.remove-volunteer', $volunteer) }}" method="POST" onsubmit="return confirm('Remove volunteer?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">No volunteers assigned yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
