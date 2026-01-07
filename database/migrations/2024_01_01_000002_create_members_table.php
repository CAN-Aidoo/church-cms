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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('alternate_phone', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            $table->string('marital_status', 50)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->default('Ghana');
            $table->string('profile_photo_url', 500)->nullable();
            $table->text('bio')->nullable();
            $table->date('join_date');
            $table->enum('member_status', ['active', 'inactive', 'pending', 'suspended'])->default('active');
            $table->date('last_contact_date')->nullable();
            $table->string('referral_source', 100)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index(['last_name', 'first_name']);
            $table->index('email');
            $table->index('phone');
            $table->index('member_status');
            $table->index('join_date');
            $table->index('user_id');
            if (DB::getDriverName() !== 'sqlite') {
                $table->fullText(['first_name', 'last_name', 'email']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
