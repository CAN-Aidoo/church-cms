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
        // Families table - CREATE FIRST
        if (! Schema::hasTable('families')) {
            Schema::create('families', function (Blueprint $table) {
                $table->id();
                $table->string('family_name');
                $table->string('family_code')->unique();
                // Remove foreign key constraint for now to avoid circular dependency
                $table->unsignedBigInteger('head_of_family_id')->nullable();
                $table->text('family_address')->nullable();
                $table->string('family_phone')->nullable();
                $table->string('family_email')->nullable();
                $table->string('family_photo_url')->nullable();
                $table->date('wedding_anniversary')->nullable();
                $table->json('family_notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('family_code');
                $table->index('head_of_family_id');
            });
        }

        // Add enhanced fields to members table
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                // Check and add columns only if they don't exist
                if (! Schema::hasColumn('members', 'middle_name')) {
                    $table->string('middle_name')->nullable()->after('first_name');
                }
                if (! Schema::hasColumn('members', 'education_level')) {
                    $table->string('education_level')->nullable()->after('occupation');
                }
                if (! Schema::hasColumn('members', 'workplace')) {
                    $table->string('workplace')->nullable()->after('occupation');
                }
                if (! Schema::hasColumn('members', 'blood_group')) {
                    $table->string('blood_group')->nullable()->after('date_of_birth');
                }
                if (! Schema::hasColumn('members', 'allergies')) {
                    $table->text('allergies')->nullable()->after('blood_group');
                }
                if (! Schema::hasColumn('members', 'medical_conditions')) {
                    $table->text('medical_conditions')->nullable()->after('allergies');
                }
                if (! Schema::hasColumn('members', 'custom_fields')) {
                    $table->json('custom_fields')->nullable()->after('notes');
                }
                if (! Schema::hasColumn('members', 'whatsapp_phone')) {
                    $table->string('whatsapp_phone')->nullable()->after('phone');
                }
                if (! Schema::hasColumn('members', 'work_email')) {
                    $table->string('work_email')->nullable()->after('email');
                }
                if (! Schema::hasColumn('members', 'gps_location')) {
                    $table->string('gps_location')->nullable()->after('address');
                }
                if (! Schema::hasColumn('members', 'is_baptized')) {
                    $table->boolean('is_baptized')->default(false)->after('join_date');
                }
                if (! Schema::hasColumn('members', 'baptism_date')) {
                    $table->date('baptism_date')->nullable()->after('is_baptized');
                }
                if (! Schema::hasColumn('members', 'baptism_location')) {
                    $table->string('baptism_location')->nullable()->after('baptism_date');
                }
                if (! Schema::hasColumn('members', 'is_holy_spirit_baptized')) {
                    $table->boolean('is_holy_spirit_baptized')->default(false)->after('baptism_location');
                }
                if (! Schema::hasColumn('members', 'holy_spirit_baptism_date')) {
                    $table->date('holy_spirit_baptism_date')->nullable()->after('is_holy_spirit_baptized');
                }
                if (! Schema::hasColumn('members', 'spiritual_gifts')) {
                    $table->json('spiritual_gifts')->nullable()->after('holy_spirit_baptism_date');
                }
                if (! Schema::hasColumn('members', 'ministry_involvement')) {
                    $table->json('ministry_involvement')->nullable()->after('spiritual_gifts');
                }
                if (! Schema::hasColumn('members', 'family_id')) {
                    $table->foreignId('family_id')->nullable()->constrained('families')->onDelete('set null')->after('shepherd_id');
                }
                if (! Schema::hasColumn('members', 'spouse_id')) {
                    $table->foreignId('spouse_id')->nullable()->constrained('members')->onDelete('set null')->after('family_id');
                }
            });
        }

        // Add foreign key constraint to families table after members table modification
        if (Schema::hasTable('families') && Schema::hasTable('members')) {
            Schema::table('families', function (Blueprint $table) {
                // Only add constraint if it doesn't exist (Laravel doesn't have a hasForeignKey method, so we might skip or wrap in try-catch, but here relying on previous steps)
                // Assuming it's safe as we removed it in create block
                $table->foreign('head_of_family_id')->references('id')->on('members')->onDelete('set null');
            });
        }

        // Children table
        if (! Schema::hasTable('children')) {
            Schema::create('children', function (Blueprint $table) {
                $table->id();
                $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
                $table->string('first_name');
                $table->string('middle_name')->nullable();
                $table->string('last_name');
                $table->date('date_of_birth');
                $table->enum('gender', ['male', 'female']);
                $table->string('blood_group')->nullable();
                $table->text('allergies')->nullable();
                $table->text('medical_conditions')->nullable();
                $table->string('school')->nullable();
                $table->string('grade_level')->nullable();
                $table->string('photo_url')->nullable();
                $table->json('pick_up_authorization')->nullable();
                $table->json('emergency_contacts')->nullable();
                $table->json('growth_milestones')->nullable();
                $table->boolean('is_active')->default(true);
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('family_id');
                $table->index(['first_name', 'last_name']);
                $table->index('date_of_birth');
            });
        }

        // Member documents table
        if (! Schema::hasTable('member_documents')) {
            Schema::create('member_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('document_type');
                $table->string('document_name');
                $table->string('file_path');
                $table->string('file_type');
                $table->integer('file_size')->default(0);
                $table->string('category')->nullable();
                $table->json('tags')->nullable();
                $table->text('description')->nullable();
                $table->date('issue_date')->nullable();
                $table->date('expiry_date')->nullable();
                $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();

                $table->index('member_id');
                $table->index('document_type');
                $table->index('category');
            });
        }

        // Member lifecycle events table
        if (! Schema::hasTable('member_lifecycle_events')) {
            Schema::create('member_lifecycle_events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('event_type');
                $table->date('event_date');
                $table->string('event_location')->nullable();
                $table->text('event_details')->nullable();
                $table->json('metadata')->nullable();
                $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index('member_id');
                $table->index('event_type');
                $table->index('event_date');
            });
        }

        // Member notes table
        if (! Schema::hasTable('member_notes')) {
            Schema::create('member_notes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('note_type');
                $table->string('title');
                $table->longText('content');
                $table->enum('visibility', ['private', 'pastors_only', 'staff'])->default('pastors_only');
                $table->boolean('is_sensitive')->default(false);
                $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();

                $table->index('member_id');
                $table->index('note_type');
                $table->index('visibility');
            });
        }

        // Member service units (many-to-many)
        if (! Schema::hasTable('member_service_unit')) {
            Schema::create('member_service_unit', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->foreignId('service_unit_id')->constrained('service_units')->onDelete('cascade');
                $table->enum('role', ['member', 'leader', 'assistant_leader'])->default('member');
                $table->date('joined_date');
                $table->date('left_date')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->unique(['member_id', 'service_unit_id']);
                $table->index('is_active');
            });
        }

        // Member photo versions
        if (! Schema::hasTable('member_photo_versions')) {
            Schema::create('member_photo_versions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->string('photo_url');
                $table->string('photo_type')->default('profile');
                $table->integer('width')->nullable();
                $table->integer('height')->nullable();
                $table->integer('file_size')->nullable();
                $table->boolean('is_current')->default(false);
                $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index('member_id');
                $table->index('is_current');
            });
        }

        // Member transfers table
        if (! Schema::hasTable('member_transfers')) {
            Schema::create('member_transfers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                $table->enum('transfer_type', ['incoming', 'outgoing']);
                $table->string('previous_church')->nullable();
                $table->string('new_church')->nullable();
                $table->date('transfer_date');
                $table->text('transfer_reason')->nullable();
                $table->string('transfer_letter_path')->nullable();
                $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->default('pending');
                $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamp('approved_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index('member_id');
                $table->index('transfer_type');
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first to avoid constraint violations
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                if (Schema::hasColumn('members', 'family_id')) {
                    $table->dropForeign(['family_id']);
                }
                if (Schema::hasColumn('members', 'spouse_id')) {
                    $table->dropForeign(['spouse_id']);
                }
            });
        }

        if (Schema::hasTable('families')) {
            Schema::table('families', function (Blueprint $table) {
                // Use array syntax for dropForeign with column name if possible, or constraint name
                // Standard Laravel constraint name: table_column_foreign
                try {
                    $table->dropForeign(['head_of_family_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
            });
        }

        Schema::dropIfExists('member_transfers');
        Schema::dropIfExists('member_photo_versions');
        Schema::dropIfExists('member_service_unit');
        Schema::dropIfExists('member_notes');
        Schema::dropIfExists('member_lifecycle_events');
        Schema::dropIfExists('member_documents');
        Schema::dropIfExists('children');
        Schema::dropIfExists('families');

        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $columns = [
                    'middle_name', 'education_level', 'workplace', 'blood_group',
                    'allergies', 'medical_conditions', 'custom_fields', 'whatsapp_phone',
                    'work_email', 'gps_location', 'is_baptized', 'baptism_date',
                    'baptism_location', 'is_holy_spirit_baptized', 'holy_spirit_baptism_date',
                    'spiritual_gifts', 'ministry_involvement', 'family_id', 'spouse_id',
                ];

                foreach ($columns as $column) {
                    if (Schema::hasColumn('members', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
