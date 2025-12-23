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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->date('service_date');
            $table->string('service_type', 50); // Changed from enum to string for flexibility
            $table->enum('status', ['present', 'absent', 'excused', 'late'])->default('absent');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();

            // Unique constraint - one attendance record per member per service
            $table->unique(['member_id', 'service_date', 'service_type'], 'unique_attendance');

            // Indexes
            $table->index('member_id');
            $table->index('service_date');
            $table->index('status');
            $table->index('service_type');
            $table->index(['member_id', 'service_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
