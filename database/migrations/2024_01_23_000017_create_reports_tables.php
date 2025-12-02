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
        // Custom reports table
        if (! Schema::hasTable('custom_reports')) {
            Schema::create('custom_reports', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('type'); // membership, financial, attendance, program, custom
                $table->text('description')->nullable();
                $table->json('configuration'); // fields, filters, grouping, calculations
                $table->json('columns'); // selected columns with order
                $table->json('filters')->nullable(); // filter configuration
                $table->string('group_by')->nullable();
                $table->json('calculations')->nullable(); // sum, avg, count fields
                $table->json('chart_config')->nullable(); // chart type and settings
                $table->boolean('is_template')->default(false);
                $table->boolean('is_public')->default(false);
                $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index(['type', 'is_template']);
                $table->index('created_by');
            });
        }

        // Report schedules table
        if (! Schema::hasTable('report_schedules')) {
            Schema::create('report_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('custom_report_id')->nullable()->constrained('custom_reports')->onDelete('cascade');
                $table->string('report_type')->nullable(); // for standard reports
                $table->string('name');
                $table->string('frequency'); // daily, weekly, monthly, quarterly, yearly
                $table->json('recipients'); // email addresses
                $table->string('format'); // pdf, excel, csv
                $table->json('parameters')->nullable(); // date ranges, filters
                $table->time('run_time')->default('08:00:00');
                $table->integer('day_of_week')->nullable(); // 0-6 for weekly
                $table->integer('day_of_month')->nullable(); // 1-31 for monthly
                $table->timestamp('last_run_at')->nullable();
                $table->timestamp('next_run_at')->nullable();
                $table->boolean('is_active')->default(true);
                $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index(['is_active', 'next_run_at']);
            });
        }

        // Report executions table (history)
        if (! Schema::hasTable('report_executions')) {
            Schema::create('report_executions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('custom_report_id')->nullable()->constrained('custom_reports')->onDelete('set null');
                $table->foreignId('report_schedule_id')->nullable()->constrained('report_schedules')->onDelete('set null');
                $table->string('report_name');
                $table->string('report_type');
                $table->json('parameters')->nullable();
                $table->string('format');
                $table->string('file_path')->nullable();
                $table->integer('file_size')->default(0);
                $table->integer('rows_count')->default(0);
                $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
                $table->text('error_message')->nullable();
                $table->timestamp('started_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->index(['status', 'created_at']);
                $table->index('generated_by');
            });
        }

        // Report favorites table
        if (! Schema::hasTable('report_favorites')) {
            Schema::create('report_favorites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('custom_report_id')->constrained('custom_reports')->onDelete('cascade');
                $table->timestamps();

                $table->unique(['user_id', 'custom_report_id']);
            });
        }

        // Analytics metrics table (for dashboard)
        if (! Schema::hasTable('analytics_metrics')) {
            Schema::create('analytics_metrics', function (Blueprint $table) {
                $table->id();
                $table->string('metric_type'); // growth, financial, engagement, ministry
                $table->string('metric_name');
                $table->date('metric_date');
                $table->string('period'); // daily, weekly, monthly, yearly
                $table->decimal('value', 15, 2);
                $table->json('metadata')->nullable(); // additional context
                $table->timestamps();

                $table->unique(['metric_type', 'metric_name', 'metric_date', 'period'], 'analytics_metrics_unique');
                $table->index(['metric_type', 'metric_date']);
            });
        }

        // Report data snapshots (for historical comparisons)
        if (! Schema::hasTable('report_snapshots')) {
            Schema::create('report_snapshots', function (Blueprint $table) {
                $table->id();
                $table->string('snapshot_type'); // membership, financial, attendance
                $table->date('snapshot_date');
                $table->json('data'); // snapshot of key metrics
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['snapshot_type', 'snapshot_date']);
                $table->index('snapshot_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_snapshots');
        Schema::dropIfExists('analytics_metrics');
        Schema::dropIfExists('report_favorites');
        Schema::dropIfExists('report_executions');
        Schema::dropIfExists('report_schedules');
        Schema::dropIfExists('custom_reports');
    }
};
