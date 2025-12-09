@extends('layouts.mobile')

@section('title', 'Service Unit Roster')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white p-6 shadow-lg -mx-4 -mt-4">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ url('/mobile/service-unit') }}" class="p-1 rounded-full hover:bg-white/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold" id="unit-name">Unit Roster</h1>
        </div>
    </div>

    <!-- Roster List -->
    <div id="roster-list" class="space-y-4 px-1">
        <!-- Populated via JS -->
        <div class="animate-pulse space-y-4">
            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="h-6 bg-gray-200 rounded w-1/2 mb-3"></div>
                <div class="h-4 bg-gray-200 rounded w-1/3 mb-4"></div>
            </div>
            @endfor
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const unitId = window.location.pathname.split('/')[3]; // Extract ID from URL
        const rosterList = document.getElementById('roster-list');
        
        try {
             // Load Unit Name
            const unitRes = await app.api.get(`/mobile/v1/service-unit/${unitId}/details`);
            if (unitRes.success) {
                document.getElementById('unit-name').textContent = unitRes.data.unit.name + ' Roster';
            }

            // Load Rosters
            const res = await app.api.get(`/mobile/v1/service-unit/${unitId}/rosters`);
            if (res.success && res.data.length > 0) {
                renderRosters(res.data);
            } else {
                rosterList.innerHTML = `
                    <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-300">
                        <p class="text-gray-500">No rosters found.</p>
                    </div>
                `;
            }

        } catch (error) {
             console.error('Failed to load rosters:', error);
             app.showToast('Failed to load rosters', 'error');
        }

        function renderRosters(rosters) {
             rosterList.innerHTML = rosters.map(roster => `
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-gray-900">${roster.roster_name}</h3>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg uppercase tracking-wider">
                            ${roster.status}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mb-2">
                        <span class="font-medium">Date:</span> ${new Date(roster.duty_date).toLocaleDateString()}
                    </p>
                    <p class="text-gray-500 text-sm">
                        <span class="font-medium">Type:</span> ${roster.duty_type}
                    </p>
                     <div class="mt-4">
                         <h4 class="text-sm font-semibold text-gray-800 mb-2">Assignments:</h4>
                         <ul class="list-disc list-inside text-sm text-gray-600">
                            ${roster.assignments && roster.assignments.length > 0 ? 
                                roster.assignments.map(a => `<li>${a.member.first_name} ${a.member.last_name}</li>`).join('') : 
                                '<li>No assignments</li>'}
                         </ul>
                     </div>
                </div>
            `).join('');
        }
    });
</script>
@endpush
@endsection
