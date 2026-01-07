@extends('layouts.app')

@section('title', 'Curriculum Lessons')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Curriculum</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.index') }}" class="hover:text-primary-600 transition-colors">Children's Ministry</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Curriculum</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('childrens-ministry.curriculum.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Lesson
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card border border-slate-100 shadow-sm mb-6">
    <div class="p-4">
        <form method="GET" action="{{ route('childrens-ministry.curriculum') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="md:col-span-2">
                <label for="search" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by title, topic..." class="form-input w-full pl-10 border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                </div>
            </div>
            <div>
                <label for="age_group" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Age Group</label>
                <select name="age_group" id="age_group" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">All Groups</option>
                    <option value="nursery" {{ request('age_group') == 'nursery' ? 'selected' : '' }}>Nursery</option>
                    <option value="toddlers" {{ request('age_group') == 'toddlers' ? 'selected' : '' }}>Toddlers</option>
                    <option value="primary" {{ request('age_group') == 'primary' ? 'selected' : '' }}>Primary (K-2)</option>
                     <option value="juniors" {{ request('age_group') == 'juniors' ? 'selected' : '' }}>Juniors (3-5)</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-secondary w-full justify-center">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($lessons as $lesson)
        <div class="card border border-slate-100 shadow-sm flex flex-col h-full group hover:border-primary-200 hover:shadow-md transition-all">
            <div class="p-6 flex-1">
                <div class="flex justify-between items-start mb-3">
                    <span class="inline-flex items-center rounded-lg px-2.5 py-0.5 text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 capitalize">
                        {{ $lesson->age_group }}
                    </span>
                    <span class="inline-flex items-center rounded-lg px-2.5 py-0.5 text-xs font-bold 
                        {{ $lesson->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                        {{ $lesson->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
                
                <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors line-clamp-2">
                    <a href="{{ route('childrens-ministry.curriculum.show', $lesson) }}">{{ $lesson->title }}</a>
                </h3>
                <p class="text-sm text-slate-500 mb-3 font-medium">{{ $lesson->series ? "Series: $lesson->series" : 'Standalone Lesson' }}</p>
                
                <p class="text-sm text-slate-600 line-clamp-3 mb-4">{{ $lesson->lesson_objective }}</p>
                
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $lesson->duration_minutes }} mins
                    </span>
                    <span class="font-medium bg-slate-50 px-2 py-0.5 rounded border border-slate-100">{{ $lesson->bible_reference }}</span>
                </div>
            </div>
            <div class="px-6 py-3 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-3 text-sm font-medium">
                <a href="{{ route('childrens-ministry.curriculum.show', $lesson) }}" class="text-primary-600 hover:text-primary-700">View</a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('childrens-ministry.curriculum.edit', $lesson) }}" class="text-slate-500 hover:text-slate-800">Edit</a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 text-center bg-slate-50 rounded-xl border border-dashed border-slate-300">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">No Lessons Found</h3>
            <p class="text-slate-500 mb-6">Start building your curriculum by creating a new lesson.</p>
            <a href="{{ route('childrens-ministry.curriculum.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
                Create Lesson
            </a>
        </div>
    @endforelse
</div>

@if($lessons instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-8">
        {{ $lessons->links() }}
    </div>
@endif
@endsection
