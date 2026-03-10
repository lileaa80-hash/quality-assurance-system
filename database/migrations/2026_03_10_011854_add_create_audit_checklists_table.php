<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained(); // Unit yang diaudit
            $table->foreignId('standard_id')->constrained(); // Standar yang diperiksa
            $table->foreignId('standard_indicator_id')->constrained(); // Indikator yang diperiksa
            
            // Hasil audit
            $table->enum('result', ['compliant', 'partially_compliant', 'non_compliant', 'not_applicable'])->nullable();
            $table->integer('score')->nullable(); // Skor jika menggunakan skala
            $table->text('objective_evidence')->nullable(); // Bukti objektif
            $table->text('notes')->nullable();
            
            // Auditor yang memeriksa
            $table->foreignId('auditor_id')->constrained('users');
            $table->datetime('checked_at')->nullable();
            
            // Upload bukti (MinIO)
            $table->json('evidence_files')->nullable(); // Array file paths
            
            $table->timestamps();
            
            $table->index(['audit_schedule_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_checklists');
    }
};