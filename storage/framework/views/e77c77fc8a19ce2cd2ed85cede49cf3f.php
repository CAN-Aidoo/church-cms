<?php $__env->startSection('title', 'Birthday Calendar'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="<?php echo e(route('birthdays.index')); ?>" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Birthday Calendar</h1>
            </div>
            <p class="text-gray-600">Upcoming birthdays for the next <?php echo e($days); ?> days</p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('birthdays.calendar', ['days' => 7])); ?>"
               class="px-4 py-2 <?php echo e($days == 7 ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 text-gray-700'); ?> rounded-lg hover:opacity-90 transition">
                7 Days
            </a>
            <a href="<?php echo e(route('birthdays.calendar', ['days' => 30])); ?>"
               class="px-4 py-2 <?php echo e($days == 30 ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 text-gray-700'); ?> rounded-lg hover:opacity-90 transition">
                30 Days
            </a>
            <a href="<?php echo e(route('birthdays.calendar', ['days' => 90])); ?>"
               class="px-4 py-2 <?php echo e($days == 90 ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 text-gray-700'); ?> rounded-lg hover:opacity-90 transition">
                90 Days
            </a>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg shadow-lg p-6 text-white mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold"><?php echo e($report['total']); ?> Birthdays</h2>
                <p class="text-pink-100 mt-1">in the next <?php echo e($days); ?> days</p>
            </div>
            <div class="text-6xl">🎂</div>
        </div>
    </div>

    <!-- Birthday List by Date -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Birthdays by Date</h2>

        <?php if(count($report['grouped_by_date']) > 0): ?>
        <div class="space-y-6">
            <?php $__currentLoopData = $report['grouped_by_date']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $members): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-blue-100 rounded-lg px-4 py-2">
                        <p class="text-lg font-bold text-blue-900"><?php echo e(\Carbon\Carbon::parse($date)->format('M d')); ?></p>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">
                        <?php echo e(\Carbon\Carbon::parse($date)->setYear(now()->year)->format('l, F d')); ?>

                    </h3>
                    <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-sm font-medium">
                        <?php echo e($members->count()); ?> <?php echo e(Str::plural('birthday', $members->count())); ?>

                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ml-4">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memberData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-pink-50 transition">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                            <?php echo e(strtoupper(substr(explode(' ', $memberData['name'])[0], 0, 1))); ?>

                        </div>
                        <div>
                            <p class="font-semibold text-gray-900"><?php echo e($memberData['name']); ?></p>
                            <p class="text-xs text-gray-600"><?php echo e($memberData['phone']); ?></p>
                            <p class="text-xs text-purple-700 font-medium">Turning <?php echo e($memberData['age']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📅</div>
            <p class="text-gray-600">No birthdays in the selected period</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/birthdays/calendar.blade.php ENDPATH**/ ?>