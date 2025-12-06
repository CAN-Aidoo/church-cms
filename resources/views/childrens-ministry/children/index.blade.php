@extends('layouts.app')

@section('title', 'Children Directory')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Children Directory') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('childrens-ministry.children') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Age Group</label>
                    <select name="age_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">All Groups</option>
                        <option value="nursery" {{ request('age_group') == 'nursery' ? 'selected' : '' }}>Nursery</option>
                        <option value="toddlers" {{ request('age_group') == 'toddlers' ? 'selected' : '' }}>Toddlers</option>
                        <option value="primary" {{ request('age_group') == 'primary' ? 'selected' : '' }}>Primary</option>
                        <option value="teens" {{ request('age_group') == 'teens' ? 'selected' : '' }}>Teens</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Birthday Month</label>
                    <select name="birthday_month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">All Months</option>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('birthday_month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age / DOB</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent/Guardian</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($children as $child)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $child->full_name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $child->age }} yrs</div>
                                <div class="text-xs text-gray-500">{{ $child->date_of_birth->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $child->grade_level ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $child->family->family_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('childrens-ministry.children.show', $child) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No children found matching criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($children instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-4 border-t border-gray-200">
                {{ $children->links() }}
            </div>
        @endif
    </div>
@endsection
