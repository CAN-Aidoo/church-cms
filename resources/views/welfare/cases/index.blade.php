@extends('layouts.app')

@section('title', 'Welfare Cases')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Welfare Cases</h1>
            <p class="text-slate-600">Manage and track beneficiary assistance requests.</p>
        </div>
        <a href="{{ route('welfare.cases.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-sm group">
            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Case
        </a>
    </div>

    <!-- Filters -->
    <div class="card border border-slate-100 shadow-sm mb-6">
        <div class="p-4">
            <form action="{{ route('welfare.cases') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, name..." class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Status</label>
                    <select name="status" class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Priority</label>
                    <select name="priority" class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <div class="flex gap-2">
                     <button type="submit" class="flex-1 px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-colors text-sm font-bold shadow-sm">
                        Filter
                    </button>
                    <a href="{{ route('welfare.cases') }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors text-sm font-medium">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Cases List -->
    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="px-6 py-4">Case Details</th>
                        <th class="px-6 py-4">Beneficiary</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Priority</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cases as $case)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-sm group-hover:text-primary-600 transition-colors mb-0.5">{{ Str::limit($case->case_title, 40) }}</div>
                                <div class="text-xs text-slate-500">{{ Str::limit($case->case_description, 50) }}</div>
                                <div class="text-[10px] text-slate-400 mt-1">{{ $case->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-700 block">{{ $case->beneficiary_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-slate-100 text-slate-600 capitalize">
                                    {{ str_replace('_', ' ', $case->case_category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                                    {{ $case->priority === 'critical' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 
                                      ($case->priority === 'high' ? 'bg-orange-100 text-orange-700 border border-orange-200' : 
                                      ($case->priority === 'medium' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-slate-100 text-slate-600 border border-slate-200')) }}">
                                    {{ ucfirst($case->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wide
                                    {{ $case->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : 
                                      ($case->status === 'rejected' ? 'bg-rose-50 text-rose-600' : 
                                      ($case->status === 'closed' ? 'bg-slate-100 text-slate-500' : 
                                      ($case->status === 'under_review' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600'))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('welfare.cases.show', $case) }}" class="inline-flex items-center text-xs font-bold text-primary-600 hover:text-primary-700 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded transition-colors">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <p class="text-slate-500 font-medium text-sm">No welfare cases found matching your filters.</p>
                                <a href="{{ route('welfare.cases.create') }}" class="text-primary-600 hover:text-primary-700 text-xs font-bold mt-2 inline-block">Create New Case</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $cases->links() }}
        </div>
    </div>
</div>
@endsection
