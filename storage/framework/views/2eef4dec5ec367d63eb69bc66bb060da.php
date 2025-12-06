<?php $__env->startSection('title', 'Reports Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Reports Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600">Generate insights and export data across all church operations</p>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="<?php echo e(route('reports.builder')); ?>" class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-lg">Custom Report</h3>
                    <p class="text-sm text-blue-100">Build your own report</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('reports.analytics')); ?>" class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-lg">Analytics</h3>
                    <p class="text-sm text-purple-100">View insights & trends</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('reports.schedules')); ?>" class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-lg">Schedules</h3>
                    <p class="text-sm text-green-100">Automated reports</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('reports.executions')); ?>" class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-lg">History</h3>
                    <p class="text-sm text-orange-100">Generated reports</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Standard Reports -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Standard Reports</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Membership Reports -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Membership Reports</h3>
                </div>
                <div class="space-y-2">
                    <?php $__currentLoopData = $standardReports['membership']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($report['route'])); ?>" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600"><?php echo e($report['name']); ?></span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Financial Reports -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Financial Reports</h3>
                </div>
                <div class="space-y-2">
                    <?php $__currentLoopData = $standardReports['financial']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($report['route'])); ?>" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600"><?php echo e($report['name']); ?></span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Attendance Reports -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Attendance Reports</h3>
                </div>
                <div class="space-y-2">
                    <?php $__currentLoopData = $standardReports['attendance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($report['route'])); ?>" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600"><?php echo e($report['name']); ?></span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Program Reports -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Program Reports</h3>
                </div>
                <div class="space-y-2">
                    <?php $__currentLoopData = $standardReports['program']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($report['route'])); ?>" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600"><?php echo e($report['name']); ?></span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Reports & Recent Executions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Custom Reports -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">My Custom Reports</h3>
                <a href="<?php echo e(route('reports.builder')); ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Create New
                </a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $customReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1">
                        <a href="<?php echo e(route('reports.custom.show', $report)); ?>" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                            <?php echo e($report->name); ?>

                        </a>
                        <p class="text-xs text-gray-500 mt-1">
                            <?php echo e(ucfirst($report->type)); ?> • <?php echo e($report->created_at->diffForHumans()); ?>

                        </p>
                    </div>
                    <button type="button"
                            onclick="toggleFavorite(<?php echo e($report->id); ?>)"
                            class="ml-2 text-gray-400 hover:text-yellow-500">
                        <svg class="w-5 h-5" fill="<?php echo e($report->isFavoritedBy(auth()->user()) ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </button>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No custom reports yet</p>
                    <a href="<?php echo e(route('reports.builder')); ?>" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                        Create your first report
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Executions -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Reports</h3>
                <a href="<?php echo e(route('reports.executions')); ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All
                </a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $recentExecutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $execution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900"><?php echo e($execution->report_name); ?></p>
                        <div class="flex items-center mt-1 text-xs text-gray-500">
                            <span><?php echo e($execution->created_at->diffForHumans()); ?></span>
                            <span class="mx-2">•</span>
                            <span class="uppercase"><?php echo e($execution->format); ?></span>
                        </div>
                    </div>
                    <div class="ml-4 flex items-center gap-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            <?php echo e($execution->status === 'completed' ? 'bg-green-100 text-green-800' : ''); ?>

                            <?php echo e($execution->status === 'failed' ? 'bg-red-100 text-red-800' : ''); ?>

                            <?php echo e($execution->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : ''); ?>">
                            <?php echo e(ucfirst($execution->status)); ?>

                        </span>
                        <?php if($execution->isDownloadable()): ?>
                            <a href="<?php echo e(route('reports.executions.download', $execution)); ?>" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No reports generated yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleFavorite(reportId) {
    fetch(`/reports/custom/${reportId}/favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/reports/index.blade.php ENDPATH**/ ?>