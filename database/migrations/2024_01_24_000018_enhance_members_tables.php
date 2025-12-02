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
        // Families table - CREATE FIRST before adding foreign keys
        if (! Schema::hasTable('families')) {
            Schema::create('families', function (Blueprint $table) {
                $table->id();
                $table->string('family_name');
                $table->string('family_code')->unique();
                $table->foreignId('head_of_family_id')->nullable()->constrained('members')->onDelete('set null');
                $table->text('family_address')->nullable();
                $table->string('family_phone')->nullable();
                $table->string('family_email')->nullable();
                $table->string('family_photo_url')->nullable();
                $table->date('wedding_anniversary')->nullable();
                $table->json('family_notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('family_code');
                $table->index('head_of_family_id');
            });
        }

        // Add enhanced fields to members table AFTER creating families table
        if (! Schema::hasColumn('members', 'middle_name')) {
            Schema::table('members', function (Blueprint $table) {
                // Extended personal information
                $table->string('middle_name')->nullable()->after('first_name');
                $table->string('education_level')->nullable()->after('occupation');
                $table->string('workplace')->nullable()->after('occupation');
                $table->string('blood_group')->nullable()->after('date_of_birth');
                $table->text('allergies')->nullable()->after('blood_group');
                $table->text('medical_conditions')->nullable()->after('allergies');
                $table->json('custom_fields')->nullable()->after('notes');

                // Extended contact information
                $table->string('whatsapp_phone')->nullable()->after('phone');
                $table->string('work_email')->nullable()->after('email');
                $table->string('gps_location')->nullable()->after('address');

                // Church information enhancements
                $table->boolean('is_baptized')->default(false)->after('join_date');
                $table->date('baptism_date')->nullable()->after('is_baptized');
                $table->string('baptism_location')->nullable()->after('baptism_date');
                $table->boolean('is_holy_spirit_baptized')->default(false)->after('baptism_location');
                $table->date('holy_spirit_baptism_date')->nullable()->after('is_holy_spirit_baptized');
                $table->json('spiritual_gifts')->nullable()->after('holy_spirit_baptism_date');
                $table->json('ministry_involvement')->nullable()->after('spiritual_gifts');

                // Family relationships
                $table->foreignId('family_id')->nullable()->constrained('families')->onDelete('set null')->after('shepherd_id');
                $table->foreignId('spouse_id')->nullable()->constrained('members')->onDelete('set null')->after('family_id');

                // Additional indexes
                $table->index('family_id');
                $table->index('spouse_id');
                $table->index(['is_baptized', 'baptism_date']);
            });
        }

        // Children table
        if (! Schema::hasTable('children')) {
            Schema::create('children', function (Blueprint $table) {
                $table->id();
                $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
                $table->string('first_name');
                $table->string('middle_name')->nullable();
                $table->string('last_name');
                $table->date('date_of_birth');
                $table->enum('gender', ['male', 'female']);
                $table->string('blood_group')->nullable();
                $table->text('allergies')->nullable();
                $table->text('medical_conditions')->nullable();
                $table->string('school')->nullable();
                $table->string('grade_level')->nullable();
                $table->string('photo_url')->nullable();
                $table->json('pick_up_authorization')->nullable(); // List of authorized people
                $table->json('emergency_contacts')->nullable();
                $table->json('growth_milestones')->nullable();
                $table->boolean('is_active')->default(true);
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('family_id');
                $table->index(['first_name', 'last_name']);
                $table->index('date_of_birth');
            });
        }

        // Member documents table
        if (! Schema::hasTable('member_documents')) {
            Schema::create('member_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('document_type'); // baptism_certificate, marriage_certificate, transfer_letter, etc.
                $table->string('document_name');
                $table->string('file_path');
                $table->string('file_type');
                $table->integer('file_size')->default(0);
                $table->string('category')->nullable();
                $table->json('tags')->nullable();
                $table->text('description')->nullable();
                $table->date('issue_date')->nullable();
                $table->date('expiry_date')->nullable();
                $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();

                $table->index('member_id');
                $table->index('document_type');
                $table->index('category');
            });
        }

        // Member lifecycle events table
        if (! Schema::hasTable('member_lifecycle_events')) {
            Schema::create('member_lifecycle_events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('event_type'); // joined, baptized, married, transferred, suspended, reinstated, deceased
                $table->date('event_date');
                $table->string('event_location')->nullable();
                $table->text('event_details')->nullable();
                $table->json('metadata')->nullable();
                $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index('member_id');
                $table->index('event_type');
                $table->index('event_date');
            });
        }

        // Member notes table
        if (! Schema::hasTable('member_notes')) {
            Schema::create('member_notes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('note_type'); // pastoral, counselling, disciplinary, award, general
                $table->string('title');
                $table->longText('content');
                $table->enum('visibility', ['private', 'pastors_only', 'staff'])->default('pastors_only');
                $table->boolean('is_sensitive')->default(false);
                $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();

                $table->index('member_id');
                $table->index('note_type');
                $table->index('visibility');
            });
        }

        // Member service units (many-to-many)
        if (! Schema::hasTable('member_service_unit')) {
            Schema::create('member_service_unit', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->foreignId('service_unit_id')->constrained('service_units')->onDelete('cascade');
                $table->enum('role', ['member', 'leader', 'assistant_leader'])->default('member');
                $table->date('joined_date');
                $table->date('left_date')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->unique(['member_id', 'service_unit_id']);
                $table->index('is_active');
            });
        }

        // Member photo versions (for profile photo history)
        if (! Schema::hasTable('member_photo_versions')) {
            Schema::create('member_photo_versions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('photo_url');
                $table->string('photo_type')->default('profile'); // profile, family, event
                $table->integer('width')->nullable();
                $table->integer('height')->nullable();
                $table->integer('file_size')->nullable();
                $table->boolean('is_current')->default(false);
                $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index('member_id');
                $table->index('is_current');
            });
        }

        // Member transfers table
        if (! Schema::hasTable('member_transfers')) {
            Schema::create('member_transfers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->enum('transfer_type', ['incoming', 'outgoing']);
                $table->string('previous_church')->nullable();
                $table->string('new_church')->nullable();
                $table->date('transfer_date');
                $table->text('transfer_reason')->nullable();
                $table->string('transfer_letter_path')->nullable();
                $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->default('pending');
                $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamp('approved_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index('member_id');
                $table->index('transfer_type');
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_transfers');
        Schema::dropIfExists('member_photo_versions');
        Schema::dropIfExists('member_service_unit');
        Schema::dropIfExists('member_notes');
        Schema::dropIfExists('member_lifecycle_events');
        Schema::dropIfExists('member_documents');
        Schema::dropIfExists('children');
        Schema::dropIfExists('families');

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'middle_name',
                'education_level',
                'workplace',
                'blood_group',
                'allergies',
                'medical_conditions',
                'custom_fields',
                'whatsapp_phone',
                'work_email',
                'gps_location',
                'is_baptized',
                'baptism_date',
                'baptism_location',
                'is_holy_spirit_baptized',
                'holy_spirit_baptism_date',
                'spiritual_gifts',
                'ministry_involvement',
                'family_id',
                'spouse_id',
            ]);
        });
    }
};
