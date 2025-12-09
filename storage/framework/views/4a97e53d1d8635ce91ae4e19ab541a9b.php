<?php $__env->startSection('title', 'Attendance Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Attendance Reports</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('reports.index')); ?>">Reports</a>
            <span>/</span>
            <span>Attendance Reports</span>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.attendance.summary')); ?>" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>" class="form-input">
            </div>
            <div>
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>" class="form-input">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Attendance</p>
            <p class="text-3xl font-bold text-blue-600"><?php echo e($data['total_attendance'] ?? 0); ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Unique Attendees</p>
            <p class="text-3xl font-bold text-green-600"><?php echo e($data['unique_attendees'] ?? 0); ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Attendance Rate</p>
            <p class="text-3xl font-bold text-purple-600"><?php echo e(number_format($data['attendance_rate'] ?? 0, 1)); ?>%</p>
        </div>
    </div>
</div>

<!-- By Service Type -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Service Type</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($data['by_service_type'])): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $data['by_service_type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceType => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 capitalize"><?php echo e(str_replace('_', ' ', $serviceType)); ?></p>
                        <p class="text-2xl font-bold"><?php echo e($count); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">No service type data available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Attendance Trend by Date -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">Attendance Trend</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($data['by_date'])): ?>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-right">Attendance Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data['by_date']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(\Carbon\Carbon::parse($date)->format('l, F j, Y')); ?></td>
                                <td class="text-right font-semibold"><?php echo e($count); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">No attendance trend data available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Attendance Records -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Attendance Records (<?php echo e(count($data['attendance_records'] ?? [])); ?>)</h3>
    </div>
    <div class="card-body p-0">
        <?php if(!empty($data['attendance_records']) && count($data['attendance_records']) > 0): ?>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Service Date</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Check-in Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data['attendance_records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($record->member): ?>
                                        <a href="<?php echo e(route('members.show', $record->member->id)); ?>" class="text-blue-600 hover:underline">
                                            <?php echo e($record->member->first_name); ?> <?php echo e($record->member->last_name); ?>

                                        </a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(\Carbon\Carbon::parse($record->service_date)->format('M d, Y')); ?></td>
                                <td class="capitalize"><?php echo e(str_replace('_', ' ', $record->service_type)); ?></td>
                                <td>
                                    <span class="badge
                                        <?php if($record->status === 'present'): ?> badge-success
                                        <?php elseif($record->status === 'late'): ?> badge-warning
                                        <?php elseif($record->status === 'excused'): ?> badge-info
                                        <?php else: ?> badge-secondary
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($record->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($record->check_in_time ?? 'N/A'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">No attendance records found for the selected period.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/reports/attendance.blade.php ENDPATH**/ ?>