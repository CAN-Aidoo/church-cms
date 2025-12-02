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
        // System settings table
        if (! Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string'); // string, integer, boolean, json, text
                $table->string('group')->default('general'); // general, email, sms, notifications, security, etc.
                $table->text('description')->nullable();
                $table->boolean('is_encrypted')->default(false);
                $table->boolean('is_public')->default(false);
                $table->timestamps();

                $table->index(['group', 'key']);
            });
        }

        // Email templates table
        if (! Schema::hasTable('email_templates')) {
            Schema::create('email_templates', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('subject');
                $table->longText('body_html');
                $table->longText('body_text')->nullable();
                $table->json('available_variables')->nullable();
                $table->string('category')->default('general');
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index('category');
            });
        }

        // SMS templates table
        if (! Schema::hasTable('sms_templates')) {
            Schema::create('sms_templates', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('message');
                $table->json('available_variables')->nullable();
                $table->string('category')->default('general');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Audit logs table - skip if already exists (created in earlier migration)
        if (! Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('action');
                $table->string('auditable_type');
                $table->unsignedBigInteger('auditable_id')->nullable();
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();

                $table->index(['auditable_type', 'auditable_id']);
                $table->index('user_id');
                $table->index('created_at');
            });
        }

        // System backups table
        if (! Schema::hasTable('system_backups')) {
            Schema::create('system_backups', function (Blueprint $table) {
                $table->id();
                $table->string('filename');
                $table->string('type'); // full, database, files
                $table->bigInteger('size')->default(0);
                $table->string('storage_path');
                $table->enum('status', ['pending', 'in_progress', 'completed', 'failed'])->default('pending');
                $table->text('error_message')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_backups');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('sms_templates');
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('system_settings');
    }
};
