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
        Schema::table('programs', function (Blueprint $table) {
            $table->string('registration_qr_code', 100)->nullable()->after('status');
            $table->string('check_in_qr_code', 100)->nullable()->after('registration_qr_code');
            
            if (DB::getDriverName() !== 'sqlite') {
                $table->unique('registration_qr_code');
                $table->unique('check_in_qr_code');
            }
            $table->boolean('qr_registration_enabled')->default(false)->after('check_in_qr_code');
            $table->boolean('qr_checkin_enabled')->default(false)->after('qr_registration_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['registration_qr_code', 'check_in_qr_code', 'qr_registration_enabled', 'qr_checkin_enabled']);
        });
    }
};
