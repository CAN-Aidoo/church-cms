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
        Schema::table('attendance', function (Blueprint $table) {
            $table->enum('check_in_method', ['manual', 'qr_scan', 'facial', 'nfc', 'mobile_app', 'web'])->default('manual')->after('status');
            $table->uuid('qr_code_id')->nullable()->after('check_in_method');
            // SQLite has limited support for adding foreign keys to existing tables (ALTER TABLE).
            // We skip the constraint in testing/SQLite to avoid schema errors.
            if (DB::getDriverName() !== 'sqlite') {
                $table->foreign('qr_code_id')->references('id')->on('qr_codes')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['qr_code_id']);
            }
            $table->dropColumn(['check_in_method', 'qr_code_id']);
        });
    }
};
