<?php $__env->startSection('title', 'Report Schedules'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Report Schedules</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('reports.index')); ?>">Reports</a>
            <span>/</span>
            <span>Schedules</span>
        </nav>
    </div>
    <div class="page-actions">
        <button type="button" class="btn btn-primary" onclick="openScheduleModal()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Schedule
        </button>
    </div>
</div>

<!-- Active Schedules -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Active Schedules</h3>
    </div>
    <div class="card-body p-0">
        <?php if($schedules && $schedules->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Report</th>
                            <th>Frequency</th>
                            <th>Next Run</th>
                            <th>Recipients</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div>
                                        <p class="font-medium"><?php echo e($schedule->custom_report->name ?? $schedule->report_type); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($schedule->report_type ?? 'Custom Report'); ?></p>
                                    </div>
                                </td>
                                <td class="capitalize"><?php echo e($schedule->frequency); ?></td>
                                <td><?php echo e($schedule->next_run_at ? \Carbon\Carbon::parse($schedule->next_run_at)->format('M d, Y H:i') : 'Not scheduled'); ?></td>
                                <td>
                                    <?php if($schedule->recipients): ?>
                                        <?php
                                            $recipients = is_string($schedule->recipients) ? json_decode($schedule->recipients, true) : $schedule->recipients;
                                            $count = is_array($recipients) ? count($recipients) : 0;
                                        ?>
                                        <span class="badge badge-info"><?php echo e($count); ?> recipient<?php echo e($count != 1 ? 's' : ''); ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400">None</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($schedule->is_active): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <button onclick="editSchedule(<?php echo e($schedule->id); ?>)" class="btn btn-sm btn-secondary">
                                            Edit
                                        </button>
                                        <form method="POST" action="<?php echo e(route('reports.schedules.delete', $schedule)); ?>" class="inline" onsubmit="return confirm('Delete this schedule?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No schedules</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new report schedule.</p>
                <div class="mt-6">
                    <button type="button" class="btn btn-primary" onclick="openScheduleModal()">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Schedule
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Schedule Report</h3>
            <button onclick="closeScheduleModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="<?php echo e(route('reports.schedules.store')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Report Selection -->
            <div class="mb-4">
                <label for="custom_report_id" class="form-label">Select Report *</label>
                <select id="custom_report_id" name="custom_report_id" class="form-select" required>
                    <option value="">Choose a report...</option>
                    <?php $__currentLoopData = $customReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($report->id); ?>"><?php echo e($report->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Frequency -->
            <div class="mb-4">
                <label for="frequency" class="form-label">Frequency *</label>
                <select id="frequency" name="frequency" class="form-select" required>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly</option>
                </select>
            </div>

            <!-- Time -->
            <div class="mb-4">
                <label for="run_time" class="form-label">Run Time *</label>
                <input type="time" id="run_time" name="run_time" class="form-input" required>
                <p class="text-xs text-gray-500 mt-1">Time when the report will be generated</p>
            </div>

            <!-- Recipients -->
            <div class="mb-4">
                <label for="recipients" class="form-label">Email Recipients</label>
                <textarea id="recipients" name="recipients" rows="3" class="form-input" placeholder="Enter email addresses, one per line"></textarea>
                <p class="text-xs text-gray-500 mt-1">One email address per line</p>
            </div>

            <!-- Format -->
            <div class="mb-4">
                <label for="format" class="form-label">Export Format</label>
                <select id="format" name="format" class="form-select">
                    <option value="pdf">PDF</option>
                    <option value="excel">Excel</option>
                    <option value="csv">CSV</option>
                </select>
            </div>

            <!-- Active Status -->
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked class="form-checkbox">
                    <span class="ml-2 text-sm">Active</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" class="btn btn-secondary" onclick="closeScheduleModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Schedule</button>
            </div>
        </form>
    </div>
</div>

<script>
function openScheduleModal() {
    document.getElementById('scheduleModal').classList.remove('hidden');
}

function closeScheduleModal() {
    document.getElementById('scheduleModal').classList.add('hidden');
}

function editSchedule(id) {
    alert('Edit schedule ' + id + ' - functionality coming soon');
}

// Close modal on outside click
window.onclick = function(event) {
    const modal = document.getElementById('scheduleModal');
    if (event.target == modal) {
        closeScheduleModal();
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/reports/schedules.blade.php ENDPATH**/ ?>