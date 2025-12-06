<?php $__env->startSection('title', 'Counselling Dashboard'); ?>

<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <?php echo e(__('Counselling Dashboard')); ?>

    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Pending Sessions</h3>
            <p class="text-3xl font-bold text-orange-500"><?php echo e($statistics['pending_sessions'] ?? 0); ?></p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Active Cases</h3>
            <p class="text-3xl font-bold text-blue-600"><?php echo e($statistics['active_cases'] ?? 0); ?></p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Available Counsellors</h3>
            <p class="text-3xl font-bold text-green-600"><?php echo e($statistics['available_counsellors'] ?? 0); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Today's Sessions</h3>
                <?php if(isset($todaysSessions) && count($todaysSessions) > 0): ?>
                    <ul class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $todaysSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium"><?php echo e($session->member->full_name ?? 'Unknown'); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($session->session_time->format('H:i')); ?> with <?php echo e($session->counsellor->user->name ?? 'Counsellor'); ?></p>
                                    </div>
                                    <a href="<?php echo e(route('counselling.sessions.show', $session)); ?>" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No sessions scheduled for today.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Recent Active Cases</h3>
                <?php if(isset($activeCases) && count($activeCases) > 0): ?>
                    <ul class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $activeCases->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium"><?php echo e($case->case_title); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($case->member->full_name ?? 'Unknown Member'); ?></p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800"><?php echo e($case->priority); ?></span>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No active cases.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/counselling/index.blade.php ENDPATH**/ ?>