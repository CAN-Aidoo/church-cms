<?php $__env->startSection('title', 'Record Transaction'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Record Transaction</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('transactions.index')); ?>">Transactions</a>
            <span>/</span>
            <span>Record Transaction</span>
        </nav>
    </div>
</div>

<form action="<?php echo e(route('transactions.store')); ?>" method="POST" enctype="multipart/form-data" class="max-w-4xl">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Transaction Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaction Details</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="transaction_date" class="form-label required">Transaction Date</label>
                            <input type="date" id="transaction_date" name="transaction_date"
                                   value="<?php echo e(old('transaction_date', date('Y-m-d'))); ?>"
                                   class="form-input <?php $__errorArgs = ['transaction_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required>
                            <?php $__errorArgs = ['transaction_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="transaction_type" class="form-label required">Type</label>
                            <select id="transaction_type" name="transaction_type"
                                    class="form-select <?php $__errorArgs = ['transaction_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required x-data x-on:change="updateCategories($event.target.value)">
                                <option value="">Select Type</option>
                                <option value="income" <?php echo e(old('transaction_type') === 'income' ? 'selected' : ''); ?>>Income</option>
                                <option value="expense" <?php echo e(old('transaction_type') === 'expense' ? 'selected' : ''); ?>>Expense</option>
                            </select>
                            <?php $__errorArgs = ['transaction_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="category" class="form-label required">Category</label>
                            <select id="category" name="category"
                                    class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                <option value="">Select Category</option>
                                <optgroup label="Income Categories" id="income-categories" style="display:none;">
                                    <option value="tithe">Tithe</option>
                                    <option value="offering">Offering</option>
                                    <option value="donation">Donation</option>
                                    <option value="pledge">Pledge</option>
                                    <option value="fundraising">Fundraising</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="other_income">Other Income</option>
                                </optgroup>
                                <optgroup label="Expense Categories" id="expense-categories" style="display:none;">
                                    <option value="salary">Salary & Wages</option>
                                    <option value="utilities">Utilities</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="events">Events & Programs</option>
                                    <option value="administration">Administration</option>
                                    <option value="welfare">Welfare</option>
                                    <option value="missions">Missions</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="other_expense">Other Expense</option>
                                </optgroup>
                            </select>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="amount" class="form-label required">Amount (GHS)</label>
                            <input type="number" id="amount" name="amount"
                                   value="<?php echo e(old('amount')); ?>"
                                   step="0.01" min="0.01"
                                   class="form-input <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required>
                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="payment_method" class="form-label required">Payment Method</label>
                            <select id="payment_method" name="payment_method"
                                    class="form-select <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                <option value="">Select Method</option>
                                <option value="cash" <?php echo e(old('payment_method') === 'cash' ? 'selected' : ''); ?>>Cash</option>
                                <option value="cheque" <?php echo e(old('payment_method') === 'cheque' ? 'selected' : ''); ?>>Cheque</option>
                                <option value="bank_transfer" <?php echo e(old('payment_method') === 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                                <option value="mobile_money" <?php echo e(old('payment_method') === 'mobile_money' ? 'selected' : ''); ?>>Mobile Money</option>
                                <option value="card" <?php echo e(old('payment_method') === 'card' ? 'selected' : ''); ?>>Card</option>
                                <option value="other" <?php echo e(old('payment_method') === 'other' ? 'selected' : ''); ?>>Other</option>
                            </select>
                            <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" id="reference_number" name="reference_number"
                                   value="<?php echo e(old('reference_number')); ?>"
                                   placeholder="e.g., CHQ123456"
                                   class="form-input <?php $__errorArgs = ['reference_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['reference_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="form-label required">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="form-textarea <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      required><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="2"
                                      class="form-textarea <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('notes')); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Member Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Member (Optional)</h3>
                </div>
                <div class="card-body">
                    <div>
                        <label for="member_id" class="form-label">Select Member</label>
                        <select id="member_id" name="member_id"
                                class="form-select <?php $__errorArgs = ['member_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Anonymous/No Member</option>
                            <?php if($member ?? false): ?>
                            <option value="<?php echo e($member->id); ?>" selected><?php echo e($member->full_name); ?></option>
                            <?php endif; ?>
                        </select>
                        <?php $__errorArgs = ['member_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="form-error"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="text-xs text-gray-500 mt-1">Leave blank for anonymous donations or general expenses</p>
                    </div>
                </div>
            </div>

            <!-- Receipt Upload -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Receipt/Document</h3>
                </div>
                <div class="card-body" x-data="{ fileName: '' }">
                    <input type="file" id="receipt" name="receipt"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="hidden"
                           @change="fileName = $event.target.files[0]?.name || ''">
                    <label for="receipt" class="btn btn-outline w-full cursor-pointer justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span x-text="fileName || 'Upload Receipt'"></span>
                    </label>
                    <?php $__errorArgs = ['receipt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error mt-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="text-xs text-gray-500 mt-2">PDF, JPG, PNG up to 2MB</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body space-y-3">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Record Transaction
                    </button>
                    <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-secondary w-full">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function updateCategories(type) {
    const incomeCategories = document.getElementById('income-categories');
    const expenseCategories = document.getElementById('expense-categories');
    const categorySelect = document.getElementById('category');

    categorySelect.value = '';

    if (type === 'income') {
        incomeCategories.style.display = 'block';
        expenseCategories.style.display = 'none';
    } else if (type === 'expense') {
        incomeCategories.style.display = 'none';
        expenseCategories.style.display = 'block';
    } else {
        incomeCategories.style.display = 'none';
        expenseCategories.style.display = 'none';
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/transactions/create.blade.php ENDPATH**/ ?>