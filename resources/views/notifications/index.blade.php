@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
            <p class="text-gray-600 mt-1">{{ $unreadCount }} unread notification(s)</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('notifications.preferences') }}"
               class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Preferences
            </a>
            @if($unreadCount > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Mark All Read
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('notifications.index') }}" class="flex gap-4">
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Types</option>
                <option value="birthday" {{ request('type') === 'birthday' ? 'selected' : '' }}>Birthday</option>
                <option value="anniversary" {{ request('type') === 'anniversary' ? 'selected' : '' }}>Anniversary</option>
                <option value="attendance_alert" {{ request('type') === 'attendance_alert' ? 'selected' : '' }}>Attendance Alert</option>
                <option value="finance_approval" {{ request('type') === 'finance_approval' ? 'selected' : '' }}>Finance Approval</option>
                <option value="duty_roster" {{ request('type') === 'duty_roster' ? 'selected' : '' }}>Duty Roster</option>
                <option value="meeting_reminder" {{ request('type') === 'meeting_reminder' ? 'selected' : '' }}>Meeting Reminder</option>
            </select>

            <select name="is_read" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="false" {{ request('is_read') === 'false' ? 'selected' : '' }}>Unread Only</option>
                <option value="true" {{ request('is_read') === 'true' ? 'selected' : '' }}>Read Only</option>
            </select>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Filter
            </button>

            @if(request()->anyFilled(['type', 'is_read']))
            <a href="{{ route('notifications.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Clear
            </a>
            @endif
        </form>
    </div>

    <!-- Notifications List -->
    <div class="space-y-3">
        @forelse($notifications as $notification)
        <div class="bg-white border-2 {{ $notification->is_read ? 'border-gray-200' : 'border-blue-300' }} rounded-lg p-4 hover:shadow-md transition {{ $notification->getTypeClass() }}">
            <div class="flex items-start gap-4">
                <!-- Icon -->
                <div class="text-3xl flex-shrink-0">
                    {{ $notification->getDefaultIcon() }}
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 {{ $notification->is_read ? '' : 'text-blue-900' }}">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                <span class="inline-block w-2 h-2 bg-blue-600 rounded-full ml-2"></span>
                                @endif
                            </h3>
                            <p class="text-gray-700 mt-1">{{ $notification->message }}</p>

                            <!-- Metadata -->
                            <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                    {{ ucwords(str_replace('_', ' ', $notification->type)) }}
                                </span>
                                @if($notification->priority === 'high' || $notification->priority === 'urgent')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                    {{ ucfirst($notification->priority) }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 flex-shrink-0">
                            @if(!$notification->is_read)
                            <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition text-sm"
                                        title="Mark as read">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST"
                                  onsubmit="return confirm('Delete this notification?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-sm"
                                        title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Action Button -->
                    @if($notification->action_url)
                    <a href="{{ $notification->action_url }}"
                       class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                        View Details →
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Notifications</h3>
            <p class="text-gray-600">You're all caught up!</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
    @endif

    <!-- Bulk Actions -->
    @if($notifications->where('is_read', true)->count() > 0)
    <div class="mt-6 bg-white rounded-lg shadow-md p-4">
        <div class="flex justify-between items-center">
            <p class="text-gray-700">{{ $notifications->where('is_read', true)->count() }} read notification(s)</p>
            <form action="{{ route('notifications.delete-all-read') }}" method="POST"
                  onsubmit="return confirm('Delete all read notifications?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                    Delete All Read
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
