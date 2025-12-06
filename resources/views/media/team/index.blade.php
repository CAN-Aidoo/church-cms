@extends('layouts.app')

@section('title', 'Media Team')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Media Team</h1>
        <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
            Add Member
        </button>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6">
            @forelse($members as $member)
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg border border-gray-100 hover:shadow-md transition-all text-center">
                    <div class="w-20 h-20 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-2xl mb-4">
                        {{ substr($member->user->name ?? 'U', 0, 1) }}
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $member->user->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ ucfirst(str_replace('_', ' ', $member->primary_role)) }}</p>
                    
                    <div class="flex gap-1 flex-wrap justify-center mb-4">
                        @foreach($member->skills ?? [] as $skill)
                            <span class="px-2 py-0.5 text-xs bg-white border border-gray-200 rounded text-gray-600">{{ $skill }}</span>
                        @endforeach
                    </div>

                    <span class="px-2 py-1 text-xs rounded-full {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                        {{ $member->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    No team members found.
                </div>
            @endforelse
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $members->links() }}
        </div>
    </div>
@endsection
