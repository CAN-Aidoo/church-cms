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
        // Service schedules table
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('service_type', ['regular', 'special', 'midweek', 'youth', 'children', 'prayer_meeting', 'bible_study', 'other']);
            $table->date('service_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('venue')->nullable();
            $table->text('theme')->nullable();
            $table->text('sermon_title')->nullable();
            $table->text('sermon_text')->nullable();
            $table->foreignId('preacher_id')->nullable()->constrained('members')->onDelete('set null');
            $table->integer('expected_attendance')->nullable();
            $table->integer('actual_attendance')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->json('additional_info')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['service_date', 'start_time']);
            $table->index('service_type');
            $table->index('status');
        });

        // Worship planning table
        Schema::create('worship_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_schedule_id')->constrained('service_schedules')->onDelete('cascade');
            $table->integer('order_number');
            $table->enum('item_type', ['opening_prayer', 'worship_song', 'hymn', 'scripture_reading', 'prayer', 'offering', 'special_number', 'sermon', 'altar_call', 'announcements', 'benediction', 'other']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('members')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->json('song_details')->nullable(); // {song_number, key, tempo, etc.}
            $table->timestamps();

            $table->index(['service_schedule_id', 'order_number']);
        });

        // Service volunteers/duty roster table
        Schema::create('service_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_schedule_id')->constrained('service_schedules')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('role', ['usher', 'choir', 'instrumentalist', 'tech_team', 'protocol', 'media', 'security', 'parking', 'childrens_church', 'altar_worker', 'offering_counter', 'intercessor', 'other']);
            $table->string('specific_duty')->nullable();
            $table->enum('status', ['assigned', 'confirmed', 'declined', 'completed', 'absent'])->default('assigned');
            $table->timestamp('confirmed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['service_schedule_id', 'member_id', 'role']);
            $table->index('role');
        });

        // Service resources/equipment table
        Schema::create('service_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_schedule_id')->constrained('service_schedules')->onDelete('cascade');
            $table->enum('resource_type', ['equipment', 'material', 'facility', 'other']);
            $table->string('resource_name');
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'unavailable'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        // Service announcements table
        Schema::create('service_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_schedule_id')->nullable()->constrained('service_schedules')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('display_on_screen')->default(false);
            $table->boolean('send_sms')->default(false);
            $table->boolean('send_email')->default(false);
            $table->string('target_audience')->nullable(); // 'all', 'members', 'visitors', specific groups
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['start_date', 'end_date']);
        });

        // Sermon notes/archives table
        Schema::create('sermons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_schedule_id')->constrained('service_schedules')->onDelete('cascade');
            $table->string('title');
            $table->text('sermon_text'); // Bible reference
            $table->text('theme')->nullable();
            $table->foreignId('preacher_id')->constrained('members')->onDelete('cascade');
            $table->text('summary')->nullable();
            $table->longText('full_notes')->nullable();
            $table->json('key_points')->nullable(); // Array of main points
            $table->string('audio_file_path')->nullable();
            $table->string('video_file_path')->nullable();
            $table->string('slides_file_path')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->text('tags')->nullable(); // Comma-separated tags
            $table->timestamps();

            $table->index('preacher_id');
            $table->index('title');
        });

        // Special service types/templates table
        Schema::create('service_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('service_type', ['regular', 'special', 'midweek', 'youth', 'children', 'prayer_meeting', 'bible_study', 'other']);
            $table->text('description')->nullable();
            $table->json('default_worship_plan')->nullable(); // JSON structure of typical order of service
            $table->json('default_roles')->nullable(); // Default volunteer roles needed
            $table->integer('default_duration_minutes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Service feedback/evaluation table
        Schema::create('service_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_schedule_id')->constrained('service_schedules')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->integer('overall_rating')->nullable(); // 1-5
            $table->integer('worship_rating')->nullable(); // 1-5
            $table->integer('preaching_rating')->nullable(); // 1-5
            $table->integer('organization_rating')->nullable(); // 1-5
            $table->text('comments')->nullable();
            $table->text('suggestions')->nullable();
            $table->boolean('would_recommend')->default(true);
            $table->timestamps();

            $table->index('service_schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_feedback');
        Schema::dropIfExists('service_templates');
        Schema::dropIfExists('sermons');
        Schema::dropIfExists('service_announcements');
        Schema::dropIfExists('service_resources');
        Schema::dropIfExists('service_volunteers');
        Schema::dropIfExists('worship_plans');
        Schema::dropIfExists('service_schedules');
    }
};
