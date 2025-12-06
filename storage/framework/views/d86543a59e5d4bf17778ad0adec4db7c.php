<?php $__env->startSection('title', 'Visitors'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Visitor Management</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <span>Visitors</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="<?php echo e(route('visitors.reports')); ?>" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        <a href="<?php echo e(route('visitors.eligible')); ?>" class="btn btn-gold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Eligible (<?php echo e($statistics['eligible_for_conversion'] ?? 0); ?>)
        </a>
        <a href="<?php echo e(route('visitors.create')); ?>" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Register Visitor
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card bg-gradient-primary">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e($statistics['total_visitors']); ?></div>
            <div class="stat-label">Total Visitors</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-green-500 to-green-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e($statistics['active_visitors']); ?></div>
            <div class="stat-label">Active Visitors</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-gold">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e($statistics['eligible_for_conversion']); ?></div>
            <div class="stat-label">Eligible for Conversion</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e($statistics['conversion_rate']); ?>%</div>
            <div class="stat-label">Conversion Rate</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6" x-data="{ showFilters: false }">
    <div class="card-header">
        <h3 class="card-title">Filters</h3>
        <button @click="showFilters = !showFilters" class="btn btn-sm btn-outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div x-show="showFilters" x-transition class="card-body">
        <form method="GET" action="<?php echo e(route('visitors.index')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>" class="form-input">
            </div>
            <div>
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>" class="form-input">
            </div>
            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active" <?php echo e(($filters['status'] ?? '') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(($filters['status'] ?? '') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="converted" <?php echo e(($filters['status'] ?? '') === 'converted' ? 'selected' : ''); ?>>Converted</option>
                </select>
            </div>
            <div>
                <label for="converted" class="form-label">Converted</label>
                <select id="converted" name="converted" class="form-select">
                    <option value="">All</option>
                    <option value="yes" <?php echo e(($filters['converted'] ?? '') === 'yes' ? 'selected' : ''); ?>>Yes</option>
                    <option value="no" <?php echo e(($filters['converted'] ?? '') === 'no' ? 'selected' : ''); ?>>No</option>
                </select>
            </div>
            <div>
                <label for="search" class="form-label">Search</label>
                <input type="text" id="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Name, email, phone..." class="form-input">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-primary flex-1">Apply Filters</button>
                <a href="<?php echo e(route('visitors.index')); ?>" class="btn btn-outline">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Visitors Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Visitor List (<?php echo e($visitors->total()); ?> total)</h3>
        <a href="<?php echo e(route('visitors.export', request()->query())); ?>" class="text-blue-600 hover:underline text-sm">
            Export CSV
        </a>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>First Visit</th>
                        <th>Last Visit</th>
                        <th>Visits</th>
                        <th>Referral Source</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $visitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="font-medium"><?php echo e($visitor->first_name); ?> <?php echo e($visitor->last_name); ?></div>
                        </td>
                        <td>
                            <div class="text-sm"><?php echo e($visitor->email ?? '-'); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($visitor->phone); ?></div>
                        </td>
                        <td class="whitespace-nowrap"><?php echo e($visitor->first_visit_date?->format('M d, Y')); ?></td>
                        <td class="whitespace-nowrap"><?php echo e($visitor->last_visit_date?->format('M d, Y')); ?></td>
                        <td>
                            <span class="badge <?php echo e($visitor->visit_count >= 5 ? 'badge-success' : 'badge-secondary'); ?>">
                                <?php echo e($visitor->visit_count); ?> <?php echo e(Str::plural('visit', $visitor->visit_count)); ?>

                            </span>
                        </td>
                        <td class="capitalize"><?php echo e(str_replace('_', ' ', $visitor->referral_source ?? '-')); ?></td>
                        <td>
                            <?php if($visitor->status === 'active'): ?>
                            <span class="badge badge-success">Active</span>
                            <?php elseif($visitor->status === 'converted'): ?>
                            <span class="badge badge-primary">Converted</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('visitors.show', $visitor)); ?>" class="text-blue-600 hover:text-blue-800" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <?php if($visitor->visit_count >= 5 && !$visitor->converted_member_id): ?>
                                <a href="<?php echo e(route('visitors.convert.form', $visitor)); ?>" class="text-gold-600 hover:text-gold-800" title="Convert to Member">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">No visitors found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($visitors->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($visitors->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/visitors/index.blade.php ENDPATH**/ ?>