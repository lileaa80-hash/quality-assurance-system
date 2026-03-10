<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', [
                'audit_summary',
                'accreditation_result',
                'evaluation_summary',
                'document_status',
                'finding_trend',
                'custom'
            ]);
            $table->json('parameters')->nullable(); // Parameter laporan
            $table->json('data_summary')->nullable(); // Ringkasan data
            $table->string('file_path')->nullable(); // File generated (PDF/Excel) di MinIO
            $table->enum('format', ['pdf', 'excel', 'html'])->default('pdf');
            
            // Periode laporan
            $table->year('year')->nullable();
            $table->string('quarter')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Pembuat
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('generated_at');
            
            $table->timestamps();
            
            $table->index(['type', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};