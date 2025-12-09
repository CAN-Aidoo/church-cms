<?php $__env->startSection('title', 'Prayer Requests'); ?>

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Prayer Requests</h1>
        <a href="<?php echo e(route('prayer.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
            Submit Request
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Active Requests</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['total_active'] ?? 0)); ?></h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Urgent</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['urgent'] ?? 0)); ?></h3>
                </div>
                <div class="p-2 bg-red-50 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['pending'] ?? 0)); ?></h3>
                </div>
                <div class="p-2 bg-yellow-50 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Answered (Month)</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($statistics['answered_this_month'] ?? 0)); ?></h3>
                </div>
                <div class="p-2 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-900 text-sm">Recent Requests</h3>
                
                <form action="<?php echo e(route('prayer.index')); ?>" method="GET" class="flex gap-2">
                    <select name="urgency" class="text-xs rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" onchange="this.form.submit()">
                        <option value="">All Urgency</option>
                        <option value="critical" <?php echo e(request('urgency') == 'critical' ? 'selected' : ''); ?>>Critical</option>
                        <option value="high" <?php echo e(request('urgency') == 'high' ? 'selected' : ''); ?>>High</option>
                        <option value="normal" <?php echo e(request('urgency') == 'normal' ? 'selected' : ''); ?>>Normal</option>
                        <option value="low" <?php echo e(request('urgency') == 'low' ? 'selected' : ''); ?>>Low</option>
                    </select>
                    
                    <select name="status" class="text-xs rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="answered" <?php echo e(request('status') == 'answered' ? 'selected' : ''); ?>>Answered</option>
                    </select>
                </form>
            </div>
            
            <div class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $prayerRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 text-xs rounded-full 
                                    <?php echo e($request->urgency === 'critical' ? 'bg-red-100 text-red-800' : 
                                      ($request->urgency === 'high' ? 'bg-orange-100 text-orange-800' : 
                                      'bg-blue-100 text-blue-800')); ?>">
                                    <?php echo e(ucfirst($request->urgency)); ?>

                                </span>
                                <span class="text-xs text-gray-500"><?php echo e($request->category->name ?? 'General'); ?></span>
                            </div>
                            <span class="text-xs text-gray-400"><?php echo e($request->created_at->diffForHumans()); ?></span>
                        </div>
                        
                        <h4 class="font-semibold text-gray-900 mb-1"><?php echo e($request->request_title); ?></h4>
                        
                        <div class="flex justify-between items-center mt-4">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <?php if($request->is_anonymous): ?>
                                    <span class="italic">Anonymous</span>
                                <?php else: ?>
                                    <span><?php echo e($request->requester_name); ?></span>
                                <?php endif; ?>
                                
                                <?php if($request->assignedIntercessor): ?>
                                    <span class="flex items-center gap-1 bg-gray-100 px-2 py-0.5 rounded">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <?php echo e($request->assignedIntercessor->full_name); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <a href="<?php echo e(route('prayer.show', $request)); ?>" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View Details</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-8 text-center text-gray-500 text-sm">No prayer requests found.</div>
                <?php endif; ?>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100">
                <?php echo e($prayerRequests->links()); ?>

            </div>
        </div>

        
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Categories</h3>
                <div class="space-y-2">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600"><?php echo e($category->name); ?></span>
                            <span class="px-2 py-0.5 bg-gray-100 rounded-full text-xs font-medium text-gray-600"><?php echo e($category->active_requests_count ?? 0); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-xl shadow-sm p-6 text-white">
                <h3 class="font-bold mb-2">Prayer Wall</h3>
                <p class="text-sm text-primary-100 mb-4">Join others in praying for the needs of the church family.</p>
                <a href="<?php echo e(route('prayer.wall')); ?>" class="block w-full py-2 bg-white text-primary-600 text-center rounded-lg font-medium text-sm hover:bg-primary-50 transition-colors">
                    Go to Prayer Wall
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/prayer/index.blade.php ENDPATH**/ ?>