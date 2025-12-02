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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->enum('transaction_type', ['tithe', 'offering', 'donation', 'expense', 'other_income']);
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('GHS');
            $table->string('category', 100)->nullable();
            $table->string('sub_category', 100)->nullable();
            $table->text('description')->nullable();
            $table->enum('payment_method', ['cash', 'mobile_money', 'bank_transfer', 'check', 'card', 'other'])->nullable();
            $table->string('reference_number', 100)->nullable();
            $table->string('receipt_url', 500)->nullable();
            $table->text('receipt_notes')->nullable();
            $table->date('transaction_date');
            $table->enum('status', ['pending', 'completed', 'reconciled', 'disputed'])->default('completed');
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('transaction_type');
            $table->index('transaction_date');
            $table->index('member_id');
            $table->index('status');
            $table->index('category');
            $table->index(['transaction_date', 'transaction_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
