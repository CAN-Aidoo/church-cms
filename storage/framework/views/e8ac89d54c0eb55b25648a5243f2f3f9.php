<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Equipment Maintenance</h1>
            <p class="text-gray-600 mt-1">Track and schedule equipment maintenance</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('equipment.reports')); ?>" class="btn btn-secondary">
                <i class="fas fa-chart-bar mr-2"></i>Reports
            </a>
            <a href="<?php echo e(route('equipment.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Equipment
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-red-600"><?php echo e($equipment->where(function($q) {
                    $q->whereNotNull('next_service_date')->where('next_service_date', '<', now());
                })->count()); ?></p>
                <p class="text-sm text-gray-600">Overdue</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-clock text-yellow-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-yellow-600"><?php echo e($equipment->where(function($q) {
                    $q->whereNotNull('next_service_date')
                      ->where('next_service_date', '>=', now())
                      ->where('next_service_date', '<=', now()->addDays(7));
                })->count()); ?></p>
                <p class="text-sm text-gray-600">Due This Week</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-wrench text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600"><?php echo e($equipment->where('status', 'maintenance')->count()); ?></p>
                <p class="text-sm text-gray-600">In Maintenance</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600"><?php echo e($equipment->filter(function($item) {
                    return $item->status === 'active' &&
                           ($item->next_service_date === null || $item->next_service_date > now()->addDays(7));
                })->count()); ?></p>
                <p class="text-sm text-gray-600">Up to Date</p>
            </div>
        </div>
    </div>

    <!-- Equipment Requiring Maintenance -->
    <?php if($equipment->count() > 0): ?>
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Equipment Requiring Maintenance</h2>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Last Service</th>
                            <th>Next Service</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $equipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="
                            <?php if($item->next_service_date && $item->next_service_date->isPast()): ?>
                            bg-red-50
                            <?php elseif($item->next_service_date && $item->next_service_date->diffInDays(now()) <= 7): ?>
                            bg-yellow-50
                            <?php endif; ?>">
                            <td>
                                <div class="flex items-center gap-3">
                                    <?php if($item->next_service_date && $item->next_service_date->isPast()): ?>
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                    <?php elseif($item->next_service_date && $item->next_service_date->diffInDays(now()) <= 7): ?>
                                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                    <?php else: ?>
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                    <?php endif; ?>
                                    <div>
                                        <a href="<?php echo e(route('equipment.show', $item)); ?>" class="font-medium text-blue-600 hover:underline">
                                            <?php echo e($item->name); ?>

                                        </a>
                                        <?php if($item->serial_number): ?>
                                        <p class="text-xs text-gray-500">SN: <?php echo e($item->serial_number); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light"><?php echo e($item->category); ?></span>
                            </td>
                            <td><?php echo e($item->location); ?></td>
                            <td>
                                <?php if($item->last_service_date): ?>
                                <span class="text-sm"><?php echo e($item->last_service_date->format('M d, Y')); ?></span>
                                <p class="text-xs text-gray-500"><?php echo e($item->last_service_date->diffForHumans()); ?></p>
                                <?php else: ?>
                                <span class="text-gray-400 text-sm">Never serviced</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($item->next_service_date): ?>
                                <span class="text-sm
                                    <?php if($item->next_service_date->isPast()): ?> text-red-600 font-semibold
                                    <?php elseif($item->next_service_date->diffInDays(now()) <= 7): ?> text-yellow-600 font-semibold
                                    <?php endif; ?>">
                                    <?php echo e($item->next_service_date->format('M d, Y')); ?>

                                </span>
                                <p class="text-xs text-gray-500">
                                    <?php if($item->next_service_date->isPast()): ?>
                                    Overdue by <?php echo e($item->next_service_date->diffForHumans(null, true)); ?>

                                    <?php else: ?>
                                    <?php echo e($item->next_service_date->diffForHumans()); ?>

                                    <?php endif; ?>
                                </p>
                                <?php else: ?>
                                <span class="text-gray-400 text-sm">Not scheduled</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge
                                    <?php if($item->status === 'active'): ?> badge-success
                                    <?php elseif($item->status === 'maintenance'): ?> badge-warning
                                    <?php else: ?> badge-secondary
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($item->status)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('equipment.maintenance.form', $item)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-wrench mr-1"></i>Record
                                    </a>
                                    <a href="<?php echo e(route('equipment.show', $item)); ?>" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye mr-1"></i>View
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
    <?php else: ?>
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-check-circle text-green-400 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg font-medium">All equipment is up to date!</p>
            <p class="text-gray-500 text-sm mt-2">No maintenance required at this time</p>
            <a href="<?php echo e(route('equipment.index')); ?>" class="btn btn-primary mt-4">
                <i class="fas fa-arrow-left mr-2"></i>Back to Equipment
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/equipment/maintenance.blade.php ENDPATH**/ ?>