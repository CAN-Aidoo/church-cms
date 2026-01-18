@extends('layouts.app')

@section('title', 'Welfare Programs')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Welfare Programs</h1>
            <p class="text-slate-600">Manage long-term initiatives and projects.</p>
        </div>
        <a href="{{ route('welfare.programs.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-sm group">
            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Program
        </a>
    </div>

    <!-- Programs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($programs as $program)
        <div class="card border border-slate-100 shadow-sm hover:shadow-md transition-all group overflow-hidden flex flex-col h-full">
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border
                        {{ $program->status === 'active' ? 'bg-green-50 text-green-700 border-green-100' : 
                          ($program->status === 'paused' ? 'bg-amber-50 text-amber-700 border-amber-100' : 
                          ($program->status === 'completed' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-slate-50 text-slate-600 border-slate-200')) }}">
                        {{ ucfirst($program->status) }}
                    </span>
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-primary-600 transition-colors">
                    <a href="{{ route('welfare.programs.show', $program) }}">{{ $program->program_name }}</a>
                </h3>
                <p class="text-xs text-slate-500 uppercase tracking-wide font-semibold mb-4">{{ str_replace('_', ' ', $program->program_type) }}</p>

                <p class="text-sm text-slate-600 mb-6 line-clamp-2 flex-1">
                    {{ $program->description ?? 'No description provided.' }}
                </p>

                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-medium text-slate-500">
                        <span>Budget Usage</span>
                        <span>{{ number_format(($program->amount_spent / max(1, $program->budget_allocated)) * 100, 0) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500
                            {{ ($program->amount_spent / max(1, $program->budget_allocated)) > 0.9 ? 'bg-rose-500' : 'bg-primary-500' }}" 
                            style="width: {{ min(100, ($program->amount_spent / max(1, $program->budget_allocated)) * 100) }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-400 mt-1">
                        <span>GHS {{ number_format($program->amount_spent) }}</span>
                        <span>GHS {{ number_format($program->budget_allocated) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs text-slate-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        {{ $program->start_date ? $program->start_date->format('M d, Y') : 'N/A' }}
                    </span>
                    <a href="{{ route('welfare.programs.show', $program) }}" class="text-xs font-bold text-primary-600 hover:text-primary-700 flex items-center gap-1 group/link">
                        View Dashboard
                        <svg class="w-3.5 h-3.5 group-hover/link:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <!-- Edit -->
                    <a href="{{ route('welfare.programs.edit', $program) }}" class="text-slate-400 hover:text-primary-600 transition-colors" title="Edit Program">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <!-- Delete -->
                    <form action="{{ route('welfare.programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('Delete this program? This will only work if there are no active beneficiaries.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" title="Delete Program">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
         <div class="col-span-full py-16 text-center bg-white rounded-xl border border-slate-100 border-dashed">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No programs found</h3>
            <p class="text-slate-500 mb-6">Create a new welfare program to get started.</p>
             <a href="{{ route('welfare.programs.create') }}" class="px-6 py-2 bg-primary-600 text-white rounded-lg font-bold hover:bg-primary-700 transition">
                Create Program
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $programs->links() }}
    </div>
</div>
@endsection