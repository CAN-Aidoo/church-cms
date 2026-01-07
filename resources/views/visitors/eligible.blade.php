@extends('layouts.app')

@section('title', 'Eligible for Conversion')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Visitors Eligible for Membership</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}" class="hover:text-primary-600 transition-colors">Visitors</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Eligible</span>
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

<!-- Info Banner -->
<div class="card p-6 bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/20 mb-8">
    <div class="flex items-start gap-5">
        <div class="p-3 bg-white/20 rounded-xl">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-heading font-bold mb-2">5-Visit Conversion Rule</h2>
            <p class="text-base opacity-95 mb-6 leading-relaxed max-w-3xl">
                These visitors have attended at least 5 services and are eligible to become members. Review their information and initiate the conversion process.
            </p>
            <div class="inline-flex bg-white/20 rounded-xl px-5 py-3 backdrop-blur-sm">
                <div>
                    <div class="text-3xl font-heading font-bold mb-0.5">{{ count($eligibleVisitors) }}</div>
                    <div class="text-xs font-bold uppercase tracking-wider opacity-80">Eligible Visitors</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Eligible Visitors Table -->
<div class="card border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">
            Eligible Visitors
            <span class="text-xs font-normal text-slate-500 ml-2 bg-white px-2 py-0.5 rounded-full border border-slate-200">{{ count($eligibleVisitors) }} ready for conversion</span>
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Priority</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Name</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Contact</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">First Visit</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Last Visit</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Visits</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Days Active</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Referral</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($eligibleVisitors as $index => $visitor)
                <tr class="transition-colors {{ $visitor->visit_count >= 8 ? 'bg-emerald-50/30 hover:bg-emerald-50/50' : 'hover:bg-slate-50/50' }}">
                    <td class="px-6 py-4">
                        @if($visitor->visit_count >= 10)
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">High</span>
                        @elseif($visitor->visit_count >= 7)
                        <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Medium</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">Normal</span>
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
                        <div class="text-sm text-slate-700">{{ $visitor->first_visit_date?->format('M d, Y') }}</div>
                        <div class="text-xs text-slate-500">{{ $visitor->first_visit_date?->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-slate-700">{{ $visitor->last_visit_date?->format('M d, Y') }}</div>
                        <div class="text-xs text-slate-500">{{ $visitor->last_visit_date?->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-sm font-semibold ring-1 ring-inset {{ $visitor->visit_count >= 10 ? 'bg-emerald-100 text-emerald-700 ring-emerald-600/30' : 'bg-blue-100 text-blue-700 ring-blue-600/30' }}">
                            {{ $visitor->visit_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-slate-600">
                            {{ $visitor->first_visit_date?->diffInDays() }} days
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 capitalize">{!! $visitor->referral_source ? str_replace('_', ' ', $visitor->referral_source) : '<span class="text-slate-400">-</span>' !!}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('visitors.show', $visitor) }}" class="p-1.5 text-slate-400 hover:text-primary-600 transition-colors bg-white rounded-lg border border-slate-200 hover:border-primary-200 shadow-sm" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('visitors.convert.form', $visitor) }}" class="btn btn-sm bg-amber-500 hover:bg-amber-600 text-white border-0 shadow-md shadow-amber-500/20 font-medium">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Convert
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 mb-1">No Visitors Ready Yet</h3>
                            <p class="text-slate-500">Visitors will appear here once they've attended 5 or more services.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(count($eligibleVisitors) > 0)
<!-- Conversion Guidelines -->
<div class="card p-6 mt-8 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
    <div class="flex items-start gap-4">
        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-blue-900 text-lg mb-2">Conversion Process Guidelines</h4>
            <ul class="text-sm text-blue-800 space-y-1.5 list-none">
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>Priority Levels:</strong> High (10+ visits), Medium (7-9 visits), Normal (5-6 visits)</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>Review visitor information</strong> before initiating conversion</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>Conversion creates:</strong> User account, Member record, Unique member ID</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>Initial status:</strong> Pending (requires completion of foundations class)</li>
                <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> <strong>Next steps:</strong> Assign to shepherd, enroll in onboarding program</li>
            </ul>
        </div>
    </div>
</div>
@endif
@endsection
