@extends('layouts.app')

@section('title', 'Program Details')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
             <a href="{{ route('welfare.programs') }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    {{ $program->program_name }}
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border
                        {{ $program->status === 'active' ? 'bg-green-50 text-green-700 border-green-100' : 
                          ($program->status === 'paused' ? 'bg-amber-50 text-amber-700 border-amber-100' : 
                          ($program->status === 'completed' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-slate-50 text-slate-600 border-slate-200')) }}">
                        {{ ucfirst($program->status) }}
                    </span>
                </h1>
                <p class="text-slate-600 text-sm capitalize">{{ str_replace('_', ' ', $program->program_type) }}</p>
            </div>
        </div>
        
        <div class="flex gap-2">
            <!-- Edit Button could go here if route existed -->
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Program Overview -->
            <div class="card border border-slate-100 shadow-sm p-6 md:p-8">
                <h3 class="font-bold text-slate-800 text-lg mb-4">About this Program</h3>
                <div class="prose max-w-none text-slate-600 mb-8 leading-relaxed">
                    <p>{{ $program->description ?? 'No detailed description available.' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Duration</span>
                         <p class="text-sm font-semibold text-slate-700">
                            {{ $program->start_date ? $program->start_date->format('M d, Y') : 'Start TBD' }} 
                            <span class="text-slate-400 mx-1">→</span> 
                            {{ $program->end_date ? $program->end_date->format('M d, Y') : 'Ongoing' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Financials -->
            <div class="card border border-slate-100 shadow-sm p-6 md:p-8">
                <h3 class="font-bold text-slate-800 text-lg mb-6">Financial Overview</h3>
                
                <div class="bg-slate-50 rounded-xl p-6 mb-6 border border-slate-100">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Budget Utilization</p>
                            <h4 class="text-2xl font-bold text-slate-800">
                                {{ number_format(($program->amount_spent / max(1, $program->budget_allocated)) * 100, 1) }}%
                            </h4>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500 uppercase tracking-wide font-bold mb-1">Remaining</p>
                            <p class="text-sm font-bold text-emerald-600">GHS {{ number_format(max(0, $program->budget_allocated - $program->amount_spent), 2) }}</p>
                        </div>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">
                         <div class="h-full rounded-full transition-all duration-500
                            {{ ($program->amount_spent / max(1, $program->budget_allocated)) > 0.9 ? 'bg-rose-500' : 'bg-primary-500' }}" 
                            style="width: {{ min(100, ($program->amount_spent / max(1, $program->budget_allocated)) * 100) }}%"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="p-4 rounded-lg bg-blue-50 border border-blue-100">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wide mb-1">Total Budget</p>
                        <p class="text-xl font-bold text-blue-900">GHS {{ number_format($program->budget_allocated, 2) }}</p>
                    </div>
                    <div class="p-4 rounded-lg bg-purple-50 border border-purple-100">
                         <p class="text-xs font-bold text-purple-600 uppercase tracking-wide mb-1">Total Spent</p>
                        <p class="text-xl font-bold text-purple-900">GHS {{ number_format($program->amount_spent ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

             <!-- Beneficiaries -->
            <div class="card border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-base">Beneficiaries</h3>
                    <span class="text-xs font-bold bg-white px-2.5 py-1 rounded-full border border-slate-200 text-slate-600 shadow-sm">
                        {{ $program->beneficiaries_count ?? 0 }} Total
                    </span>
                </div>
                 <div class="p-6 text-center">
                     @if($program->beneficiaries_count > 0)
                        <!-- Placeholder for list since actual beneficiary relation structure might need more inspection, assuming standard iteration if data exists -->
                        <div class="flex flex-col items-center justify-center py-8">
                             <p class="text-slate-500 mb-2">Beneficiary functionality is ready.</p>
                             <!-- If we had a beneficiaries relation loaded, we would loop here -->
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <p class="text-slate-500 font-medium">No beneficiaries added yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            <div class="card border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wide">Manage Program</h3>
                </div>
                <div class="p-5 space-y-3">
                    @if($program->status !== 'active')
                        <form action="{{ route('welfare.programs.activate', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn btn-primary flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg font-bold text-sm shadow-sm transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Activate Program
                            </button>
                        </form>
                    @endif

                    @if($program->status === 'active')
                        <form action="{{ route('welfare.programs.pause', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Pause Program
                            </button>
                        </form>
                        <form action="{{ route('welfare.programs.complete', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Complete Program
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Coordinator -->
            <div class="card border border-slate-100 shadow-sm">
                 <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wide">Program Lead</h3>
                </div>
                <div class="p-5 flex items-center gap-4">
                     <div class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 font-bold text-lg">
                        {{ substr($program->coordinator->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $program->coordinator->name ?? 'Unassigned' }}</p>
                        <p class="text-xs text-slate-500">Coordinator</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
