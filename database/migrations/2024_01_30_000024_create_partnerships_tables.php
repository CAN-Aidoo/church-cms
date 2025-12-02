<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Partners
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->enum('partner_type', ['organization', 'individual'])->default('organization');
            $table->string('name');
            $table->enum('category', ['ministry', 'mission', 'corporate_sponsor', 'sister_church', 'international', 'media', 'other'])->default('ministry');
            $table->text('description')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('status');
        });

        // Partnership agreements
        Schema::create('partnership_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->string('agreement_title');
            $table->text('terms_conditions')->nullable();
            $table->decimal('financial_commitment', 12, 2)->nullable();
            $table->json('deliverables')->nullable();
            $table->json('reporting_requirements')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('duration_months')->nullable();
            $table->boolean('auto_renew')->default(false);
            $table->enum('status', ['draft', 'active', 'expired', 'terminated'])->default('draft');
            $table->string('document_path')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('partner_id');
            $table->index(['start_date', 'end_date']);
        });

        // Partnership activities
        Schema::create('partnership_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->string('activity_title');
            $table->enum('activity_type', ['joint_program', 'resource_sharing', 'exchange', 'collaborative_project', 'support_initiative', 'other']);
            $table->text('description')->nullable();
            $table->date('activity_date');
            $table->json('participants')->nullable();
            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');
            $table->text('outcomes')->nullable();
            $table->foreignId('coordinator_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('partner_id');
            $table->index('activity_date');
        });

        // Partnership financials
        Schema::create('partnership_financials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['inflow', 'outflow']);
            $table->enum('category', ['contribution', 'sponsorship', 'grant', 'mission_support', 'partnership_fee', 'project_funding', 'other']);
            $table->text('description');
            $table->decimal('amount', 12, 2);
            $table->date('transaction_date');
            $table->string('reference_number')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('partner_id');
            $table->index('transaction_date');
        });

        // Partnership communications
        Schema::create('partnership_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->enum('communication_type', ['email', 'meeting', 'call', 'report', 'newsletter', 'other']);
            $table->string('subject');
            $table->text('message')->nullable();
            $table->datetime('communication_date');
            $table->json('attachments')->nullable();
            $table->foreignId('sent_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('partner_id');
            $table->index('communication_date');
        });

        // Partnership impact assessments
        Schema::create('partnership_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->date('assessment_date');
            $table->text('goals_achieved')->nullable();
            $table->json('metrics')->nullable();
            $table->integer('roi_score')->nullable();
            $table->text('benefits')->nullable();
            $table->text('challenges')->nullable();
            $table->enum('overall_rating', ['excellent', 'good', 'satisfactory', 'needs_improvement'])->default('satisfactory');
            $table->text('recommendations')->nullable();
            $table->foreignId('assessed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('partner_id');
            $table->index('assessment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partnership_assessments');
        Schema::dropIfExists('partnership_communications');
        Schema::dropIfExists('partnership_financials');
        Schema::dropIfExists('partnership_activities');
        Schema::dropIfExists('partnership_agreements');
        Schema::dropIfExists('partners');
    }
};
