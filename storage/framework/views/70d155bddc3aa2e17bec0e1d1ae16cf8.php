<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="<?php echo e(route('sms.index')); ?>" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Create SMS Broadcast</h1>
        </div>
        <p class="text-gray-600">Compose and send messages to members</p>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="<?php echo e(route('sms.store')); ?>" class="space-y-6" x-data="{
            recipientType: 'all_members',
            message: '',
            recipientCount: <?php echo e($recipientOptions['all_members']); ?>,
            scheduleType: 'send_now',

            get messageLength() {
                return this.message.length;
            },

            get segments() {
                return this.messageLength <= 160 ? 1 : Math.ceil(this.messageLength / 153);
            },

            get estimatedCost() {
                return (this.recipientCount * this.segments * 0.05).toFixed(2);
            },

            updateRecipientCount() {
                const counts = {
                    'all_members': <?php echo e($recipientOptions['all_members']); ?>,
                    'pending_members': <?php echo e($recipientOptions['pending_members']); ?>,
                    'birthdays_today': <?php echo e($recipientOptions['birthdays_today']); ?>,
                    'birthdays_this_week': <?php echo e($recipientOptions['birthdays_this_week']); ?>,
                    'custom': 0,
                    'specific_members': 0
                };
                this.recipientCount = counts[this.recipientType] || 0;
            }
        }">
            <?php echo csrf_field(); ?>

            <!-- Message Content -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Message Content</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Broadcast Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="<?php echo e(old('title')); ?>"
                               required
                               class="form-input w-full <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="e.g., Sunday Service Reminder, Birthday Wishes">
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="text-xs text-gray-500 mt-1">For internal reference only, not sent to recipients</p>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message"
                                  id="message"
                                  rows="6"
                                  required
                                  x-model="message"
                                  maxlength="1600"
                                  class="form-textarea w-full <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  placeholder="Type your message here..."><?php echo e(old('message')); ?></textarea>
                        <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <!-- Character Counter -->
                        <div class="flex justify-between text-xs mt-2">
                            <div>
                                <span x-text="messageLength"></span> / 1600 characters
                                <span class="ml-3">|</span>
                                <span class="ml-3" x-text="segments"></span> SMS segment<span x-show="segments > 1">s</span>
                            </div>
                            <div class="text-gray-600">
                                <span x-show="messageLength <= 160" class="text-green-600">Single SMS</span>
                                <span x-show="messageLength > 160" class="text-yellow-600">Multi-part SMS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipients -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Select Recipients</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Recipient Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Recipient Group <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="recipient_type"
                                       value="all_members"
                                       x-model="recipientType"
                                       @change="updateRecipientCount()"
                                       checked
                                       class="form-radio">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium">All Active Members</span>
                                    <span class="text-sm text-gray-600 ml-2">(<?php echo e($recipientOptions['all_members']); ?> members)</span>
                                </span>
                            </label>

                            <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="recipient_type"
                                       value="pending_members"
                                       x-model="recipientType"
                                       @change="updateRecipientCount()"
                                       class="form-radio">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium">Pending Members</span>
                                    <span class="text-sm text-gray-600 ml-2">(<?php echo e($recipientOptions['pending_members']); ?> members)</span>
                                </span>
                            </label>

                            <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="recipient_type"
                                       value="birthdays_today"
                                       x-model="recipientType"
                                       @change="updateRecipientCount()"
                                       class="form-radio">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium">Birthdays Today</span>
                                    <span class="text-sm text-gray-600 ml-2">(<?php echo e($recipientOptions['birthdays_today']); ?> members)</span>
                                </span>
                            </label>

                            <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="recipient_type"
                                       value="birthdays_this_week"
                                       x-model="recipientType"
                                       @change="updateRecipientCount()"
                                       class="form-radio">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium">Birthdays This Week</span>
                                    <span class="text-sm text-gray-600 ml-2">(<?php echo e($recipientOptions['birthdays_this_week']); ?> members)</span>
                                </span>
                            </label>

                            <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="recipient_type"
                                       value="custom"
                                       x-model="recipientType"
                                       class="form-radio">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium">Custom Filter</span>
                                    <span class="text-sm text-gray-600 ml-2">(Filter by gender, age, etc.)</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Custom Filters -->
                    <div x-show="recipientType === 'custom'" x-cloak class="pl-6 space-y-4 border-l-4 border-blue-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <select name="recipient_filter[gender]" id="gender" class="form-select w-full">
                                    <option value="">All Genders</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">Marital Status</label>
                                <select name="recipient_filter[marital_status]" id="marital_status" class="form-select w-full">
                                    <option value="">All Statuses</option>
                                    <?php $__currentLoopData = $maritalStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>"><?php echo e($status); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label for="age_min" class="block text-sm font-medium text-gray-700 mb-1">Minimum Age</label>
                                <input type="number" name="recipient_filter[age_min]" id="age_min" min="0" max="120" class="form-input w-full" placeholder="e.g., 18">
                            </div>

                            <div>
                                <label for="age_max" class="block text-sm font-medium text-gray-700 mb-1">Maximum Age</label>
                                <input type="number" name="recipient_filter[age_max]" id="age_max" min="0" max="120" class="form-input w-full" placeholder="e.g., 65">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Note: Recipient count will be calculated after submission for custom filters</p>
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Delivery Schedule</h2>
                </div>
                <div class="card-body space-y-4">
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio"
                                   name="schedule_type"
                                   value="send_now"
                                   x-model="scheduleType"
                                   checked
                                   class="form-radio">
                            <span class="ml-3">
                                <span class="font-medium">Send Immediately</span>
                                <p class="text-sm text-gray-600">Messages will be queued and sent right away</p>
                            </span>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio"
                                   name="schedule_type"
                                   value="schedule"
                                   x-model="scheduleType"
                                   class="form-radio">
                            <span class="ml-3">
                                <span class="font-medium">Schedule for Later</span>
                                <p class="text-sm text-gray-600">Choose a specific date and time to send</p>
                            </span>
                        </label>
                    </div>

                    <!-- Schedule Date/Time -->
                    <div x-show="scheduleType === 'schedule'" x-cloak class="pl-6">
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-1">
                            Schedule Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                               name="scheduled_at"
                               id="scheduled_at"
                               value="<?php echo e(old('scheduled_at')); ?>"
                               min="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                               class="form-input w-full md:w-96 <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Cost Summary -->
            <div class="card bg-gradient-blue">
                <div class="card-body text-white">
                    <h3 class="text-xl font-semibold mb-4">Cost Estimate</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm opacity-90">Recipients</p>
                            <p class="text-2xl font-bold" x-text="recipientCount.toLocaleString()"></p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">SMS Segments</p>
                            <p class="text-2xl font-bold" x-text="segments"></p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">Cost per SMS</p>
                            <p class="text-2xl font-bold">GHS 0.05</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">Total Estimated Cost</p>
                            <p class="text-2xl font-bold">GHS <span x-text="estimatedCost"></span></p>
                        </div>
                    </div>
                    <p class="text-xs opacity-75 mt-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        Final cost may vary based on actual delivery. Failed messages are not charged.
                    </p>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="<?php echo e(route('sms.index')); ?>" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane mr-2"></i>
                    <span x-text="scheduleType === 'send_now' ? 'Send Broadcast' : 'Schedule Broadcast'"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/sms/create.blade.php ENDPATH**/ ?>