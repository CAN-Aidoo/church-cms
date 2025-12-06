@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('shepherds.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $shepherd->flock_name }}</h1>
                    <p class="text-gray-600">Shepherd: {{ $shepherd->full_name }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <span class="badge badge-lg
                    @if($shepherd->status === 'active') badge-success
                    @elseif($shepherd->status === 'on_leave') badge-warning
                    @else badge-secondary
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $shepherd->status)) }}
                </span>
                @can('update', $shepherd)
                <a href="{{ route('shepherds.edit', $shepherd) }}" class="btn btn-secondary">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                @endcan
                <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="btn btn-primary">
                    <i class="fas fa-users mr-2"></i>Manage Flock
                </a>
            </div>
        </div>
    </div>

    <!-- Performance Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-users text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600">{{ $shepherd->current_flock_size }}</p>
                <p class="text-sm text-gray-600">Flock Members</p>
                <p class="text-xs text-gray-500 mt-1">{{ $shepherd->available_capacity }} capacity left</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-home text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600">{{ $performance['visitations'] }}</p>
                <p class="text-sm text-gray-600">Visitations (30 days)</p>
                <p class="text-xs text-gray-500 mt-1">{{ $performance['visitations_per_member'] }} per member</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check text-gold-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-gold-600">{{ $performance['meetings'] }}</p>
                <p class="text-sm text-gray-600">Meetings Held (30 days)</p>
                <p class="text-xs text-gray-500 mt-1">{{ $performance['meetings_per_month'] }} per month</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line text-purple-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-purple-600">{{ number_format($performance['average_meeting_attendance'], 1) }}</p>
                <p class="text-sm text-gray-600">Avg. Meeting Attendance</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Follow-up Required -->
            @if($followUpVisitations->count() > 0)
            <div class="card border-yellow-200 bg-yellow-50">
                <div class="card-header bg-yellow-100">
                    <h2 class="text-xl font-semibold text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Follow-up Required
                    </h2>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @foreach($followUpVisitations as $visitation)
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-yellow-200">
                            <div>
                                <p class="font-medium text-gray-800">{{ $visitation->member->full_name }}</p>
                                <p class="text-sm text-gray-600">
                                    Last visit: {{ $visitation->visit_date->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-yellow-700">
                                    Follow-up due: {{ $visitation->follow_up_date->format('M d, Y') }}
                                </p>
                            </div>
                            <a href="{{ route('shepherds.create-visitation', ['shepherd' => $shepherd, 'member_id' => $visitation->member_id]) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-home mr-1"></i>Visit
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Upcoming Meetings -->
            @if($upcomingMeetings->count() > 0)
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Upcoming Meetings</h2>
                    <a href="{{ route('shepherds.create-meeting', $shepherd) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i>Schedule Meeting
                    </a>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @foreach($upcomingMeetings as $meeting)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="badge badge-info">{{ ucfirst($meeting->meeting_type) }}</span>
                                    @if($meeting->is_today)
                                    <span class="badge badge-danger">Today</span>
                                    @elseif($meeting->is_upcoming)
                                    <span class="badge badge-warning">Upcoming</span>
                                    @endif
                                </div>
                                <p class="font-medium text-gray-800">{{ $meeting->meeting_date->format('M d, Y') }}</p>
                                @if($meeting->meeting_time)
                                <p class="text-sm text-gray-600">{{ $meeting->meeting_time }}</p>
                                @endif
                                @if($meeting->location)
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $meeting->location }}
                                </p>
                                @endif
                            </div>
                            <a href="{{ route('shepherds.meetings', $shepherd) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('shepherds.meetings', $shepherd) }}" class="text-blue-600 hover:underline text-sm">
                            View all meetings →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Visitations -->
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Recent Visitations</h2>
                    <a href="{{ route('shepherds.create-visitation', $shepherd) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i>Record Visit
                    </a>
                </div>
                <div class="card-body">
                    @if($recentVisitations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Member</th>
                                    <th>Type</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentVisitations as $visitation)
                                <tr>
                                    <td>{{ $visitation->visit_date->format('M d, Y') }}</td>
                                    <td>{{ $visitation->member->full_name }}</td>
                                    <td>
                                        <span class="badge badge-light">
                                            {{ ucfirst(str_replace('_', ' ', $visitation->visit_type)) }}
                                        </span>
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $visitation->visit_reason)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('shepherds.visitations', $shepherd) }}" class="text-blue-600 hover:underline text-sm">
                            View all visitations →
                        </a>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">No recent visitations</p>
                    @endif
                </div>
            </div>

            <!-- Flock Members -->
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Flock Members ({{ $shepherd->current_flock_size }})</h2>
                    <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-users-cog mr-1"></i>Manage
                    </a>
                </div>
                <div class="card-body">
                    @if($shepherd->flockMembers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($shepherd->flockMembers->take(10) as $member)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->full_name }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                            <div class="w-12 h-12 rounded-full bg-gradient-blue flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                            </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $member->full_name }}</p>
                                <p class="text-xs text-gray-600">{{ $member->phone }}</p>
                            </div>
                            <a href="{{ route('members.show', $member) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @if($shepherd->flockMembers->count() > 10)
                    <div class="mt-4 text-center">
                        <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="text-blue-600 hover:underline text-sm">
                            View all {{ $shepherd->current_flock_size }} members →
                        </a>
                    </div>
                    @endif
                    @else
                    <p class="text-gray-500 text-center py-4">No flock members assigned yet</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Shepherd Info -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Shepherd Information</h2>
                </div>
                <div class="card-body space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Shepherd Name</p>
                        <p class="font-medium text-gray-800">{{ $shepherd->full_name }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Appointed Date</p>
                        <p class="font-medium text-gray-800">{{ $shepherd->appointed_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $shepherd->years_of_service }} {{ $shepherd->years_of_service == 1 ? 'year' : 'years' }} of service</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Flock Capacity</p>
                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="
                                        @if($shepherd->capacity_percentage >= 100) bg-red-500
                                        @elseif($shepherd->capacity_percentage >= 80) bg-yellow-500
                                        @else bg-green-500
                                        @endif
                                        h-3 rounded-full transition-all"
                                         style="width: {{ min($shepherd->capacity_percentage, 100) }}%"></div>
                                </div>
                            </div>
                            <span class="text-sm font-medium text-gray-700">
                                {{ number_format($shepherd->capacity_percentage, 0) }}%
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $shepherd->current_flock_size }} of {{ $shepherd->max_flock_size }} members
                        </p>
                    </div>

                    @if($shepherd->description)
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Description</p>
                        <p class="text-sm text-gray-700">{{ $shepherd->description }}</p>
                    </div>
                    @endif

                    @if($shepherd->notes)
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Notes</p>
                        <p class="text-sm text-gray-700">{{ $shepherd->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Quick Actions</h2>
                </div>
                <div class="card-body space-y-2">
                    <a href="{{ route('shepherds.create-visitation', $shepherd) }}" class="btn btn-secondary w-full">
                        <i class="fas fa-home mr-2"></i>Record Visitation
                    </a>
                    <a href="{{ route('shepherds.create-meeting', $shepherd) }}" class="btn btn-secondary w-full">
                        <i class="fas fa-calendar-plus mr-2"></i>Schedule Meeting
                    </a>
                    <a href="{{ route('shepherds.visitations', $shepherd) }}" class="btn btn-secondary w-full">
                        <i class="fas fa-history mr-2"></i>View All Visitations
                    </a>
                    <a href="{{ route('shepherds.meetings', $shepherd) }}" class="btn btn-secondary w-full">
                        <i class="fas fa-calendar mr-2"></i>View All Meetings
                    </a>
                    <a href="{{ route('shepherds.reports', $shepherd) }}" class="btn btn-secondary w-full">
                        <i class="fas fa-file-alt mr-2"></i>View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
