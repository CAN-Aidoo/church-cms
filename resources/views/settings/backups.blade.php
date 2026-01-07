@extends('layouts.app')

@section('title', 'System Backups')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">System Backups</h1>
            <p class="text-slate-500 mt-1">Safeguard your data with regular snapshots.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('settings.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Settings
            </a>
            <button onclick="document.getElementById('createBackupModal').classList.remove('hidden')" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                New Backup
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

     @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Backup Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card p-6 border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Snapshots</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $backups->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" /></svg>
            </div>
        </div>

        <div class="card p-6 border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Successful</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $backups->where('status', 'completed')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <div class="card p-6 border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Processing</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $backups->where('status', 'in_progress')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform animate-pulse">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <div class="card p-6 border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Failed</p>
                <p class="text-2xl font-bold text-rose-600 mt-1">{{ $backups->where('status', 'failed')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Backups List -->
    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Filename</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @forelse($backups as $backup)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700 font-mono">{{ $backup->filename }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="align-middle inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border capitalize
                                    {{ $backup->type === 'full' ? 'bg-primary-50 text-primary-700 border-primary-100' : '' }}
                                    {{ $backup->type === 'database' ? 'bg-cyan-50 text-cyan-700 border-cyan-100' : '' }}
                                    {{ $backup->type === 'files' ? 'bg-purple-50 text-purple-700 border-purple-100' : '' }}">
                                    {{ ucfirst($backup->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-mono">
                                {{ $backup->size > 0 ? number_format($backup->size / 1024 / 1024, 2) . ' MB' : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold
                                    {{ $backup->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : '' }}
                                    {{ $backup->status === 'in_progress' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $backup->status === 'failed' ? 'bg-rose-50 text-rose-700' : '' }}
                                    {{ $backup->status === 'pending' ? 'bg-slate-100 text-slate-700' : '' }}">
                                    @if($backup->status === 'in_progress')
                                        <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    @endif
                                    {{ ucfirst(str_replace('_', ' ', $backup->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-700">{{ $backup->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-slate-400">by {{ $backup->creator->name ?? 'System' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center justify-end gap-3">
                                    @if($backup->status === 'completed')
                                        <a href="{{ route('settings.download-backup', $backup) }}" class="text-primary-600 hover:text-primary-800 font-bold hover:underline">Download</a>
                                    @endif
                                     @if($backup->status === 'failed')
                                        <button type="button" onclick="alert('Error: {{ addslashes($backup->error_message ?? 'Unknown error') }}')" class="text-rose-600 hover:text-rose-800 font-bold hover:underline">Error Details</button>
                                    @endif
                                    <form action="{{ route('settings.delete-backup', $backup) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-rose-600 font-bold hover:underline transition-colors">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">No backups available.</p>
                                <p class="text-xs text-slate-400 mt-1">Create a backup to secure your data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($backups->hasPages())
        <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
            {{ $backups->links() }}
        </div>
        @endif
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-100 rounded-xl p-5 flex items-start gap-4">
        <div class="p-2 bg-blue-100 rounded-lg text-blue-600 flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <h4 class="text-blue-900 font-bold text-sm mb-1">Backup Strategy Guide</h4>
            <p class="text-blue-800 text-sm leading-relaxed mb-2">Regular backups are your safety net. We recommend the following schedule:</p>
            <div class="flex gap-4">
                <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-1 rounded">Daily: Database Only</span>
                <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-1 rounded">Weekly: Full Backup</span>
            </div>
        </div>
    </div>
</div>

<!-- Create Backup Modal -->
<div id="createBackupModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-800">New Backup</h3>
             <button onclick="document.getElementById('createBackupModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="{{ route('settings.create-backup') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <label class="block relative p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors group">
                    <div class="flex items-center gap-3">
                        <input type="radio" name="type" value="full" required class="form-radio text-primary-600 border-slate-300 focus:ring-primary-500 w-5 h-5">
                        <div>
                            <span class="block text-sm font-bold text-slate-800">Full System Backup</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Includes database and all uploaded files (Recommended)</span>
                        </div>
                    </div>
                </label>

                <label class="block relative p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors group">
                    <div class="flex items-center gap-3">
                        <input type="radio" name="type" value="database" required class="form-radio text-primary-600 border-slate-300 focus:ring-primary-500 w-5 h-5">
                        <div>
                            <span class="block text-sm font-bold text-slate-800">Database Only</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Quick backup of all application data tables</span>
                        </div>
                    </div>
                </label>

                 <label class="block relative p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors group">
                    <div class="flex items-center gap-3">
                        <input type="radio" name="type" value="files" required class="form-radio text-primary-600 border-slate-300 focus:ring-primary-500 w-5 h-5">
                        <div>
                            <span class="block text-sm font-bold text-slate-800">Media Files Only</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Backup of uploads directory (Images, Documents)</span>
                        </div>
                    </div>
                </label>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                 <button type="button" onclick="document.getElementById('createBackupModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm">Cancel</button>
                 <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-bold text-sm shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Start Backup
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
