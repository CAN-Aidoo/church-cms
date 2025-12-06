@extends('layouts.app')

@section('title', 'Welfare Cases')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welfare Cases</h1>
        <a href="{{ route('welfare.cases.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
            New Case
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Filters --}}
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <form action="{{ route('welfare.cases') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Search cases..." class="rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500" value="{{ request('search') }}">
                
                <select name="status" class="rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>

                <select name="priority" class="rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Priorities</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors text-sm font-medium">
                    Filter
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-50">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Case Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Beneficiary</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($cases as $case)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $case->case_title }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($case->case_description, 30) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $case->beneficiary_name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs text-gray-600 capitalize">{{ str_replace('_', ' ', $case->case_category) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $case->priority === 'critical' ? 'bg-red-100 text-red-800' : 
                                      ($case->priority === 'high' ? 'bg-orange-100 text-orange-800' : 
                                      ($case->priority === 'medium' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($case->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $case->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                      ($case->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                      ($case->status === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $case->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('welfare.cases.show', $case) }}" class="text-primary-600 hover:text-primary-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 text-sm">No cases found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $cases->links() }}
        </div>
    </div>
@endsection
