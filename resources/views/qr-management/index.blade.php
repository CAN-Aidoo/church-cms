@extends('layouts.app')

@section('title', 'QR Codes')

@section('header')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">QR Code Management</h1>
        <p class="text-slate-500 text-sm mt-1">Generate and manage system-wide QR codes</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('qr-management.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-900 focus:outline-none focus:border-primary-900 focus:ring ring-primary-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Generate New
        </a>
    </div>
</div>
@endsection

@section('content')

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Total Active</p>
                <p class="text-2xl font-bold text-slate-800">{{ $qrCodes->where('revoked', 0)->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Total Scans</p>
                <p class="text-2xl font-bold text-slate-800">{{ $qrCodes->sum('total_scans') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 mb-6">
    <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 w-full">
             <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Type</label>
             <select name="type" class="w-full rounded-lg border-slate-200 text-sm focus:ring-primary-500 focus:border-primary-500 bg-slate-50">
                 <option value="">All Types</option>
                 <option value="SERVICE_ATTENDANCE" {{ request('type') == 'SERVICE_ATTENDANCE' ? 'selected' : '' }}>Service Attendance</option>
                 <option value="EVENT_REGISTRATION" {{ request('type') == 'EVENT_REGISTRATION' ? 'selected' : '' }}>Event Registration</option>
                 <option value="PAYMENT" {{ request('type') == 'PAYMENT' ? 'selected' : '' }}>Payment</option>
             </select>
        </div>
        <div class="flex-1 w-full">
             <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status</label>
             <select name="status" class="w-full rounded-lg border-slate-200 text-sm focus:ring-primary-500 focus:border-primary-500 bg-slate-50">
                 <option value="">All Statuses</option>
                 <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                 <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                 <option value="EXPIRED" {{ request('status') == 'EXPIRED' ? 'selected' : '' }}>Expired</option>
                 <option value="REVOKED" {{ request('status') == 'REVOKED' ? 'selected' : '' }}>Revoked</option>
             </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-900 transition-colors">
                Filter
            </button>
            <a href="{{ route('qr-management.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Results Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    @if($qrCodes->isEmpty())
        <div class="text-center py-12 px-6">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">No QR Codes Found</h3>
            <p class="text-slate-500 text-sm mb-6">Get started by creating your first QR code for services or events.</p>
            <a href="{{ route('qr-management.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-bold hover:bg-primary-700 transition-colors">
                Generate QR Code
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Type / ID</th>
                         <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Context</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Scans</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($qrCodes as $qr)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                   <i class="fas fa-qrcode"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700 text-sm">{{ str_replace('_', ' ', $qr->type) }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ substr($qr->id, 0, 8) }}...</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($qr->service_date)
                                <p class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::parse($qr->service_date)->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-500">{{ $qr->service_type }}</p>
                            @else
                                <span class="text-xs text-slate-400 italic">N/A</span>
                            @endif
                            <p class="text-[10px] text-slate-400 mt-1">Created {{ $qr->generated_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                             @if($qr->revoked)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Revoked
                                </span>
                            @elseif($qr->isExpired())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                    Expired
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    Active
                                </span>
                            @endif
                            
                            @if(!$qr->revoked && !$qr->isExpired() && $qr->expiration_time)
                                <p class="text-[10px] text-slate-400 mt-1">Expires {{ $qr->expiration_time->diffForHumans() }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                                {{ $qr->total_scans }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- View -->
                                <a href="{{ route('qr-management.show', $qr->id) }}" class="text-slate-400 hover:text-blue-600 transition-colors" title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <!-- Edit -->
                                @if(!$qr->revoked && !$qr->isExpired())
                                <a href="{{ route('qr-management.edit', $qr->id) }}" class="text-slate-400 hover:text-primary-600 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                @endif
                                <!-- Delete -->
                                @if($qr->revoked || $qr->isExpired())
                                <form action="{{ route('qr-management.destroy', $qr->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this QR code permanently?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @else
                                <!-- Revoke -->
                                <button onclick="revokeQR('{{ $qr->id }}')" class="text-slate-400 hover:text-red-600 transition-colors" title="Revoke">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $qrCodes->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function revokeQR(id) {
        if(confirm('Are you sure you want to revoke this QR code? It will stop working immediately.')) {
            fetch(`/api/v1/qr-management/${id}/revoke`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}` // Ensure token is sent if needed, or rely on cookie session for web
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to revoke'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred');
            });
        }
    }
</script>
@endpush
