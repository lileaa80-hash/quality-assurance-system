<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('audit_number')->unique(); // AUD/2024/001
            $table->string('title');
            $table->enum('type', ['internal', 'external', 'surveillance'])->default('internal');
            $table->enum('scope', ['institutional', 'faculty', 'program', 'specific'])->default('program');
            $table->year('period_year');
            $table->string('period_semester')->nullable(); // ganjil, genap
            
            // Waktu pelaksanaan
            $table->date('start_date');
            $table->date('end_date');
            $table->date('opening_date')->nullable(); // Tanggal pembukaan
            $table->date('closing_date')->nullable(); // Tanggal penutupan
            
            // Standar yang digunakan
            $table->json('standards_used'); // Array standard_id
            
            // Status
            $table->enum('status', [
                'planned', 'preparation', 'opened', 'ongoing', 
                'closing', 'completed', 'cancelled'
            ])->default('planned');
            
            // Dokumen pendukung (MinIO)
            $table->string('terms_of_reference')->nullable(); // TOR file
            $table->string('schedule_document')->nullable(); // Jadwal detail
            
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('type');
            $table->index('status');
            $table->index(['period_year', 'period_semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_schedules');
    }
};