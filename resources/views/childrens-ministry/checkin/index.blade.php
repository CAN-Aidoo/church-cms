@extends('layouts.app')

@section('title', 'Child Check-in')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Check-in Station') }}
    </h2>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Check-in Form -->
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">New Check-in</h3>
                    <form method="POST" action="{{ route('childrens-ministry.checkin.process') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Child ID / Search</label>
                                {{-- In a real app, this would be a search select or autocomplete --}}
                                <input type="number" name="child_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required placeholder="Enter Child ID">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Classroom</label>
                                <select name="classroom_assigned" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="Nursery">Nursery</option>
                                    <option value="Toddlers">Toddlers</option>
                                    <option value="K-Grade 2">K-Grade 2</option>
                                    <option value="Grade 3-5">Grade 3-5</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                <textarea name="notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" rows="2"></textarea>
                            </div>

                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                                Check In
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Check-ins List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Active Check-ins ({{ $checkins->count() }})</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Child</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($checkins as $checkin)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $checkin->child->full_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $checkin->created_at->format('H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-mono text-blue-600">{{ $checkin->security_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <form method="POST" action="{{ route('childrens-ministry.checkout.process', $checkin) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="security_code" value="{{ $checkin->security_code }}">
                                                <input type="hidden" name="authorized_person" value="Parent">
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Check Out</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No children checked in yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Total Checked In</h3>
                <p class="text-4xl font-bold text-blue-600">{{ $statistics['active_count'] ?? 0 }}</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">By Classroom</h3>
                <ul class="space-y-2">
                    @foreach($statistics['by_classroom'] ?? [] as $room => $count)
                        <li class="flex justify-between">
                            <span class="text-gray-600">{{ $room }}</span>
                            <span class="font-bold">{{ $count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
