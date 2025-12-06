<?php $__env->startSection('title', 'Children\'s Ministry Dashboard'); ?>

<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <?php echo e(__('Children\'s Ministry Dashboard')); ?>

    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Statistics Cards -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Total Children</h3>
            <p class="text-3xl font-bold text-blue-600"><?php echo e($statistics['total_children'] ?? 0); ?></p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Today's Check-ins</h3>
            <p class="text-3xl font-bold text-green-600"><?php echo e($statistics['todays_checkins'] ?? 0); ?></p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Volunteers</h3>
            <p class="text-3xl font-bold text-purple-600"><?php echo e($statistics['volunteers'] ?? 0); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Check-ins -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Recent Check-ins</h3>
                <?php if(isset($todaysCheckins) && count($todaysCheckins) > 0): ?>
                    <ul class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $todaysCheckins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium"><?php echo e($checkin->child->full_name ?? 'Unknown'); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($checkin->created_at->format('H:i')); ?></p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Checked In</span>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No check-ins yet today.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Upcoming Events</h3>
                <?php if(isset($upcomingEvents) && count($upcomingEvents) > 0): ?>
                    <ul class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium"><?php echo e($event->event_name); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($event->start_date->format('M d, Y')); ?></p>
                                    </div>
                                    <a href="<?php echo e(route('childrens-ministry.events.show', $event)); ?>" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No upcoming events.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/childrens-ministry/index.blade.php ENDPATH**/ ?>