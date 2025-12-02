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
        // Prayer categories table
        Schema::create('prayer_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->default('#3B82F6'); // Hex color for UI
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Prayer requests table
        Schema::create('prayer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('prayer_categories')->onDelete('set null');
            $table->string('requester_name'); // For non-members
            $table->string('requester_phone')->nullable();
            $table->string('requester_email')->nullable();
            $table->text('request_title');
            $table->longText('request_details');
            $table->enum('urgency', ['low', 'normal', 'high', 'critical'])->default('normal');
            $table->enum('privacy_level', ['public', 'pastors_only', 'private'])->default('public');
            $table->enum('status', ['pending', 'assigned', 'praying', 'answered', 'cancelled'])->default('pending');
            $table->foreignId('assigned_to')->nullable()->constrained('members')->onDelete('set null'); // Prayer warrior/pastor
            $table->timestamp('answered_at')->nullable();
            $table->longText('testimony')->nullable(); // When answered
            $table->boolean('share_testimony')->default(false);
            $table->boolean('is_anonymous')->default(false);
            $table->json('tags')->nullable(); // Array of tags
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('urgency');
            $table->index(['member_id', 'status']);
        });

        // Prayer assignments/intercessors table
        Schema::create('prayer_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prayer_request_id')->constrained('prayer_requests')->onDelete('cascade');
            $table->foreignId('intercessor_id')->constrained('members')->onDelete('cascade');
            $table->timestamp('assigned_at');
            $table->timestamp('started_praying_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['assigned', 'praying', 'completed'])->default('assigned');
            $table->timestamps();

            $table->unique(['prayer_request_id', 'intercessor_id']);
            $table->index('intercessor_id');
        });

        // Prayer updates/progress notes table
        Schema::create('prayer_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prayer_request_id')->constrained('prayer_requests')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->text('update_text');
            $table->enum('update_type', ['progress', 'note', 'status_change', 'answered'])->default('note');
            $table->boolean('notify_requester')->default(false);
            $table->timestamps();

            $table->index('prayer_request_id');
        });

        // Prayer groups/circles table
        Schema::create('prayer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('leader_id')->nullable()->constrained('members')->onDelete('set null');
            $table->enum('meeting_frequency', ['daily', 'weekly', 'biweekly', 'monthly', 'adhoc'])->default('weekly');
            $table->string('meeting_day')->nullable(); // e.g., 'Monday', 'Every 1st Sunday'
            $table->time('meeting_time')->nullable();
            $table->string('meeting_location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Prayer group members table
        Schema::create('prayer_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prayer_group_id')->constrained('prayer_groups')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('role', ['member', 'co_leader', 'leader'])->default('member');
            $table->timestamp('joined_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['prayer_group_id', 'member_id']);
        });

        // Prayer meetings/sessions table
        Schema::create('prayer_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prayer_group_id')->nullable()->constrained('prayer_groups')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('meeting_date');
            $table->integer('duration_minutes')->default(60);
            $table->string('location')->nullable();
            $table->text('agenda')->nullable();
            $table->text('notes')->nullable();
            $table->integer('attendance_count')->nullable();
            $table->json('prayer_points')->nullable(); // Array of prayer points
            $table->foreignId('led_by')->nullable()->constrained('members')->onDelete('set null');
            $table->timestamps();

            $table->index('meeting_date');
        });

        // Prayer testimonies table
        Schema::create('prayer_testimonies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prayer_request_id')->nullable()->constrained('prayer_requests')->onDelete('set null');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->string('title');
            $table->longText('testimony');
            $table->date('testimony_date');
            $table->boolean('is_approved')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->boolean('share_publicly')->default(true);
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->index('is_approved');
            $table->index('testimony_date');
        });

        // Prayer statistics/analytics table
        Schema::create('prayer_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_requests')->default(0);
            $table->integer('new_requests')->default(0);
            $table->integer('answered_requests')->default(0);
            $table->integer('pending_requests')->default(0);
            $table->integer('active_intercessors')->default(0);
            $table->integer('total_prayer_hours')->default(0);
            $table->timestamps();

            $table->unique('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prayer_statistics');
        Schema::dropIfExists('prayer_testimonies');
        Schema::dropIfExists('prayer_meetings');
        Schema::dropIfExists('prayer_group_members');
        Schema::dropIfExists('prayer_groups');
        Schema::dropIfExists('prayer_updates');
        Schema::dropIfExists('prayer_assignments');
        Schema::dropIfExists('prayer_requests');
        Schema::dropIfExists('prayer_categories');
    }
};
