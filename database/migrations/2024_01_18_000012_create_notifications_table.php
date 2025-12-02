<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // In-app notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('type', [
                'info',
                'success',
                'warning',
                'error',
                'birthday',
                'anniversary',
                'attendance_alert',
                'finance_approval',
                'duty_roster',
                'meeting_reminder',
                'general',
            ])->default('info');
            $table->string('icon')->nullable(); // Icon class or emoji
            $table->string('action_url')->nullable(); // URL to navigate to when clicked
            $table->json('metadata')->nullable(); // Additional data (member_id, transaction_id, etc.)
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->timestamp('expires_at')->nullable(); // Auto-delete after this date
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'created_at']);
            $table->index('type');
        });

        // Email notifications queue
        Schema::create('email_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_email');
            $table->foreignId('recipient_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->text('body_html');
            $table->text('body_plain')->nullable();
            $table->enum('category', [
                'transactional',
                'birthday',
                'announcement',
                'alert',
                'report',
                'general',
            ])->default('general');
            $table->enum('status', ['queued', 'sending', 'sent', 'failed', 'cancelled'])->default('queued');
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->string('message_id')->nullable(); // Email provider message ID
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->json('attachments')->nullable(); // File paths or URLs
            $table->timestamps();

            $table->index(['status', 'scheduled_for']);
            $table->index('recipient_user_id');
        });

        // Push notifications (for future mobile app)
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->string('device_token')->nullable();
            $table->enum('platform', ['ios', 'android', 'web'])->nullable();
            $table->json('data')->nullable(); // Additional payload data
            $table->enum('status', ['queued', 'sent', 'failed'])->default('queued');
            $table->timestamp('sent_at')->nullable();
            $table->string('notification_id')->nullable(); // Firebase/APNS message ID
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });

        // Notification preferences per user
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // In-app notifications
            $table->boolean('in_app_enabled')->default(true);
            $table->json('in_app_types')->nullable(); // Which notification types to show

            // Email notifications
            $table->boolean('email_enabled')->default(true);
            $table->json('email_types')->nullable(); // Which types to email
            $table->time('email_digest_time')->nullable(); // Time for daily digest
            $table->boolean('email_digest_enabled')->default(false);

            // SMS notifications
            $table->boolean('sms_enabled')->default(true);
            $table->json('sms_types')->nullable(); // Which types via SMS

            // Push notifications
            $table->boolean('push_enabled')->default(true);
            $table->json('push_types')->nullable();

            // Quiet hours
            $table->time('quiet_hours_start')->nullable(); // e.g., 22:00
            $table->time('quiet_hours_end')->nullable(); // e.g., 07:00
            $table->boolean('quiet_hours_enabled')->default(false);

            $table->timestamps();

            $table->unique('user_id');
        });

        // Notification templates
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique(); // e.g., 'birthday_wish', 'attendance_alert'
            $table->text('description')->nullable();
            $table->enum('channel', ['in_app', 'email', 'sms', 'push', 'all'])->default('all');
            $table->string('subject')->nullable(); // For email
            $table->text('template_content');
            $table->json('placeholders')->nullable(); // Available placeholders
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('code');
        });

        // Notification logs (for audit trail)
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('channel', ['in_app', 'email', 'sms', 'push']);
            $table->string('notification_type');
            $table->text('message')->nullable();
            $table->enum('status', ['sent', 'failed', 'bounced']);
            $table->text('error_details')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->index(['user_id', 'sent_at']);
            $table->index(['channel', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('notification_preferences');
        Schema::dropIfExists('push_notifications');
        Schema::dropIfExists('email_notifications');
        Schema::dropIfExists('notifications');
    }
};
