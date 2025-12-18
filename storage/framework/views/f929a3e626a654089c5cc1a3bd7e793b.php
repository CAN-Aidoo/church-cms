<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 pb-safe z-50">
    <div class="flex justify-around items-center h-16">
        <a href="<?php echo e(url('/mobile/dashboard')); ?>" class="flex flex-col items-center justify-center w-full h-full <?php echo e(request()->is('mobile/dashboard') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600'); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="<?php echo e(url('/mobile/service-unit')); ?>" class="flex flex-col items-center justify-center w-full h-full <?php echo e(request()->is('mobile/service-unit*') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600'); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span class="text-xs mt-1">Units</span>
        </a>
         <a href="<?php echo e(url('/mobile/check-in')); ?>" class="flex flex-col items-center justify-center w-full h-full <?php echo e(request()->is('mobile/check-in') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600'); ?>">
            <div class="bg-blue-600 text-white rounded-full p-2 -mt-6 shadow-lg border-4 border-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 17h.01M9 20h.01M12 20h.01M12 17h.01M12 14h.01M15 11h.01M15 14h.01" />
                </svg>
            </div>
            <span class="text-xs mt-1">Scan</span>
        </a>
        <a href="<?php echo e(url('/mobile/give')); ?>" class="flex flex-col items-center justify-center w-full h-full <?php echo e(request()->is('mobile/give') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600'); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-xs mt-1">Give</span>
        </a>
        <a href="<?php echo e(url('/mobile/profile')); ?>" class="flex flex-col items-center justify-center w-full h-full <?php echo e(request()->is('mobile/profile') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600'); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-xs mt-1">Profile</span>
        </a>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/layouts/partials/mobile-nav.blade.php ENDPATH**/ ?>