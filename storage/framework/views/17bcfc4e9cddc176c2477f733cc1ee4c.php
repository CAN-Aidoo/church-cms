<?php $__env->startSection('title', 'Visitor Follow-up'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Visitor Follow-up Management</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('visitors.index')); ?>">Visitors</a>
            <span>/</span>
            <span>Follow-up</span>
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

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e(count($needingFollowUp)); ?></div>
            <div class="stat-label">Needing Follow-up (14+ days)</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-red-500 to-red-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e(count($notReturned)); ?></div>
            <div class="stat-label">Not Returned (30+ days)</div>
        </div>
    </div>
</div>

<!-- Visitors Needing Follow-up (14+ days since last visit) -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">
            Visitors Needing Follow-up
            <span class="text-sm text-gray-500 font-normal ml-2">(Inactive 14+ days)</span>
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
                        <th>Last Visit</th>
                        <th>Days Inactive</th>
                        <th>Total Visits</th>
                        <th>Referral</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $needingFollowUp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($visitor->last_visit_date?->diffInDays() > 30 ? 'bg-red-50' : 'bg-yellow-50'); ?>">
                        <td>
                            <?php if($visitor->last_visit_date?->diffInDays() > 30): ?>
                            <span class="badge badge-danger">Urgent</span>
                            <?php else: ?>
                            <span class="badge badge-warning">Normal</span>
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
                            <div class="text-sm"><?php echo e($visitor->last_visit_date?->format('M d, Y')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($visitor->last_visit_date?->diffForHumans()); ?></div>
                        </td>
                        <td>
                            <span class="badge <?php echo e($visitor->last_visit_date?->diffInDays() > 30 ? 'badge-danger' : 'badge-warning'); ?>">
                                <?php echo e($visitor->last_visit_date?->diffInDays()); ?> days
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-secondary"><?php echo e($visitor->visit_count); ?> <?php echo e(Str::plural('visit', $visitor->visit_count)); ?></span>
                        </td>
                        <td class="capitalize text-sm"><?php echo e(str_replace('_', ' ', $visitor->referral_source ?? '-')); ?></td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('visitors.show', $visitor)); ?>" class="btn btn-sm btn-outline" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="tel:<?php echo e($visitor->phone); ?>" class="btn btn-sm btn-primary" title="Call">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </a>
                                <?php if($visitor->email): ?>
                                <a href="mailto:<?php echo e($visitor->email); ?>" class="btn btn-sm btn-outline" title="Email">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xl font-medium text-gray-600 mb-2">All Caught Up!</p>
                            <p class="text-gray-500">No visitors requiring immediate follow-up at this time.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- First-time Visitors Who Haven't Returned (30+ days) -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            First-time Visitors (Not Returned)
            <span class="text-sm text-gray-500 font-normal ml-2">(30+ days since first visit)</span>
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>First Visit</th>
                        <th>Days Since Visit</th>
                        <th>Referral Source</th>
                        <th>Interests</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $notReturned; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
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
                        <td>
                            <span class="badge badge-danger">
                                <?php echo e($visitor->first_visit_date?->diffInDays()); ?> days
                            </span>
                        </td>
                        <td class="capitalize text-sm"><?php echo e(str_replace('_', ' ', $visitor->referral_source ?? '-')); ?></td>
                        <td class="text-sm text-gray-600"><?php echo e(Str::limit($visitor->interests ?? '-', 30)); ?></td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('visitors.show', $visitor)); ?>" class="btn btn-sm btn-outline" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="tel:<?php echo e($visitor->phone); ?>" class="btn btn-sm btn-primary" title="Call">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </a>
                                <button type="button" @click="$refs.inactiveModal<?php echo e($visitor->id); ?>.showModal()" class="btn btn-sm btn-outline text-gray-600" title="Mark Inactive">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Mark Inactive Modal -->
                            <dialog x-ref="inactiveModal<?php echo e($visitor->id); ?>" class="rounded-lg shadow-xl w-full max-w-md p-0">
                                <div class="card m-0">
                                    <div class="card-header">
                                        <h3 class="card-title">Mark as Inactive</h3>
                                        <button type="button" @click="$refs.inactiveModal<?php echo e($visitor->id); ?>.close()" class="text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <form action="<?php echo e(route('visitors.markInactive', $visitor)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="card-body">
                                            <p class="text-sm mb-4"><strong><?php echo e($visitor->first_name); ?> <?php echo e($visitor->last_name); ?></strong> hasn't returned since their first visit <?php echo e($visitor->first_visit_date?->diffInDays()); ?> days ago.</p>
                                            <div class="mb-4">
                                                <label for="reason<?php echo e($visitor->id); ?>" class="form-label required">Reason</label>
                                                <textarea id="reason<?php echo e($visitor->id); ?>" name="reason" rows="3"
                                                          class="form-textarea"
                                                          required
                                                          placeholder="e.g., No interest, Relocated, No response to follow-up..."></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer flex justify-end gap-3">
                                            <button type="button" @click="$refs.inactiveModal<?php echo e($visitor->id); ?>.close()" class="btn btn-secondary">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-danger">
                                                Mark as Inactive
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </dialog>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xl font-medium text-gray-600 mb-2">Excellent!</p>
                            <p class="text-gray-500">All first-time visitors have returned or been followed up.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Follow-up Guidelines -->
<?php if(count($needingFollowUp) > 0 || count($notReturned) > 0): ?>
<div class="card mt-6 bg-blue-50 border-blue-200">
    <div class="card-body">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-900 mb-2">Follow-up Best Practices</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• <strong>14-21 days:</strong> Send a friendly SMS or call to check in</li>
                    <li>• <strong>22-30 days:</strong> Personal phone call from pastor or staff member</li>
                    <li>• <strong>30+ days:</strong> Final outreach with invitation to upcoming event</li>
                    <li>• <strong>First-time visitors:</strong> Contact within 48 hours of first visit</li>
                    <li>• <strong>Document all contact attempts</strong> in visitor notes</li>
                    <li>• <strong>Mark as inactive</strong> if no response after 3 follow-up attempts</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/visitors/follow-up.blade.php ENDPATH**/ ?>