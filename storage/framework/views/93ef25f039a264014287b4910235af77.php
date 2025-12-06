<?php $__env->startSection('title', 'Create Service'); ?>

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Schedule New Service</h1>
        <a href="<?php echo e(route('services.index')); ?>" class="text-sm text-gray-500 hover:text-gray-700">Back to List</a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?php echo e(route('services.store')); ?>" method="POST" class="p-6">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required placeholder="e.g. Sunday Celebration Service">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                    <select name="service_type" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                        <option value="regular">Regular Sunday Service</option>
                        <option value="midweek">Midweek Service</option>
                        <option value="special">Special Event</option>
                        <option value="youth">Youth Service</option>
                        <option value="children">Children's Service</option>
                        <option value="prayer_meeting">Prayer Meeting</option>
                        <option value="bible_study">Bible Study</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="service_date" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="time" name="start_time" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="time" name="end_time" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                    <input type="text" name="venue" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="e.g. Main Auditorium">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Theme / Topic</label>
                    <input type="text" name="theme" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preacher</label>
                    <select name="preacher_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Preacher</option>
                        <?php $__currentLoopData = $preachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($preacher->id); ?>"><?php echo e($preacher->full_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expected Attendance</label>
                    <input type="number" name="expected_attendance" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="<?php echo e(route('services.index')); ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">Create Service</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/services/create.blade.php ENDPATH**/ ?>