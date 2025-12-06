<?php $__env->startSection('title', 'Programs & Events'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Programs & Events</h1>
            <p class="text-gray-600 mt-1">Manage church programs, conferences, and special events</p>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\Program::class)): ?>
        <a href="<?php echo e(route('programs.create')); ?>" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Program
        </a>
        <?php endif; ?>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Programs</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($summary['total']); ?></p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Upcoming</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($summary['upcoming']); ?></p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Ongoing</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($summary['ongoing']); ?></p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Completed (Year)</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($summary['completed_this_year']); ?></p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Participants (Year)</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($summary['total_participants_this_year'])); ?></p>
                </div>
                <div class="bg-indigo-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('programs.index')); ?>" class="flex flex-wrap gap-4">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="draft" <?php echo e(($filters['status'] ?? '') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                <option value="published" <?php echo e(($filters['status'] ?? '') === 'published' ? 'selected' : ''); ?>>Published</option>
                <option value="ongoing" <?php echo e(($filters['status'] ?? '') === 'ongoing' ? 'selected' : ''); ?>>Ongoing</option>
                <option value="completed" <?php echo e(($filters['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                <option value="cancelled" <?php echo e(($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>

            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Types</option>
                <option value="conference" <?php echo e(($filters['type'] ?? '') === 'conference' ? 'selected' : ''); ?>>Conference</option>
                <option value="seminar" <?php echo e(($filters['type'] ?? '') === 'seminar' ? 'selected' : ''); ?>>Seminar</option>
                <option value="crusade" <?php echo e(($filters['type'] ?? '') === 'crusade' ? 'selected' : ''); ?>>Crusade</option>
                <option value="retreat" <?php echo e(($filters['type'] ?? '') === 'retreat' ? 'selected' : ''); ?>>Retreat</option>
                <option value="workshop" <?php echo e(($filters['type'] ?? '') === 'workshop' ? 'selected' : ''); ?>>Workshop</option>
                <option value="training" <?php echo e(($filters['type'] ?? '') === 'training' ? 'selected' : ''); ?>>Training</option>
            </select>

            <input type="text" name="search" placeholder="Search programs..." value="<?php echo e($filters['search'] ?? ''); ?>"
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Filter
            </button>

            <?php if(!empty($filters)): ?>
            <a href="<?php echo e(route('programs.index')); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Clear
            </a>
            <?php endif; ?>
        </form>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            
            <?php if($program->flyer_path): ?>
            <img src="<?php echo e(Storage::url($program->flyer_path)); ?>" alt="<?php echo e($program->name); ?>" class="w-full h-48 object-cover">
            <?php else: ?>
            <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
                </svg>
            </div>
            <?php endif; ?>

            
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo e($program->getStatusBadgeClass()); ?>">
                        <?php echo e(ucfirst($program->status)); ?>

                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">
                        <?php echo e($program->getTypeLabel()); ?>

                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($program->name); ?></h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($program->description); ?></p>

                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e($program->start_date->format('M d, Y')); ?> - <?php echo e($program->end_date->format('M d, Y')); ?>

                    </div>

                    <?php if($program->venue_name): ?>
                    <div class="flex items-center text-sm text-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e($program->venue_name); ?>

                    </div>
                    <?php endif; ?>

                    <?php if($program->requires_registration): ?>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                            <?php echo e($program->current_participants); ?>

                            <?php if($program->max_participants): ?>
                                / <?php echo e($program->max_participants); ?> registered
                            <?php else: ?>
                                registered
                            <?php endif; ?>
                        </div>
                        <?php if($program->registration_fee > 0): ?>
                        <span class="text-blue-600 font-semibold">GHS <?php echo e(number_format($program->registration_fee, 2)); ?></span>
                        <?php else: ?>
                        <span class="text-green-600 font-semibold">Free</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="flex gap-2">
                    <a href="<?php echo e(route('programs.show', $program)); ?>" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm">
                        View Details
                    </a>
                    <?php if($program->canRegister()): ?>
                    <a href="<?php echo e(route('programs.registration-form', $program)); ?>" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center text-sm">
                        Register
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Programs Found</h3>
            <p class="text-gray-600 mb-4">Start by creating your first program</p>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\Program::class)): ?>
            <a href="<?php echo e(route('programs.create')); ?>" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Create Program
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($programs->hasPages()): ?>
    <div class="mt-8">
        <?php echo e($programs->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/programs/index.blade.php ENDPATH**/ ?>