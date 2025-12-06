@extends('layouts.app')

@section('title', 'Agreements')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Partnership Agreements</h1>
        <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
            New Agreement
        </button>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-50">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Partner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($agreements as $agreement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $agreement->agreement_title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $agreement->partner->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $agreement->start_date->format('M Y') }} - {{ $agreement->end_date ? $agreement->end_date->format('M Y') : 'Ongoing' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $agreement->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($agreement->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-primary-600 hover:text-primary-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">No agreements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $agreements->links() }}
        </div>
    </div>
@endsection
