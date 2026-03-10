<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->morphs('approvable'); // Document, AuditReport, etc
            $table->foreignId('workflow_step_id')->constrained();
            $table->foreignId('approver_id')->constrained('users');
            $table->enum('status', ['pending', 'approved', 'rejected', 'revised'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('action_at')->nullable();
            $table->timestamps();
            
            $table->index(['approvable_id', 'approvable_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};