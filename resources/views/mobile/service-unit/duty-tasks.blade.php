@extends('layouts.mobile')

@section('title', 'Duty Tasks - Church App')
@section('header', 'Duty Tasks')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header with Back Button -->
    <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white p-6 shadow-lg -mx-4 -mt-4">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ url('/mobile/service-unit') }}" class="p-1 rounded-full hover:bg-white/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-xl font-bold" id="dutyTitle">Loading...</h1>
                <p class="text-sm text-orange-100 opacity-90" id="dutyDate">-</p>
            </div>
        </div>

        <!-- Progress -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm">Progress</span>
                <span class="text-sm font-bold" id="progressText">0 / 0</span>
            </div>
            <div class="h-2 bg-white/20 rounded-full overflow-hidden">
                <div id="progressBar" class="h-full bg-white transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Check-in Status -->
    <div id="checkInStatus" class="hidden bg-green-50 border border-green-200 rounded-xl p-4 mx-1">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-green-900">Checked In</h3>
                <p class="text-sm text-green-700" id="checkInTime">-</p>
            </div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="px-1">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Your Tasks</h2>

        <!-- Loading State -->
        <div id="loadingState" class="space-y-3">
            @for ($i = 0; $i < 3; $i++)
            <div class="animate-pulse bg-white p-4 rounded-xl border border-gray-100">
                <div class="h-4 bg-gray-200 rounded w-2/3 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-1/2"></div>
            </div>
            @endfor
        </div>

        <!-- Tasks Container -->
        <div id="tasksList" class="hidden space-y-3"></div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No Tasks Assigned</h3>
            <p class="text-gray-500">No tasks have been assigned for this duty.</p>
        </div>
    </div>

    <!-- Complete All Button -->
    <div id="completeAllSection" class="hidden px-1">
        <button id="completeAllBtn" class="w-full py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl shadow-lg hover:from-green-700 hover:to-green-800 active:scale-95 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Mark All Tasks Complete</span>
        </button>
    </div>
</div>

