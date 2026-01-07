@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Audit Logs</h1>
            <p class="text-slate-500 mt-1">Monitor system activity and changes.</p>
        </div>
        <a href="{{ route('settings.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Settings
        </a>
    </div>

    <!-- Toolbar -->
    <div class="card border border-slate-100 shadow-sm mb-8 overflow-hidden">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
             <form action="{{ route('settings.audit-logs') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                 <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">User</label>
                    <select name="user_id" class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                             <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Action Type</label>
                    <select name="action" class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                         <option value="">All Actions</option>
                        <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                        <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                    </select>
                </div>
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                </div>
                 <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-slate-800 text-white rounded-lg hover:bg-slate-900 font-bold text-sm shadow-sm transition-colors">
                        Apply Filters
                    </button>
                    @if(request()->anyFilled(['user_id', 'action', 'date_from', 'date_to']))
                     <a href="{{ route('settings.audit-logs') }}" class="px-4 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 font-bold text-sm transition-colors text-center">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50 border-b border-slate-100/50">
                    <tr>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Timestamp</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Event</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Resource</th>
                         <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-800">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                 @if($log->user)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                            {{ substr($log->user->name, 0, 1) }}
                                        </div>
                                         <span class="text-sm text-slate-700 font-medium">{{ $log->user->name }}</span>
                                    </div>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-500 text-xs font-bold">System</span>
                                @endif
                                <div class="text-[10px] text-slate-400 mt-0.5 pl-8">{{ $log->ip_address ?? 'IP hidden' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold border
                                    {{ $log->action === 'created' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : '' }}
                                    {{ $log->action === 'updated' ? 'bg-blue-50 text-blue-700 border-blue-100' : '' }}
                                    {{ $log->action === 'deleted' ? 'bg-rose-50 text-rose-700 border-rose-100' : '' }}
                                    {{ in_array($log->action, ['login', 'logout']) ? 'bg-slate-100 text-slate-700 border-slate-200' : '' }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-700 font-medium">{{ class_basename($log->auditable_type) }}</div>
                                <div class="text-xs text-slate-400 font-mono">ID: {{ $log->auditable_id ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button type="button" @click="$dispatch('open-audit-modal', { log: {{ json_encode($log) }} })" class="text-xs font-bold text-primary-600 hover:text-primary-700 hover:underline">
                                    View Data
                                </button>
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <p class="text-sm">No log entries found matching criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Details Modal -->
<div x-data="{ open: false, log: null }"
     @open-audit-modal.window="open = true; log = $event.detail.log"
     @keydown.escape.window="open = false"
     x-show="open"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
     style="display: none;">
    
    <div x-show="open" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="open = false"></div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
        
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center flex-shrink-0">
            <div>
                <h3 class="font-bold text-lg text-slate-800">Change Details</h3>
                <p class="text-xs text-slate-500">Recorded on <span x-text="log ? new Date(log.created_at).toLocaleString() : ''"></span></p>
            </div>
            <button @click="open = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto" x-show="log">
            <div class="space-y-6">
                 <!-- Metadata -->
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">User Agent</span>
                        <div class="text-slate-700 break-all text-xs" x-text="log ? log.user_agent : 'N/A'"></div>
                    </div>
                     <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">IP Address</span>
                        <div class="text-slate-700 font-mono text-xs" x-text="log ? log.ip_address : 'N/A'"></div>
                    </div>
                </div>

                <!-- Changes -->
                <div x-show="log && log.old_values" class="space-y-2">
                    <h4 class="text-sm font-bold text-rose-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                        Old Values
                    </h4>
                    <pre class="bg-rose-50 text-rose-900 text-xs font-mono p-4 rounded-lg border border-rose-100 overflow-x-auto" x-text="JSON.stringify(log.old_values, null, 2)"></pre>
                </div>

                 <div x-show="log && log.new_values" class="space-y-2">
                    <h4 class="text-sm font-bold text-emerald-700 flex items-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        New Values
                    </h4>
                    <pre class="bg-emerald-50 text-emerald-900 text-xs font-mono p-4 rounded-lg border border-emerald-100 overflow-x-auto" x-text="JSON.stringify(log.new_values, null, 2)"></pre>
                </div>
                
                 <div x-show="log && !log.old_values && !log.new_values" class="text-center py-8 text-slate-400">
                    <p class="text-sm">No data changes recorded for this event.</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end flex-shrink-0">
             <button @click="open = false" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm shadow-sm hover:bg-slate-50">Close</button>
        </div>
    </div>
</div>
@endsection
