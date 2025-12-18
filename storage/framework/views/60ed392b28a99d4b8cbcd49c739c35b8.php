<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, viewport-fit=cover">
    <meta name="theme-color" content="#2563eb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/icon-192x192.png')); ?>">

    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body {
            -webkit-tap-highlight-color: transparent;
            overscroll-behavior-y: none;
        }
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom);
        }
        .pt-safe {
            padding-top: env(safe-area-inset-top);
        }
        /* Hide scrollbar for clean UI */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">
    
    <!-- Main Content -->
    <main class="flex-1 p-4 pt-safe">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 left-4 right-4 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/mobile-app.js')); ?>"></script>
    <script>
        // Initialize Mobile App
        document.addEventListener('DOMContentLoaded', () => {
            window.app = new ChurchMobileApp();
            
            // Handle Toast from Session
            <?php if(session('success')): ?>
                app.showToast("<?php echo e(session('success')); ?>", 'success');
            <?php endif; ?>
            <?php if(session('error')): ?>
                app.showToast("<?php echo e(session('error')); ?>", 'error');
            <?php endif; ?>
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/layouts/mobile.blade.php ENDPATH**/ ?>