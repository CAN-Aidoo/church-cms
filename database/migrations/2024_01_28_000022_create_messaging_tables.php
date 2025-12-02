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
        // Conversations (both direct and group)
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['direct', 'group'])->default('direct');
            $table->string('name')->nullable(); // Group name
            $table->text('description')->nullable(); // Group description
            $table->string('avatar')->nullable(); // Group avatar
            $table->json('settings')->nullable(); // Group settings (allow_attachments, etc.)
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'created_at']);
            $table->index('last_message_at');
        });

        // Conversation participants
        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['owner', 'admin', 'moderator', 'member'])->default('member');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('last_read_at')->nullable();
            $table->boolean('is_muted')->default(false);
            $table->timestamp('muted_until')->nullable();
            $table->boolean('notifications_enabled')->default(true);
            $table->boolean('is_active')->default(true); // For leaving groups
            $table->timestamp('left_at')->nullable();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id']);
            $table->index('user_id');
        });

        // Messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reply_to_id')->nullable()->constrained('messages')->nullOnDelete();
            $table->enum('type', ['text', 'image', 'video', 'audio', 'file', 'location', 'announcement'])->default('text');
            $table->text('content')->nullable();
            $table->json('attachments')->nullable(); // Array of file paths
            $table->json('metadata')->nullable(); // Additional data (location coords, file info, etc.)
            $table->boolean('is_edited')->default(false);
            $table->timestamp('edited_at')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('pinned_at')->nullable();
            $table->foreignId('pinned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_important')->default(false);
            $table->integer('disappear_after_hours')->nullable(); // Disappearing messages
            $table->timestamp('disappear_at')->nullable();
            $table->timestamps();

            $table->index('conversation_id');
            $table->index('sender_id');
            $table->index('created_at');
            $table->index(['conversation_id', 'created_at']);
        });

        // Message read receipts
        Schema::create('message_read_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->unique(['message_id', 'user_id']);
            $table->index('user_id');
        });

        // Message reactions
        Schema::create('message_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('emoji', 10); // 👍, ❤️, 😂, etc.
            $table->timestamps();

            $table->unique(['message_id', 'user_id', 'emoji']);
            $table->index('message_id');
        });

        // Starred messages (bookmarks)
        Schema::create('starred_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['message_id', 'user_id']);
            $table->index('user_id');
        });

        // Blocked users
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blocker_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('blocked_id')->constrained('users')->cascadeOnDelete();
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->unique(['blocker_id', 'blocked_id']);
            $table->index('blocker_id');
            $table->index('blocked_id');
        });

        // Message reports
        Schema::create('message_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('users')->cascadeOnDelete();
            $table->enum('reason', ['spam', 'harassment', 'inappropriate', 'offensive', 'other']);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();

            $table->index('message_id');
            $table->index('status');
        });

        // Typing indicators (temporary table, could use Redis instead)
        Schema::create('typing_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();

            $table->unique(['conversation_id', 'user_id']);
            $table->index('expires_at');
        });

        // File storage tracking
        Schema::create('message_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type'); // mime type
            $table->integer('file_size'); // bytes
            $table->string('display_name')->nullable();
            $table->json('thumbnail_paths')->nullable(); // For images/videos
            $table->integer('download_count')->default(0);
            $table->timestamps();

            $table->index('message_id');
        });

        // Conversation categories/folders
        Schema::create('conversation_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('slug');
        });

        // Assign conversations to categories
        Schema::create('conversation_category_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('conversation_categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // User-specific categorization
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_category_assignments');
        Schema::dropIfExists('conversation_categories');
        Schema::dropIfExists('message_files');
        Schema::dropIfExists('typing_indicators');
        Schema::dropIfExists('message_reports');
        Schema::dropIfExists('blocked_users');
        Schema::dropIfExists('starred_messages');
        Schema::dropIfExists('message_reactions');
        Schema::dropIfExists('message_read_receipts');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');
    }
};
