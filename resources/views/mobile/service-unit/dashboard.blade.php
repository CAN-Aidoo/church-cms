@extends('layouts.mobile')

@section('title', 'Service Units')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-b-3xl p-6 shadow-lg -mx-4 -mt-4">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">My Units</h1>
                <p class="text-orange-100 opacity-90">Service & Ministry</p>
            </div>
            <div class="bg-white/20 p-2 rounded-full backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Units List -->
    <div id="units-list" class="space-y-4 px-1">
        <!-- Loading State -->
        <div class="animate-pulse space-y-4">
            @for ($i = 0; $i < 2; $i++)
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="h-6 bg-gray-200 rounded w-1/2 mb-3"></div>
                <div class="h-4 bg-gray-200 rounded w-1/3 mb-4"></div>
                <div class="flex gap-2">
                    <div class="h-8 bg-gray-200 rounded w-20"></div>
                    <div class="h-8 bg-gray-200 rounded w-20"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Upcoming Duties -->
    <div class="px-1">
        <h2 class="text-lg font-bold text-gray-800 mb-3">Upcoming Duties</h2>
        <div id="duties-list" class="space-y-3">
             <!-- Populated via JS -->
        </div>
    </div>
</div>

<!-- Bottom Navigation (Standard) -->
@include('layouts.partials.mobile-nav')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const unitsList = document.getElementById('units-list');
        const dutiesList = document.getElementById('duties-list');

        try {
            // Load My Units (Existing Endpoint)
            const unitsRes = await app.api.get('/mobile/v1/service-unit/my-units');
            
            if (unitsRes.success && unitsRes.data.length > 0) {
                renderUnits(unitsRes.data);
            } else {
                unitsList.innerHTML = `
                    <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-300">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500">You are not in any service units.</p>
                        <a href="#" class="text-blue-600 font-medium text-sm mt-2 block">Join a Unit</a>
                    </div>
                `;
            }

            // Load Upcoming Duties (Using existing endpoint logic)
            // Note: This endpoint might need to be created if not exists, for now simulating or using member duties
            // Assuming /mobile/v1/service-unit/duty-roster exists or using mock
            renderDuties([]); 

        } catch (error) {
            console.error('Failed to load service units:', error);
            app.showToast('Failed to load data', 'error');
        }

        function renderUnits(units) {
            unitsList.innerHTML = units.map(unit => `
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-orange-100 to-white rounded-bl-full -mr-4 -mt-4"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">${unit.name}</h3>
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-lg uppercase tracking-wider">
                                ${unit.pivot.role}
                            </span>
                        </div>
                        
                        <p class="text-gray-500 text-sm mb-4 line-clamp-1">${unit.description || 'No description'}</p>
                        
                        <div class="flex gap-2">
                            <a href="/mobile/service-unit/${unit.id}/roster" class="flex-1 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium text-center border border-gray-200 transition">
                                View Roster
                            </a>
                            ${['leader', 'assistant_leader'].includes(unit.pivot.role) ? `
                                <a href="/mobile/service-unit/${unit.id}/manage" class="flex-1 py-2 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg text-sm font-medium text-center border border-orange-200 transition">
                                    Manage
                                </a>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderDuties(duties) {
            if (duties.length === 0) {
                dutiesList.innerHTML = `
                    <div class="bg-gray-50 rounded-xl p-4 text-center text-gray-500 text-sm">
                        No upcoming duties scheduled.
                    </div>
                `;
                return;
            }
            // Implementation for duties list
        }
    });
</script>
@endpush
@endsection
