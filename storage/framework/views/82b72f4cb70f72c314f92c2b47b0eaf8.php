<?php $__env->startSection('title', 'Eligible for Conversion'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Visitors Eligible for Membership</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('visitors.index')); ?>">Visitors</a>
            <span>/</span>
            <span>Eligible</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="<?php echo e(route('visitors.reports')); ?>" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        <a href="<?php echo e(route('visitors.index')); ?>" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            All Visitors
        </a>
    </div>
</div>

<!-- Info Banner -->
<div class="card bg-gradient-gold mb-6">
    <div class="card-body text-white">
        <div class="flex items-start gap-4">
            <svg class="w-12 h-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <div class="flex-1">
                <h2 class="text-2xl font-bold mb-2">5-Visit Conversion Rule</h2>
                <p class="text-sm opacity-90 mb-3">
                    These visitors have attended at least 5 services and are eligible to become members. Review their information and initiate the conversion process.
                </p>
                <div class="flex gap-4">
                    <div class="bg-white/20 rounded-lg px-4 py-2">
                        <div class="text-2xl font-bold"><?php echo e(count($eligibleVisitors)); ?></div>
                        <div class="text-xs opacity-90">Eligible Visitors</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Eligible Visitors Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Eligible Visitors
            <span class="text-sm text-gray-500 font-normal ml-2">(<?php echo e(count($eligibleVisitors)); ?> ready for conversion)</span>
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>First Visit</th>
                        <th>Last Visit</th>
                        <th>Visits</th>
                        <th>Days Active</th>
                        <th>Referral</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $eligibleVisitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($visitor->visit_count >= 8 ? 'bg-green-50' : ''); ?>">
                        <td>
                            <?php if($visitor->visit_count >= 10): ?>
                            <span class="badge badge-danger">High</span>
                            <?php elseif($visitor->visit_count >= 7): ?>
                            <span class="badge badge-warning">Medium</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Normal</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="font-medium"><?php echo e($visitor->first_name); ?> <?php echo e($visitor->last_name); ?></div>
                        </td>
                        <td>
                            <div class="text-sm"><?php echo e($visitor->email ?? '-'); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($visitor->phone); ?></div>
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="text-sm"><?php echo e($visitor->first_visit_date?->format('M d, Y')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($visitor->first_visit_date?->diffForHumans()); ?></div>
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="text-sm"><?php echo e($visitor->last_visit_date?->format('M d, Y')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($visitor->last_visit_date?->diffForHumans()); ?></div>
                        </td>
                        <td>
                            <span class="badge <?php echo e($visitor->visit_count >= 10 ? 'badge-success' : 'badge-primary'); ?> text-lg px-3 py-1">
                                <?php echo e($visitor->visit_count); ?>

                            </span>
                        </td>
                        <td>
                            <span class="text-sm font-medium">
                                <?php echo e($visitor->first_visit_date?->diffInDays()); ?> days
                            </span>
                        </td>
                        <td class="capitalize text-sm"><?php echo e(str_replace('_', ' ', $visitor->referral_source ?? '-')); ?></td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('visitors.show', $visitor)); ?>" class="btn btn-sm btn-outline" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="<?php echo e(route('visitors.convert.form', $visitor)); ?>" class="btn btn-sm btn-gold">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Convert
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xl font-medium text-gray-600 mb-2">No Visitors Ready Yet</p>
                            <p class="text-gray-500">Visitors will appear here once they've attended 5 or more services.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if(count($eligibleVisitors) > 0): ?>
<!-- Conversion Guidelines -->
<div class="card mt-6 bg-blue-50 border-blue-200">
    <div class="card-body">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-900 mb-2">Conversion Process</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• <strong>Priority Levels:</strong> High (10+ visits), Medium (7-9 visits), Normal (5-6 visits)</li>
                    <li>• <strong>Review visitor information</strong> before initiating conversion</li>
                    <li>• <strong>Conversion creates:</strong> User account, Member record, Unique member ID</li>
                    <li>• <strong>Initial status:</strong> Pending (requires completion of foundations class)</li>
                    <li>• <strong>Next steps:</strong> Assign to shepherd, enroll in onboarding program</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/visitors/eligible.blade.php ENDPATH**/ ?>