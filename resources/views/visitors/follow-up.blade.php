@extends('layouts.app')

@section('title', 'Visitor Follow-up')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Visitor Follow-up Management</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}" class="hover:text-primary-600 transition-colors">Visitors</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Follow-up</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('visitors.reports') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Reports
        </a>
        <a href="{{ route('visitors.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            All Visitors
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Needing Follow-up (14+ days)</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ count($needingFollowUp) }}</h3>
            </div>
            <div class="p-3 bg-amber-100/50 rounded-xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-red-500 bg-gradient-to-br from-white to-red-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Not Returned (30+ days)</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ count($notReturned) }}</h3>
            </div>
            <div class="p-3 bg-red-100/50 rounded-xl text-red-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Visitors Needing Follow-up (14+ days since last visit) -->
<div class="card border border-slate-100 mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">
            Visitors Needing Follow-up
            <span class="text-xs font-normal text-slate-500 ml-2 bg-white px-2 py-0.5 rounded-full border border-slate-200">Inactive 14+ days</span>
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Priority</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Name</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Contact</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Last Visit</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Days Inactive</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Total Visits</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Referral</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($needingFollowUp as $visitor)
                <tr class="transition-colors {{ $visitor->last_visit_date?->diffInDays() > 30 ? 'bg-red-50/50 hover:bg-red-50' : 'bg-amber-50/30 hover:bg-amber-50/50' }}">
                    <td class="px-6 py-4">
                        @if($visitor->last_visit_date?->diffInDays() > 30)
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Urgent</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Normal</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">{{ $visitor->first_name }} {{ $visitor->last_name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-600 mb-0.5">{{ $visitor->email ?? '-' }}</div>
                        <div class="text-xs text-slate-500 font-mono">{{ $visitor->phone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-slate-700">{{ $visitor->last_visit_date?->format('M d, Y') }}</div>
                        <div class="text-xs text-slate-500">{{ $visitor->last_visit_date?->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $visitor->last_visit_date?->diffInDays() > 30 ? 'bg-red-100 text-red-700 ring-red-600/20' : 'bg-amber-100 text-amber-700 ring-amber-600/20' }}">
                            {{ $visitor->last_visit_date?->diffInDays() }} days
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">{{ $visitor->visit_count }} {{ Str::plural('visit', $visitor->visit_count) }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 capitalize">{{ str_replace('_', ' ', $visitor->referral_source ?? '-') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('visitors.show', $visitor) }}" class="p-1.5 text-slate-400 hover:text-primary-600 transition-colors bg-white rounded-lg border border-slate-200 hover:border-primary-200 shadow-sm" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="tel:{{ $visitor->phone }}" class="p-1.5 text-slate-400 hover:text-emerald-600 transition-colors bg-white rounded-lg border border-slate-200 hover:border-emerald-200 shadow-sm" title="Call">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </a>
                            @if($visitor->email)
                            <a href="mailto:{{ $visitor->email }}" class="p-1.5 text-slate-400 hover:text-blue-600 transition-colors bg-white rounded-lg border border-slate-200 hover:border-blue-200 shadow-sm" title="Email">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 mb-1">All Caught Up!</h3>
                            <p class="text-slate-500">No visitors requiring immediate follow-up at this time.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- First-time Visitors Who Haven't Returned (30+ days) -->
<div class="card border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">
            First-time Visitors (Not Returned)
            <span class="text-xs font-normal text-slate-500 ml-2 bg-white px-2 py-0.5 rounded-full border border-slate-200">30+ days since first visit</span>
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Name</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Contact</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">First Visit</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Days Since Visit</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Referral Source</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Interests</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($notReturned as $visitor)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">{{ $visitor->first_name }} {{ $visitor->last_name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-600 mb-0.5">{{ $visitor->email ?? '-' }}</div>
                        <div class="text-xs text-slate-500 font-mono">{{ $visitor->phone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-slate-700">{{ $visitor->first_visit_date?->format('M d, Y') }}</div>
                        <div class="text-xs text-slate-500">{{ $visitor->first_visit_date?->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                            {{ $visitor->first_visit_date?->diffInDays() }} days
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 capitalize">{{ str_replace('_', ' ', $visitor->referral_source ?? '-') }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ Str::limit($visitor->interests ?? '-', 30) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('visitors.show', $visitor) }}" class="p-1.5 text-slate-400 hover:text-primary-600 transition-colors bg-white rounded-lg border border-slate-200 hover:border-primary-200 shadow-sm" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="tel:{{ $visitor->phone }}" class="p-1.5 text-slate-400 hover:text-emerald-600 transition-colors bg-white rounded-lg border border-slate-200 hover:border-emerald-200 shadow-sm" title="Call">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </a>
                            <button type="button" @click="$refs.inactiveModal{{ $visitor->id }}.showModal()" class="p-1.5 text-slate-400 hover:text-red-600 transition-colors bg-white rounded-lg border border-slate-200 hover:border-red-200 shadow-sm" title="Mark Inactive">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            </button>
                        </div>

                        <!-- Mark Inactive Modal -->
                        <dialog x-ref="inactiveModal{{ $visitor->id }}" class="rounded-xl shadow-2xl w-full max-w-md p-0 backdrop:bg-slate-900/50 backdrop:backdrop-blur-sm">
                            <div class="card border-0 shadow-none m-0">
                                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                                    <h3 class="font-bold text-slate-900">Mark as Inactive</h3>
                                    <button type="button" @click="$refs.inactiveModal{{ $visitor->id }}.close()" class="text-slate-400 hover:text-slate-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <form action="{{ route('visitors.markInactive', $visitor) }}" method="POST">
                                    @csrf
                                    <div class="p-6">
                                        <p class="text-sm text-slate-600 mb-4 whitespace-normal text-left"><strong>{{ $visitor->first_name }} {{ $visitor->last_name }}</strong> hasn't returned since their first visit {{ $visitor->first_visit_date?->diffInDays() }} days ago.</p>
                                        <div class="mb-4 text-left">
                                            <label for="reason{{ $visitor->id }}" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Reason</label>
                                            <textarea id="reason{{ $visitor->id }}" name="reason" rows="3"
                                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500"
                                                      required
                                                      placeholder="e.g., No interest, Relocated, No response to follow-up..."></textarea>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                                        <button type="button" @click="$refs.inactiveModal{{ $visitor->id }}.close()" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            Mark as Inactive
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </dialog>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 mb-1">Excellent!</h3>
                            <p class="text-slate-500">All first-time visitors have returned or been followed up.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Follow-up Guidelines -->
@if(count($needingFollowUp) > 0 || count($notReturned) > 0)
<div class="card p-6 mt-8 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
    <div class="flex items-start gap-4">
        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-blue-900 text-lg mb-2">Follow-up Best Practices</h4>
            <ul class="text-sm text-blue-800 space-y-1.5 list-none">
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>14-21 days:</strong> Send a friendly SMS or call to check in</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>22-30 days:</strong> Personal phone call from pastor or staff member</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>30+ days:</strong> Final outreach with invitation to upcoming event</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>First-time visitors:</strong> Contact within 48 hours of first visit</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>Document all contact attempts</strong> in visitor notes</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>Mark as inactive</strong> if no response after 3 follow-up attempts</li>
            </ul>
        </div>
    </div>
</div>
@endif
@endsection
