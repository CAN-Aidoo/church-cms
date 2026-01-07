@extends('layouts.app')

@section('title', 'Child Check-in Station')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Check-in Station</h1>
         <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.index') }}" class="hover:text-primary-600 transition-colors">Children's Ministry</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Check-in</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1 bg-white border border-slate-200 rounded-full text-slate-600 text-sm font-medium shadow-sm">
            {{ now()->format('l, F j, Y') }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Check-in Form -->
    <div class="lg:col-span-2 space-y-6">
        <!-- New Check-in Card -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">New Check-in</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('childrens-ministry.checkin.process') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label for="child_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Child ID / Search</label>
                            <input type="number" 
                                   name="child_id" 
                                   id="child_id" 
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" 
                                   required 
                                   placeholder="Enter Child ID or scan badge"
                                   autofocus>
                            <p class="text-xs text-slate-500 mt-1">Scan QR code or enter numeric ID.</p>
                        </div>
                        
                        <div class="col-span-2 md:col-span-1">
                            <label for="classroom_assigned" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Classroom</label>
                            <select name="classroom_assigned" id="classroom_assigned" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                                <option value="Nursery">Nursery (0-2)</option>
                                <option value="Toddlers">Toddlers (3-5)</option>
                                <option value="K-Grade 2">Primary (K-Grade 2)</option>
                                <option value="Grade 3-5">Juniors (Grade 3-5)</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Session Notes (Optional)</label>
                            <textarea name="notes" id="notes" class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" rows="2" placeholder="e.g. Diaper bag included, picked up by Aunt..."></textarea>
                        </div>

                        <div class="col-span-2 pt-2">
                            <button type="submit" class="btn btn-primary w-full justify-center shadow-lg shadow-primary-500/30 py-2.5 text-base">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Check In Information
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Current Check-ins List -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Active Check-ins</h3>
                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-700">
                    {{ $checkins->count() }} Present
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">Child</th>
                            <th class="px-6 py-3 text-left">Check-in Time</th>
                            <th class="px-6 py-3 text-left">Security Code</th>
                            <th class="px-6 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($checkins as $checkin)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                                            {{ substr($checkin->child->first_name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-800">{{ $checkin->child->full_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $checkin->created_at->format('h:i A') }}
                                    <span class="text-xs text-slate-400 block">{{ $checkin->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                     <span class="font-mono text-sm font-bold bg-slate-100 text-slate-700 px-2 py-1 rounded">
                                        {{ $checkin->security_code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('childrens-ministry.checkout.process', $checkin) }}" class="inline-flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="security_code" value="{{ $checkin->security_code }}">
                                        <input type="hidden" name="authorized_person" value="Parent"> <!-- Simplified for UI speed -->
                                        <button type="submit" class="btn btn-sm text-red-600 bg-red-50 hover:bg-red-100 border-red-100">
                                            Check Out
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-medium">No check-ins yet today.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar Stats -->
    <div class="space-y-6">
        <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <h3 class="text-blue-100 font-medium text-sm uppercase tracking-wider mb-1">Total Checked In</h3>
            <p class="text-5xl font-bold">{{ $statistics['active_count'] ?? 0 }}</p>
            <p class="text-blue-100 text-sm mt-2">Children currently active</p>
        </div>

        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Classroom Breakdown</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($statistics['by_classroom'] ?? [] as $room => $count)
                         <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">{{ $room }}</span>
                                <span class="font-bold text-slate-900">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $statistics['active_count'] > 0 ? ($count / $statistics['active_count']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                         <p class="text-slate-500 text-sm text-center">No active data.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="card border border-slate-100 shadow-sm">
            <div class="p-6 text-center">
                 <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h4 class="font-bold text-slate-800 mb-1">Emergency Mode</h4>
                <p class="text-sm text-slate-500 mb-4">Print emergency roster for all classrooms.</p>
                <button class="btn btn-outline-danger w-full justify-center">Print Roster</button>
            </div>
        </div>
    </div>
</div>
@endsection
