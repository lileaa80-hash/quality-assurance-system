<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_findings', function (Blueprint $table) {
            $table->id();
            $table->string('finding_number')->unique(); // TEM/2024/001
            $table->foreignId('audit_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained();
            $table->foreignId('audit_checklist_id')->nullable()->constrained();
            
            // Klasifikasi temuan
            $table->enum('category', ['major', 'minor', 'observation', 'strength'])->default('minor');
            $table->enum('type', ['systematic', 'sporadic', 'unique'])->default('sporadic');
            
            // Deskripsi temuan
            $table->text('finding_description');
            $table->text('criteria_reference'); // Referensi standar yang dilanggar
            $table->text('objective_evidence'); // Bukti temuan
            
            // Status
            $table->enum('status', [
                'open', 'in_progress', 'closed', 'verified'
            ])->default('open');
            
            // Severity
            $table->integer('risk_level')->default(1); // 1-5, 5 paling serius
            
            // Dokumen pendukung (MinIO)
            $table->json('supporting_files')->nullable();
            $table->string('photo_evidence')->nullable();
            
            // Auditor
            $table->foreignId('auditor_id')->constrained('users');
            $table->datetime('finding_date');
            
            $table->timestamps();
            
            $table->index('status');
            $table->index(['audit_schedule_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_findings');
    }
};