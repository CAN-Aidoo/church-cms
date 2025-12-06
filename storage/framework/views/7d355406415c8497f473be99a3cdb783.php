<?php $__env->startSection('title', 'System Backups'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">System Backups</h1>
            <p class="mt-2 text-sm text-gray-600">Create and manage system backups for data protection</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('settings.index')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Back to Settings
            </a>
            <button type="button"
                    @click="$dispatch('open-create-modal')"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Create Backup
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Backup Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Backups</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($backups->total()); ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-green-900 mt-1"><?php echo e($backups->where('status', 'completed')->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">In Progress</p>
                    <p class="text-2xl font-bold text-yellow-900 mt-1"><?php echo e($backups->where('status', 'in_progress')->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Failed</p>
                    <p class="text-2xl font-bold text-red-900 mt-1"><?php echo e($backups->where('status', 'failed')->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Backups List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filename</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <!-- Filename -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900"><?php echo e($backup->filename); ?></span>
                                </div>
                            </td>

                            <!-- Type -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e($backup->type === 'full' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                    <?php echo e($backup->type === 'database' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($backup->type === 'files' ? 'bg-purple-100 text-purple-800' : ''); ?>">
                                    <?php echo e(ucfirst($backup->type)); ?>

                                </span>
                            </td>

                            <!-- Size -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if($backup->size > 0): ?>
                                    <?php echo e(number_format($backup->size / 1024 / 1024, 2)); ?> MB
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e($backup->status === 'completed' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($backup->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                    <?php echo e($backup->status === 'failed' ? 'bg-red-100 text-red-800' : ''); ?>

                                    <?php echo e($backup->status === 'pending' ? 'bg-gray-100 text-gray-800' : ''); ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $backup->status))); ?>

                                </span>
                            </td>

                            <!-- Created -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div><?php echo e($backup->created_at->format('M d, Y')); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($backup->created_at->format('h:i A')); ?></div>
                            </td>

                            <!-- Created By -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($backup->creator->name ?? 'System'); ?>

                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <?php if($backup->status === 'completed'): ?>
                                        <a href="<?php echo e(route('settings.download-backup', $backup)); ?>"
                                           class="text-blue-600 hover:text-blue-800 font-medium">
                                            Download
                                        </a>
                                    <?php endif; ?>

                                    <?php if($backup->status === 'failed'): ?>
                                        <button type="button"
                                                @click="alert('Error: <?php echo e(addslashes($backup->error_message ?? 'Unknown error')); ?>')"
                                                class="text-red-600 hover:text-red-800 font-medium">
                                            View Error
                                        </button>
                                    <?php endif; ?>

                                    <form action="<?php echo e(route('settings.delete-backup', $backup)); ?>"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this backup? This action cannot be undone.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No backups found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating your first backup.</p>
                                <button type="button"
                                        @click="$dispatch('open-create-modal')"
                                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Create Backup
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($backups->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($backups->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <!-- Information Card -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">About System Backups</h4>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Regular backups are essential for data protection. Three types of backups are available:</p>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li><strong>Full Backup:</strong> Complete system backup including database and files</li>
                        <li><strong>Database Only:</strong> Backup of all database tables and data</li>
                        <li><strong>Files Only:</strong> Backup of uploaded files and media</li>
                    </ul>
                    <p class="mt-2">Backups are processed in the background queue. You'll be notified when they're complete.</p>
                    <p class="mt-2 font-medium">Recommended: Create full backups weekly and database backups daily.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Backup Modal -->
<div x-data="{ open: false }"
     @open-create-modal.window="open = true"
     @keydown.escape.window="open = false"
     x-show="open"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div x-show="open"
             @click="open = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <!-- Modal panel -->
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?php echo e(route('settings.create-backup')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Create New Backup
                            </h3>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Select Backup Type</label>
                                <div class="space-y-3">
                                    <label class="flex items-start p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="type" value="full" class="mt-1" required>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">Full Backup</div>
                                            <div class="text-xs text-gray-500">Complete backup of database and files (Recommended)</div>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="type" value="database" class="mt-1" required>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">Database Only</div>
                                            <div class="text-xs text-gray-500">Backup all database tables and data</div>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="type" value="files" class="mt-1" required>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">Files Only</div>
                                            <div class="text-xs text-gray-500">Backup uploaded files and media</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Create Backup
                    </button>
                    <button type="button"
                            @click="open = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/settings/backups.blade.php ENDPATH**/ ?>