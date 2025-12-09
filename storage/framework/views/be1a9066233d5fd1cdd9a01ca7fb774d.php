<?php $__env->startSection('title', 'Messaging'); ?>

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Messaging</h1>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
                New Message
            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-[600px] flex overflow-hidden">
        
        <div class="w-1/3 border-r border-gray-100 flex flex-col">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <input type="text" placeholder="Search conversations..." class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="flex-1 overflow-y-auto">
                <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('messaging.conversation', $conversation)); ?>" class="block p-4 hover:bg-gray-50 border-b border-gray-50 transition-colors <?php echo e(request()->route('conversation')?->id === $conversation->id ? 'bg-blue-50' : ''); ?>">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-sm font-semibold text-gray-900 truncate"><?php echo e($conversation->name ?? 'Direct Message'); ?></h4>
                            <span class="text-xs text-gray-400"><?php echo e($conversation->updated_at->format('M d')); ?></span>
                        </div>
                        <p class="text-xs text-gray-500 truncate"><?php echo e($conversation->last_message_content ?? 'No messages yet'); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-8 text-center text-gray-500 text-sm">No conversations found.</div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="flex-1 flex items-center justify-center bg-gray-50">
            <div class="text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <p class="text-lg font-medium">Select a conversation</p>
                <p class="text-sm mt-1">Or start a new one</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/messaging/index.blade.php ENDPATH**/ ?>