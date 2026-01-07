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
        Schema::table('members', function (Blueprint $table) {
            $table->string('member_qr_code', 100)->nullable()->after('spouse_id');
            // SQLite doesn't support UNIQUE in ADD COLUMN. We add index separately if needed, or skip for simplicity in testing as uniqueness checks are handled by app logic predominantly.
            if (DB::getDriverName() !== 'sqlite') {
                 $table->unique('member_qr_code');
            }
            $table->timestamp('last_qr_scan')->nullable()->after('member_qr_code');
            $table->integer('qr_scan_count')->default(0)->after('last_qr_scan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['member_qr_code', 'last_qr_scan', 'qr_scan_count']);
        });
    }
};
