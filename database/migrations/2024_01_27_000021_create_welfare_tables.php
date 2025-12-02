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
        // Welfare cases
        Schema::create('welfare_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number', 20)->unique();
            $table->foreignId('beneficiary_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('beneficiary_name'); // In case non-member
            $table->string('beneficiary_phone')->nullable();
            $table->string('beneficiary_email')->nullable();
            $table->text('address')->nullable();
            $table->enum('case_category', [
                'medical',
                'education',
                'housing',
                'food',
                'emergency',
                'bereavement',
                'job_loss',
                'other',
            ]);
            $table->string('case_title');
            $table->text('case_description');
            $table->json('supporting_documents')->nullable(); // Array of file paths
            $table->decimal('amount_requested', 12, 2)->nullable();
            $table->decimal('amount_approved', 12, 2)->nullable();
            $table->decimal('amount_disbursed', 12, 2)->default(0);
            $table->enum('status', [
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'disbursed',
                'closed',
            ])->default('submitted');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->integer('priority_score')->nullable(); // Auto-calculated
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('approval_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->date('case_date');
            $table->date('closed_date')->nullable();
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('case_number');
            $table->index('beneficiary_id');
            $table->index('status');
            $table->index('case_category');
            $table->index('priority');
        });

        // Home visitation reports
        Schema::create('welfare_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('welfare_cases')->cascadeOnDelete();
            $table->date('visit_date');
            $table->time('visit_time')->nullable();
            $table->foreignId('visitor_id')->constrained('users')->cascadeOnDelete();
            $table->text('visit_notes');
            $table->json('findings')->nullable(); // Structured assessment data
            $table->json('photos')->nullable(); // Evidence photos
            $table->enum('recommendation', ['approve', 'reject', 'further_investigation'])->nullable();
            $table->text('recommendation_notes')->nullable();
            $table->timestamps();

            $table->index('case_id');
            $table->index('visit_date');
        });

        // Welfare fund transactions
        Schema::create('welfare_fund_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code', 20)->unique();
            $table->enum('type', ['collection', 'disbursement', 'transfer', 'adjustment']);
            $table->string('category'); // offering, appeal, donation, case_disbursement, admin, etc.
            $table->text('description');
            $table->decimal('amount', 12, 2);
            $table->date('transaction_date');
            $table->foreignId('case_id')->nullable()->constrained('welfare_cases')->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete(); // For donations
            $table->string('reference_number')->nullable();
            $table->enum('payment_method', ['cash', 'bank_transfer', 'cheque', 'mobile_money', 'other'])->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('transaction_code');
            $table->index('type');
            $table->index('transaction_date');
            $table->index('case_id');
        });

        // Welfare programs
        Schema::create('welfare_programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->enum('program_type', [
                'widows_orphans',
                'elderly_care',
                'scholarships',
                'medical_assistance',
                'food_bank',
                'disaster_relief',
                'other',
            ]);
            $table->text('description')->nullable();
            $table->decimal('budget_allocated', 12, 2)->nullable();
            $table->decimal('budget_spent', 12, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'paused', 'completed', 'cancelled'])->default('active');
            $table->integer('beneficiaries_count')->default(0);
            $table->json('eligibility_criteria')->nullable();
            $table->foreignId('coordinator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('program_type');
            $table->index('status');
        });

        // Beneficiary enrollment in programs
        Schema::create('welfare_program_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('welfare_programs')->cascadeOnDelete();
            $table->foreignId('beneficiary_id')->constrained('members')->cascadeOnDelete();
            $table->date('enrollment_date');
            $table->decimal('support_amount', 12, 2)->nullable();
            $table->enum('frequency', ['one_time', 'weekly', 'monthly', 'quarterly', 'annually'])->nullable();
            $table->date('next_payment_date')->nullable();
            $table->enum('status', ['active', 'suspended', 'graduated', 'withdrawn'])->default('active');
            $table->date('graduation_date')->nullable();
            $table->text('graduation_notes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['program_id', 'beneficiary_id']);
            $table->index('status');
        });

        // Welfare volunteers
        Schema::create('welfare_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('skills')->nullable(); // nursing, counselling, teaching, etc.
            $table->json('availability')->nullable(); // days/times available
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('emergency_contact')->nullable();
            $table->integer('hours_contributed')->default(0);
            $table->date('joined_date');
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('status');
        });

        // Volunteer assignments
        Schema::create('welfare_volunteer_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('welfare_volunteers')->cascadeOnDelete();
            $table->foreignId('case_id')->nullable()->constrained('welfare_cases')->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('welfare_programs')->nullOnDelete();
            $table->string('task_description');
            $table->date('assignment_date');
            $table->date('due_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->integer('hours_logged')->nullable();
            $table->enum('status', ['assigned', 'in_progress', 'completed', 'cancelled'])->default('assigned');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('volunteer_id');
            $table->index('status');
        });

        // Welfare impact assessments
        Schema::create('welfare_impact_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('welfare_cases')->cascadeOnDelete();
            $table->date('assessment_date');
            $table->foreignId('assessor_id')->constrained('users')->cascadeOnDelete();
            $table->text('situation_before');
            $table->text('situation_after');
            $table->json('impact_indicators')->nullable(); // health, education, housing, income
            $table->enum('overall_impact', ['very_positive', 'positive', 'neutral', 'negative'])->default('positive');
            $table->text('success_story')->nullable();
            $table->boolean('can_share_testimony')->default(false);
            $table->json('photos')->nullable();
            $table->timestamps();

            $table->index('case_id');
            $table->index('assessment_date');
        });

        // Welfare budget allocations
        Schema::create('welfare_budget_allocations', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->enum('category', [
                'medical',
                'education',
                'housing',
                'food_bank',
                'emergency',
                'programs',
                'administration',
                'other',
            ]);
            $table->decimal('allocated_amount', 12, 2);
            $table->decimal('spent_amount', 12, 2)->default(0);
            $table->decimal('committed_amount', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['year', 'category']);
        });

        // Welfare committee decisions
        Schema::create('welfare_committee_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('welfare_cases')->cascadeOnDelete();
            $table->date('meeting_date');
            $table->json('committee_members')->nullable(); // Array of user IDs
            $table->enum('decision', ['approved', 'rejected', 'deferred', 'more_info_needed']);
            $table->text('decision_notes');
            $table->decimal('approved_amount', 12, 2)->nullable();
            $table->json('conditions')->nullable(); // Terms/conditions for approval
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('case_id');
            $table->index('meeting_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welfare_committee_decisions');
        Schema::dropIfExists('welfare_budget_allocations');
        Schema::dropIfExists('welfare_impact_assessments');
        Schema::dropIfExists('welfare_volunteer_assignments');
        Schema::dropIfExists('welfare_volunteers');
        Schema::dropIfExists('welfare_program_beneficiaries');
        Schema::dropIfExists('welfare_programs');
        Schema::dropIfExists('welfare_fund_transactions');
        Schema::dropIfExists('welfare_visits');
        Schema::dropIfExists('welfare_cases');
    }
};
