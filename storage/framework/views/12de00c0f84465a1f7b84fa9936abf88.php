<?php $__env->startSection('title', 'Welfare Dashboard'); ?>

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welfare Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Manage welfare cases and programs</p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('welfare.cases.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
                New Case
            </a>
            <a href="<?php echo e(route('welfare.programs.create')); ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm font-medium">
                Create Program
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Active Cases</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['active_cases'] ?? 0)); ?></h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending Review</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['pending_cases'] ?? 0)); ?></h3>
                </div>
                <div class="p-2 bg-yellow-50 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Disbursed</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">GHS <?php echo e(number_format($statistics['total_disbursed'] ?? 0, 2)); ?></h3>
                </div>
                <div class="p-2 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-900 text-sm">High Priority Cases</h3>
                <a href="<?php echo e(route('welfare.cases')); ?>" class="text-xs text-primary-600 hover:text-primary-700 font-medium">View All</a>
            </div>
            <div class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $highPriorityCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900"><?php echo e($case->case_title); ?></h4>
                                <p class="text-xs text-gray-500"><?php echo e($case->beneficiary_name ?? 'Unknown Beneficiary'); ?></p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800 font-medium capitalize"><?php echo e($case->priority); ?></span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-gray-500"><?php echo e($case->created_at->diffForHumans()); ?></span>
                            <a href="<?php echo e(route('welfare.cases.show', $case)); ?>" class="text-xs text-primary-600 hover:text-primary-800 font-medium">View Details</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-6 py-8 text-center text-gray-500 text-sm">No high priority cases.</div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-900 text-sm">Active Programs</h3>
                <a href="<?php echo e(route('welfare.programs')); ?>" class="text-xs text-primary-600 hover:text-primary-700 font-medium">View All</a>
            </div>
            <div class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $activePrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900"><?php echo e($program->program_name); ?></h4>
                                <p class="text-xs text-gray-500 capitalize"><?php echo e(str_replace('_', ' ', $program->program_type)); ?></p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800 font-medium">Active</span>
                        </div>
                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-primary-600 h-1.5 rounded-full" style="width: <?php echo e(min(100, ($program->amount_spent / max(1, $program->budget_allocated)) * 100)); ?>%"></div>
                            </div>
                            <div class="flex justify-between mt-1 text-xs text-gray-500">
                                <span>Spent: GHS <?php echo e(number_format($program->amount_spent, 2)); ?></span>
                                <span>Budget: GHS <?php echo e(number_format($program->budget_allocated, 2)); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-6 py-8 text-center text-gray-500 text-sm">No active programs.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/welfare/index.blade.php ENDPATH**/ ?>