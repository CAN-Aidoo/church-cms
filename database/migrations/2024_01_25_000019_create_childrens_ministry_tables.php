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
        // Children's check-ins table
        Schema::create('children_checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('service_schedules')->onDelete('set null');
            $table->date('checkin_date');
            $table->time('checkin_time');
            $table->time('checkout_time')->nullable();
            $table->string('classroom_assigned')->nullable();
            $table->string('security_code', 10);
            $table->string('name_tag_printed')->default('no'); // yes, no
            $table->foreignId('checked_in_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('checked_out_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('checkout_authorized_person')->nullable();
            $table->enum('status', ['checked_in', 'checked_out', 'absent'])->default('checked_in');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['child_id', 'checkin_date']);
            $table->index('security_code');
            $table->index('status');
        });

        // Curriculum lessons table
        Schema::create('curriculum_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('series')->nullable();
            $table->enum('age_group', ['nursery', 'toddlers', 'beginners', 'primary', 'juniors', 'teens']);
            $table->text('bible_story');
            $table->string('bible_reference');
            $table->text('memory_verse');
            $table->text('lesson_objective')->nullable();
            $table->longText('lesson_content')->nullable();
            $table->json('activities')->nullable(); // Array of activities
            $table->json('craft_projects')->nullable();
            $table->json('resources')->nullable(); // Videos, songs, games
            $table->integer('duration_minutes')->default(45);
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('age_group');
            $table->index('series');
            $table->index('is_published');
        });

        // Lesson schedules table
        Schema::create('lesson_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_lesson_id')->constrained('curriculum_lessons')->onDelete('cascade');
            $table->date('scheduled_date');
            $table->enum('age_group', ['nursery', 'toddlers', 'beginners', 'primary', 'juniors', 'teens']);
            $table->string('classroom')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assistant_teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('expected_attendance')->default(0);
            $table->integer('actual_attendance')->default(0);
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->text('teacher_notes')->nullable();
            $table->timestamps();

            $table->index(['scheduled_date', 'age_group']);
            $table->index('status');
        });

        // Teachers table
        Schema::create('childrens_ministry_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['lead_teacher', 'assistant_teacher', 'substitute'])->default('assistant_teacher');
            $table->json('age_groups_certified')->nullable(); // Which age groups they can teach
            $table->boolean('background_check_completed')->default(false);
            $table->date('background_check_date')->nullable();
            $table->date('background_check_expiry')->nullable();
            $table->json('training_completed')->nullable(); // Array of training courses
            $table->date('last_training_date')->nullable();
            $table->integer('years_experience')->default(0);
            $table->text('special_skills')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('is_active');
            $table->index('background_check_expiry');
        });

        // Resource library table
        Schema::create('childrens_ministry_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('resource_type', ['teaching_material', 'visual_aid', 'song', 'game', 'video', 'craft', 'story']);
            $table->enum('age_group', ['nursery', 'toddlers', 'beginners', 'primary', 'juniors', 'teens', 'all']);
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->json('tags')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->text('materials_needed')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('downloads_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('resource_type');
            $table->index('age_group');
        });

        // Children's events table
        Schema::create('childrens_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->enum('event_type', ['vbs', 'camp', 'holiday_program', 'talent_show', 'sports', 'field_trip', 'workshop', 'other']);
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->json('age_groups')->nullable(); // Which age groups can attend
            $table->integer('max_participants')->nullable();
            $table->integer('registered_count')->default(0);
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->date('registration_deadline')->nullable();
            $table->string('flyer_url')->nullable();
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->foreignId('coordinator_id')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('event_type');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });

        // Event registrations table
        Schema::create('childrens_event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('childrens_event_id')->constrained('childrens_events')->onDelete('cascade');
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->date('registration_date');
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('special_requirements')->nullable();
            $table->json('emergency_contact')->nullable();
            $table->enum('status', ['registered', 'confirmed', 'attended', 'cancelled'])->default('registered');
            $table->foreignId('registered_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['childrens_event_id', 'child_id']);
            $table->index('status');
        });

        // Parent communications table
        Schema::create('parent_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->nullable()->constrained('children')->onDelete('cascade');
            $table->foreignId('family_id')->nullable()->constrained('families')->onDelete('cascade');
            $table->string('communication_type'); // lesson_summary, behavior_report, achievement, reminder, general
            $table->string('subject');
            $table->longText('message');
            $table->json('recipients')->nullable(); // Email addresses or phone numbers
            $table->enum('delivery_method', ['email', 'sms', 'both'])->default('email');
            $table->enum('status', ['draft', 'sent', 'failed'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('communication_type');
            $table->index('status');
        });

        // Behavior reports table
        Schema::create('child_behavior_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->date('report_date');
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->enum('behavior_type', ['positive', 'negative', 'concern', 'milestone']);
            $table->text('description');
            $table->text('action_taken')->nullable();
            $table->boolean('parent_notified')->default(false);
            $table->timestamp('parent_notified_at')->nullable();
            $table->timestamps();

            $table->index(['child_id', 'report_date']);
            $table->index('behavior_type');
        });

        // Achievement certificates table
        Schema::create('child_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->string('achievement_type'); // bible_verse_mastery, perfect_attendance, good_behavior, etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('achievement_date');
            $table->string('certificate_path')->nullable();
            $table->boolean('certificate_issued')->default(false);
            $table->foreignId('awarded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['child_id', 'achievement_date']);
            $table->index('achievement_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_achievements');
        Schema::dropIfExists('child_behavior_reports');
        Schema::dropIfExists('parent_communications');
        Schema::dropIfExists('childrens_event_registrations');
        Schema::dropIfExists('childrens_events');
        Schema::dropIfExists('childrens_ministry_resources');
        Schema::dropIfExists('childrens_ministry_teachers');
        Schema::dropIfExists('lesson_schedules');
        Schema::dropIfExists('curriculum_lessons');
        Schema::dropIfExists('children_checkins');
    }
};
