<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_observations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('health_report_id')->constrained()->cascadeOnDelete();
            $table->string('observed_by');
            $table->dateTime('observed_at');
            $table->decimal('temperature', 3, 1)->nullable();
            $table->text('symptom_notes')->nullable();
            $table->string('appetite')->nullable();
            $table->string('rest_quality')->nullable();
            $table->string('activity_level')->nullable();
            $table->boolean('medication_compliance')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['health_report_id', 'observed_at']);
        });

        Schema::create('referrals', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('health_report_id')->constrained()->cascadeOnDelete();
            $table->string('referred_by');
            $table->string('facility_name');
            $table->text('reason');
            $table->dateTime('referred_at');
            $table->text('result_notes')->nullable();
            $table->dateTime('follow_up_at')->nullable();
            $table->enum('status', ['dibuat', 'dalam_tindak_lanjut', 'selesai'])->default('dibuat');
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('auditable_type');
            $table->unsignedBigInteger('auditable_id');
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->index(['auditable_type', 'auditable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('daily_observations');
    }
};
