@extends('layouts.app')

@section('title', 'Counselling Resources')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resource Library') }}
        </h2>
        <a href="{{ route('counselling.resources.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add Resource
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('counselling.resources') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search resources..." class="w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="flex items-center">
                     <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($resources as $resource)
                    <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded capitalize">{{ $resource->resource_type }}</span>
                        </div>
                        <h3 class="text-lg font-bold mb-2">{{ $resource->title }}</h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $resource->description }}</p>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <a href="{{ route('counselling.resources.show', $resource) }}" class="text-blue-600 hover:underline text-sm font-medium">View Resource</a>
                            <div class="flex items-center gap-2">
                                <!-- Edit -->
                                <a href="{{ route('counselling.resources.edit', $resource) }}" class="text-slate-400 hover:text-primary-600 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Delete -->
                                <form action="{{ route('counselling.resources.destroy', $resource) }}" method="POST" class="inline" onsubmit="return confirm('Delete this resource? This will also delete the associated file.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        No resources found.
                    </div>
                @endforelse
            </div>

             @if($resources instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-6">
                    {{ $resources->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
