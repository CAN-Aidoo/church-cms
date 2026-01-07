@extends('layouts.app')

@section('title', 'Email Templates')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Email Templates</h1>
            <p class="text-slate-500 mt-1">Customize automated system emails.</p>
        </div>
        <a href="{{ route('settings.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Settings
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{ activeCategory: 'all' }" class="space-y-6">
        <!-- Filtering -->
        <div class="flex flex-wrap gap-2 p-1 bg-slate-100 rounded-xl inline-flex">
            <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-white text-slate-800 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'"
                    class="px-4 py-2 rounded-lg text-sm transition-all">
                All Templates
            </button>
            <button @click="activeCategory = 'member'"
                    :class="activeCategory === 'member' ? 'bg-white text-slate-800 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'"
                    class="px-4 py-2 rounded-lg text-sm transition-all">
                Member
            </button>
            <button @click="activeCategory = 'finance'"
                    :class="activeCategory === 'finance' ? 'bg-white text-slate-800 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'"
                    class="px-4 py-2 rounded-lg text-sm transition-all">
                Finance
            </button>
            <button @click="activeCategory = 'event'"
                    :class="activeCategory === 'event' ? 'bg-white text-slate-800 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'"
                    class="px-4 py-2 rounded-lg text-sm transition-all">
                Events
            </button>
             <button @click="activeCategory = 'notification'"
                    :class="activeCategory === 'notification' ? 'bg-white text-slate-800 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'"
                    class="px-4 py-2 rounded-lg text-sm transition-all">
                Notifications
            </button>
        </div>

        <!-- Templates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($templates as $template)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $template->category }}'" 
                     class="card group hover:shadow-lg transition-all duration-300 border-slate-200">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center 
                                    {{ $template->category === 'member' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $template->category === 'finance' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                    {{ $template->category === 'event' ? 'bg-purple-100 text-purple-600' : '' }}
                                    {{ $template->category === 'notification' ? 'bg-amber-100 text-amber-600' : '' }}
                                    {{ !in_array($template->category, ['member', 'finance', 'event', 'notification']) ? 'bg-slate-100 text-slate-600' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($template->category === 'member') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        @elseif($template->category === 'finance') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        @elseif($template->category === 'event') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        @endif
                                    </svg>
                                </div>
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide
                                    {{ $template->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $template->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <h3 class="font-bold text-slate-800 text-lg mb-1">{{ $template->name }}</h3>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-1">Subject: <span class="text-slate-700 font-medium">{{ $template->subject }}</span></p>

                         <!-- Variables preview -->
                        @if($template->available_variables && count($template->available_variables) > 0)
                            <div class="flex flex-wrap gap-1 mb-6">
                                @foreach(array_slice($template->available_variables, 0, 3) as $variable)
                                    <code class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-mono">{{ '{' . '{' . $variable . '}' . '}' }}</code>
                                @endforeach
                                @if(count($template->available_variables) > 3)
                                    <span class="text-[10px] text-slate-400 font-medium">+{{ count($template->available_variables) - 3 }} more</span>
                                @endif
                            </div>
                        @endif

                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-[10px] text-slate-400 font-medium" title="{{ $template->updated_at }}">
                                Updated {{ $template->updated_at->diffForHumans() }}
                            </span>
                             <a href="{{ route('settings.edit-email-template', $template) }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                Edit Template
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                 <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No email templates found</h3>
                    <p class="text-slate-500 max-w-sm mt-1">Check your database or seeders to ensure default templates are loaded.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
