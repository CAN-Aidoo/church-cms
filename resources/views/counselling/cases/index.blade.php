@extends('layouts.app')

@section('title', 'Counselling Cases')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cases') }}
        </h2>
        <a href="{{ route('counselling.cases.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            New Case
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Case Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Counsellor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($cases as $case)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $case->case_title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $case->member->full_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $case->primaryCounsellor->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm capitalize">{{ $case->priority }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm capitalize">{{ $case->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('counselling.cases.show', $case) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No cases found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         @if($cases instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-4 border-t border-gray-200">
                {{ $cases->links() }}
            </div>
        @endif
    </div>
@endsection
