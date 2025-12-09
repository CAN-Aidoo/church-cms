<?php $__env->startSection('title', 'Program Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Program Reports</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('reports.index')); ?>">Reports</a>
            <span>/</span>
            <span>Program Reports</span>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.program.performance')); ?>" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="draft" <?php echo e(($filters['status'] ?? '') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                    <option value="published" <?php echo e(($filters['status'] ?? '') === 'published' ? 'selected' : ''); ?>>Published</option>
                    <option value="ongoing" <?php echo e(($filters['status'] ?? '') === 'ongoing' ? 'selected' : ''); ?>>Ongoing</option>
                    <option value="completed" <?php echo e(($filters['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="cancelled" <?php echo e(($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </div>
            <div>
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="worship" <?php echo e(($filters['category'] ?? '') === 'worship' ? 'selected' : ''); ?>>Worship</option>
                    <option value="outreach" <?php echo e(($filters['category'] ?? '') === 'outreach' ? 'selected' : ''); ?>>Outreach</option>
                    <option value="training" <?php echo e(($filters['category'] ?? '') === 'training' ? 'selected' : ''); ?>>Training</option>
                    <option value="social" <?php echo e(($filters['category'] ?? '') === 'social' ? 'selected' : ''); ?>>Social</option>
                    <option value="youth" <?php echo e(($filters['category'] ?? '') === 'youth' ? 'selected' : ''); ?>>Youth</option>
                    <option value="children" <?php echo e(($filters['category'] ?? '') === 'children' ? 'selected' : ''); ?>>Children</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Programs</p>
            <p class="text-3xl font-bold text-blue-600"><?php echo e($data['total_programs'] ?? 0); ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Participants</p>
            <p class="text-3xl font-bold text-green-600"><?php echo e($data['total_participants'] ?? 0); ?></p>
        </div>
    </div>
</div>

<!-- By Status -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Status</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($data['by_status'])): ?>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <?php $__currentLoopData = $data['by_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <p class="text-sm text-gray-600 capitalize"><?php echo e($status); ?></p>
                        <p class="text-2xl font-bold"><?php echo e($count); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">No status data available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- By Category -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Category</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($data['by_category'])): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $data['by_category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 capitalize"><?php echo e($category); ?></p>
                        <p class="text-2xl font-bold"><?php echo e($count); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">No category data available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Programs List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Programs (<?php echo e(count($data['programs'] ?? [])); ?>)</h3>
    </div>
    <div class="card-body p-0">
        <?php if(!empty($data['programs']) && count($data['programs']) > 0): ?>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>Category</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th class="text-right">Participants</th>
                            <th class="text-right">Sessions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data['programs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('programs.show', $program->id)); ?>" class="text-blue-600 hover:underline">
                                        <?php echo e($program->name); ?>

                                    </a>
                                </td>
                                <td class="capitalize"><?php echo e($program->category ?? 'N/A'); ?></td>
                                <td><?php echo e($program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('M d, Y') : 'N/A'); ?></td>
                                <td><?php echo e($program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('M d, Y') : 'N/A'); ?></td>
                                <td>
                                    <span class="badge
                                        <?php if($program->status === 'ongoing'): ?> badge-primary
                                        <?php elseif($program->status === 'completed'): ?> badge-success
                                        <?php elseif($program->status === 'cancelled'): ?> badge-danger
                                        <?php else: ?> badge-secondary
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($program->status)); ?>

                                    </span>
                                </td>
                                <td class="text-right"><?php echo e($program->registrations->count() ?? 0); ?></td>
                                <td class="text-right"><?php echo e($program->sessions->count() ?? 0); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">No programs found matching the selected filters.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/reports/program.blade.php ENDPATH**/ ?>