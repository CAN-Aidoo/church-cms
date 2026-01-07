@extends('layouts.mobile')

@section('title', 'Message Flock - Church App')
@section('header', 'Message Flock')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header with Back Button -->
    <div class="bg-white p-4 -mx-4 -mt-4 shadow-sm border-b border-gray-100 sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <a href="{{ url('/mobile/shepherd') }}" class="p-2 -ml-2 text-gray-600 hover:bg-gray-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Message Flock</h1>
        </div>
    </div>

    <!-- Send Message Form -->
    <form id="messageForm" class="space-y-6">
        <!-- Recipients Selection -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Recipients</h3>

            <!-- Select All / Deselect All -->
            <div class="flex gap-2 mb-3">
                <button type="button" onclick="selectAll()" class="flex-1 px-3 py-2 text-sm bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100 active:scale-95 transition">
                    Select All
                </button>
                <button type="button" onclick="deselectAll()" class="flex-1 px-3 py-2 text-sm bg-gray-50 text-gray-700 font-medium rounded-lg hover:bg-gray-100 active:scale-95 transition">
                    Deselect All
                </button>
            </div>

            <!-- Filter by Engagement -->
            <div class="mb-3">
                <label class="block text-xs text-gray-600 mb-1">Filter by Engagement</label>
                <select id="engagementFilter" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    <option value="all" selected>All Members</option>
                    <option value="Engaged">Engaged Only</option>
                    <option value="Committed">Committed Only</option>
                    <option value="Regular">Regular Only</option>
                    <option value="At Risk">At Risk Only</option>
                    <option value="Inactive">Inactive Only</option>
                </select>
            </div>

            <!-- Member Checkboxes -->
            <div id="membersList" class="space-y-2 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50">
                <!-- Loading State -->
                <div class="animate-pulse space-y-2">
                    @for ($i = 0; $i < 3; $i++)
                    <div class="h-10 bg-gray-200 rounded"></div>
                    @endfor
                </div>
            </div>

            <!-- Selected Count -->
            <div class="mt-3 text-sm text-gray-600 text-center">
                <span id="selectedCount">0</span> member(s) selected
            </div>
        </div>

        <!-- Message Content -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Message</h3>

            <textarea id="messageText" rows="6" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 resize-none" placeholder="Type your message here..."></textarea>

            <!-- Character Count -->
            <div class="flex justify-between items-center mt-2 text-xs">
                <span id="charCount" class="text-gray-500">0 / 160 characters</span>
                <span id="smsCount" class="text-gray-500">1 SMS</span>
            </div>

            <!-- Warning for long messages -->
            <div id="longMessageWarning" class="hidden mt-2 bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-800">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span>This message is longer than 160 characters and will be sent as multiple SMS segments.</span>
                </div>
            </div>
        </div>

        <!-- Quick Message Templates -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Quick Templates</h3>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="useTemplate('encouragement')" class="px-3 py-2 text-sm bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 active:scale-95 transition text-left">
                    <div class="font-medium">Encouragement</div>
                    <div class="text-xs opacity-75">Keep pressing on...</div>
                </button>
                <button type="button" onclick="useTemplate('prayer')" class="px-3 py-2 text-sm bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 active:scale-95 transition text-left">
                    <div class="font-medium">Prayer</div>
                    <div class="text-xs opacity-75">Praying for you...</div>
                </button>
                <button type="button" onclick="useTemplate('service')" class="px-3 py-2 text-sm bg-green-50 text-green-700 rounded-lg hover:bg-green-100 active:scale-95 transition text-left">
                    <div class="font-medium">Service Reminder</div>
                    <div class="text-xs opacity-75">See you Sunday...</div>
                </button>
                <button type="button" onclick="useTemplate('followup')" class="px-3 py-2 text-sm bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 active:scale-95 transition text-left">
                    <div class="font-medium">Follow-up</div>
                    <div class="text-xs opacity-75">Checking in...</div>
                </button>
            </div>
        </div>

        <!-- Send Button -->
        <button type="submit" id="sendBtn" class="w-full py-4 px-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-blue-800 transform active:scale-95 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
            <span>Send Message</span>
        </button>
    </form>
</div>

