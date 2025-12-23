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
        Schema::create('equipment_checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->foreignId('checked_out_by')->constrained('users')->onDelete('cascade'); // Assuming User ID
            $table->dateTime('checkout_time');
            $table->dateTime('expected_return')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->string('status', 20)->default('checked_out'); // checked_out, returned, overdue
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('checkout_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_checkouts');
    }
};
