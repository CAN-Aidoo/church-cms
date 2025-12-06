<?php $__env->startSection('title', 'Email Templates'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Email Templates</h1>
            <p class="mt-2 text-sm text-gray-600">Manage and customize email templates for automated communications</p>
        </div>
        <a href="<?php echo e(route('settings.index')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            Back to Settings
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Filter by Category -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <div class="flex items-center gap-4">
            <label class="text-sm font-medium text-gray-700">Filter by Category:</label>
            <div class="flex flex-wrap gap-2" x-data="{ activeCategory: 'all' }">
                <button @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    All Templates
                </button>
                <button @click="activeCategory = 'member'"
                        :class="activeCategory === 'member' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Member
                </button>
                <button @click="activeCategory = 'finance'"
                        :class="activeCategory === 'finance' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Finance
                </button>
                <button @click="activeCategory = 'event'"
                        :class="activeCategory === 'event' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Events
                </button>
                <button @click="activeCategory = 'notification'"
                        :class="activeCategory === 'notification' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Notifications
                </button>
            </div>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200">
                <!-- Template Header -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1"><?php echo e($template->name); ?></h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php echo e($template->category === 'member' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                <?php echo e($template->category === 'finance' ? 'bg-green-100 text-green-800' : ''); ?>

                                <?php echo e($template->category === 'event' ? 'bg-purple-100 text-purple-800' : ''); ?>

                                <?php echo e($template->category === 'notification' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                <?php echo e(!in_array($template->category, ['member', 'finance', 'event', 'notification']) ? 'bg-gray-100 text-gray-800' : ''); ?>">
                                <?php echo e(ucfirst($template->category)); ?>

                            </span>
                        </div>
                        <div class="ml-2">
                            <?php if($template->is_active): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Subject Preview -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Subject:</label>
                        <p class="text-sm text-gray-700 truncate"><?php echo e($template->subject); ?></p>
                    </div>

                    <!-- Available Variables -->
                    <?php if($template->available_variables && count($template->available_variables) > 0): ?>
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-500 mb-2">Available Variables:</label>
                            <div class="flex flex-wrap gap-1">
                                <?php $__currentLoopData = $template->available_variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono bg-gray-100 text-gray-700">
                                        <?php echo e('{' . '{' . $variable . '}' . '}'); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Body Preview -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Body Preview:</label>
                        <div class="text-sm text-gray-600 line-clamp-3">
                            <?php echo Str::limit(strip_tags($template->body_html), 120); ?>

                        </div>
                    </div>
                </div>

                <!-- Template Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        Updated <?php echo e($template->updated_at->diffForHumans()); ?>

                    </div>
                    <a href="<?php echo e(route('settings.edit-email-template', $template)); ?>"
                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No email templates</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first email template.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Template Information -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">About Email Templates</h4>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Email templates are used throughout the system for automated communications:</p>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li><strong>Member templates:</strong> Welcome emails, status changes, notifications</li>
                        <li><strong>Finance templates:</strong> Giving receipts, pledge reminders, statements</li>
                        <li><strong>Event templates:</strong> Event invitations, reminders, confirmations</li>
                        <li><strong>Notification templates:</strong> System alerts, reports, summaries</li>
                    </ul>
                    <p class="mt-2">Use the provided variables in double curly braces (e.g., <code class="bg-blue-100 px-1 rounded"><?php echo e(name); ?></code>) to personalize messages.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('templateFilters', () => ({
        activeCategory: 'all'
    }))
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/settings/email-templates.blade.php ENDPATH**/ ?>