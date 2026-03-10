<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accreditation_borangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accreditation_period_id')->constrained()->onDelete('cascade');
            $table->foreignId('standard_id')->constrained();
            $table->foreignId('standard_indicator_id')->constrained();
            
            // Isian borang
            $table->text('response')->nullable();
            $table->text('analysis')->nullable();
            $table->string('target')->nullable();
            $table->string('achievement')->nullable();
            
            // Dokumen pendukung (MinIO)
            $table->json('supporting_documents')->nullable();
            
            // Penilaian
            $table->integer('self_assessment_score')->nullable(); // Penilaian mandiri
            $table->integer('assessor_score')->nullable(); // Penilaian asesor
            $table->text('assessor_notes')->nullable();
            
            // Status pengisian
            $table->enum('status', ['draft', 'submitted', 'verified', 'revised'])->default('draft');
            $table->foreignId('filled_by')->constrained('users');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->datetime('verified_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditation_borangs');
    }
};