@extends('layouts.app')

@section('title', 'QR Code Details')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">QR Code Details</h1>
        <p class="text-slate-500 text-sm mt-1">ID: <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-600">{{ $qrCode->id }}</code></p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('qr-management.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg font-medium text-sm text-slate-600 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
        <button onclick="printQR('{{ $qrCode->id }}')" class="inline-flex items-center px-4 py-2 bg-slate-800 text-white rounded-lg font-medium text-sm hover:bg-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="flex flex-col lg:flex-row gap-6">

    <!-- QR Code & Actions -->
    <div class="w-full lg:w-96 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 text-center">
            <div id="qrCodeDisplay" class="bg-slate-50 rounded-xl p-4 mb-4 border border-slate-100 flex items-center justify-center min-h-[200px]">
                <div class="animate-pulse flex flex-col items-center">
                    <div class="w-12 h-12 bg-slate-200 rounded-full mb-2"></div>
                    <div class="h-4 bg-slate-200 rounded w-24"></div>
                </div>
            </div>
            
            <div class="mb-6">
                <span class="text-xs font-bold uppercase text-slate-400 mb-1 block">Status</span>
                @if($qrCode->revoked)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Revoked</span>
                @elseif($qrCode->isExpired())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-800">Expired</span>
                    <p class="text-xs text-red-500 mt-1 font-medium">Expired {{ $qrCode->expiration_time->diffForHumans() }}</p>
                @elseif($qrCode->isPending())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">Pending</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">Active</span>
                @endif
            </div>

            <div class="space-y-2">
                <button onclick="downloadQR()" class="w-full py-2 bg-emerald-50 text-emerald-600 rounded-lg text-sm font-bold hover:bg-emerald-100 border border-emerald-100 transition-colors">
                    Download PNG
                </button>
                @if(!$qrCode->revoked)
                    <button onclick="revokeQR()" class="w-full py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 border border-red-100 transition-colors">
                        Revoke Access
                    </button>
                     @if(!$qrCode->isExpired())
                    <button onclick="extendQR()" class="w-full py-2 bg-white text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50 border border-slate-200 transition-colors">
                        Extend Expiration
                    </button>
                    @endif
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h4 class="text-sm font-bold text-slate-800 uppercase mb-4">Quick Stats</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-slate-50">
                    <span class="text-slate-500 text-sm">Total Scans</span>
                    <span class="font-bold text-slate-800 text-lg">{{ $qrCode->total_scans }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-slate-50">
                    <span class="text-slate-500 text-sm">Unique Users</span>
                    <span class="font-bold text-slate-800 text-lg">{{ $qrCode->unique_users }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 text-sm">Success Rate</span>
                    <span class="font-bold text-emerald-600 text-lg">{{ number_format($qrCode->success_rate, 1) }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details & Logs -->
    <div class="flex-1 space-y-6">
        
        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-primary-600 uppercase mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Configuration
                </h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Type</dt>
                        <dd class="font-medium text-slate-800">{{ str_replace('_', ' ', $qrCode->type) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Service Date</dt>
                        <dd class="font-medium text-slate-800">{{ $qrCode->service_date ? \Carbon\Carbon::parse($qrCode->service_date)->format('M d, Y') : 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Service Type</dt>
                        <dd class="font-medium text-slate-800 capitalize">{{ str_replace('_', ' ', $qrCode->service_type) ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Generated By</dt>
                        <dd class="font-medium text-slate-800">{{ $qrCode->generator->name ?? 'System' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                  <h3 class="text-sm font-bold text-primary-600 uppercase mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Timing & Limits
                </h3>
                 <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Activation</dt>
                        <dd class="font-medium text-slate-800">{{ $qrCode->activation_time->format('M d, H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Expiration</dt>
                        <dd class="font-medium text-slate-800">{{ $qrCode->expiration_time->format('M d, H:i') }}</dd>
                    </div>
                     <div class="flex justify-between">
                        <dt class="text-slate-500">Location</dt>
                        <dd class="font-medium text-slate-800">
                             @if($qrCode->location_required)
                                <span class="text-emerald-600">Required ({{ $qrCode->location_radius }}m)</span>
                            @else
                                <span class="text-slate-400">Optional</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Max Scans</dt>
                        <dd class="font-medium text-slate-800">{{ $qrCode->max_scans ?? 'Unlimited' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Charts -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
             <h3 class="text-sm font-bold text-slate-800 uppercase mb-4">Scan Activity</h3>
             <div class="h-64">
                 <canvas id="scanTrendsChart"></canvas>
             </div>
        </div>

        <!-- Logs -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
             <div class="p-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Recent Scans</h3>
                 <button onclick="exportLogs()" class="text-xs font-bold text-primary-600 hover:text-primary-700">
                    Export CSV
                </button>
             </div>
             <div class="overflow-x-auto">
                 <table class="w-full text-left text-sm">
                     <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                         <tr>
                             <th class="px-6 py-3">Time</th>
                             <th class="px-6 py-3">User</th>
                             <th class="px-6 py-3">Details</th>
                             <th class="px-6 py-3">Status</th>
                         </tr>
                     </thead>
                     <tbody class="divide-y divide-slate-100">
                          @forelse($scanLogs as $log)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-3 text-slate-600">{{ $log->scan_time->format('M d, H:i') }}</td>
                                <td class="px-6 py-3 font-medium text-slate-800">
                                     @if($log->user)
                                        {{ $log->user->name }}
                                    @else
                                        <span class="text-slate-400 italic">Guest</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-slate-500">
                                    <div class="flex items-center gap-2">
                                        @if($log->device_type === 'ios') <i class="fab fa-apple"></i> @elseif($log->device_type === 'android') <i class="fab fa-android"></i> @else <i class="fas fa-globe"></i> @endif
                                        <span>{{ ucfirst($log->device_type) }}</span>
                                        @if($log->distance_from_church)
                                            <span class="text-xs bg-slate-100 px-1.5 rounded">{{ $log->distance_from_church }}m</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                     @if($log->success)
                                        <span class="text-emerald-600 font-bold text-xs">Success</span>
                                    @else
                                        <span class="text-red-500 font-bold text-xs" title="{{ $log->error_reason }}">Failed</span>
                                    @endif
                                </td>
                            </tr>
                          @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">No scans recorded yet.</td>
                            </tr>
                          @endforelse
                     </tbody>
                 </table>
             </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const qrId = '{{ $qrCode->id }}';

    // Fetch and display QR
    fetch(`/api/v1/qr-management/${qrId}`, {
        headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('qrCodeDisplay').innerHTML = `
                <img src="${data.data.image}" class="w-48 h-48 rounded-lg shadow-sm">
            `;
        }
    })
    .catch(console.error);

    // Chart
    new Chart(document.getElementById('scanTrendsChart'), {
        type: 'line',
        data: {
            labels: @json($analytics['hourly_distribution'] ?? array_fill(0, 24, 0)).map((_, i) => i + ':00'),
            datasets: [{
                label: 'Scans',
                data: @json(array_values($analytics['hourly_distribution'] ?? array_fill(0, 24, 0))),
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    function downloadQR() {
        const img = document.querySelector('#qrCodeDisplay img');
        if(img) {
            const a = document.createElement('a');
            a.href = img.src;
            a.download = `QR-${qrId}.png`;
            a.click();
        } else {
             alert('QR Image not loaded yet');
        }
    }

    function printQR(id) {
         window.open(`/qr-management/print/preview?qr_ids=${id}`, '_blank');
    }

    // Mock functions for other actions - replace with real API calls
    async function revokeQR() {
        if(confirm('Revoke access?')) {
            // fetch logic
            alert('Revoked (Mock Action)');
            location.reload();
        }
    }
    
    function extendQR() {
        const min = prompt('Extend by minutes:', 60);
        if(min) alert('Extended (Mock Action)');
    }

    function exportLogs() {
        alert('Exporting CSV...');
    }

</script>
@endpush
