<?php $__env->startSection('title', 'Financial Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Financial Reports</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('transactions.index')); ?>">Transactions</a>
            <span>/</span>
            <span>Reports</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="<?php echo e(route('transactions.export', $filters)); ?>" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export Report
        </a>
        <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            View Transactions
        </a>
    </div>
</div>

<!-- Date Range Filter -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('transactions.reports')); ?>" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from"
                       value="<?php echo e($filters['date_from']); ?>"
                       class="form-input">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to"
                       value="<?php echo e($filters['date_to']); ?>"
                       class="form-input">
            </div>
            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply
            </button>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card bg-gradient-primary">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS <?php echo e(number_format($summary['total_income'], 2)); ?></div>
            <div class="stat-label">Total Income</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-red-500 to-red-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS <?php echo e(number_format($summary['total_expenses'], 2)); ?></div>
            <div class="stat-label">Total Expenses</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-gold">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value <?php echo e($summary['net_balance'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                GHS <?php echo e(number_format($summary['net_balance'], 2)); ?>

            </div>
            <div class="stat-label">Net Balance</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS <?php echo e(number_format($summary['pending_amount'], 2)); ?></div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Monthly Trends Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Monthly Trends (Last 12 Months)</h3>
        </div>
        <div class="card-body">
            <canvas id="monthlyTrendsChart" height="300"></canvas>
        </div>
    </div>

    <!-- Income vs Expense Pie Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Income vs Expenses</h3>
        </div>
        <div class="card-body">
            <canvas id="incomeExpensePieChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Breakdown Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Income Breakdown -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Income Breakdown</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalIncome = array_sum($incomeBreakdown);
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $incomeBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="capitalize font-medium"><?php echo e(str_replace('_', ' ', $category)); ?></td>
                            <td class="text-right">GHS <?php echo e(number_format($amount, 2)); ?></td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="flex-1 max-w-[100px] bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full"
                                             style="width: <?php echo e($totalIncome > 0 ? ($amount / $totalIncome * 100) : 0); ?>%"></div>
                                    </div>
                                    <span class="text-sm"><?php echo e($totalIncome > 0 ? number_format($amount / $totalIncome * 100, 1) : 0); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">No income recorded in this period</td>
                        </tr>
                        <?php endif; ?>
                        <?php if(count($incomeBreakdown) > 0): ?>
                        <tr class="font-bold bg-gray-50">
                            <td>Total Income</td>
                            <td class="text-right">GHS <?php echo e(number_format($totalIncome, 2)); ?></td>
                            <td class="text-right">100%</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expense Breakdown -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Expense Breakdown</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalExpenses = array_sum($expenseBreakdown);
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $expenseBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="capitalize font-medium"><?php echo e(str_replace('_', ' ', $category)); ?></td>
                            <td class="text-right">GHS <?php echo e(number_format($amount, 2)); ?></td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="flex-1 max-w-[100px] bg-gray-200 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full"
                                             style="width: <?php echo e($totalExpenses > 0 ? ($amount / $totalExpenses * 100) : 0); ?>%"></div>
                                    </div>
                                    <span class="text-sm"><?php echo e($totalExpenses > 0 ? number_format($amount / $totalExpenses * 100, 1) : 0); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">No expenses recorded in this period</td>
                        </tr>
                        <?php endif; ?>
                        <?php if(count($expenseBreakdown) > 0): ?>
                        <tr class="font-bold bg-gray-50">
                            <td>Total Expenses</td>
                            <td class="text-right">GHS <?php echo e(number_format($totalExpenses, 2)); ?></td>
                            <td class="text-right">100%</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Top Donors -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">Top Donors (Current Period)</h3>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Member</th>
                        <th>Member ID</th>
                        <th class="text-right">Total Given</th>
                        <th class="text-right">Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $topDonors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php if($index === 0): ?>
                            <span class="text-2xl">🥇</span>
                            <?php elseif($index === 1): ?>
                            <span class="text-2xl">🥈</span>
                            <?php elseif($index === 2): ?>
                            <span class="text-2xl">🥉</span>
                            <?php else: ?>
                            <span class="text-gray-500">#<?php echo e($index + 1); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('members.show', $donor['member'])); ?>" class="text-blue-600 hover:underline font-medium">
                                <?php echo e($donor['member']->full_name); ?>

                            </a>
                        </td>
                        <td class="text-gray-600"><?php echo e($donor['member']->member_id); ?></td>
                        <td class="text-right font-semibold">GHS <?php echo e(number_format($donor['total_given'], 2)); ?></td>
                        <td class="text-right text-gray-600"><?php echo e($donor['member']->transactions()->count()); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500">
                            No donor data available for this period
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pending Approvals (Admin/Pastor Only) -->
<?php if(auth()->user()->hasAnyRole(['admin', 'pastor']) && count($pendingApprovals) > 0): ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pending Approvals</h3>
        <a href="<?php echo e(route('transactions.pending')); ?>" class="text-blue-600 hover:underline text-sm">
            View All
        </a>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Recorded By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pendingApprovals->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="whitespace-nowrap"><?php echo e($transaction->transaction_date->format('M d, Y')); ?></td>
                        <td>
                            <?php if($transaction->transaction_type === 'income'): ?>
                            <span class="badge badge-success">Income</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Expense</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(Str::limit($transaction->description, 40)); ?></td>
                        <td class="font-semibold whitespace-nowrap">GHS <?php echo e(number_format($transaction->amount, 2)); ?></td>
                        <td><?php echo e($transaction->recorder->full_name ?? 'System'); ?></td>
                        <td class="whitespace-nowrap">
                            <a href="<?php echo e(route('transactions.show', $transaction)); ?>" class="btn btn-sm btn-primary">
                                Review
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Trends Chart
const trendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
const trendsData = <?php echo json_encode($trends, 15, 512) ?>;
const trendsLabels = Object.keys(trendsData);
const incomeData = trendsLabels.map(label => trendsData[label].income);
const expenseData = trendsLabels.map(label => trendsData[label].expenses);
const netData = trendsLabels.map(label => trendsData[label].net);

new Chart(trendsCtx, {
    type: 'line',
    data: {
        labels: trendsLabels,
        datasets: [{
            label: 'Income',
            data: incomeData,
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.4
        }, {
            label: 'Expenses',
            data: expenseData,
            borderColor: 'rgb(239, 68, 68)',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4
        }, {
            label: 'Net Balance',
            data: netData,
            borderColor: 'rgb(234, 179, 8)',
            backgroundColor: 'rgba(234, 179, 8, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'GHS ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Income vs Expense Pie Chart
const pieCtx = document.getElementById('incomeExpensePieChart').getContext('2d');
new Chart(pieCtx, {
    type: 'doughnut',
    data: {
        labels: ['Income', 'Expenses'],
        datasets: [{
            data: [<?php echo e($summary['total_income']); ?>, <?php echo e($summary['total_expenses']); ?>],
            backgroundColor: [
                'rgb(34, 197, 94)',
                'rgb(239, 68, 68)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        return label + ': GHS ' + value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                }
            }
        }
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/transactions/reports.blade.php ENDPATH**/ ?>