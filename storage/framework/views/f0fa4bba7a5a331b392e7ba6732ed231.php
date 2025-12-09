<?php $__env->startSection('title', 'Financial Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Financial Reports</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('reports.index')); ?>">Reports</a>
            <span>/</span>
            <span>Financial Reports</span>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.financial.income')); ?>" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>" class="form-input">
            </div>
            <div>
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>" class="form-input">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Income</p>
            <p class="text-3xl font-bold text-green-600">GHS <?php echo e(number_format($data['total_income'] ?? 0, 2)); ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Expenses</p>
            <p class="text-3xl font-bold text-red-600">GHS <?php echo e(number_format($data['total_expenses'] ?? 0, 2)); ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Net Balance</p>
            <p class="text-3xl font-bold <?php echo e(($data['net_balance'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                GHS <?php echo e(number_format($data['net_balance'] ?? 0, 2)); ?>

            </p>
        </div>
    </div>
</div>

<!-- By Category -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Category</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($data['by_category'])): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php $__currentLoopData = $data['by_category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <h4 class="font-semibold mb-3 capitalize"><?php echo e($type); ?></h4>
                        <div class="space-y-2">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm"><?php echo e($item['category'] ?? 'Uncategorized'); ?></span>
                                    <span class="font-semibold">GHS <?php echo e(number_format($item['total'] ?? 0, 2)); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">No financial data available for the selected period.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Monthly Trend -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Monthly Trend</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($data['by_month'])): ?>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-right">Income</th>
                            <th class="text-right">Expenses</th>
                            <th class="text-right">Net</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data['by_month']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $types): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $income = collect($types)->where('transaction_type', 'income')->sum('total');
                                $expenses = collect($types)->where('transaction_type', 'expense')->sum('total');
                                $net = $income - $expenses;
                            ?>
                            <tr>
                                <td><?php echo e(\Carbon\Carbon::parse($month . '-01')->format('F Y')); ?></td>
                                <td class="text-right text-green-600">GHS <?php echo e(number_format($income, 2)); ?></td>
                                <td class="text-right text-red-600">GHS <?php echo e(number_format($expenses, 2)); ?></td>
                                <td class="text-right font-semibold <?php echo e($net >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    GHS <?php echo e(number_format($net, 2)); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">No monthly data available.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/reports/financial.blade.php ENDPATH**/ ?>