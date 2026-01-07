@extends('layouts.app')

@section('title', 'Manage Volunteers')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Manage Volunteers</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-primary-600 transition-colors">Services</a>
            <span>/</span>
            <a href="{{ route('services.show', $service) }}" class="hover:text-primary-600 transition-colors">{{ $service->name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Volunteers</span>
        </nav>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Assign Form -->
    <div class="lg:col-span-1">
        <div class="card border border-slate-100 shadow-sm sticky top-6">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Assign Volunteer</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('services.assign-volunteer', $service) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="role" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Role</label>
                        <select name="role" id="role" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
                            <option value="">Select Role...</option>
                            @foreach($roles as $role)
                            <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="member_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Member</label>
                        <select name="member_id" id="member_id" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
                             <option value="">Select a member...</option>
                             <!-- This should be populated via JS or controller for better UX with search -->
                             @foreach(\App\Models\Member::active()->orderBy('first_name')->take(100)->get() as $member)
                             <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                             @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Select a member to assign.</p>
                    </div>

                    <div>
                        <label for="specific_duty" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Specific Duty</label>
                        <input type="text" name="specific_duty" id="specific_duty" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" placeholder="e.g. Door 1 Greeter">
                    </div>

                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl" placeholder="Any special instructions..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Assign Volunteer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Volunteer List -->
    <div class="lg:col-span-2">
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Assigned Volunteers</h3>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-600">
                    {{ $service->volunteers->count() }} Total
                </span>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($service->volunteers as $volunteer)
                <div class="p-4 hover:bg-slate-50 transition-colors group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">
                                {{ substr($volunteer->member->first_name, 0, 1) }}{{ substr($volunteer->member->last_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-medium text-slate-900">{{ $volunteer->member->full_name }}</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ str_replace('_', ' ', $volunteer->role) }}</span>
                                    @if($volunteer->specific_duty)
                                    <span class="text-xs text-slate-300">•</span>
                                    <span class="text-xs text-slate-500 italic">{{ $volunteer->specific_duty }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize 
                                {{ $volunteer->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700' : 
                                  ($volunteer->status === 'declined' ? 'bg-red-50 text-red-700' : 
                                  ($volunteer->status === 'completed' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700')) }}">
                                {{ ucfirst($volunteer->status) }}
                            </span>
                            
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-2">
                                <button type="button" 
                                        onclick="alert('Edit functionality to be implemented via modal');"
                                        class="p-1 text-slate-400 hover:text-primary-600 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('services.remove-volunteer', $volunteer) }}" method="POST" onsubmit="return confirm('Remove volunteer?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-red-600 transition-colors" title="Remove">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if($volunteer->notes)
                    <div class="mt-2 ml-14 text-xs text-slate-500 bg-slate-50 p-2 rounded border border-slate-100">
                        {{ $volunteer->notes }}
                    </div>
                    @endif
                </div>
                @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">No Volunteers</h3>
                    <p class="text-slate-500 text-xs mt-1">Assign volunteers using the form on the left.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
