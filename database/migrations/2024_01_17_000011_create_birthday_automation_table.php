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
        // Birthday wishes sent to members
        Schema::create('birthday_wishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->date('birthday_date');
            $table->year('year_sent');
            $table->enum('wish_type', ['birthday', 'wedding_anniversary', 'membership_anniversary', 'ministry_anniversary'])->default('birthday');
            $table->enum('delivery_method', ['sms', 'email', 'both'])->default('sms');
            $table->text('message');
            $table->enum('status', ['pending', 'sent', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->string('sms_id')->nullable(); // Twilio message SID
            $table->string('email_id')->nullable(); // Email tracking ID
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamps();

            $table->index(['member_id', 'wish_type', 'year_sent']);
            $table->index(['birthday_date', 'status']);
            $table->index('scheduled_at');
        });

        // Anniversary milestones tracking
        Schema::create('anniversary_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('milestone_type', ['wedding_anniversary', 'membership_anniversary', 'ministry_anniversary', 'ordination_anniversary']);
            $table->date('milestone_date');
            $table->integer('years_completed'); // e.g., 1, 5, 10, 25, 50
            $table->boolean('is_special')->default(false); // For 25th, 50th wedding anniversaries, etc.
            $table->boolean('recognition_given')->default(false);
            $table->date('recognized_on')->nullable();
            $table->text('recognition_notes')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'milestone_type']);
            $table->index(['milestone_date', 'recognition_given']);
        });

        // Birthday/Anniversary automation settings
        Schema::create('birthday_automation_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('event_type', ['birthday', 'wedding_anniversary', 'membership_anniversary', 'ministry_anniversary']);
            $table->boolean('enabled')->default(true);
            $table->boolean('sms_enabled')->default(true);
            $table->boolean('email_enabled')->default(false);
            $table->time('send_time')->default('00:00:00'); // Time to send wishes (e.g., midnight)
            $table->text('sms_template');
            $table->text('email_subject')->nullable();
            $table->text('email_template')->nullable();
            $table->boolean('notify_pastor')->default(true);
            $table->boolean('announce_in_service')->default(true);
            $table->json('special_milestones')->nullable(); // [1, 5, 10, 25, 50] years
            $table->text('special_milestone_message')->nullable();
            $table->timestamps();

            $table->unique('event_type');
        });

        // Birthday/Anniversary notifications queue
        Schema::create('birthday_notification_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('notification_type', ['birthday', 'anniversary', 'milestone']);
            $table->date('event_date');
            $table->timestamp('scheduled_for');
            $table->enum('status', ['queued', 'processing', 'sent', 'failed'])->default('queued');
            $table->text('notification_data')->nullable(); // JSON data for the notification
            $table->integer('attempts')->default(0);
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['scheduled_for', 'status']);
            $table->index(['member_id', 'event_date']);
        });

        // Service announcements for birthdays/anniversaries
        Schema::create('birthday_service_announcements', function (Blueprint $table) {
            $table->id();
            $table->date('service_date');
            $table->enum('service_type', ['sunday_service', 'midweek_service', 'special_event'])->default('sunday_service');
            $table->enum('announcement_type', ['birthdays', 'anniversaries', 'milestones', 'general']);
            $table->text('announcement_text');
            $table->json('member_ids')->nullable(); // Array of member IDs being announced
            $table->boolean('displayed')->default(false);
            $table->timestamp('displayed_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['service_date', 'service_type']);
            $table->index(['announcement_type', 'displayed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birthday_service_announcements');
        Schema::dropIfExists('birthday_notification_queue');
        Schema::dropIfExists('birthday_automation_settings');
        Schema::dropIfExists('anniversary_milestones');
        Schema::dropIfExists('birthday_wishes');
    }
};