<!-- Task Detail Modal -->
<div id="taskDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">Task Details</h3>
            <button onclick="closeTaskDetail()" class="p-2 hover:bg-gray-100 rounded-full">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="taskDetailContent" class="p-6">
            <!-- Populated via JS -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    let dutyId = null;
    let dutyData = null;
    let tasks = [];

    document.addEventListener('DOMContentLoaded', async () => {
        // Extract duty ID from URL
        dutyId = window.location.pathname.split('/')[4];

        await loadDutyTasks();

        // Complete All Button
        document.getElementById('completeAllBtn').addEventListener('click', completeAllTasks);
    });

    async function loadDutyTasks() {
        ChurchApp.showLoading(true);
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('tasksList').classList.add('hidden');

        try {
            const result = await ChurchApp.apiCall(`/api/mobile/v1/service-unit/duty/${dutyId}/tasks`, 'GET');

            if (result.success && result.data) {
                dutyData = result.data.duty;
                tasks = result.data.tasks || [];

                // Update header
                document.getElementById('dutyTitle').textContent = dutyData.unit_name + ' Duty';
                document.getElementById('dutyDate').textContent = formatDate(dutyData.duty_date);

                // Check-in status
                if (dutyData.checked_in) {
                    document.getElementById('checkInStatus').classList.remove('hidden');
                    document.getElementById('checkInTime').textContent = 'Checked in at ' + formatTime(dutyData.check_in_time);
                }

                // Render tasks
                renderTasks();
                updateProgress();
            }
        } catch (error) {
            console.error('Failed to load duty tasks:', error);
            ChurchApp.showToast('Failed to load duty tasks', 'error');
        } finally {
            ChurchApp.showLoading(false);
            document.getElementById('loadingState').classList.add('hidden');
        }
    }

    function renderTasks() {
        const tasksList = document.getElementById('tasksList');
        const emptyState = document.getElementById('emptyState');

        if (tasks.length === 0) {
            tasksList.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        tasksList.classList.remove('hidden');

        tasksList.innerHTML = tasks.map(task => {
            const isCompleted = task.completed;

            return `
                <div class="bg-white rounded-xl shadow-sm border ${isCompleted ? 'border-green-200 bg-green-50' : 'border-gray-100'} p-4">
                    <div class="flex items-start gap-3">
                        <!-- Checkbox -->
                        <button onclick="toggleTask(${task.id})" class="flex-shrink-0 w-6 h-6 rounded-full border-2 ${isCompleted ? 'bg-green-500 border-green-500' : 'border-gray-300'} flex items-center justify-center transition-all">
                            ${isCompleted ? `
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            ` : ''}
                        </button>

                        <!-- Task Content -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold ${isCompleted ? 'text-green-900 line-through' : 'text-gray-900'}">${task.task_name}</h3>
                            ${task.description ? `
                                <p class="text-sm text-gray-600 mt-1">${task.description}</p>
                            ` : ''}

                            ${task.priority ? `
                                <span class="inline-block mt-2 px-2 py-0.5 text-xs rounded-full ${getPriorityColor(task.priority)}">
                                    ${task.priority}
                                </span>
                            ` : ''}

                            ${isCompleted && task.completed_at ? `
                                <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    Completed ${formatTimeAgo(task.completed_at)}
                                </p>
                            ` : ''}
                        </div>

                        <!-- More Button -->
                        <button onclick="showTaskDetail(${task.id})" class="flex-shrink-0 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    async function toggleTask(taskId) {
        const task = tasks.find(t => t.id === taskId);
        if (!task) return;

        const newStatus = !task.completed;

        try {
            const result = await ChurchApp.apiCall(`/api/mobile/v1/service-unit/task/${taskId}/toggle`, 'POST', {
                completed: newStatus
            });

            if (result.success) {
                task.completed = newStatus;
                task.completed_at = newStatus ? new Date().toISOString() : null;

                renderTasks();
                updateProgress();

                ChurchApp.showToast(newStatus ? 'Task completed!' : 'Task marked incomplete', 'success');
            }
        } catch (error) {
            console.error('Failed to toggle task:', error);
            ChurchApp.showToast('Failed to update task', 'error');
        }
    }

    async function completeAllTasks() {
        const incompleteTasks = tasks.filter(t => !t.completed);

        if (incompleteTasks.length === 0) {
            ChurchApp.showToast('All tasks are already complete!', 'info');
            return;
        }

        if (!confirm(`Mark ${incompleteTasks.length} remaining task(s) as complete?`)) {
            return;
        }

        ChurchApp.showLoading(true);

        try {
            const result = await ChurchApp.apiCall(`/api/mobile/v1/service-unit/duty/${dutyId}/complete-all`, 'POST');

            if (result.success) {
                // Mark all tasks as completed
                tasks.forEach(task => {
                    task.completed = true;
                    task.completed_at = new Date().toISOString();
                });

                renderTasks();
                updateProgress();

                ChurchApp.showToast('All tasks completed!', 'success');

                // Redirect after delay
                setTimeout(() => {
                    window.location.href = '{{ url('/mobile/service-unit') }}';
                }, 2000);
            }
        } catch (error) {
            console.error('Failed to complete all tasks:', error);
            ChurchApp.showToast('Failed to complete all tasks', 'error');
        } finally {
            ChurchApp.showLoading(false);
        }
    }

    function updateProgress() {
        const completed = tasks.filter(t => t.completed).length;
        const total = tasks.length;
        const percent = total > 0 ? (completed / total) * 100 : 0;

        document.getElementById('progressText').textContent = `${completed} / ${total}`;
        document.getElementById('progressBar').style.width = percent + '%';

        // Show/hide complete all button
        const completeAllSection = document.getElementById('completeAllSection');
        if (completed < total && total > 0) {
            completeAllSection.classList.remove('hidden');
        } else {
            completeAllSection.classList.add('hidden');
        }
    }

    function showTaskDetail(taskId) {
        const task = tasks.find(t => t.id === taskId);
        if (!task) return;

        const content = `
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide">Task Name</label>
                    <p class="font-bold text-gray-900 text-lg">${task.task_name}</p>
                </div>

                ${task.description ? `
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Description</label>
                        <p class="text-gray-700 bg-gray-50 p-3 rounded-lg mt-1">${task.description}</p>
                    </div>
                ` : ''}

                <div class="grid grid-cols-2 gap-4">
                    ${task.priority ? `
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Priority</label>
                            <p class="font-medium text-gray-900 capitalize">${task.priority}</p>
                        </div>
                    ` : ''}

                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Status</label>
                        <p class="font-medium ${task.completed ? 'text-green-600' : 'text-orange-600'}">
                            ${task.completed ? 'Completed' : 'Pending'}
                        </p>
                    </div>
                </div>

                ${task.completed && task.completed_at ? `
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Completed At</label>
                        <p class="text-gray-700">${formatDateTime(task.completed_at)}</p>
                    </div>
                ` : ''}

                <button onclick="closeTaskDetail(); toggleTask(${task.id});" class="w-full py-3 ${task.completed ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700'} text-white font-bold rounded-xl transition">
                    ${task.completed ? 'Mark as Incomplete' : 'Mark as Complete'}
                </button>
            </div>
        `;

        document.getElementById('taskDetailContent').innerHTML = content;
        document.getElementById('taskDetailModal').classList.remove('hidden');
    }

    window.closeTaskDetail = function() {
        document.getElementById('taskDetailModal').classList.add('hidden');
    };

    function getPriorityColor(priority) {
        const colors = {
            'high': 'bg-red-100 text-red-700',
            'medium': 'bg-yellow-100 text-yellow-700',
            'low': 'bg-blue-100 text-blue-700'
        };
        return colors[priority?.toLowerCase()] || 'bg-gray-100 text-gray-700';
    }

    function formatDate(dateStr) {
        if (!dateStr) return 'N/A';
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
    }

    function formatTime(timeStr) {
        if (!timeStr) return 'N/A';
        const date = new Date(timeStr);
        return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    }

    function formatDateTime(dateTimeStr) {
        if (!dateTimeStr) return 'N/A';
        const date = new Date(dateTimeStr);
        return date.toLocaleString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: '2-digit'
        });
    }

    function formatTimeAgo(dateTimeStr) {
        if (!dateTimeStr) return 'N/A';
        const date = new Date(dateTimeStr);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);

        if (diffMins < 1) return 'just now';
        if (diffMins < 60) return `${diffMins}m ago`;
        const diffHours = Math.floor(diffMins / 60);
        if (diffHours < 24) return `${diffHours}h ago`;
        const diffDays = Math.floor(diffHours / 24);
        return `${diffDays}d ago`;
    }
</script>
@endpush
@endsection
