<?php $__env->startSection('title', 'Partnerships'); ?>

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Partnerships Dashboard</h1>
        <div class="flex gap-2">
            <a href="<?php echo e(route('partnerships.partners')); ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm font-medium">
                Manage Partners
            </a>
            <a href="<?php echo e(route('partnerships.agreements')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
                Agreements
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Partners</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['total_partners'] ?? 0)); ?></h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Active Agreements</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['active_agreements'] ?? 0)); ?></h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending Renewals</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['pending_renewals'] ?? 0)); ?></h3>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/partnerships/index.blade.php ENDPATH**/ ?>