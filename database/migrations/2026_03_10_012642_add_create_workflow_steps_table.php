<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('step_order');
            $table->enum('approver_type', ['role', 'user', 'unit_head', 'position'])->default('role');
            $table->string('approver_value'); // role_id, user_id, atau position
            $table->boolean('requires_approval')->default(true);
            $table->integer('time_limit_days')->nullable(); // Batas waktu approval
            $table->json('conditions')->nullable(); // Kondisi untuk step ini
            $table->timestamps();
            
            $table->unique(['workflow_id', 'step_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_steps');
    }
};