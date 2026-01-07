@extends('layouts.app')

@section('title', 'Generate QR Code')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Generate New QR Code</h1>
        <p class="text-slate-500 text-sm mt-1">Create a secure QR code for church activities</p>
    </div>
    <a href="{{ route('qr-management.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg font-medium text-sm text-slate-600 hover:bg-slate-50 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to List
    </a>
</div>
@endsection

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    
    <!-- Configuration Form -->
    <div class="flex-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                Configuration
            </h3>

            <form id="qrGenerationForm" class="space-y-6">
                @csrf
                
                <!-- Type -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 mb-1">QR Code Type <span class="text-red-500">*</span></label>
                    <select id="type" name="type" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select Purpose...</option>
                        <option value="SERVICE_ATTENDANCE">Service Attendance</option>
                        <option value="EVENT_REGISTRATION">Event Registration</option>
                        <option value="PAYMENT">Payment</option>
                        <option value="CHECK_IN">General Check-In</option>
                        <option value="VISITOR_REGISTRATION">Visitor Registration</option>
                        <option value="EQUIPMENT_CHECKOUT">Equipment Checkout</option>
                    </select>
                </div>

                <!-- Service Details -->
                <div id="serviceDetails" class="hidden p-4 bg-slate-50 rounded-lg border border-slate-200 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Service Date</label>
                            <input type="date" name="service_date" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Service Type</label>
                            <select name="service_type" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="sunday_first">Sunday First Service</option>
                                <option value="sunday_second">Sunday Second Service</option>
                                <option value="wednesday">Midweek Service</option>
                                <option value="special">Special Event</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Start Time</label>
                        <input type="time" name="service_time" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <p class="text-xs text-slate-400 mt-1">Activates 30min before, expires 2h after.</p>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Activation Time</label>
                        <input type="datetime-local" name="activation_time" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <p class="text-xs text-slate-400 mt-1">Leave empty for immediate.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Expiration Time</label>
                        <input type="datetime-local" name="expiration_time" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <p class="text-xs text-slate-400 mt-1">Default is 24 hours.</p>
                    </div>
                </div>

                <!-- Settings Toggles -->
                <div class="space-y-3 pt-2">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors cursor-pointer">
                        <input type="checkbox" id="location_required" name="location_required" checked class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 w-5 h-5">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Require GPS Location</span>
                            <span class="block text-xs text-slate-500">User must be within radius to scan</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors cursor-pointer">
                        <input type="checkbox" id="requires_verification" name="requires_verification" checked class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 w-5 h-5">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Require Identity Verification</span>
                            <span class="block text-xs text-slate-500">Only logged-in members can scan</span>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 py-3 px-4 bg-primary-600 text-white font-bold rounded-xl shadow-lg shadow-primary-200 hover:bg-primary-700 active:scale-[0.98] transition-all">
                        Generate QR Code
                    </button>
                    <button type="button" onclick="generateBatch()" class="px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                        Batch
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Preview Sidebar -->
    <div class="w-full lg:w-96 space-y-6">
        <!-- Preview Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 text-center">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-6">Preview</h3>
            
            <div id="qrPlaceholder" class="py-8">
                <div class="w-48 h-48 bg-slate-100 rounded-2xl mx-auto flex items-center justify-center text-slate-300 mb-4 border-2 border-dashed border-slate-200">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <p class="text-slate-400 text-sm">QR Code will appear here</p>
            </div>

            <div id="qrResult" class="hidden">
                <img id="qrImage" src="" class="w-48 h-48 mx-auto rounded-xl shadow-sm border border-slate-100 mb-4">
                <div class="flex flex-col gap-2">
                    <a id="qrLink" href="#" target="_blank" class="w-full py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-200">Open Link</a>
                    <button onclick="downloadCurrentQR()" class="w-full py-2 bg-emerald-50 text-emerald-600 rounded-lg text-sm font-bold hover:bg-emerald-100 border border-emerald-100">Download PNG</button>
                    <button onclick="printCurrentQR()" class="w-full py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50">Print</button>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
            <h4 class="text-blue-800 font-bold mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Best Practices
            </h4>
            <ul class="text-sm text-blue-700 space-y-2">
                <li>• Use high contrast when printing tags.</li>
                <li>• For events, set expiration to end of day.</li>
                <li>• Enable GPS for attendance taking.</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentQR = null;

    document.getElementById('type').addEventListener('change', function() {
        const isService = this.value === 'SERVICE_ATTENDANCE';
        document.getElementById('serviceDetails').classList.toggle('hidden', !isService);
    });

    document.getElementById('qrGenerationForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = new FormData(e.target);
        const data = Object.fromEntries(form.entries());
        data.location_required = document.getElementById('location_required').checked;
        data.requires_verification = document.getElementById('requires_verification').checked;

        try {
            // Simulate API call for UI demo (Replace with actual fetch)
            /*
            const res = await fetch('{{ route('qr-management.store') }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            */
           
           // Mock Result
           const result = {
               success: true,
               data: {
                   id: 'QR-' + Date.now(),
                   image: 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=CHURCH-CMS-' + Date.now(),
                   url: '#'
               }
           };

            if(result.success) {
                currentQR = result.data;
                document.getElementById('qrPlaceholder').classList.add('hidden');
                document.getElementById('qrResult').classList.remove('hidden');
                document.getElementById('qrImage').src = result.data.image;
                document.getElementById('qrLink').href = result.data.url;
                
                window.dispatchEvent(new CustomEvent('notify', { 
                    detail: { message: 'QR Code Generated Successfully!', type: 'success' } 
                }));
            }
        } catch(e) {
            console.error(e);
            window.dispatchEvent(new CustomEvent('notify', { 
                detail: { message: 'Failed to generate QR', type: 'error' } 
            }));
        }
    });

    function downloadCurrentQR() {
        if(!currentQR) return;
        const a = document.createElement('a');
        a.href = currentQR.image;
        a.download = `QR-${currentQR.id}.png`;
        a.click();
    }

    function printCurrentQR() {
        if(!currentQR) return;
        window.open('about:blank', '_blank').document.write(`<img src="${currentQR.image}" onload="window.print()">`);
    }

    function generateBatch() {
        // Simple prompt for demo
        const count = prompt("How many codes to generate (1-10)?");
        if(count && count > 0) {
            window.dispatchEvent(new CustomEvent('notify', { 
                detail: { message: `Batch generation of ${count} codes started...`, type: 'info' } 
            }));
        }
    }
</script>
@endpush
