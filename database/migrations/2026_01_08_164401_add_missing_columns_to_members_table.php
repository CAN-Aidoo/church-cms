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
            // Check and add missing columns
            if (!Schema::hasColumn('members', 'middle_name')) {
                $table->string('middle_name', 100)->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('members', 'work_email')) {
                $table->string('work_email')->nullable()->after('email');
            }
            if (!Schema::hasColumn('members', 'whatsapp_phone')) {
                $table->string('whatsapp_phone', 20)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('members', 'state')) {
                $table->string('state', 100)->nullable()->after('city');
            }
            if (!Schema::hasColumn('members', 'workplace')) {
                $table->string('workplace', 100)->nullable()->after('occupation');
            }
            if (!Schema::hasColumn('members', 'education_level')) {
                $table->string('education_level', 50)->nullable()->after('workplace');
            }
            if (!Schema::hasColumn('members', 'blood_group')) {
                $table->string('blood_group', 10)->nullable()->after('education_level');
            }
            if (!Schema::hasColumn('members', 'allergies')) {
                $table->text('allergies')->nullable()->after('blood_group');
            }
            if (!Schema::hasColumn('members', 'medical_conditions')) {
                $table->text('medical_conditions')->nullable()->after('allergies');
            }
            if (!Schema::hasColumn('members', 'gps_location')) {
                $table->string('gps_location', 100)->nullable()->after('country');
            }
            if (!Schema::hasColumn('members', 'photo_url')) {
                $table->string('photo_url', 500)->nullable()->after('profile_photo_url');
            }
            if (!Schema::hasColumn('members', 'status')) {
                $table->string('status', 50)->nullable()->after('member_status');
            }
            if (!Schema::hasColumn('members', 'department')) {
                $table->string('department', 100)->nullable()->after('status');
            }
            if (!Schema::hasColumn('members', 'emergency_contact_name')) {
                $table->string('emergency_contact_name', 100)->nullable()->after('department');
            }
            if (!Schema::hasColumn('members', 'emergency_contact_phone')) {
                $table->string('emergency_contact_phone', 20)->nullable()->after('emergency_contact_name');
            }
            if (!Schema::hasColumn('members', 'is_baptized')) {
                $table->boolean('is_baptized')->default(false)->after('notes');
            }
            if (!Schema::hasColumn('members', 'baptism_date')) {
                $table->date('baptism_date')->nullable()->after('is_baptized');
            }
            if (!Schema::hasColumn('members', 'baptism_location')) {
                $table->string('baptism_location', 200)->nullable()->after('baptism_date');
            }
            if (!Schema::hasColumn('members', 'is_holy_spirit_baptized')) {
                $table->boolean('is_holy_spirit_baptized')->default(false)->after('baptism_location');
            }
            if (!Schema::hasColumn('members', 'holy_spirit_baptism_date')) {
                $table->date('holy_spirit_baptism_date')->nullable()->after('is_holy_spirit_baptized');
            }
            if (!Schema::hasColumn('members', 'spiritual_gifts')) {
                $table->json('spiritual_gifts')->nullable()->after('holy_spirit_baptism_date');
            }
            if (!Schema::hasColumn('members', 'ministry_involvement')) {
                $table->json('ministry_involvement')->nullable()->after('spiritual_gifts');
            }
            if (!Schema::hasColumn('members', 'custom_fields')) {
                $table->json('custom_fields')->nullable()->after('ministry_involvement');
            }
            if (!Schema::hasColumn('members', 'family_id')) {
                $table->foreignId('family_id')->nullable()->after('custom_fields');
            }
            if (!Schema::hasColumn('members', 'spouse_id')) {
                $table->foreignId('spouse_id')->nullable()->after('family_id');
            }
            if (!Schema::hasColumn('members', 'shepherd_id')) {
                $table->foreignId('shepherd_id')->nullable()->after('spouse_id');
            }
            if (!Schema::hasColumn('members', 'member_qr_code')) {
                $table->string('member_qr_code', 100)->nullable()->unique()->after('shepherd_id');
            }
            if (!Schema::hasColumn('members', 'last_qr_scan')) {
                $table->timestamp('last_qr_scan')->nullable()->after('member_qr_code');
            }
            if (!Schema::hasColumn('members', 'qr_scan_count')) {
                $table->integer('qr_scan_count')->default(0)->after('last_qr_scan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $columns = [
                'middle_name', 'work_email', 'whatsapp_phone', 'state', 'workplace',
                'education_level', 'blood_group', 'allergies', 'medical_conditions',
                'gps_location', 'photo_url', 'status', 'department',
                'emergency_contact_name', 'emergency_contact_phone',
                'is_baptized', 'baptism_date', 'baptism_location',
                'is_holy_spirit_baptized', 'holy_spirit_baptism_date',
                'spiritual_gifts', 'ministry_involvement', 'custom_fields',
                'family_id', 'spouse_id', 'shepherd_id',
                'member_qr_code', 'last_qr_scan', 'qr_scan_count'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('members', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
