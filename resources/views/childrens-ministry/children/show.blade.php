@extends('layouts.app')

@section('title', $child->full_name)

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">{{ $child->full_name }}</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.children') }}" class="hover:text-primary-600 transition-colors">Children's Directory</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Profile</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        @can('update', $child)
        <a href="{{ route('childrens-ministry.children.edit', $child) }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Edit Attributes
        </a>
        @endcan
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Main Card -->
        <div class="card border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 relative">
                 <div class="absolute top-0 right-0 p-6 opacity-30">
                    <svg class="w-32 h-32 text-slate-100" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row gap-6 items-start">
                    <div class="w-24 h-24 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-3xl font-bold border-4 border-white shadow-md">
                        {{ substr($child->first_name, 0, 1) }}{{ substr($child->last_name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-slate-800">{{ $child->full_name }}</h2>
                        <div class="text-sm text-slate-500 mt-1 flex flex-wrap gap-x-4 gap-y-1">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $child->age }} years old
                            </span>
                             <span class="flex items-center gap-1 capitalize">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $child->gender }}
                            </span>
                            @if($child->grade_level)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                {{ $child->grade_level }}
                            </span>
                            @endif
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Date of Birth</p>
                                <p class="font-medium text-slate-900">{{ $child->date_of_birth->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">School</p>
                                <p class="font-medium text-slate-900">{{ $child->school_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Family Information -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Family Information</h3>
            </div>
            <div class="p-6">
                @if($child->family)
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">{{ $child->family->family_name }} Family</h4>
                            @if($child->family->address)
                            <div class="flex items-start gap-2 text-sm text-slate-600 mt-1">
                                <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $child->family->address }}</span>
                            </div>
                            @endif
                            <div class="mt-3">
                                <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700">View Family Profile &rarr;</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                        <p class="text-slate-500">No family linked to this child record.</p>
                        <button class="text-sm text-primary-600 hover:text-primary-700 font-medium mt-1">Link Family</button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Medical Information -->
        <div class="card border border-red-50 shadow-sm">
            <div class="px-6 py-4 border-b border-red-50 bg-red-50/30 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h3 class="font-bold text-red-800 text-base">Medical Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Allergies</p>
                        @if($child->allergies)
                            <div class="bg-red-50 text-red-800 px-3 py-2 rounded-lg text-sm font-medium border border-red-100">
                                {{ $child->allergies }}
                            </div>
                        @else
                            <p class="text-slate-500 italic">None known</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Medical Conditions</p>
                         @if($child->medical_conditions)
                            <div class="bg-slate-50 text-slate-800 px-3 py-2 rounded-lg text-sm border border-slate-100">
                                {{ $child->medical_conditions }}
                            </div>
                        @else
                            <p class="text-slate-500 italic">None known</p>
                        @endif
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Special Needs / Notes</p>
                        <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $child->special_needs_notes ?? 'No additional notes provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance History Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <div class="card border border-slate-100 shadow-sm h-full">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Recent Attendance</h3>
            </div>
            <div class="p-0">
                @if(isset($attendanceHistory) && count($attendanceHistory) > 0)
                    <div class="divide-y divide-slate-100">
                        @foreach($attendanceHistory->take(8) as $attendance)
                            <div class="px-6 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <span class="text-sm font-medium text-slate-700">{{ $attendance->date->format('M d, Y') }}</span>
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-bold bg-emerald-50 text-emerald-700">Present</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-slate-100 text-center">
                        <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700">View Full History</a>
                    </div>
                @else
                    <div class="p-8 text-center">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-slate-500 text-sm">No attendance history found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
