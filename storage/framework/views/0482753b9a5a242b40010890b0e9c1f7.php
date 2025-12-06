<?php $__env->startSection('title', 'Service Planning'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Service Planning</h1>
            <p class="text-gray-600 mt-1">Manage worship services, schedules, and volunteers</p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('services.calendar')); ?>" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                Calendar View
            </a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\ServiceSchedule::class)): ?>
            <a href="<?php echo e(route('services.create')); ?>" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Service
            </a>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Today's Services</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($summary['today_services']); ?></p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">This Week</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($summary['this_week_services']); ?></p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending Volunteers</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($summary['pending_volunteers']); ?></p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Avg Attendance Rate</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($summary['avg_attendance_rate'], 1)); ?>%</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('services.index')); ?>" class="flex flex-wrap gap-4">
            <select name="service_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Service Types</option>
                <option value="regular" <?php echo e(($filters['service_type'] ?? '') === 'regular' ? 'selected' : ''); ?>>Regular Service</option>
                <option value="special" <?php echo e(($filters['service_type'] ?? '') === 'special' ? 'selected' : ''); ?>>Special Service</option>
                <option value="midweek" <?php echo e(($filters['service_type'] ?? '') === 'midweek' ? 'selected' : ''); ?>>Midweek Service</option>
                <option value="youth" <?php echo e(($filters['service_type'] ?? '') === 'youth' ? 'selected' : ''); ?>>Youth Service</option>
                <option value="children" <?php echo e(($filters['service_type'] ?? '') === 'children' ? 'selected' : ''); ?>>Children Service</option>
                <option value="prayer_meeting" <?php echo e(($filters['service_type'] ?? '') === 'prayer_meeting' ? 'selected' : ''); ?>>Prayer Meeting</option>
                <option value="bible_study" <?php echo e(($filters['service_type'] ?? '') === 'bible_study' ? 'selected' : ''); ?>>Bible Study</option>
            </select>

            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="draft" <?php echo e(($filters['status'] ?? '') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                <option value="scheduled" <?php echo e(($filters['status'] ?? '') === 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                <option value="in_progress" <?php echo e(($filters['status'] ?? '') === 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                <option value="completed" <?php echo e(($filters['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                <option value="cancelled" <?php echo e(($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>

            <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>" placeholder="From Date"
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

            <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>" placeholder="To Date"
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

            <input type="text" name="search" placeholder="Search services..." value="<?php echo e($filters['search'] ?? ''); ?>"
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 flex-1">

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Filter
            </button>

            <?php if(!empty($filters)): ?>
            <a href="<?php echo e(route('services.index')); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Clear
            </a>
            <?php endif; ?>
        </form>
    </div>

    
    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <h3 class="text-xl font-bold text-gray-900"><?php echo e($service->name); ?></h3>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo e($service->getStatusBadgeClass()); ?>">
                            <?php echo e(ucfirst($service->status)); ?>

                        </span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                            <?php echo e($service->service_type_label); ?>

                        </span>
                    </div>

                    <?php if($service->theme): ?>
                    <p class="text-sm text-gray-600 mb-3"><?php echo e($service->theme); ?></p>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Date & Time</p>
                            <div class="flex items-center text-sm text-gray-900">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <div><?php echo e($service->service_date->format('D, M d, Y')); ?></div>
                                    <div class="text-xs text-gray-500">
                                        <?php echo e(\Carbon\Carbon::parse($service->start_time)->format('g:i A')); ?>

                                        <?php if($service->end_time): ?>
                                            - <?php echo e(\Carbon\Carbon::parse($service->end_time)->format('g:i A')); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if($service->preacher): ?>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Preacher</p>
                            <div class="flex items-center text-sm text-gray-900">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e($service->preacher->first_name); ?> <?php echo e($service->preacher->last_name); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($service->venue): ?>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Venue</p>
                            <div class="flex items-center text-sm text-gray-900">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e($service->venue); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Volunteers</p>
                            <div class="flex items-center text-sm text-gray-900">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>
                                <?php echo e($service->volunteers_count); ?> assigned
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ml-4 flex flex-col gap-2">
                    <a href="<?php echo e(route('services.show', $service)); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm">
                        View Details
                    </a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $service)): ?>
                    <a href="<?php echo e(route('services.edit', $service)); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-center text-sm">
                        Edit
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Services Found</h3>
            <p class="text-gray-600 mb-4">Start by creating your first service schedule</p>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\ServiceSchedule::class)): ?>
            <a href="<?php echo e(route('services.create')); ?>" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Create Service
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($services->hasPages()): ?>
    <div class="mt-8">
        <?php echo e($services->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/services/index.blade.php ENDPATH**/ ?>