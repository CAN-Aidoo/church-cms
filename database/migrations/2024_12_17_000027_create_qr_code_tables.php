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
        // QR Codes Table - Main table for generated QR codes
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type', 50); // SERVICE_ATTENDANCE, EVENT_REGISTRATION, PAYMENT, etc.
            $table->string('church_id', 50);
            $table->date('service_date')->nullable();
            $table->string('service_type', 50)->nullable(); // sunday_first, midweek, etc.
            $table->dateTime('activation_time')->nullable();
            $table->dateTime('expiration_time')->nullable();
            $table->boolean('location_required')->default(true);
            $table->decimal('location_latitude', 10, 7)->nullable();
            $table->decimal('location_longitude', 10, 7)->nullable();
            $table->integer('location_radius')->default(100); // meters
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('generated_at')->useCurrent();
            $table->string('status', 20)->default('PENDING'); // PENDING, ACTIVE, EXPIRED, REVOKED
            $table->boolean('revoked')->default(false);
            $table->foreignId('revoked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('revoked_at')->nullable();
            $table->integer('max_scans')->nullable(); // null = unlimited
            $table->boolean('allow_family')->default(true);
            $table->boolean('requires_verification')->default(false);
            $table->boolean('offline_allowed')->default(true);
            $table->json('metadata')->nullable(); // Additional config data
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index(['activation_time', 'expiration_time']);
            $table->index(['type', 'service_date']);
            $table->index('church_id');
        });

        // QR Scan Logs Table - Track every scan attempt
        Schema::create('qr_scan_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('qr_id')->constrained('qr_codes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('scan_time');
            $table->decimal('location_latitude', 10, 7)->nullable();
            $table->decimal('location_longitude', 10, 7)->nullable();
            $table->decimal('location_accuracy', 8, 2)->nullable(); // meters
            $table->integer('distance_from_church')->nullable(); // meters
            $table->string('device_id', 100)->nullable();
            $table->string('device_type', 50)->nullable(); // ios, android, web
            $table->ipAddress('ip_address')->nullable();
            $table->boolean('success');
            $table->string('error_reason', 200)->nullable();
            $table->integer('processing_time')->nullable(); // milliseconds
            $table->boolean('offline_sync')->default(false);
            $table->timestamp('synced_at')->nullable();
            $table->string('scan_result', 50)->nullable(); // CHECK_IN_SUCCESS, ATTENDANCE_MARKED, etc.
            $table->json('metadata')->nullable(); // Additional scan data
            $table->timestamps();

            // Indexes
            $table->index('qr_id');
            $table->index('user_id');
            $table->index('scan_time');
            $table->index(['success', 'scan_time']);
            $table->index('offline_sync');
        });

        // QR Analytics Table - Aggregated analytics data
        Schema::create('qr_analytics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('qr_id')->constrained('qr_codes')->onDelete('cascade');
            $table->date('date');
            $table->integer('total_scans')->default(0);
            $table->integer('unique_users')->default(0);
            $table->integer('successful_scans')->default(0);
            $table->integer('failed_scans')->default(0);
            $table->decimal('success_rate', 5, 2)->nullable(); // percentage
            $table->integer('avg_scan_time')->nullable(); // milliseconds
            $table->timestamp('peak_time')->nullable();
            $table->integer('peak_scans')->default(0);
            $table->integer('error_count')->default(0);
            $table->integer('offline_syncs')->default(0);
            $table->integer('gps_failures')->default(0);
            $table->integer('duplicate_attempts')->default(0);
            $table->json('hourly_distribution')->nullable(); // Scan distribution by hour
            $table->json('error_categories')->nullable(); // Error breakdown
            $table->json('device_breakdown')->nullable(); // iOS vs Android stats
            $table->timestamps();

            // Indexes
            $table->index('qr_id');
            $table->index('date');
            $table->unique(['qr_id', 'date']); // One analytics record per QR per day
        });

        // QR Code Settings Table - Global QR configuration
        Schema::create('qr_code_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 100)->unique();
            $table->text('setting_value');
            $table->string('setting_type', 50); // string, integer, boolean, json
            $table->text('description')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('qr_code_settings')->insert([
            [
                'setting_key' => 'default_location_radius',
                'setting_value' => '100',
                'setting_type' => 'integer',
                'description' => 'Default GPS radius in meters for location verification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'default_activation_offset',
                'setting_value' => '15',
                'setting_type' => 'integer',
                'description' => 'Minutes before service start that QR becomes active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'default_expiration_offset',
                'setting_value' => '30',
                'setting_type' => 'integer',
                'description' => 'Minutes after service end that QR expires',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'church_coordinates',
                'setting_value' => '{"lat": 5.6037, "lng": -0.1870}',
                'setting_type' => 'json',
                'description' => 'Main church GPS coordinates (Accra example)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'enable_offline_mode',
                'setting_value' => 'true',
                'setting_type' => 'boolean',
                'description' => 'Allow offline scanning with later sync',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'enable_gps_verification',
                'setting_value' => 'true',
                'setting_type' => 'boolean',
                'description' => 'Require GPS verification for scans',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'qr_refresh_interval',
                'setting_value' => '30',
                'setting_type' => 'integer',
                'description' => 'Seconds between QR code refresh for anti-screenshot',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'encryption_key',
                'setting_value' => bin2hex(random_bytes(32)),
                'setting_type' => 'string',
                'description' => 'AES-256 encryption key for QR data (DO NOT SHARE)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_analytics');
        Schema::dropIfExists('qr_scan_logs');
        Schema::dropIfExists('qr_codes');
        Schema::dropIfExists('qr_code_settings');
    }
};
