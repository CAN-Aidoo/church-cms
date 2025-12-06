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
        Schema::create('service_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 20)->unique();
            $table->text('description')->nullable();
            $table->enum('category', ['music', 'technical', 'hospitality', 'security', 'admin', 'children', 'media', 'other'])->default('other');
            $table->foreignId('leader_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('assistant_leader_id')->nullable()->constrained('members')->onDelete('set null');
            $table->integer('min_members')->default(2);
            $table->integer('max_members')->default(20);
            $table->integer('current_members')->default(0);
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('meeting_schedule', 255)->nullable();
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('category');
            $table->index('code');
        });

        Schema::create('service_unit_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_unit_id')->constrained('service_units')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('role', ['leader', 'assistant_leader', 'member', 'trainee'])->default('member');
            $table->date('joined_date');
            $table->date('left_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->json('skills')->nullable();
            $table->integer('proficiency_level')->default(1); // 1-5 scale
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint - one member can be in a unit only once
            // We need to remove status from unique constraint or allow only one active status
            // To avoid duplicates with different statuses, just unique member and unit might be safer,
            // or ensure app logic handles re-joining.
            // Let's relax to member_id and service_unit_id
            $table->unique(['service_unit_id', 'member_id']); 
            $table->index(['service_unit_id', 'status']);
            $table->index(['member_id', 'status']);
        });

        Schema::create('duty_rosters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_unit_id')->constrained('service_units')->onDelete('cascade');
            $table->string('roster_name', 100);
            $table->date('duty_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('duty_type', ['sunday_service', 'midweek_service', 'special_event', 'rehearsal', 'practice', 'other'])->default('sunday_service');
            $table->string('location', 255)->nullable();
            $table->text('instructions')->nullable();
            $table->enum('status', ['draft', 'published', 'completed', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('duty_date');
            $table->index('status');
            $table->index(['service_unit_id', 'duty_date']);
        });

        Schema::create('duty_roster_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duty_roster_id')->constrained('duty_rosters')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('position', 100)->nullable();
            $table->enum('status', ['assigned', 'confirmed', 'declined', 'absent', 'present'])->default('assigned');
            $table->timestamp('confirmed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint - one member per roster
            $table->unique(['duty_roster_id', 'member_id']);
        });

        Schema::create('service_unit_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_unit_id')->constrained('service_units')->onDelete('cascade');
            $table->string('title', 200);
            $table->date('meeting_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location', 255)->nullable();
            $table->enum('meeting_type', ['regular', 'training', 'planning', 'evaluation', 'emergency', 'social'])->default('regular');
            $table->text('agenda')->nullable();
            $table->text('minutes')->nullable();
            $table->integer('attendance_count')->default(0);
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();

            // Indexes
            $table->index('meeting_date');
            $table->index('status');
            $table->index(['service_unit_id', 'meeting_date']);
        });

        Schema::create('service_unit_meeting_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('service_unit_meetings')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('status', ['present', 'absent', 'excused', 'late'])->default('present');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint
            $table->unique(['meeting_id', 'member_id']);
        });

        Schema::create('service_unit_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_unit_id')->constrained('service_units')->onDelete('cascade');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->date('training_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location', 255)->nullable();
            $table->foreignId('trainer_id')->nullable()->constrained('members')->onDelete('set null');
            $table->text('topics_covered')->nullable();
            $table->integer('max_participants')->nullable();
            $table->integer('enrolled_count')->default(0);
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            // Indexes
            $table->index('training_date');
            $table->index('status');
        });

        Schema::create('service_unit_training_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('service_unit_trainings')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('status', ['enrolled', 'attended', 'absent', 'withdrawn'])->default('enrolled');
            $table->integer('score')->nullable(); // For assessments
            $table->boolean('certified')->default(false);
            $table->text('feedback')->nullable();
            $table->timestamps();

            // Unique constraint
            $table->unique(['training_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_unit_training_enrollments');
        Schema::dropIfExists('service_unit_trainings');
        Schema::dropIfExists('service_unit_meeting_attendance');
        Schema::dropIfExists('service_unit_meetings');
        Schema::dropIfExists('duty_roster_assignments');
        Schema::dropIfExists('duty_rosters');
        Schema::dropIfExists('service_unit_members');
        Schema::dropIfExists('service_units');
    }
};