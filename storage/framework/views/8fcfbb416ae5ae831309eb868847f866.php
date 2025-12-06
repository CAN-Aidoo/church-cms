<?php $__env->startSection('title', 'Transactions'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Financial Transactions</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <span>Transactions</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="<?php echo e(route('transactions.reports')); ?>" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        <a href="<?php echo e(route('transactions.export', request()->query())); ?>" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export CSV
        </a>
        <a href="<?php echo e(route('transactions.create')); ?>" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Record Transaction
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card bg-gradient-primary">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS <?php echo e(number_format($summary['total_income'] ?? 0, 2)); ?></div>
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
            <div class="stat-value">GHS <?php echo e(number_format($summary['total_expenses'] ?? 0, 2)); ?></div>
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
            <div class="stat-value">GHS <?php echo e(number_format($summary['net_balance'] ?? 0, 2)); ?></div>
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
            <div class="stat-value"><?php echo e($statistics['pending_count'] ?? 0); ?></div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6" x-data="{ showFilters: false }">
    <div class="card-header">
        <h3 class="card-title">Filters</h3>
        <button @click="showFilters = !showFilters" class="btn btn-sm btn-outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div x-show="showFilters" x-transition class="card-body">
        <form method="GET" action="<?php echo e(route('transactions.index')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from"
                       value="<?php echo e($filters['date_from'] ?? ''); ?>"
                       class="form-input">
            </div>

            <div>
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to"
                       value="<?php echo e($filters['date_to'] ?? ''); ?>"
                       class="form-input">
            </div>

            <div>
                <label for="transaction_type" class="form-label">Type</label>
                <select id="transaction_type" name="transaction_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="income" <?php echo e(($filters['transaction_type'] ?? '') === 'income' ? 'selected' : ''); ?>>Income</option>
                    <option value="expense" <?php echo e(($filters['transaction_type'] ?? '') === 'expense' ? 'selected' : ''); ?>>Expense</option>
                </select>
            </div>

            <div>
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-select">
                    <option value="">All Categories</option>
                    <optgroup label="Income">
                        <option value="tithe" <?php echo e(($filters['category'] ?? '') === 'tithe' ? 'selected' : ''); ?>>Tithe</option>
                        <option value="offering" <?php echo e(($filters['category'] ?? '') === 'offering' ? 'selected' : ''); ?>>Offering</option>
                        <option value="donation" <?php echo e(($filters['category'] ?? '') === 'donation' ? 'selected' : ''); ?>>Donation</option>
                        <option value="pledge" <?php echo e(($filters['category'] ?? '') === 'pledge' ? 'selected' : ''); ?>>Pledge</option>
                        <option value="fundraising" <?php echo e(($filters['category'] ?? '') === 'fundraising' ? 'selected' : ''); ?>>Fundraising</option>
                    </optgroup>
                    <optgroup label="Expense">
                        <option value="salary" <?php echo e(($filters['category'] ?? '') === 'salary' ? 'selected' : ''); ?>>Salary</option>
                        <option value="utilities" <?php echo e(($filters['category'] ?? '') === 'utilities' ? 'selected' : ''); ?>>Utilities</option>
                        <option value="maintenance" <?php echo e(($filters['category'] ?? '') === 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                        <option value="events" <?php echo e(($filters['category'] ?? '') === 'events' ? 'selected' : ''); ?>>Events</option>
                        <option value="missions" <?php echo e(($filters['category'] ?? '') === 'missions' ? 'selected' : ''); ?>>Missions</option>
                    </optgroup>
                </select>
            </div>

            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php echo e(($filters['status'] ?? '') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="completed" <?php echo e(($filters['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="cancelled" <?php echo e(($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="payment_method" class="form-label">Payment Method</label>
                <select id="payment_method" name="payment_method" class="form-select">
                    <option value="">All Methods</option>
                    <option value="cash" <?php echo e(($filters['payment_method'] ?? '') === 'cash' ? 'selected' : ''); ?>>Cash</option>
                    <option value="cheque" <?php echo e(($filters['payment_method'] ?? '') === 'cheque' ? 'selected' : ''); ?>>Cheque</option>
                    <option value="bank_transfer" <?php echo e(($filters['payment_method'] ?? '') === 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                    <option value="mobile_money" <?php echo e(($filters['payment_method'] ?? '') === 'mobile_money' ? 'selected' : ''); ?>>Mobile Money</option>
                    <option value="card" <?php echo e(($filters['payment_method'] ?? '') === 'card' ? 'selected' : ''); ?>>Card</option>
                </select>
            </div>

            <div>
                <label for="search" class="form-label">Search</label>
                <input type="text" id="search" name="search"
                       value="<?php echo e($filters['search'] ?? ''); ?>"
                       placeholder="Description, reference..."
                       class="form-input">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-primary flex-1">
                    Apply Filters
                </button>
                <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-outline">
                    Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Transaction List
            <span class="text-sm text-gray-500 font-normal ml-2">(<?php echo e($transactions->total()); ?> total)</span>
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Member</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="whitespace-nowrap">
                            <?php echo e($transaction->transaction_date->format('M d, Y')); ?>

                        </td>
                        <td>
                            <?php if($transaction->transaction_type === 'income'): ?>
                            <span class="badge badge-success">Income</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Expense</span>
                            <?php endif; ?>
                        </td>
                        <td class="capitalize"><?php echo e(str_replace('_', ' ', $transaction->category)); ?></td>
                        <td>
                            <div class="font-medium"><?php echo e(Str::limit($transaction->description, 40)); ?></div>
                            <?php if($transaction->reference_number): ?>
                            <div class="text-xs text-gray-500">Ref: <?php echo e($transaction->reference_number); ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($transaction->member): ?>
                            <a href="<?php echo e(route('members.show', $transaction->member)); ?>" class="text-blue-600 hover:underline">
                                <?php echo e($transaction->member->full_name); ?>

                            </a>
                            <?php else: ?>
                            <span class="text-gray-400">Anonymous</span>
                            <?php endif; ?>
                        </td>
                        <td class="font-semibold whitespace-nowrap">
                            GHS <?php echo e(number_format($transaction->amount, 2)); ?>

                        </td>
                        <td class="capitalize"><?php echo e(str_replace('_', ' ', $transaction->payment_method)); ?></td>
                        <td>
                            <?php if($transaction->status === 'completed'): ?>
                            <span class="badge badge-success">Completed</span>
                            <?php elseif($transaction->status === 'pending'): ?>
                            <span class="badge badge-warning">Pending</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Cancelled</span>
                            <?php endif; ?>
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('transactions.show', $transaction)); ?>"
                                   class="text-blue-600 hover:text-blue-800" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <?php if($transaction->status === 'pending'): ?>
                                <a href="<?php echo e(route('transactions.edit', $transaction)); ?>"
                                   class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            No transactions found
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($transactions->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($transactions->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/transactions/index.blade.php ENDPATH**/ ?>