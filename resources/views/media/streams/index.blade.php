@extends('layouts.app')

@section('title', 'Live Streams')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Live Streams</h1>
        <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
            Schedule Stream
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
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Scheduled Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Platforms</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($streams as $stream)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                {{ $stream->stream_title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $stream->scheduled_start->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @foreach($stream->platforms ?? [] as $platform)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-1">
                                        {{ ucfirst($platform) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $stream->status === 'live' ? 'bg-red-100 text-red-800 animate-pulse' : 
                                      ($stream->status === 'completed' ? 'bg-gray-100 text-gray-800' : 
                                      'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($stream->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-primary-600 hover:text-primary-900">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">No streams scheduled.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $streams->links() }}
        </div>
    </div>
@endsection
