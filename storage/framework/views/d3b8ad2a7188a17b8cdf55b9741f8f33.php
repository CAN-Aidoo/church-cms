<?php $__env->startSection('title', 'Mark Attendance'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Mark Attendance</h1>
        <nav class="breadcrumb">
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('attendance.index')); ?>">Attendance</a>
            <span>/</span>
            <span>Mark Attendance</span>
        </nav>
    </div>
</div>

<form action="<?php echo e(route('attendance.bulk')); ?>" method="POST" id="attendance-form"
      x-data="attendanceMarking()" @submit.prevent="submitForm">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
        <!-- Service Details Card -->
        <div class="lg:col-span-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Service Details</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="service_date" class="form-label required">Service Date</label>
                            <input type="date" id="service_date" name="service_date"
                                   value="<?php echo e($serviceDate); ?>"
                                   class="form-input <?php $__errorArgs = ['service_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required
                                   x-model="serviceDate">
                            <?php $__errorArgs = ['service_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="service_type" class="form-label required">Service Type</label>
                            <select id="service_type" name="service_type"
                                    class="form-select <?php $__errorArgs = ['service_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required
                                    x-model="serviceType">
                                <option value="sunday_first" <?php echo e($serviceType === 'sunday_first' ? 'selected' : ''); ?>>Sunday First Service</option>
                                <option value="sunday_second" <?php echo e($serviceType === 'sunday_second' ? 'selected' : ''); ?>>Sunday Second Service</option>
                                <option value="midweek" <?php echo e($serviceType === 'midweek' ? 'selected' : ''); ?>>Midweek Service</option>
                                <option value="prayer_meeting" <?php echo e($serviceType === 'prayer_meeting' ? 'selected' : ''); ?>>Prayer Meeting</option>
                                <option value="special" <?php echo e($serviceType === 'special' ? 'selected' : ''); ?>>Special Service</option>
                            </select>
                            <?php $__errorArgs = ['service_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="form-label">Quick Actions</label>
                            <div class="flex gap-2">
                                <button type="button" @click="markAll('present')" class="btn btn-sm btn-primary">
                                    Mark All Present
                                </button>
                                <button type="button" @click="clearAll()" class="btn btn-sm btn-secondary">
                                    Clear All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Summary</h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Members</span>
                        <span class="font-semibold text-gray-900" x-text="totalMembers"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Present</span>
                        <span class="font-semibold text-green-600" x-text="presentCount"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Absent</span>
                        <span class="font-semibold text-red-600" x-text="absentCount"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Excused</span>
                        <span class="font-semibold text-yellow-600" x-text="excusedCount"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Late</span>
                        <span class="font-semibold text-orange-600" x-text="lateCount"></span>
                    </div>
                    <div class="pt-3 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Attendance Rate</span>
                            <span class="text-lg font-bold text-primary-600" x-text="attendanceRate + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-gradient-primary h-2 rounded-full" :style="'width: ' + attendanceRate + '%'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Members List -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="card-title">Members (<?php echo e($members->count()); ?>)</h3>
            <div class="flex gap-4">
                <div class="relative">
                    <input type="text"
                           placeholder="Search members..."
                           class="form-input pl-10"
                           x-model="searchQuery"
                           @input="filterMembers">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-12">#</th>
                            <th>Member</th>
                            <th>Member ID</th>
                            <th>Contact</th>
                            <th class="text-center">Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $existing = $existingAttendance->firstWhere('member_id', $member->id);
                        ?>
                        <tr x-show="filteredMembers.includes(<?php echo e($member->id); ?>)"
                            x-transition
                            x-data="{ status: '<?php echo e($existing ? $existing->status : ''); ?>', notes: '<?php echo e($existing ? $existing->notes : ''); ?>' }">
                            <td><?php echo e($index + 1); ?></td>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <?php if($member->photo_url): ?>
                                    <img src="<?php echo e(Storage::url($member->photo_url)); ?>"
                                         alt="<?php echo e($member->full_name); ?>"
                                         class="w-10 h-10 rounded-full object-cover">
                                    <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-gradient-primary flex items-center justify-center text-white font-semibold">
                                        <?php echo e(strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1))); ?>

                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-semibold text-gray-900"><?php echo e($member->full_name); ?></div>
                                        <?php if($member->department): ?>
                                        <div class="text-xs text-gray-500"><?php echo e($member->department); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="font-mono text-sm"><?php echo e($member->member_id); ?></td>
                            <td class="text-sm"><?php echo e($member->phone); ?></td>
                            <td>
                                <input type="hidden" :name="'attendance[' + <?php echo e($index); ?> + '][member_id]'" value="<?php echo e($member->id); ?>">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                            @click="status = 'present'; updateCounts()"
                                            :class="status === 'present' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700'"
                                            class="px-3 py-1 rounded text-sm font-medium hover:opacity-80 transition">
                                        Present
                                    </button>
                                    <button type="button"
                                            @click="status = 'absent'; updateCounts()"
                                            :class="status === 'absent' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                                            class="px-3 py-1 rounded text-sm font-medium hover:opacity-80 transition">
                                        Absent
                                    </button>
                                    <button type="button"
                                            @click="status = 'excused'; updateCounts()"
                                            :class="status === 'excused' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700'"
                                            class="px-3 py-1 rounded text-sm font-medium hover:opacity-80 transition">
                                        Excused
                                    </button>
                                    <button type="button"
                                            @click="status = 'late'; updateCounts()"
                                            :class="status === 'late' ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-700'"
                                            class="px-3 py-1 rounded text-sm font-medium hover:opacity-80 transition">
                                        Late
                                    </button>
                                </div>
                                <input type="hidden" :name="'attendance[' + <?php echo e($index); ?> + '][status]'" x-model="status">
                            </td>
                            <td>
                                <input type="text"
                                       :name="'attendance[' + <?php echo e($index); ?> + '][notes]'"
                                       x-model="notes"
                                       placeholder="Optional notes..."
                                       class="form-input form-input-sm">
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <span x-text="getMarkedCount()"></span> of <span x-text="totalMembers"></span> members marked
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('attendance.index')); ?>" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Attendance
                </button>
            </div>
        </div>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function attendanceMarking() {
    return {
        serviceDate: '<?php echo e($serviceDate); ?>',
        serviceType: '<?php echo e($serviceType); ?>',
        searchQuery: '',
        totalMembers: <?php echo e($members->count()); ?>,
        filteredMembers: <?php echo json_encode($members->pluck('id'), 15, 512) ?>,

        get presentCount() {
            return this.getStatusCount('present');
        },
        get absentCount() {
            return this.getStatusCount('absent');
        },
        get excusedCount() {
            return this.getStatusCount('excused');
        },
        get lateCount() {
            return this.getStatusCount('late');
        },
        get attendanceRate() {
            const marked = this.getMarkedCount();
            if (marked === 0) return 0;
            return Math.round((this.presentCount / marked) * 100);
        },

        getStatusCount(status) {
            let count = 0;
            document.querySelectorAll('input[name*="[status]"]').forEach(input => {
                if (input.value === status) count++;
            });
            return count;
        },

        getMarkedCount() {
            let count = 0;
            document.querySelectorAll('input[name*="[status]"]').forEach(input => {
                if (input.value !== '') count++;
            });
            return count;
        },

        markAll(status) {
            if (!confirm(`Are you sure you want to mark all members as ${status}?`)) return;

            document.querySelectorAll('tr[x-show]').forEach(row => {
                const statusButtons = row.querySelectorAll('button[type="button"]');
                statusButtons.forEach(btn => {
                    if (btn.textContent.trim().toLowerCase() === status) {
                        btn.click();
                    }
                });
            });
        },

        clearAll() {
            if (!confirm('Are you sure you want to clear all attendance marks?')) return;

            document.querySelectorAll('input[name*="[status]"]').forEach(input => {
                input.value = '';
            });
            this.updateCounts();
        },

        filterMembers() {
            const query = this.searchQuery.toLowerCase();
            if (query === '') {
                this.filteredMembers = <?php echo json_encode($members->pluck('id'), 15, 512) ?>;
                return;
            }

            this.filteredMembers = [];
            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                if ('<?php echo e(strtolower($member->full_name)); ?>'.includes(query) ||
                    '<?php echo e(strtolower($member->member_id)); ?>'.includes(query) ||
                    '<?php echo e(strtolower($member->phone)); ?>'.includes(query)) {
                    this.filteredMembers.push(<?php echo e($member->id); ?>);
                }
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        },

        updateCounts() {
            // Force Alpine to re-calculate computed properties
            this.$nextTick(() => {});
        },

        submitForm() {
            const marked = this.getMarkedCount();
            if (marked === 0) {
                alert('Please mark at least one member before submitting.');
                return;
            }

            if (confirm(`Submit attendance for ${marked} member(s)?`)) {
                document.getElementById('attendance-form').submit();
            }
        }
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/attendance/mark.blade.php ENDPATH**/ ?>