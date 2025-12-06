<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Equipment Management</h1>
            <p class="text-gray-600 mt-1">Track and manage church equipment and assets</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('equipment.maintenance')); ?>" class="btn btn-secondary">
                <i class="fas fa-wrench mr-2"></i>Maintenance
            </a>
            <a href="<?php echo e(route('equipment.reports')); ?>" class="btn btn-secondary">
                <i class="fas fa-chart-bar mr-2"></i>Reports
            </a>
            
            <a href="<?php echo e(route('equipment.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Add Equipment
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('equipment.index')); ?>" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="<?php echo e(request('search')); ?>"
                               placeholder="Name or serial number..."
                               class="form-input w-full">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category" class="form-select w-full">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>>
                                <?php echo e($category); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="form-select w-full">
                            <option value="">All Statuses</option>
                            <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                            <option value="maintenance" <?php echo e(request('status') == 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                            <option value="retired" <?php echo e(request('status') == 'retired' ? 'selected' : ''); ?>>Retired</option>
                        </select>
                    </div>

                    <!-- Condition Filter -->
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                        <select name="condition" id="condition" class="form-select w-full">
                            <option value="">All Conditions</option>
                            <option value="excellent" <?php echo e(request('condition') == 'excellent' ? 'selected' : ''); ?>>Excellent</option>
                            <option value="good" <?php echo e(request('condition') == 'good' ? 'selected' : ''); ?>>Good</option>
                            <option value="fair" <?php echo e(request('condition') == 'fair' ? 'selected' : ''); ?>>Fair</option>
                            <option value="poor" <?php echo e(request('condition') == 'poor' ? 'selected' : ''); ?>>Poor</option>
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <select name="location" id="location" class="form-select w-full">
                            <option value="">All Locations</option>
                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($location); ?>" <?php echo e(request('location') == $location ? 'selected' : ''); ?>>
                                <?php echo e($location); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Showing <?php echo e($equipment->count()); ?> of <?php echo e($equipment->total()); ?> equipment items
                    </div>
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('equipment.index')); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-redo mr-1"></i>Reset
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-filter mr-1"></i>Apply Filters
                        </button>
                        <a href="<?php echo e(route('equipment.export', request()->query())); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-download mr-1"></i>Export CSV
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Equipment List -->
    <?php if($equipment->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $equipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body">
                <!-- Status Badge -->
                <div class="flex justify-between items-start mb-3">
                    <span class="badge
                        <?php if($item->status === 'active'): ?> badge-success
                        <?php elseif($item->status === 'maintenance'): ?> badge-warning
                        <?php elseif($item->status === 'retired'): ?> badge-danger
                        <?php else: ?> badge-secondary
                        <?php endif; ?>">
                        <?php echo e(ucfirst($item->status)); ?>

                    </span>
                    <span class="badge badge-light"><?php echo e($item->category); ?></span>
                </div>

                <!-- Equipment Name -->
                <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo e($item->name); ?></h3>

                <!-- Details -->
                <div class="space-y-2 text-sm">
                    <?php if($item->serial_number): ?>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-barcode w-5"></i>
                        <span><?php echo e($item->serial_number); ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt w-5"></i>
                        <span><?php echo e($item->location); ?></span>
                    </div>

                    <?php if($item->assigned_to): ?>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-user w-5"></i>
                        <span><?php echo e($item->assigned_to); ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="flex items-center">
                        <i class="fas fa-heartbeat w-5"></i>
                        <span class="
                            <?php if($item->condition === 'excellent'): ?> text-green-600
                            <?php elseif($item->condition === 'good'): ?> text-blue-600
                            <?php elseif($item->condition === 'fair'): ?> text-yellow-600
                            <?php else: ?> text-red-600
                            <?php endif; ?> font-medium">
                            <?php echo e(ucfirst($item->condition)); ?>

                        </span>
                    </div>

                    <!-- Value -->
                    <div class="flex items-center text-gray-700 font-semibold">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>GHS <?php echo e(number_format($item->purchase_price, 2)); ?></span>
                    </div>

                    <!-- Maintenance Alert -->
                    <?php if($item->next_service_date && $item->next_service_date->isPast()): ?>
                    <div class="flex items-center text-red-600">
                        <i class="fas fa-exclamation-triangle w-5"></i>
                        <span class="text-xs">Maintenance overdue</span>
                    </div>
                    <?php elseif($item->next_service_date && $item->next_service_date->diffInDays(now()) <= 7): ?>
                    <div class="flex items-center text-yellow-600">
                        <i class="fas fa-exclamation-circle w-5"></i>
                        <span class="text-xs">Maintenance due soon</span>
                    </div>
                    <?php endif; ?>

                    <!-- Warranty Alert -->
                    <?php if($item->warranty_expiry && $item->warranty_expiry->isFuture() && $item->warranty_expiry->diffInMonths(now()) <= 3): ?>
                    <div class="flex items-center text-orange-600">
                        <i class="fas fa-shield-alt w-5"></i>
                        <span class="text-xs">Warranty expiring soon</span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 mt-4 pt-4 border-t border-gray-200">
                    <a href="<?php echo e(route('equipment.show', $item)); ?>" class="btn btn-sm btn-secondary flex-1">
                        <i class="fas fa-eye mr-1"></i>View
                    </a>
                    
                    <a href="<?php echo e(route('equipment.edit', $item)); ?>" class="btn btn-sm btn-primary flex-1">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($equipment->links()); ?>

    </div>
    <?php else: ?>
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-boxes text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">No equipment found</p>
            
            <a href="<?php echo e(route('equipment.create')); ?>" class="btn btn-primary mt-4">
                <i class="fas fa-plus mr-2"></i>Add First Equipment
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/equipment/index.blade.php ENDPATH**/ ?>