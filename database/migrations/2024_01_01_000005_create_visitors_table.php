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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('visit_date');
            $table->string('service_type', 50)->nullable();
            $table->string('how_heard', 100)->nullable();
            $table->boolean('follow_up_required')->default(true);
            $table->enum('follow_up_status', ['pending', 'contacted', 'member_invited', 'converted', 'no_response'])->default('pending');
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->integer('visit_count')->default(1);
            $table->foreignId('converted_member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index('visit_date');
            $table->index('follow_up_status');
            $table->index('email');
            $table->index('phone');
            $table->index('visit_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
