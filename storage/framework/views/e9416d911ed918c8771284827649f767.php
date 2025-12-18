<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Service Check In - <?php echo e(config('app.name')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center shadow-lg">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Service Check-In</h1>
            <p class="text-gray-600 id="serviceInfo">Loading service details...</p>
        </div>

        <!-- Member Search -->
        <div class="bg-white rounded-lg shadow-xl p-6 mb-4" id="searchForm">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Search Your Name</label>
                <input type="text" id="memberSearch" placeholder="Type your first or last name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Search Results -->
            <div id="searchResults" class="space-y-2 hidden">
                <p class="text-sm text-gray-600 mb-2">Select your name:</p>
                <div id="memberList"></div>
            </div>

            <!-- Family Check-in Option -->
            <div id="familyOption" class="hidden mt-4 p-4 bg-blue-50 rounded-lg">
                <label class="flex items-center">
                    <input type="checkbox" id="includeFamilyCheckbox" class="mr-2">
                    <span class="text-sm font-semibold text-blue-900">Check in family members too</span>
                </label>
                <div id="familyMembers" class="hidden mt-3 space-y-2"></div>
            </div>

            <button id="checkInButton" class="hidden w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-4 rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-105 mt-4">
                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Check In
            </button>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="hidden bg-white rounded-lg shadow-xl p-6">
            <div class="text-center">
                <div class="bg-green-100 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Check-in Successful!</h2>
                <div id="successDetails"></div>
            </div>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-red-800 font-semibold" id="errorText"></span>
            </div>
        </div>
    </div>

    <script>
        // Get token from URL
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        let selectedMember = null;
        let allMembers = [];

        if (!token) {
            showError('Invalid QR code. Please scan a valid service check-in code.');
        }

        // Fetch all members for search
        fetch('/api/v1/members/search?per_page=1000', {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            allMembers = data.data || data;
        });

        // Member search
        document.getElementById('memberSearch').addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            if (searchTerm.length < 2) {
                document.getElementById('searchResults').classList.add('hidden');
                return;
            }

            const filtered = allMembers.filter(m =>
                m.first_name.toLowerCase().includes(searchTerm) ||
                m.last_name.toLowerCase().includes(searchTerm)
            );

            if (filtered.length > 0) {
                displaySearchResults(filtered);
            }
        });

        function displaySearchResults(members) {
            const list = document.getElementById('memberList');
            list.innerHTML = members.slice(0, 10).map(m => `
                <div class="p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-blue-50 transition" onclick="selectMember(${m.id})">
                    <p class="font-semibold text-gray-800">${m.first_name} ${m.last_name}</p>
                    <p class="text-sm text-gray-600">${m.email || m.phone || ''}</p>
                </div>
            `).join('');
            document.getElementById('searchResults').classList.remove('hidden');
        }

        function selectMember(memberId) {
            selectedMember = allMembers.find(m => m.id === memberId);
            document.getElementById('searchResults').classList.add('hidden');
            document.getElementById('memberSearch').value = `${selectedMember.first_name} ${selectedMember.last_name}`;
            document.getElementById('checkInButton').classList.remove('hidden');

            // Show family option if member has family
            if (selectedMember.family_id) {
                loadFamilyMembers(selectedMember.family_id, memberId);
            }
        }

        function loadFamilyMembers(familyId, currentMemberId) {
            fetch(`/api/v1/members?family_id=${familyId}`)
                .then(res => res.json())
                .then(data => {
                    const familyMembers = (data.data || data).filter(m => m.id !== currentMemberId);
                    if (familyMembers.length > 0) {
                        displayFamilyMembers(familyMembers);
                        document.getElementById('familyOption').classList.remove('hidden');
                    }
                });
        }

        function displayFamilyMembers(members) {
            const container = document.getElementById('familyMembers');
            container.innerHTML = members.map(m => `
                <label class="flex items-center">
                    <input type="checkbox" class="family-member-checkbox mr-2" value="${m.id}">
                    <span class="text-sm text-gray-700">${m.first_name} ${m.last_name}</span>
                </label>
            `).join('');

            document.getElementById('includeFamilyCheckbox').addEventListener('change', (e) => {
                container.classList.toggle('hidden', !e.target.checked);
            });
        }

        // Check-in button handler
        document.getElementById('checkInButton').addEventListener('click', async () => {
            if (!selectedMember) return;

            const familyCheckboxes = document.querySelectorAll('.family-member-checkbox:checked');
            const familyMemberIds = Array.from(familyCheckboxes).map(cb => parseInt(cb.value));

            if (familyMemberIds.length > 0) {
                // Family check-in
                await familyCheckIn([selectedMember.id, ...familyMemberIds]);
            } else {
                // Individual check-in
                await individualCheckIn(selectedMember.id);
            }
        });

        async function individualCheckIn(memberId) {
            try {
                const response = await fetch('/api/mobile/v1/check-in/service', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        token: token,
                        member_id: memberId
                    })
                });

                const result = await response.json();
                handleCheckInResult(result);
            } catch (error) {
                showError('An error occurred. Please try again.');
            }
        }

        async function familyCheckIn(memberIds) {
            try {
                const response = await fetch('/api/mobile/v1/check-in/family', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        token: token,
                        family_members: memberIds
                    })
                });

                const result = await response.json();
                handleFamilyCheckInResult(result);
            } catch (error) {
                showError('An error occurred. Please try again.');
            }
        }

        function handleCheckInResult(result) {
            if (result.success) {
                document.getElementById('searchForm').classList.add('hidden');
                document.getElementById('successDetails').innerHTML = `
                    <p class="text-lg font-semibold text-gray-700">${result.data.member_name}</p>
                    <p class="text-sm text-gray-600 mt-2">Checked in at ${result.data.check_in_time}</p>
                `;
                document.getElementById('successMessage').classList.remove('hidden');
            } else {
                showError(result.message);
            }
        }

        function handleFamilyCheckInResult(result) {
            if (result.success) {
                document.getElementById('searchForm').classList.add('hidden');
                const checkedIn = result.data.checked_in.join(', ');
                const alreadyCheckedIn = result.data.already_checked_in.length > 0
                    ? `<p class="text-sm text-yellow-600 mt-2">Already checked in: ${result.data.already_checked_in.join(', ')}</p>`
                    : '';

                document.getElementById('successDetails').innerHTML = `
                    <p class="text-lg font-semibold text-gray-700">Checked in ${result.data.total_checked_in} member(s)</p>
                    <p class="text-sm text-gray-600 mt-2">${checkedIn}</p>
                    ${alreadyCheckedIn}
                `;
                document.getElementById('successMessage').classList.remove('hidden');
            } else {
                showError(result.message);
            }
        }

        function showError(message) {
            document.getElementById('errorText').textContent = message;
            document.getElementById('errorMessage').classList.remove('hidden');
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/mobile/service-checkin.blade.php ENDPATH**/ ?>