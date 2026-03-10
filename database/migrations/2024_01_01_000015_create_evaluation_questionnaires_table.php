<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', [
                'student_satisfaction', 
                'lecturer_performance',
                'alumni_tracer',
                'stakeholder_satisfaction',
                'self_evaluation'
            ]);
            
            // Periode
            $table->year('year');
            $table->string('semester')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            
            // Target responden
            $table->enum('target_audience', [
                'students', 'lecturers', 'staff', 'alumni', 'stakeholders', 'all'
            ]);
            $table->json('target_units')->nullable(); // Unit yang menjadi target
            
            // Status
            $table->enum('status', ['draft', 'active', 'closed', 'archived'])->default('draft');
            
            // Pengaturan
            $table->boolean('is_anonymous')->default(true);
            $table->boolean('allow_multiple_submissions')->default(false);
            
            // Laporan
            $table->json('summary_report')->nullable();
            $table->string('report_file')->nullable(); // File laporan (MinIO)
            
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['type', 'year', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_questionnaires');
    }
};