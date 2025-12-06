<?php $__env->startSection('title', 'Member Statistics'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Member Statistics</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('members.index')); ?>">Members</a>
            <span>/</span>
            <span>Statistics</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('members.index')); ?>" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Members
        </a>
    </div>
</div>

<!-- Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-value"><?php echo e(number_format($statistics['total_members'])); ?></div>
        <div class="stat-label">Total Members</div>
    </div>
    <div class="stat-card stat-card-gradient-green">
        <div class="stat-value"><?php echo e(number_format($statistics['active_members'])); ?></div>
        <div class="stat-label">Active Members</div>
    </div>
    <div class="stat-card stat-card-gradient-gold">
        <div class="stat-value"><?php echo e(number_format($statistics['new_members_month'])); ?></div>
        <div class="stat-label">New This Month</div>
    </div>
    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-value"><?php echo e(number_format($statistics['average_age'])); ?></div>
        <div class="stat-label">Average Age</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Demographics -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Demographics</h3>
        </div>
        <div class="card-body">
            <!-- Gender Distribution -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Gender Distribution</h4>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Male</span>
                            <span class="font-semibold text-gray-900">
                                <?php echo e($demographics['gender']['male']); ?> (<?php echo e($demographics['gender']['male_percentage']); ?>%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-primary h-2 rounded-full" style="width: <?php echo e($demographics['gender']['male_percentage']); ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Female</span>
                            <span class="font-semibold text-gray-900">
                                <?php echo e($demographics['gender']['female']); ?> (<?php echo e($demographics['gender']['female_percentage']); ?>%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-gold h-2 rounded-full" style="width: <?php echo e($demographics['gender']['female_percentage']); ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Age Distribution</h4>
                <div class="space-y-3">
                    <?php $__currentLoopData = $demographics['age_groups']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $percentage = $statistics['total_members'] > 0
                            ? round(($count / $statistics['total_members']) * 100, 1)
                            : 0;
                    ?>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600"><?php echo e($group); ?></span>
                            <span class="font-semibold text-gray-900"><?php echo e($count); ?> (<?php echo e($percentage); ?>%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-blue-gold h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Marital Status -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">Marital Status</h4>
                <div class="space-y-3">
                    <?php $__currentLoopData = $demographics['marital_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $percentage = $statistics['total_members'] > 0
                            ? round(($count / $statistics['total_members']) * 100, 1)
                            : 0;
                    ?>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600 capitalize"><?php echo e($status); ?></span>
                            <span class="font-semibold text-gray-900"><?php echo e($count); ?> (<?php echo e($percentage); ?>%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-primary h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Growth Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Member Growth (Last 12 Months)</h3>
        </div>
        <div class="card-body">
            <canvas id="memberGrowthChart" height="300"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Upcoming Birthdays -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Upcoming Birthdays (Next 30 Days)</h3>
        </div>
        <div class="card-body p-0">
            <?php if($upcomingBirthdays->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Date</th>
                            <th>Age</th>
                            <th>Days Until</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $upcomingBirthdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $birthday = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y') . '-' . $member->date_of_birth->format('m-d'));
                            if ($birthday->isPast()) {
                                $birthday->addYear();
                            }
                            $daysUntil = now()->diffInDays($birthday, false);
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('members.show', $member)); ?>" class="text-primary-600 hover:text-primary-700">
                                    <?php echo e($member->full_name); ?>

                                </a>
                            </td>
                            <td><?php echo e($member->date_of_birth->format('F d')); ?></td>
                            <td><?php echo e($member->age); ?> years</td>
                            <td>
                                <?php if($daysUntil == 0): ?>
                                <span class="badge badge-success">Today!</span>
                                <?php elseif($daysUntil == 1): ?>
                                <span class="badge badge-warning">Tomorrow</span>
                                <?php else: ?>
                                <span class="text-gray-600"><?php echo e($daysUntil); ?> days</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="p-8 text-center text-gray-500">
                <p>No upcoming birthdays in the next 30 days</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Incomplete Profiles -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Incomplete Profiles (<?php echo e($incompleteProfiles->count()); ?>)</h3>
        </div>
        <div class="card-body p-0">
            <?php if($incompleteProfiles->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Missing Information</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $incompleteProfiles->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('members.show', $member)); ?>" class="text-primary-600 hover:text-primary-700">
                                    <?php echo e($member->full_name); ?>

                                </a>
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    <?php if(!$member->photo_url): ?>
                                    <span class="badge badge-secondary text-xs">Photo</span>
                                    <?php endif; ?>
                                    <?php if(!$member->date_of_birth): ?>
                                    <span class="badge badge-secondary text-xs">DOB</span>
                                    <?php endif; ?>
                                    <?php if(!$member->phone): ?>
                                    <span class="badge badge-secondary text-xs">Phone</span>
                                    <?php endif; ?>
                                    <?php if(!$member->address): ?>
                                    <span class="badge badge-secondary text-xs">Address</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-right">
                                <a href="<?php echo e(route('members.edit', $member)); ?>" class="btn-icon btn-icon-sm text-gold-600" title="Complete Profile">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php if($incompleteProfiles->count() > 10): ?>
            <div class="p-4 bg-gray-50 border-t text-center">
                <p class="text-sm text-gray-600">
                    Showing 10 of <?php echo e($incompleteProfiles->count()); ?> incomplete profiles
                </p>
            </div>
            <?php endif; ?>
            <?php else: ?>
            <div class="p-8 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-semibold text-green-600">All profiles are complete!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Member Growth Chart
    const growthCtx = document.getElementById('memberGrowthChart');
    if (growthCtx) {
        const growthData = <?php echo json_encode($statistics['growth_trend'] ?? [], 15, 512) ?>;

        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: Object.keys(growthData),
                datasets: [{
                    label: 'New Members',
                    data: Object.values(growthData),
                    borderColor: 'rgb(37, 99, 235)',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/members/statistics.blade.php ENDPATH**/ ?>