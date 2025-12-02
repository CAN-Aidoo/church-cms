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
        Schema::create('sms_broadcast_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broadcast_id')->constrained('sms_broadcasts')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('cascade');
            $table->string('phone_number', 20);
            $table->enum('status', ['pending', 'sent', 'delivered', 'failed', 'unsubscribed'])->default('pending');
            $table->timestamp('delivery_timestamp')->nullable();
            $table->string('twilio_message_sid', 100)->nullable();
            $table->string('error_code', 10)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('broadcast_id');
            $table->index('status');
            $table->index('member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_broadcast_recipients');
    }
};
