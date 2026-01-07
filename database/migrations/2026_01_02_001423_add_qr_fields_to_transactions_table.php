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
        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('payment_qr_id')->nullable()->after('payment_method');
            // SQLite workaround for foreign keys on existing tables
            if (DB::getDriverName() !== 'sqlite') {
                $table->foreign('payment_qr_id')->references('id')->on('qr_codes')->onDelete('set null');
            }
            $table->timestamp('qr_scan_timestamp')->nullable()->after('payment_qr_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['payment_qr_id']);
            }
            $table->dropColumn(['payment_qr_id', 'qr_scan_timestamp']);
        });
    }
};
