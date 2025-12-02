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
        Schema::create('sms_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('recipient_group', 100)->nullable();
            $table->integer('recipient_count')->default(0);
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'failed', 'cancelled'])->default('draft');
            $table->integer('success_count')->default(0);
            $table->integer('failure_count')->default(0);
            $table->decimal('cost', 15, 2)->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('created_at');
            $table->index('scheduled_for');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_broadcasts');
    }
};
