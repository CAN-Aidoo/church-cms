@extends('layouts.mobile')

@section('title', 'Record Visitation')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header -->
    <div class="bg-white p-4 -mx-4 -mt-4 shadow-sm border-b border-gray-100 sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <a href="{{ url('/mobile/shepherd') }}" class="p-2 -ml-2 text-gray-600 hover:bg-gray-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Record Visitation</h1>
        </div>
    </div>

    <form id="visitation-form" class="space-y-6">
        <!-- Member Selection -->
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-2">Member Visited</label>
            <select name="member_id" id="member_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                <option value="">Select Member</option>
                <!-- Filled via JS -->
            </select>
        </div>

        <!-- Visit Details -->
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Visit Date</label>
                <input type="date" name="visit_date" id="visit_date" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50" value="{{ date('Y-m-d') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Visit Type</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="visit_type" value="home" class="peer sr-only" checked>
                        <div class="p-3 border rounded-lg text-center peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 hover:bg-gray-50 transition">
                            <span class="block font-medium">Home Visit</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="visit_type" value="hospital" class="peer sr-only">
                        <div class="p-3 border rounded-lg text-center peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 hover:bg-gray-50 transition">
                            <span class="block font-medium">Hospital</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="visit_type" value="office" class="peer sr-only">
                        <div class="p-3 border rounded-lg text-center peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 hover:bg-gray-50 transition">
                            <span class="block font-medium">Office</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="visit_type" value="call" class="peer sr-only">
                        <div class="p-3 border rounded-lg text-center peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 hover:bg-gray-50 transition">
                            <span class="block font-medium">Phone Call</span>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" id="notes" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50" placeholder="Summary of discussion, prayer points, etc..."></textarea>
            </div>
            
            <div class="flex items-center gap-3">
                <input type="checkbox" name="follow_up_required" id="follow_up_required" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                <label for="follow_up_required" class="text-sm font-medium text-gray-700">Follow-up Required?</label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" id="submit-btn" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-blue-800 transform active:scale-95 transition-all flex items-center justify-center gap-2">
            <span>Record Visit</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </button>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const select = document.getElementById('member_id');
        const form = document.getElementById('visitation-form');
        const submitBtn = document.getElementById('submit-btn');

        // Load Members
        try {
            const res = await app.api.get('/mobile/v1/shepherd/flock');
            if (res.success) {
                const members = res.data.data;
                members.forEach(member => {
                    const option = document.createElement('option');
                    option.value = member.id;
                    option.textContent = `${member.first_name} ${member.last_name}`;
                    select.appendChild(option);
                });

                // Pre-select if member ID is in URL
                const urlParams = new URLSearchParams(window.location.search);
                const memberId = urlParams.get('member_id');
                if (memberId) select.value = memberId;
            }
        } catch (error) {
            console.error('Failed to load members:', error);
            app.showToast('Failed to load member list', 'error');
        }

        // Handle Submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!select.value) {
                app.showToast('Please select a member', 'error');
                return;
            }

            const originalBtnContent = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="animate-spin mr-2">⟳</span> Saving...';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            data.follow_up_required = document.getElementById('follow_up_required').checked;

            try {
                // Get geolocation if possible
                if (navigator.geolocation) {
                    try {
                        const position = await new Promise((resolve, reject) => {
                            navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 5000 });
                        });
                        data.location_lat = position.coords.latitude;
                        data.location_lng = position.coords.longitude;
                    } catch (err) {
                        console.log('Location access denied or timed out');
                    }
                }

                const res = await app.api.post('/mobile/v1/shepherd/visit', data);
                
                if (res.success) {
                    app.showToast('Visitation recorded successfully!', 'success');
                    setTimeout(() => window.location.href = '/mobile/shepherd', 1500);
                } else {
                    throw new Error(res.message || 'Failed to record');
                }
            } catch (error) {
                console.error('Submission error:', error);
                app.showToast(error.message || 'Failed to record visitation', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            }
        });
    });
</script>
@endpush
@endsection
