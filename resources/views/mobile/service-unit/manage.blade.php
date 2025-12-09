@extends('layouts.mobile')

@section('title', 'Manage Unit')

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
            <h1 class="text-xl font-bold" id="unit-name">Loading...</h1>
        </div>

        <div class="flex gap-4 text-center">
            <div class="flex-1 bg-white/10 rounded-lg p-2 backdrop-blur-sm">
                <span class="block text-xl font-bold" id="member-count">-</span>
                <span class="text-xs text-orange-100">Members</span>
            </div>
            <div class="flex-1 bg-white/10 rounded-lg p-2 backdrop-blur-sm">
                <span class="block text-xl font-bold" id="upcoming-duties">-</span>
                <span class="text-xs text-orange-100">Duties</span>
            </div>
        </div>
    </div>

    <!-- Actions Grid -->
    <div class="grid grid-cols-2 gap-4 px-1">
        <button onclick="showAddMemberModal()" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 active:scale-95 transition">
            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Add Member</span>
        </button>

        <a href="javascript:void(0)" onclick="createRoster()" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 active:scale-95 transition">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">New Roster</span>
        </a>
    </div>

    <!-- Members List -->
    <div class="px-1">
        <h2 class="text-lg font-bold text-gray-800 mb-3">Unit Members</h2>
        <div id="members-list" class="space-y-3">
            <div class="animate-pulse space-y-3">
                <div class="bg-white h-16 rounded-xl"></div>
                <div class="bg-white h-16 rounded-xl"></div>
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div id="add-member-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-end sm:items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-6 transform transition-transform duration-300 translate-y-full sm:translate-y-0" id="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Add Member</h3>
            <button onclick="hideAddMemberModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="add-member-form" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Member</label>
                <!-- In a real app, this would be an async search select -->
                <input type="number" name="member_id" placeholder="Enter Member ID" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full px-4 py-2 border rounded-lg">
                    <option value="member">Member</option>
                    <option value="trainee">Trainee</option>
                    <option value="assistant_leader">Assistant Leader</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Joined Date</label>
                <input type="date" name="joined_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <button type="submit" class="w-full py-3 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700">
                Add to Unit
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const unitId = window.location.pathname.split('/')[3]; // Extract ID from URL
        
        try {
            // Load Unit Details
            const res = await app.api.get(`/mobile/v1/service-unit/${unitId}/details`);
            if (res.success) {
                const { unit, stats } = res.data;
                document.getElementById('unit-name').textContent = unit.name;
                document.getElementById('member-count').textContent = stats.total_members;
                document.getElementById('upcoming-duties').textContent = stats.upcoming_duties;
                
                loadMembers(unitId);
            }
        } catch (error) {
            console.error('Failed to load unit:', error);
            app.showToast('Failed to load details', 'error');
        }

        async function loadMembers(id) {
            const list = document.getElementById('members-list');
            try {
                const res = await app.api.get(`/mobile/v1/service-unit/${id}/members`);
                if (res.success) {
                    list.innerHTML = res.data.map(m => `
                        <div class="bg-white p-4 rounded-xl border border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-bold text-gray-600">
                                    ${m.member.first_name[0]}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">${m.member.first_name} ${m.member.last_name}</h4>
                                    <p class="text-xs text-gray-500 capitalize">${m.role}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-lg ${m.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                ${m.status}
                            </span>
                        </div>
                    `).join('');
                }
            } catch (err) {
                list.innerHTML = '<p class="text-center text-gray-500">Failed to load members</p>';
            }
        }

        // Add Member Logic
        window.showAddMemberModal = () => {
            document.getElementById('add-member-modal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('modal-content').classList.remove('translate-y-full');
            }, 10);
        };

        window.hideAddMemberModal = () => {
            document.getElementById('modal-content').classList.add('translate-y-full');
            setTimeout(() => {
                document.getElementById('add-member-modal').classList.add('hidden');
            }, 300);
        };

        document.getElementById('add-member-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            try {
                const res = await app.api.post(`/mobile/v1/service-unit/${unitId}/members`, data);
                if (res.success) {
                    app.showToast('Member added successfully', 'success');
                    hideAddMemberModal();
                    loadMembers(unitId);
                    e.target.reset();
                }
            } catch (error) {
                app.showToast(error.message || 'Failed to add member', 'error');
            }
        });
    });
</script>
@endpush
@endsection
