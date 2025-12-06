@extends('layouts.app')

@section('title', $child->full_name)

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $child->full_name }}
        </h2>
        <a href="{{ route('childrens-ministry.children') }}" class="text-gray-600 hover:text-gray-900">Back to Directory</a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                            <p class="mt-1">{{ $child->date_of_birth->format('F d, Y') }} ({{ $child->age }} years)</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Gender</p>
                            <p class="mt-1 capitalize">{{ $child->gender }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Grade Level</p>
                            <p class="mt-1">{{ $child->grade_level ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">School</p>
                            <p class="mt-1">{{ $child->school_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mt-6 mb-4">Family Information</h3>
                    @if($child->family)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium">{{ $child->family->family_name }} Family</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $child->family->address ?? 'No address on file' }}</p>
                            {{-- Add more family details if available --}}
                        </div>
                    @else
                        <p class="text-gray-500">No family linked.</p>
                    @endif
                </div>
            </div>

            <!-- Medical/Allergies -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4 text-red-600">Medical Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Allergies</p>
                            <p class="mt-1">{{ $child->allergies ?? 'None known' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Medical Conditions</p>
                            <p class="mt-1">{{ $child->medical_conditions ?? 'None known' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm font-medium text-gray-500">Special Notes</p>
                            <p class="mt-1">{{ $child->special_needs_notes ?? 'None' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance History -->
        <div class="col-span-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Recent Attendance</h3>
                    @if(isset($attendanceHistory) && count($attendanceHistory) > 0)
                        <ul class="space-y-3">
                            @foreach($attendanceHistory->take(5) as $attendance)
                                <li class="flex justify-between items-center text-sm">
                                    <span>{{ $attendance->date->format('M d, Y') }}</span>
                                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">Present</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm">No attendance history.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
