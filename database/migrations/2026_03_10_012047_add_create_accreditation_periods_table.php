<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accreditation_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained();
            $table->string('period_name'); // Akreditasi 2024, Reakreditasi, dll
            $table->enum('type', ['initial', 'reaccreditation', 'maintenance'])->default('initial');
            $table->enum('status', [
                'planned', 'preparation', 'submitted', 'assesment', 
                'waiting_result', 'completed', 'postponed'
            ])->default('planned');
            
            // Tanggal penting
            $table->date('start_date');
            $table->date('submission_deadline')->nullable();
            $table->date('assesment_date')->nullable();
            $table->date('result_date')->nullable();
            $table->date('expiry_date')->nullable();
            
            // Hasil
            $table->string('result_grade')->nullable(); // A, B, C, Unggul, Baik Sekali
            $table->integer('result_score')->nullable(); // Nilai numerik
            $table->string('certificate_number')->nullable();
            $table->string('certificate_file')->nullable(); // File sertifikat (MinIO)
            
            // Asesor
            $table->json('assessors')->nullable(); // Data asesor eksternal
            
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['unit_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditation_periods');
    }
};