<?php $__env->startSection('title', 'Birthday & Anniversary Automation'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Birthday & Anniversary Automation</h1>
            <p class="text-gray-600 mt-1">Automated wishes and milestone tracking</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('birthdays.settings')); ?>"
               class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
            <form action="<?php echo e(route('birthdays.process')); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        onclick="return confirm('Process today\'s birthdays and anniversaries now?')"
                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Process Now
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-sm font-medium">Birthdays Today</p>
                    <p class="text-3xl font-bold mt-2"><?php echo e($stats['birthdays_today']); ?></p>
                </div>
                <div class="bg-pink-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">This Week</p>
                    <p class="text-3xl font-bold mt-2"><?php echo e($stats['birthdays_this_week']); ?></p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Sent This Month</p>
                    <p class="text-3xl font-bold mt-2"><?php echo e($stats['sent_this_month']); ?></p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Upcoming Milestones</p>
                    <p class="text-3xl font-bold mt-2"><?php echo e($stats['upcoming_milestones']); ?></p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="<?php echo e(route('birthdays.calendar')); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Birthday Calendar</h3>
                    <p class="text-sm text-gray-600">View upcoming birthdays</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('birthdays.milestones')); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Milestones</h3>
                    <p class="text-sm text-gray-600">Track special anniversaries</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('birthdays.announcements')); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Service Announcements</h3>
                    <p class="text-sm text-gray-600">Manage announcements</p>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Today's Birthdays -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Today's Birthdays -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                    </svg>
                    Today's Birthdays (<?php echo e($todaysBirthdays->count()); ?>)
                </h2>

                <?php if($todaysBirthdays->isNotEmpty()): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $todaysBirthdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-pink-50 to-purple-50 border border-pink-200 rounded-lg">
                        <?php if($member->photo_url): ?>
                        <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->full_name); ?>"
                             class="w-16 h-16 rounded-full object-cover">
                        <?php else: ?>
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                            <?php echo e(strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1))); ?>

                        </div>
                        <?php endif; ?>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 text-lg"><?php echo e($member->full_name); ?></h3>
                            <p class="text-sm text-gray-600"><?php echo e($member->phone); ?></p>
                            <p class="text-sm text-purple-700 font-semibold mt-1">
                                Turning <?php echo e(\Carbon\Carbon::parse($member->date_of_birth)->age); ?> years old
                            </p>
                        </div>
                        <div class="text-4xl">🎂</div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <div class="text-6xl mb-3">🎉</div>
                    <p class="text-gray-600">No birthdays today</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Upcoming Birthdays -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Upcoming Birthdays (Next 7 Days)</h2>
                    <a href="<?php echo e(route('birthdays.calendar')); ?>" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View Calendar →
                    </a>
                </div>

                <?php if($upcomingBirthdays->isNotEmpty()): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $upcomingBirthdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                        <?php if($member->photo_url): ?>
                        <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->full_name); ?>"
                             class="w-12 h-12 rounded-full object-cover">
                        <?php else: ?>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                            <?php echo e(strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1))); ?>

                        </div>
                        <?php endif; ?>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900"><?php echo e($member->full_name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e(\Carbon\Carbon::parse($member->date_of_birth)->format('F d')); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-blue-600">
                                <?php echo e(\Carbon\Carbon::parse($member->date_of_birth)->setYear(now()->year)->diffForHumans()); ?>

                            </p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-600">No upcoming birthdays in the next 7 days</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Recent Wishes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Recent Wishes Sent</h2>
                    <a href="<?php echo e(route('birthdays.history')); ?>" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All →
                    </a>
                </div>

                <?php if($recentWishes->isNotEmpty()): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sent</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $recentWishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($wish->member->full_name); ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                        <?php echo e(ucwords(str_replace('_', ' ', $wish->wish_type))); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <?php echo e($wish->sent_at ? $wish->sent_at->format('M d, Y g:i A') : '-'); ?>

                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        <?php if($wish->status === 'sent'): ?> bg-green-100 text-green-800
                                        <?php elseif($wish->status === 'failed'): ?> bg-red-100 text-red-800
                                        <?php else: ?> bg-yellow-100 text-yellow-800
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($wish->status)); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-600">No wishes sent yet</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column - Milestones & Status -->
        <div class="space-y-6">
            <!-- Pending Wishes -->
            <?php if($stats['pending_wishes'] > 0): ?>
            <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-yellow-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-yellow-900">Pending Wishes</h3>
                        <p class="text-sm text-yellow-800 mt-1"><?php echo e($stats['pending_wishes']); ?> wishes scheduled to be sent</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Failed Wishes -->
            <?php if($stats['failed_wishes'] > 0): ?>
            <div class="bg-red-50 border-2 border-red-300 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-red-900">Failed Wishes</h3>
                        <p class="text-sm text-red-800 mt-1"><?php echo e($stats['failed_wishes']); ?> wishes failed to send</p>
                        <form action="<?php echo e(route('birthdays.retry-failed')); ?>" method="POST" class="mt-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                                Retry Failed
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Upcoming Milestones -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-900">Upcoming Milestones</h2>
                    <a href="<?php echo e(route('birthdays.milestones')); ?>" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All →
                    </a>
                </div>

                <?php if($upcomingMilestones->isNotEmpty()): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $upcomingMilestones->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-3 <?php echo e($milestone->is_special ? 'bg-gradient-to-r from-yellow-50 to-yellow-100 border-2 border-yellow-300' : 'border border-gray-200'); ?> rounded-lg">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900"><?php echo e($milestone->member->full_name); ?></p>
                                <p class="text-sm text-gray-600 mt-1"><?php echo e($milestone->description); ?></p>
                                <p class="text-xs text-gray-500 mt-1"><?php echo e($milestone->milestone_date->format('M d, Y')); ?></p>
                            </div>
                            <?php if($milestone->is_special): ?>
                            <span class="text-2xl">⭐</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-6">
                    <p class="text-gray-600 text-sm">No upcoming milestones</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/birthdays/index.blade.php ENDPATH**/ ?>