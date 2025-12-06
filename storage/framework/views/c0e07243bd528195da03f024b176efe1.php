<?php $__env->startSection('title', 'Service Calendar'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Service Calendar</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('services.index')); ?>">Services</a>
            <span>/</span>
            <span>Calendar</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('services.create')); ?>" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Schedule New Service
        </a>
    </div>
</div>

<!-- Month/Year Selector -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('services.calendar')); ?>" class="flex items-center gap-4">
            <div>
                <label for="month" class="form-label">Month</label>
                <select name="month" id="month" class="form-select">
                    <?php for($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo e($m); ?>" <?php echo e($month == $m ? 'selected' : ''); ?>>
                            <?php echo e(\Carbon\Carbon::create()->month($m)->format('F')); ?>

                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label for="year" class="form-label">Year</label>
                <select name="year" id="year" class="form-select">
                    <?php for($y = now()->year - 1; $y <= now()->year + 2; $y++): ?>
                        <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    View
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Calendar View -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(\Carbon\Carbon::create($year, $month, 1)->format('F Y')); ?> Services</h3>
        <a href="<?php echo e(route('services.index')); ?>" class="text-sm text-primary-600 hover:text-primary-700">View List</a>
    </div>
    <div class="card-body">
        <?php if($services->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $services->groupBy(function($service) { return \Carbon\Carbon::parse($service->service_date)->format('Y-m-d'); }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $dayServices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-gray-900">
                                <?php echo e(\Carbon\Carbon::parse($date)->format('l, F j, Y')); ?>

                            </h4>
                            <span class="badge badge-primary"><?php echo e($dayServices->count()); ?> <?php echo e($dayServices->count() == 1 ? 'Service' : 'Services'); ?></span>
                        </div>
                        <div class="space-y-2">
                            <?php $__currentLoopData = $dayServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between bg-gray-50 rounded p-3 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500"><?php echo e(\Carbon\Carbon::parse($service->service_time)->format('H:i')); ?></div>
                                            <div class="text-sm font-medium text-gray-700"><?php echo e($service->service_type); ?></div>
                                        </div>
                                        <div class="border-l border-gray-300 pl-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($service->title); ?></div>
                                            <?php if($service->preacher): ?>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    Preacher: <?php echo e($service->preacher->name); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="badge <?php echo e($service->status === 'completed' ? 'badge-success' : ($service->status === 'cancelled' ? 'badge-danger' : 'badge-warning')); ?>">
                                            <?php echo e(ucfirst($service->status)); ?>

                                        </span>
                                        <a href="<?php echo e(route('services.show', $service)); ?>" class="btn btn-sm btn-outline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Services Scheduled</h3>
                <p class="text-gray-500 mb-4">No services are scheduled for <?php echo e(\Carbon\Carbon::create($year, $month, 1)->format('F Y')); ?>.</p>
                <a href="<?php echo e(route('services.create')); ?>" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Schedule First Service
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/services/calendar.blade.php ENDPATH**/ ?>