@push('scripts')
<script>
    let allMembers = [];
    let filteredMembers = [];
    let selectedMemberIds = [];

    const messageTemplates = {
        encouragement: "God bless you! Keep pressing on in faith. You are in our prayers. - Your Shepherd",
        prayer: "Praying for you and your family today. May God's grace and peace be with you always.",
        service: "Looking forward to seeing you this Sunday! Service starts at 9:00 AM. God bless you!",
        followup: "Hello! Just checking in to see how you're doing. Please reach out if you need anything. God bless!"
    };

    document.addEventListener('DOMContentLoaded', async () => {
        await loadFlockMembers();

        // Character count
        const messageText = document.getElementById('messageText');
        messageText.addEventListener('input', updateCharacterCount);

        // Engagement filter
        document.getElementById('engagementFilter').addEventListener('change', filterMembers);

        // Form submission
        document.getElementById('messageForm').addEventListener('submit', handleSubmit);
    });

    async function loadFlockMembers() {
        try {
            const result = await ChurchApp.apiCall('/api/mobile/v1/shepherd/flock', 'GET');

            if (result.success && result.data) {
                allMembers = result.data.data;
                filteredMembers = allMembers;
                renderMembersList(filteredMembers);
            }
        } catch (error) {
            console.error('Failed to load flock members:', error);
            ChurchApp.showToast('Failed to load members', 'error');
        }
    }

    function renderMembersList(members) {
        const membersList = document.getElementById('membersList');

        if (members.length === 0) {
            membersList.innerHTML = `
                <div class="text-center py-6 text-gray-500 text-sm">
                    No members found with the selected filter.
                </div>
            `;
            return;
        }

        membersList.innerHTML = members.map(member => {
            const isSelected = selectedMemberIds.includes(member.id);
            const hasPhone = member.phone && member.phone.trim() !== '';

            return `
                <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white cursor-pointer ${!hasPhone ? 'opacity-50' : ''}">
                    <input type="checkbox"
                           class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
                           value="${member.id}"
                           ${isSelected ? 'checked' : ''}
                           ${!hasPhone ? 'disabled' : ''}
                           onchange="toggleMember(${member.id}, this.checked)">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-900 text-sm">${member.first_name} ${member.last_name}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full ${getEngagementColor(member.engagement_status)}">
                                ${member.engagement_status || 'Regular'}
                            </span>
                        </div>
                        ${hasPhone ? `
                            <span class="text-xs text-gray-500">${member.phone}</span>
                        ` : `
                            <span class="text-xs text-red-500">No phone number</span>
                        `}
                    </div>
                </label>
            `;
        }).join('');

        updateSelectedCount();
    }

    function filterMembers() {
        const filter = document.getElementById('engagementFilter').value;

        if (filter === 'all') {
            filteredMembers = allMembers;
        } else {
            filteredMembers = allMembers.filter(m => m.engagement_status === filter);
        }

        renderMembersList(filteredMembers);
    }

    function toggleMember(memberId, isSelected) {
        if (isSelected) {
            if (!selectedMemberIds.includes(memberId)) {
                selectedMemberIds.push(memberId);
            }
        } else {
            selectedMemberIds = selectedMemberIds.filter(id => id !== memberId);
        }
        updateSelectedCount();
    }

    function selectAll() {
        selectedMemberIds = filteredMembers
            .filter(m => m.phone && m.phone.trim() !== '')
            .map(m => m.id);
        renderMembersList(filteredMembers);
    }

    function deselectAll() {
        selectedMemberIds = [];
        renderMembersList(filteredMembers);
    }

    function updateSelectedCount() {
        document.getElementById('selectedCount').textContent = selectedMemberIds.length;
    }

    function updateCharacterCount() {
        const text = document.getElementById('messageText').value;
        const charCount = text.length;
        const smsCount = Math.ceil(charCount / (charCount <= 160 ? 160 : 153));

        document.getElementById('charCount').textContent = `${charCount} / 160 characters`;
        document.getElementById('smsCount').textContent = `${smsCount} SMS`;

        // Show warning for long messages
        const warning = document.getElementById('longMessageWarning');
        if (charCount > 160) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    }

    function useTemplate(templateKey) {
        const template = messageTemplates[templateKey];
        if (template) {
            document.getElementById('messageText').value = template;
            updateCharacterCount();
        }
    }

    async function handleSubmit(e) {
        e.preventDefault();

        const message = document.getElementById('messageText').value.trim();

        // Validation
        if (selectedMemberIds.length === 0) {
            ChurchApp.showToast('Please select at least one member', 'error');
            return;
        }

        if (!message) {
            ChurchApp.showToast('Please enter a message', 'error');
            return;
        }

        // Confirmation
        const smsCount = Math.ceil(message.length / (message.length <= 160 ? 160 : 153));
        const totalSms = selectedMemberIds.length * smsCount;
        const confirmed = confirm(`Send ${smsCount} SMS to ${selectedMemberIds.length} member(s)?\n\nTotal: ${totalSms} SMS segments will be sent.`);

        if (!confirmed) return;

        // Submit
        const sendBtn = document.getElementById('sendBtn');
        const originalContent = sendBtn.innerHTML;
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<span class="animate-spin mr-2">⟳</span> Sending...';

        try {
            const result = await ChurchApp.apiCall('/api/mobile/v1/shepherd/flock/message', 'POST', {
                member_ids: selectedMemberIds,
                message: message
            });

            if (result.success) {
                ChurchApp.showToast('Message sent successfully!', 'success');

                // Reset form
                document.getElementById('messageText').value = '';
                selectedMemberIds = [];
                renderMembersList(filteredMembers);
                updateCharacterCount();

                // Redirect after delay
                setTimeout(() => {
                    window.location.href = '{{ url('/mobile/shepherd') }}';
                }, 2000);
            } else {
                throw new Error(result.message || 'Failed to send message');
            }
        } catch (error) {
            console.error('Failed to send message:', error);
            ChurchApp.showToast(error.message || 'Failed to send message', 'error');
            sendBtn.disabled = false;
            sendBtn.innerHTML = originalContent;
        }
    }

    function getEngagementColor(status) {
        switch(status) {
            case 'Engaged': return 'bg-green-100 text-green-700';
            case 'Committed': return 'bg-blue-100 text-blue-700';
            case 'Regular': return 'bg-yellow-100 text-yellow-700';
            case 'At Risk': return 'bg-red-100 text-red-700';
            case 'Inactive': return 'bg-gray-100 text-gray-700';
            default: return 'bg-blue-100 text-blue-700';
        }
    }
</script>
@endpush
@endsection
