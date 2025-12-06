<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Shepherd Analytics</h1>
            <p class="text-gray-600 mt-1">Performance metrics and insights (Last 90 days)</p>
        </div>
        <a href="<?php echo e(route('shepherds.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Shepherds
        </a>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-users text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600"><?php echo e($stats['active']); ?></p>
                <p class="text-sm text-gray-600">Active Shepherds</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-user-friends text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600"><?php echo e($stats['total_flock_members']); ?></p>
                <p class="text-sm text-gray-600">Total in Flocks</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line text-gold-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-gold-600"><?php echo e(number_format($stats['average_flock_size'], 1)); ?></p>
                <p class="text-sm text-gray-600">Avg. Flock Size</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-red-600"><?php echo e($stats['shepherds_at_capacity']); ?></p>
                <p class="text-sm text-gray-600">At Capacity</p>
            </div>
        </div>
    </div>

    <!-- Shepherds Needing Attention -->
    <?php if($needingAttention->count() > 0): ?>
    <div class="card border-yellow-200 bg-yellow-50 mb-6">
        <div class="card-header bg-yellow-100">
            <h2 class="text-xl font-semibold text-yellow-800">
                <i class="fas fa-exclamation-triangle mr-2"></i>Shepherds Needing Attention (<?php echo e($needingAttention->count()); ?>)
            </h2>
        </div>
        <div class="card-body">
            <div class="space-y-3">
                <?php $__currentLoopData = $needingAttention; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shepherd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-yellow-200">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800"><?php echo e($shepherd->flock_name); ?></p>
                        <p class="text-sm text-gray-600">Shepherd: <?php echo e($shepherd->full_name); ?></p>
                        <p class="text-xs text-yellow-700 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Low activity in the last 30 days
                        </p>
                    </div>
                    <a href="<?php echo e(route('shepherds.show', $shepherd)); ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-eye mr-1"></i>View
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Shepherd Performance Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Shepherd Performance (Last 90 Days)</h2>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Shepherd</th>
                            <th>Flock Size</th>
                            <th>Capacity</th>
                            <th>Visitations</th>
                            <th>Visits/Member</th>
                            <th>Meetings</th>
                            <th>Avg. Attendance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $shepherds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shepherd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div>
                                    <p class="font-medium text-gray-800"><?php echo e($shepherd->flock_name); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo e($shepherd->full_name); ?></p>
                                </div>
                            </td>
                            <td>
                                <span class="font-semibold"><?php echo e($shepherd->current_flock_size); ?></span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-gray-200 rounded-full h-2">
                                        <div class="
                                            <?php if($shepherd->capacity_percentage >= 100): ?> bg-red-500
                                            <?php elseif($shepherd->capacity_percentage >= 80): ?> bg-yellow-500
                                            <?php else: ?> bg-green-500
                                            <?php endif; ?>
                                            h-2 rounded-full"
                                             style="width: <?php echo e(min($shepherd->capacity_percentage, 100)); ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600"><?php echo e(number_format($shepherd->capacity_percentage, 0)); ?>%</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info"><?php echo e($shepherd->performance['visitations']); ?></span>
                            </td>
                            <td>
                                <span class="font-medium
                                    <?php if($shepherd->performance['visitations_per_member'] >= 1): ?> text-green-600
                                    <?php elseif($shepherd->performance['visitations_per_member'] >= 0.5): ?> text-yellow-600
                                    <?php else: ?> text-red-600
                                    <?php endif; ?>">
                                    <?php echo e($shepherd->performance['visitations_per_member']); ?>

                                </span>
                            </td>
                            <td>
                                <span class="badge badge-success"><?php echo e($shepherd->performance['meetings']); ?></span>
                            </td>
                            <td>
                                <span class="font-medium text-gray-700">
                                    <?php echo e($shepherd->performance['average_meeting_attendance']); ?>

                                </span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('shepherds.show', $shepherd)); ?>" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('shepherds.manage-flock', $shepherd)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-users"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Color code performance metrics
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const visitsPerMember = parseFloat(row.querySelector('td:nth-child(5) span').textContent);
            const cell = row.querySelector('td:nth-child(5) span');

            if (visitsPerMember >= 1) {
                cell.classList.add('text-green-600');
            } else if (visitsPerMember >= 0.5) {
                cell.classList.add('text-yellow-600');
            } else {
                cell.classList.add('text-red-600');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/shepherds/analytics.blade.php ENDPATH**/ ?>