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
        // Counsellors table
        Schema::create('counsellors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('license_number')->nullable();
            $table->json('qualifications')->nullable(); // Array of degrees, certifications
            $table->json('specializations'); // Array of specialization areas
            $table->json('languages')->nullable(); // Languages spoken
            $table->text('bio')->nullable();
            $table->integer('max_sessions_per_week')->default(10);
            $table->integer('session_duration_minutes')->default(60);
            $table->enum('availability_status', ['available', 'limited', 'unavailable'])->default('available');
            $table->boolean('accepts_online_bookings')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
        });

        // Counsellor availability schedule
        Schema::create('counsellor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counsellor_id')->constrained()->cascadeOnDelete();
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_recurring')->default(true);
            $table->date('effective_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->index(['counsellor_id', 'day_of_week']);
        });

        // Counselling cases (Moved before sessions)
        Schema::create('counselling_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number', 20)->unique();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('primary_counsellor_id')->constrained('counsellors')->cascadeOnDelete();
            $table->string('case_title');
            $table->text('case_description')->nullable();
            $table->json('issue_categories')->nullable(); // Multiple issues can be tagged
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['open', 'active', 'on_hold', 'closed'])->default('open');
            $table->date('opened_date');
            $table->date('closed_date')->nullable();
            $table->text('closure_notes')->nullable();
            $table->enum('closure_reason', ['resolved', 'referred', 'discontinued', 'unresponsive', 'other'])->nullable();
            $table->integer('total_sessions')->default(0);
            $table->integer('planned_sessions')->nullable();
            $table->json('goals')->nullable(); // Case objectives
            $table->foreignId('opened_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('case_number');
            $table->index('member_id');
            $table->index('primary_counsellor_id');
            $table->index('status');
        });

        // Counselling sessions
        Schema::create('counselling_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_code', 20)->unique();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('counsellor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('case_id')->nullable()->constrained('counselling_cases')->nullOnDelete();
            $table->enum('session_type', [
                'pre_marital',
                'marriage',
                'youth',
                'addiction',
                'grief',
                'career',
                'spiritual',
                'family',
                'other',
            ]);
            $table->date('session_date');
            $table->time('session_time');
            $table->integer('duration_minutes')->default(60);
            $table->enum('mode', ['in_person', 'phone', 'video', 'email'])->default('in_person');
            $table->string('location')->nullable();
            $table->string('video_link')->nullable();
            $table->enum('urgency_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rescheduled', 'no_show'])->default('scheduled');
            $table->text('booking_notes')->nullable();
            $table->text('session_notes')->nullable(); // Will be encrypted
            $table->json('action_items')->nullable();
            $table->text('progress_assessment')->nullable();
            $table->boolean('follow_up_required')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->enum('outcome', ['resolved', 'ongoing', 'referred', 'discontinued'])->nullable();
            $table->integer('session_number')->default(1); // Session number in case series
            $table->foreignId('booked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('session_code');
            $table->index('member_id');
            $table->index('counsellor_id');
            $table->index('case_id');
            $table->index(['session_date', 'session_time']);
            $table->index('status');
        });

        // Case documents
        Schema::create('counselling_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('counselling_cases')->cascadeOnDelete();
            $table->string('document_name');
            $table->string('document_type'); // consent_form, assessment, referral, report, etc.
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->boolean('is_encrypted')->default(false);
            $table->text('description')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('case_id');
        });

        // Referrals (external referrals to specialists)
        Schema::create('counselling_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->nullable()->constrained('counselling_sessions')->nullOnDelete();
            $table->foreignId('case_id')->nullable()->constrained('counselling_cases')->nullOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('referred_to'); // Name of specialist/organization
            $table->string('specialty');
            $table->text('reason_for_referral');
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->date('referral_date');
            $table->enum('status', ['pending', 'accepted', 'declined', 'completed'])->default('pending');
            $table->text('feedback')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->foreignId('referred_by')->constrained('counsellors')->cascadeOnDelete();
            $table->timestamps();

            $table->index('member_id');
            $table->index('status');
        });

        // Consent forms
        Schema::create('counselling_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->enum('consent_type', ['general', 'minor', 'information_sharing', 'recording'])->default('general');
            $table->text('consent_text');
            $table->boolean('is_agreed')->default(false);
            $table->string('signature_path')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('member_id');
        });

        // Counselling resources library
        Schema::create('counselling_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('resource_type', ['article', 'video', 'audio', 'book', 'worksheet', 'guide', 'other'])->default('article');
            $table->json('categories'); // Issue categories this resource helps with
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->text('content')->nullable(); // For articles stored in DB
            $table->string('author')->nullable();
            $table->integer('reading_time_minutes')->nullable();
            $table->boolean('is_public')->default(false); // Can members access directly?
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            $table->json('tags')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('resource_type');
        });

        // Session feedback
        Schema::create('counselling_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('counselling_sessions')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->integer('rating')->default(5); // 1-5 stars
            $table->text('comments')->nullable();
            $table->boolean('would_recommend')->default(true);
            $table->json('helpful_aspects')->nullable();
            $table->json('improvement_suggestions')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();

            $table->index('session_id');
            $table->index('member_id');
        });

        // Counselling statistics snapshot
        Schema::create('counselling_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('snapshot_date');
            $table->integer('total_sessions')->default(0);
            $table->integer('completed_sessions')->default(0);
            $table->integer('cancelled_sessions')->default(0);
            $table->integer('active_cases')->default(0);
            $table->integer('resolved_cases')->default(0);
            $table->json('sessions_by_type')->nullable();
            $table->json('sessions_by_counsellor')->nullable();
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->integer('total_members_counselled')->default(0);
            $table->timestamps();

            $table->index('snapshot_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselling_statistics');
        Schema::dropIfExists('counselling_feedback');
        Schema::dropIfExists('counselling_resources');
        Schema::dropIfExists('counselling_consents');
        Schema::dropIfExists('counselling_referrals');
        Schema::dropIfExists('counselling_documents');
        Schema::dropIfExists('counselling_sessions');
        Schema::dropIfExists('counselling_cases');
        Schema::dropIfExists('counsellor_schedules');
        Schema::dropIfExists('counsellors');
    }
};
