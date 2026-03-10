<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Auditor
            $table->enum('role', ['lead_auditor', 'auditor', 'observer', 'trainee'])->default('auditor');
            $table->json('assigned_units')->nullable(); // Unit yang diaudit oleh auditor ini
            $table->json('assigned_standards')->nullable(); // Standar yang diaudit
            $table->boolean('is_certified')->default(false); // Auditor bersertifikat
            $table->string('certificate_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['audit_schedule_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_teams');
    }
};