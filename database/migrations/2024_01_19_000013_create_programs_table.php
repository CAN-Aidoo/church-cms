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
        // 1. Programs table
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['conference', 'seminar', 'crusade', 'retreat', 'workshop', 'training', 'other'])->default('other');
            $table->string('category')->default('other'); // Changed from enum to string
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('venue_gps')->nullable();
            $table->text('target_audience')->nullable();
            $table->integer('max_participants')->nullable();
            $table->integer('current_participants')->default(0);
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->boolean('requires_registration')->default(false);
            $table->string('flyer_path')->nullable();
            $table->json('additional_info')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('coordinator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['start_date', 'end_date']);
            $table->index('status');
            $table->index('category');
        });

        // 2. Program sessions table
        Schema::create('program_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue')->nullable();
            $table->string('speaker_name')->nullable();
            $table->text('speaker_bio')->nullable();
            $table->text('materials_required')->nullable();
            $table->integer('max_attendees')->nullable();
            $table->integer('current_attendees')->default(0);
            $table->timestamps();

            $table->index(['program_id', 'session_date']);
        });

        // 3. Program registrations table
        Schema::create('program_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->text('special_requirements')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'waitlist', 'cancelled', 'attended'])->default('pending');
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid', 'refunded'])->default('unpaid');
            $table->string('payment_reference')->nullable();
            $table->string('badge_number')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();

            $table->unique(['program_id', 'member_id']);
            $table->index('status');
            $table->index('payment_status');
        });

        // 4. Program attendance table (per session)
        Schema::create('program_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('session_id')->constrained('program_sessions')->onDelete('cascade');
            $table->foreignId('registration_id')->constrained('program_registrations')->onDelete('cascade');
            $table->timestamp('checked_in_at')->useCurrent();
            $table->enum('attendance_method', ['qr_code', 'manual', 'badge_scan'])->default('manual');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['session_id', 'registration_id']);
            $table->index(['program_id', 'session_id']);
        });

        // 5. Program resources table
        Schema::create('program_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->enum('resource_type', ['room', 'equipment', 'volunteer', 'catering', 'transport', 'other'])->default('other');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('cost', 10, 2)->default(0);
            $table->enum('status', ['requested', 'allocated', 'confirmed', 'unavailable'])->default('requested');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['program_id', 'resource_type']);
        });

        // 6. Program feedback table
        Schema::create('program_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('registration_id')->constrained('program_registrations')->onDelete('cascade');
            $table->integer('overall_rating')->nullable(); // 1-5
            $table->integer('content_rating')->nullable(); // 1-5
            $table->integer('organization_rating')->nullable(); // 1-5
            $table->integer('venue_rating')->nullable(); // 1-5
            $table->text('comments')->nullable();
            $table->text('suggestions')->nullable();
            $table->boolean('would_recommend')->default(true);
            $table->timestamps();

            $table->unique(['program_id', 'registration_id']);
        });

        // 7. Program volunteers table
        Schema::create('program_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('role', ['coordinator', 'usher', 'registration', 'technical', 'catering', 'logistics', 'other'])->default('other');
            $table->text('responsibilities')->nullable();
            $table->date('assigned_date')->nullable();
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->enum('status', ['invited', 'confirmed', 'declined', 'attended'])->default('invited');
            $table->timestamps();

            $table->unique(['program_id', 'member_id', 'role']);
            $table->index(['program_id', 'status']);
        });

        // 8. Program certificates table
        Schema::create('program_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('registration_id')->constrained('program_registrations')->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->string('certificate_path')->nullable();
            $table->timestamp('issued_at')->useCurrent();
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('certificate_number');
        });

        // 9. Program announcements table
        Schema::create('program_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('announcement_type', ['general', 'reminder', 'update', 'cancellation', 'resource'])->default('general');
            $table->enum('target_audience', ['all', 'registered', 'waitlist', 'volunteers'])->default('all');
            $table->boolean('send_sms')->default(false);
            $table->boolean('send_email')->default(true);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['program_id', 'announcement_type']);
        });

        // 10. Program expenses table
        Schema::create('program_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->string('expense_category'); // venue, catering, materials, transport, etc.
            $table->text('description');
            $table->decimal('amount', 10, 2);
            $table->date('expense_date');
            $table->string('receipt_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending');
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['program_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_expenses');
        Schema::dropIfExists('program_announcements');
        Schema::dropIfExists('program_certificates');
        Schema::dropIfExists('program_volunteers');
        Schema::dropIfExists('program_feedback');
        Schema::dropIfExists('program_resources');
        Schema::dropIfExists('program_attendance');
        Schema::dropIfExists('program_registrations');
        Schema::dropIfExists('program_sessions');
        Schema::dropIfExists('programs');
    }
};
