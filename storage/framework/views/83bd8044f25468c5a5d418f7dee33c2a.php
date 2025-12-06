<?php $__env->startSection('title', 'Analytics Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Analytics Dashboard</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('reports.index')); ?>">Reports</a>
            <span>/</span>
            <span>Analytics</span>
        </nav>
    </div>
    <div class="page-actions">
        <form method="GET" action="<?php echo e(route('reports.analytics')); ?>" class="inline-flex gap-2">
            <select name="days" class="form-select" onchange="this.form.submit()">
                <option value="7" <?php echo e($days == 7 ? 'selected' : ''); ?>>Last 7 Days</option>
                <option value="30" <?php echo e($days == 30 ? 'selected' : ''); ?>>Last 30 Days</option>
                <option value="90" <?php echo e($days == 90 ? 'selected' : ''); ?>>Last 90 Days</option>
                <option value="365" <?php echo e($days == 365 ? 'selected' : ''); ?>>Last Year</option>
            </select>
        </form>
    </div>
</div>

<!-- Key Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Members</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1"><?php echo e($data['total_members'] ?? 0); ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 text-sm">
                <span class="text-green-600">+<?php echo e($data['new_members'] ?? 0); ?></span>
                <span class="text-gray-500"> new this period</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Avg Attendance</p>
                    <p class="text-3xl font-bold text-green-600 mt-1"><?php echo e(number_format($data['avg_attendance'] ?? 0)); ?></p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 text-sm">
                <span class="text-gray-600"><?php echo e(number_format($data['attendance_rate'] ?? 0, 1)); ?>%</span>
                <span class="text-gray-500"> attendance rate</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Income</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">GHS <?php echo e(number_format($data['total_income'] ?? 0, 2)); ?></p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 text-sm text-gray-500">
                Expenses: GHS <?php echo e(number_format($data['total_expenses'] ?? 0, 2)); ?>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Programs</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1"><?php echo e($data['active_programs'] ?? 0); ?></p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 text-sm text-gray-500">
                <?php echo e($data['total_programs'] ?? 0); ?> total programs
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Membership Growth -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Membership Growth</h3>
        </div>
        <div class="card-body">
            <?php if(!empty($data['membership_growth'])): ?>
                <div class="space-y-2">
                    <?php $__currentLoopData = $data['membership_growth']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600"><?php echo e($period); ?></span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e(min(100, ($count / max(array_values($data['membership_growth']))) * 100)); ?>%"></div>
                                </div>
                                <span class="text-sm font-semibold"><?php echo e($count); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No membership data available</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Attendance Trend -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Attendance Trend</h3>
        </div>
        <div class="card-body">
            <?php if(!empty($data['attendance_trend'])): ?>
                <div class="space-y-2">
                    <?php $__currentLoopData = $data['attendance_trend']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600"><?php echo e($period); ?></span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e(min(100, ($count / max(array_values($data['attendance_trend']))) * 100)); ?>%"></div>
                                </div>
                                <span class="text-sm font-semibold"><?php echo e($count); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No attendance data available</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Financial Summary -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Financial Summary</h3>
        </div>
        <div class="card-body">
            <?php if(!empty($data['financial_summary'])): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $data['financial_summary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 capitalize"><?php echo e(str_replace('_', ' ', $category)); ?></span>
                                <span class="font-semibold">GHS <?php echo e(number_format($amount, 2)); ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: <?php echo e($amount > 0 ? min(100, ($amount / max(array_values($data['financial_summary']))) * 100) : 0); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No financial data available</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Program Participation -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Program Participation</h3>
        </div>
        <div class="card-body">
            <?php if(!empty($data['program_participation'])): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $data['program_participation']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program => $participants): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium"><?php echo e($program); ?></span>
                            <span class="badge badge-primary"><?php echo e($participants); ?> participants</span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No program data available</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Engagement Metrics -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Engagement Metrics</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <p class="text-sm text-gray-600">First Time Visitors</p>
                <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($data['first_time_visitors'] ?? 0); ?></p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600">Repeat Visitors</p>
                <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($data['repeat_visitors'] ?? 0); ?></p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600">Member Conversions</p>
                <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($data['member_conversions'] ?? 0); ?></p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600">Service Units Active</p>
                <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($data['active_service_units'] ?? 0); ?></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/reports/analytics.blade.php ENDPATH**/ ?>