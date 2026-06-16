<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicine_stock_movements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['masuk', 'keluar', 'koreksi']);
            $table->unsignedInteger('quantity');
            $table->string('reason')->nullable();
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->dateTime('moved_at');
            $table->timestamps();
        });

        Schema::create('prescriptions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('health_report_id')->constrained()->cascadeOnDelete();
            $table->string('prescribed_by');
            $table->text('notes')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->timestamps();
        });

        Schema::create('prescription_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained()->restrictOnDelete();
            $table->string('dose');
            $table->unsignedTinyInteger('frequency_per_day');
            $table->unsignedSmallInteger('duration_days');
            $table->text('instructions')->nullable();
            $table->timestamps();
        });

        Schema::create('medication_schedules', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('prescription_item_id')->constrained()->cascadeOnDelete();
            $table->dateTime('scheduled_at');
            $table->enum('status', ['terjadwal', 'diberikan', 'terlewat', 'ditolak', 'dihentikan'])->default('terjadwal');
            $table->timestamps();
            $table->index(['scheduled_at', 'status']);
        });

        Schema::create('medication_administrations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('medication_schedule_id')->constrained()->cascadeOnDelete();
            $table->string('administered_by');
            $table->dateTime('administered_at')->nullable();
            $table->enum('status', ['terjadwal', 'diberikan', 'terlewat', 'ditolak', 'dihentikan']);
            $table->text('notes')->nullable();
            $table->text('side_effects')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_administrations');
        Schema::dropIfExists('medication_schedules');
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('medicine_stock_movements');
    }
};
