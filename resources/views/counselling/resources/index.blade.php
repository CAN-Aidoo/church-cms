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
                        <a href="{{ route('counselling.resources.show', $resource) }}" class="text-blue-600 hover:underline text-sm font-medium">View Resource</a>
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
