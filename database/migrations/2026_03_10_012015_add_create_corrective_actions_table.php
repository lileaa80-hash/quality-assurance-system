<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();
            $table->string('ca_number')->unique(); // CAPA/2024/001
            $table->foreignId('audit_finding_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained();
            
            // Root cause analysis
            $table->text('root_cause');
            $table->enum('cause_category', [
                'human', 'method', 'machine', 'material', 'environment', 'other'
            ])->default('human');
            
            // Rencana perbaikan
            $table->text('corrective_action_plan');
            $table->text('preventive_action_plan')->nullable();
            $table->date('target_completion_date');
            
            // Pelaksana
            $table->foreignId('responsible_person')->constrained('users');
            
            // Implementasi
            $table->text('implementation_evidence')->nullable();
            $table->json('evidence_files')->nullable(); // Bukti perbaikan (MinIO)
            $table->date('implementation_date')->nullable();
            
            // Verifikasi
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->datetime('verified_at')->nullable();
            
            // Effectiveness
            $table->boolean('is_effective')->nullable();
            $table->enum('final_status', ['open', 'closed', 'reopened'])->default('open');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corrective_actions');
    }
};