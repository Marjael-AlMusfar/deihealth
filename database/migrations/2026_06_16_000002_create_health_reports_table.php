<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_reports', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('reported_by');
            $table->dateTime('reported_at');
            $table->string('main_symptom');
            $table->json('symptoms')->nullable();
            $table->decimal('temperature', 3, 1)->nullable();
            $table->enum('urgency', ['rendah', 'sedang', 'tinggi'])->default('rendah');
            $table->string('location')->nullable();
            $table->enum('status', ['dilaporkan', 'diperiksa', 'dalam_pemantauan', 'sembuh', 'dirujuk', 'ditutup'])->default('dilaporkan');
            $table->string('diagnosis')->nullable();
            $table->text('treatment_notes')->nullable();
            $table->text('follow_up_notes')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'urgency']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_reports');
    }
};
