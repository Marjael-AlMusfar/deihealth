<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('unit');
            $table->string('default_dose')->nullable();
            $table->text('indication')->nullable();
            $table->text('contraindication')->nullable();
            $table->unsignedInteger('minimum_stock')->default(0);
            $table->unsignedInteger('current_stock')->default(0);
            $table->date('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['name', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
