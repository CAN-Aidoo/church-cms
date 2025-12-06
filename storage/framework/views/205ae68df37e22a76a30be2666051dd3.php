<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">SMS Broadcasts</h1>
            <p class="text-gray-600 mt-1">Send mass SMS messages to members</p>
        </div>
        <a href="<?php echo e(route('sms.create')); ?>" class="btn btn-primary">
            <i class="fas fa-paper-plane mr-2"></i>New Broadcast
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
                <p class="text-xs text-gray-600">Total</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <p class="text-2xl font-bold text-gray-600"><?php echo e($stats['draft']); ?></p>
                <p class="text-xs text-gray-600">Draft</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['scheduled']); ?></p>
                <p class="text-xs text-gray-600">Scheduled</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['sending']); ?></p>
                <p class="text-xs text-gray-600">Sending</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <p class="text-2xl font-bold text-green-600"><?php echo e($stats['completed']); ?></p>
                <p class="text-xs text-gray-600">Completed</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <p class="text-2xl font-bold text-red-600"><?php echo e($stats['failed']); ?></p>
                <p class="text-xs text-gray-600">Failed</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('sms.index')); ?>" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text"
                           name="search"
                           id="search"
                           value="<?php echo e(request('search')); ?>"
                           placeholder="Title or message..."
                           class="form-input w-full">
                </div>

                <div class="w-48">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="form-select w-full">
                        <option value="">All Statuses</option>
                        <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="scheduled" <?php echo e(request('status') == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="sending" <?php echo e(request('status') == 'sending' ? 'selected' : ''); ?>>Sending</option>
                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter mr-1"></i>Filter
                    </button>
                    <a href="<?php echo e(route('sms.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-redo mr-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Broadcasts List -->
    <?php if($broadcasts->count() > 0): ?>
    <div class="space-y-4">
        <?php $__currentLoopData = $broadcasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $broadcast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-800"><?php echo e($broadcast->title); ?></h3>
                            <span class="badge
                                <?php if($broadcast->status === 'completed'): ?> badge-success
                                <?php elseif($broadcast->status === 'sending'): ?> badge-info
                                <?php elseif($broadcast->status === 'scheduled'): ?> badge-warning
                                <?php elseif($broadcast->status === 'failed'): ?> badge-danger
                                <?php else: ?> badge-secondary
                                <?php endif; ?>">
                                <?php echo e(ucfirst($broadcast->status)); ?>

                            </span>
                        </div>

                        <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?php echo e($broadcast->message); ?></p>

                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-users w-5"></i>
                                <span><?php echo e(number_format($broadcast->recipient_count)); ?> recipients</span>
                            </div>

                            <?php if($broadcast->sent_count > 0): ?>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-check-circle text-green-600 w-5"></i>
                                <span><?php echo e(number_format($broadcast->sent_count)); ?> sent</span>
                            </div>
                            <?php endif; ?>

                            <?php if($broadcast->failed_count > 0): ?>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-exclamation-circle text-red-600 w-5"></i>
                                <span><?php echo e(number_format($broadcast->failed_count)); ?> failed</span>
                            </div>
                            <?php endif; ?>

                            <div class="flex items-center gap-1">
                                <i class="fas fa-user w-5"></i>
                                <span><?php echo e($broadcast->sender->full_name); ?></span>
                            </div>

                            <div class="flex items-center gap-1">
                                <i class="fas fa-clock w-5"></i>
                                <span>
                                    <?php if($broadcast->status === 'scheduled'): ?>
                                    Scheduled: <?php echo e($broadcast->scheduled_at->format('M d, Y H:i')); ?>

                                    <?php else: ?>
                                    <?php echo e($broadcast->created_at->format('M d, Y H:i')); ?>

                                    <?php endif; ?>
                                </span>
                            </div>

                            <?php if($broadcast->estimated_cost): ?>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-money-bill-wave w-5"></i>
                                <span>GHS <?php echo e(number_format($broadcast->estimated_cost, 2)); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 ml-4">
                        <a href="<?php echo e(route('sms.show', $broadcast)); ?>" class="btn btn-sm btn-secondary whitespace-nowrap">
                            <i class="fas fa-eye mr-1"></i>View Details
                        </a>

                        <?php if($broadcast->status === 'scheduled' || $broadcast->status === 'draft'): ?>
                        <form method="POST" action="<?php echo e(route('sms.send', $broadcast)); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-primary w-full" onclick="return confirm('Send this broadcast now?')">
                                <i class="fas fa-paper-plane mr-1"></i>Send Now
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Progress Bar for Sending Status -->
                <?php if($broadcast->status === 'sending' && $broadcast->recipient_count > 0): ?>
                <div class="mt-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Sending progress</span>
                        <span><?php echo e(number_format(($broadcast->sent_count / $broadcast->recipient_count) * 100, 1)); ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all"
                             style="width: <?php echo e(($broadcast->sent_count / $broadcast->recipient_count) * 100); ?>%"></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($broadcasts->links()); ?>

    </div>
    <?php else: ?>
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-paper-plane text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">No SMS broadcasts found</p>
            <a href="<?php echo e(route('sms.create')); ?>" class="btn btn-primary mt-4">
                <i class="fas fa-plus mr-2"></i>Create First Broadcast
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/sms/index.blade.php ENDPATH**/ ?>