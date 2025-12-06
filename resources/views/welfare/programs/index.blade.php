@extends('layouts.app')

@section('title', 'Welfare Programs')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welfare Programs</h1>
        <a href="{{ route('welfare.programs.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
            Create Program
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-50">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Program Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Budget</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Spent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($programs as $program)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $program->program_name }}</div>
                                <div class="text-xs text-gray-500">{{ $program->start_date ? $program->start_date->format('M d, Y') : 'No date' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                {{ str_replace('_', ' ', $program->program_type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                GHS {{ number_format($program->budget_allocated, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                GHS {{ number_format($program->amount_spent ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $program->status === 'active' ? 'bg-green-100 text-green-800' : 
                                      ($program->status === 'paused' ? 'bg-yellow-100 text-yellow-800' : 
                                      ($program->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('welfare.programs.show', $program) }}" class="text-primary-600 hover:text-primary-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">No programs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $programs->links() }}
        </div>
    </div>
@endsection