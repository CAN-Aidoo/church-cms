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
        // Media team members
        Schema::create('media_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('primary_role', [
                'media_director',
                'camera_operator',
                'sound_engineer',
                'graphics_designer',
                'video_editor',
                'streaming_technician',
                'photographer',
                'other',
            ]);
            $table->json('skills')->nullable(); // Array of skills
            $table->json('availability')->nullable(); // Days/times available
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('joined_date');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('primary_role');
            $table->index('is_active');
        });

        // Service coverage assignments
        Schema::create('media_service_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('service_schedules')->nullOnDelete();
            $table->date('service_date');
            $table->time('service_time');
            $table->string('service_name'); // Sunday 1st, Sunday 2nd, Midweek, etc.
            $table->foreignId('team_member_id')->constrained('media_team_members')->cascadeOnDelete();
            $table->string('assigned_role');
            $table->foreignId('backup_id')->nullable()->constrained('media_team_members')->nullOnDelete();
            $table->json('equipment_assigned')->nullable();
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['service_date', 'service_time']);
            $table->index('team_member_id');
            $table->index('status');
        });

        // Live streaming sessions
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('service_schedules')->nullOnDelete();
            $table->string('stream_title');
            $table->text('stream_description')->nullable();
            $table->datetime('scheduled_start');
            $table->datetime('scheduled_end')->nullable();
            $table->datetime('actual_start')->nullable();
            $table->datetime('actual_end')->nullable();
            $table->json('platforms')->nullable(); // YouTube, Facebook, etc.
            $table->json('stream_urls')->nullable(); // URLs for each platform
            $table->json('stream_keys')->nullable(); // Encrypted stream keys
            $table->enum('status', ['scheduled', 'live', 'ended', 'cancelled'])->default('scheduled');
            $table->integer('peak_viewers')->default(0);
            $table->integer('total_views')->default(0);
            $table->json('viewer_stats')->nullable(); // Time-based viewer counts
            $table->boolean('is_recorded')->default(true);
            $table->string('recording_url')->nullable();
            $table->foreignId('technician_id')->constrained('media_team_members')->cascadeOnDelete();
            $table->text('technical_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('scheduled_start');
            $table->index('status');
        });

        // Media library content
        Schema::create('media_content', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('content_type', [
                'sermon_video',
                'sermon_audio',
                'event_video',
                'testimony',
                'worship_session',
                'photo_gallery',
                'other',
            ]);
            $table->foreignId('service_id')->nullable()->constrained('service_schedules')->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->date('content_date');
            $table->string('speaker')->nullable();
            $table->string('sermon_title')->nullable();
            $table->string('sermon_series')->nullable();
            $table->json('file_paths')->nullable(); // Array of file locations
            $table->string('thumbnail_path')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->bigInteger('file_size')->nullable(); // bytes
            $table->json('tags')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->enum('visibility', ['public', 'members_only', 'private'])->default('public');
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('media_team_members')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('content_type');
            $table->index('content_date');
            $table->index('is_published');
        });

        // Photo galleries
        Schema::create('photo_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('gallery_name');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->foreignId('event_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->string('cover_photo')->nullable();
            $table->integer('photo_count')->default(0);
            $table->enum('visibility', ['public', 'members_only', 'private'])->default('public');
            $table->foreignId('photographer_id')->nullable()->constrained('media_team_members')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('event_date');
        });

        // Gallery photos
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('photo_galleries')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->text('caption')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('file_size')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->index('gallery_id');
        });

        // Equipment inventory
        Schema::create('media_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->enum('category', [
                'camera',
                'lens',
                'audio',
                'lighting',
                'computer',
                'software',
                'cables',
                'accessories',
                'other',
            ]);
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor', 'broken'])->default('good');
            $table->enum('status', ['available', 'in_use', 'maintenance', 'retired'])->default('available');
            $table->foreignId('assigned_to')->nullable()->constrained('media_team_members')->nullOnDelete();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('status');
        });

        // Equipment maintenance log
        Schema::create('equipment_maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('media_equipment')->cascadeOnDelete();
            $table->date('service_date');
            $table->enum('service_type', ['routine', 'repair', 'calibration', 'upgrade', 'cleaning']);
            $table->text('description');
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('performed_by')->nullable();
            $table->date('next_service_date')->nullable();
            $table->timestamps();

            $table->index('equipment_id');
            $table->index('service_date');
        });

        // Production rundowns
        Schema::create('production_rundowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('service_schedules')->nullOnDelete();
            $table->date('service_date');
            $table->string('service_name');
            $table->json('rundown_items')->nullable(); // Ordered array of segments
            $table->json('shot_list')->nullable();
            $table->json('graphics_needed')->nullable();
            $table->time('sound_check_time')->nullable();
            $table->text('special_notes')->nullable();
            $table->enum('status', ['draft', 'finalized', 'in_progress', 'completed'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('service_date');
            $table->index('status');
        });

        // Editing queue
        Schema::create('editing_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->nullable()->constrained('media_content')->nullOnDelete();
            $table->string('project_title');
            $table->text('project_description')->nullable();
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', ['pending', 'in_progress', 'review', 'approved', 'published'])->default('pending');
            $table->json('raw_files')->nullable(); // Source file paths
            $table->foreignId('assigned_to')->nullable()->constrained('media_team_members')->nullOnDelete();
            $table->date('due_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->text('editor_notes')->nullable();
            $table->text('review_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('status');
            $table->index('priority');
            $table->index('assigned_to');
        });

        // Training sessions
        Schema::create('media_training_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_title');
            $table->text('description')->nullable();
            $table->string('topic'); // Camera basics, audio mixing, streaming, etc.
            $table->datetime('session_date');
            $table->integer('duration_minutes');
            $table->string('location')->nullable();
            $table->foreignId('trainer_id')->constrained('media_team_members')->cascadeOnDelete();
            $table->integer('max_participants')->nullable();
            $table->integer('registered_count')->default(0);
            $table->json('materials')->nullable(); // Training materials/resources
            $table->timestamps();

            $table->index('session_date');
        });

        // Training registrations
        Schema::create('media_training_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('media_training_sessions')->cascadeOnDelete();
            $table->foreignId('team_member_id')->constrained('media_team_members')->cascadeOnDelete();
            $table->enum('attendance_status', ['registered', 'attended', 'absent', 'cancelled'])->default('registered');
            $table->integer('assessment_score')->nullable();
            $table->boolean('certified')->default(false);
            $table->timestamps();

            $table->unique(['session_id', 'team_member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_training_registrations');
        Schema::dropIfExists('media_training_sessions');
        Schema::dropIfExists('editing_queue');
        Schema::dropIfExists('production_rundowns');
        Schema::dropIfExists('equipment_maintenance_logs');
        Schema::dropIfExists('media_equipment');
        Schema::dropIfExists('gallery_photos');
        Schema::dropIfExists('photo_galleries');
        Schema::dropIfExists('media_content');
        Schema::dropIfExists('live_streams');
        Schema::dropIfExists('media_service_assignments');
        Schema::dropIfExists('media_team_members');
    }
};
