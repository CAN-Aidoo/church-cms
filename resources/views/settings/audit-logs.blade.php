@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Audit Logs</h1>
            <p class="mt-2 text-sm text-gray-600">Track all system activities and changes</p>
        </div>
        <a href="{{ route('settings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            Back to Settings
        </a>
    </div>

    <!-- Filters -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('settings.audit-logs') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- User Filter -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">User</label>
                    <select id="user_id"
                            name="user_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Filter -->
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                    <select id="action"
                            name="action"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Actions</option>
                        <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                        <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                    <input type="date"
                           id="date_from"
                           name="date_from"
                           value="{{ request('date_from') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                    <input type="date"
                           id="date_to"
                           name="date_to"
                           value="{{ request('date_to') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('settings.audit-logs') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Reset Filters
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Audit Logs Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resource</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <!-- Timestamp -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $log->created_at->format('h:i A') }}</div>
                            </td>

                            <!-- User -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->user)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                            {{ substr($log->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $log->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ ucfirst($log->user->role) }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">System</span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $log->action === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $log->action === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $log->action === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $log->action === 'login' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $log->action === 'logout' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ !in_array($log->action, ['created', 'updated', 'deleted', 'login', 'logout']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>

                            <!-- Resource -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ class_basename($log->auditable_type) }}</div>
                                @if($log->auditable_id)
                                    <div class="text-xs text-gray-500">ID: {{ $log->auditable_id }}</div>
                                @endif
                            </td>

                            <!-- IP Address -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->ip_address ?? 'N/A' }}
                            </td>

                            <!-- Details -->
                            <td class="px-6 py-4">
                                <button type="button"
                                        @click="$dispatch('open-modal', { log: {{ json_encode($log) }} })"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No audit logs found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or check back later.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <!-- Information Card -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">About Audit Logs</h4>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Audit logs track all important activities in the system including:</p>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li>User authentication (logins and logouts)</li>
                        <li>Data creation, updates, and deletions</li>
                        <li>Configuration changes</li>
                        <li>Permission and role modifications</li>
                    </ul>
                    <p class="mt-2">Logs are retained for compliance and security purposes. Only administrators can access this information.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div x-data="{ open: false, currentLog: null }"
     @open-modal.window="open = true; currentLog = $event.detail.log"
     @keydown.escape.window="open = false"
     x-show="open"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div x-show="open"
             @click="open = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <!-- Modal panel -->
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Audit Log Details
                        </h3>
                        <div class="mt-2 space-y-4" x-show="currentLog">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Timestamp</label>
                                <p class="mt-1 text-sm text-gray-900" x-text="currentLog ? new Date(currentLog.created_at).toLocaleString() : ''"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">User Agent</label>
                                <p class="mt-1 text-sm text-gray-900 break-all" x-text="currentLog?.user_agent || 'N/A'"></p>
                            </div>
                            <div x-show="currentLog?.old_values">
                                <label class="block text-sm font-medium text-gray-700">Old Values</label>
                                <pre class="mt-1 text-xs text-gray-900 bg-gray-50 p-3 rounded overflow-x-auto" x-text="currentLog?.old_values ? JSON.stringify(currentLog.old_values, null, 2) : 'N/A'"></pre>
                            </div>
                            <div x-show="currentLog?.new_values">
                                <label class="block text-sm font-medium text-gray-700">New Values</label>
                                <pre class="mt-1 text-xs text-gray-900 bg-gray-50 p-3 rounded overflow-x-auto" x-text="currentLog?.new_values ? JSON.stringify(currentLog.new_values, null, 2) : 'N/A'"></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                        @click="open = false"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
