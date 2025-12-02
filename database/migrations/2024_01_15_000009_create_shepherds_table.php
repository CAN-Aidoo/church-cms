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
        Schema::create('shepherds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('flock_name', 100);
            $table->text('description')->nullable();
            $table->integer('max_flock_size')->default(15);
            $table->integer('current_flock_size')->default(0);
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->date('appointed_date');
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('appointed_date');
        });

        // Add shepherd_id to members table
        Schema::table('members', function (Blueprint $table) {
            $table->foreignId('shepherd_id')->nullable()->constrained('shepherds')->onDelete('set null');
            $table->index('shepherd_id');
        });

        Schema::create('flock_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shepherd_id')->constrained('shepherds')->onDelete('cascade');
            $table->date('meeting_date');
            $table->time('meeting_time')->nullable();
            $table->string('location', 255)->nullable();
            $table->enum('meeting_type', ['regular', 'special', 'emergency', 'social'])->default('regular');
            $table->text('agenda')->nullable();
            $table->text('notes')->nullable();
            $table->integer('attendance_count')->default(0);
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();

            // Indexes
            $table->index('meeting_date');
            $table->index('status');
        });

        Schema::create('flock_meeting_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('flock_meetings')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('status', ['present', 'absent', 'excused', 'late'])->default('present');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint - one attendance record per member per meeting
            $table->unique(['meeting_id', 'member_id']);
        });

        Schema::create('member_visitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shepherd_id')->constrained('shepherds')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->date('visit_date');
            $table->time('visit_time')->nullable();
            $table->enum('visit_type', ['home_visit', 'hospital_visit', 'phone_call', 'counseling', 'follow_up', 'other'])->default('home_visit');
            $table->enum('visit_reason', ['routine', 'pastoral_care', 'crisis', 'new_member', 'inactive_member', 'other'])->default('routine');
            $table->text('notes')->nullable();
            $table->text('prayer_requests')->nullable();
            $table->text('action_items')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('completed');
            $table->timestamps();

            // Indexes
            $table->index('visit_date');
            $table->index('shepherd_id');
            $table->index('member_id');
            $table->index('status');
        });

        Schema::create('shepherd_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shepherd_id')->constrained('shepherds')->onDelete('cascade');
            $table->enum('report_period', ['weekly', 'monthly', 'quarterly'])->default('weekly');
            $table->date('report_date');
            $table->date('period_start');
            $table->date('period_end');
            $table->integer('total_members')->default(0);
            $table->integer('active_members')->default(0);
            $table->integer('inactive_members')->default(0);
            $table->integer('visits_conducted')->default(0);
            $table->integer('meetings_held')->default(0);
            $table->integer('new_members')->default(0);
            $table->integer('members_left')->default(0);
            $table->text('highlights')->nullable();
            $table->text('challenges')->nullable();
            $table->text('prayer_needs')->nullable();
            $table->text('recommendations')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed'])->default('draft');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('report_date');
            $table->index('report_period');
            $table->index('status');
            $table->index(['shepherd_id', 'report_period', 'report_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shepherd_reports');
        Schema::dropIfExists('member_visitations');
        Schema::dropIfExists('flock_meeting_attendance');
        Schema::dropIfExists('flock_meetings');

        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['shepherd_id']);
            $table->dropColumn('shepherd_id');
        });

        Schema::dropIfExists('shepherds');
    }
};
